import mysql from 'mysql2/promise';

const db = mysql.createPool({
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME,
  ssl: { rejectUnauthorized: true }
});

export default async function handler(req, res) {
  res.setHeader('Access-Control-Allow-Origin', '*');
  res.setHeader('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE,OPTIONS');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type,Authorization');
  if (req.method === 'OPTIONS') return res.status(200).end();

  const { id } = req.query;

  try {
    // GET all or one
    if (req.method === 'GET') {
      if (id) {
        const [rows] = await db.query('SELECT * FROM articles WHERE id = ?', [id]);
        if (!rows.length) return res.status(404).json({ error: 'Article non trouvé' });
        return res.json(rows[0]);
      }
      const { statut, categorie, search } = req.query;
      let sql = 'SELECT * FROM articles WHERE 1=1';
      const params = [];
      if (statut)    { sql += ' AND statut = ?';              params.push(statut); }
      if (categorie) { sql += ' AND categorie = ?';           params.push(categorie); }
      if (search)    { sql += ' AND (titre LIKE ? OR description LIKE ?)'; params.push(`%${search}%`, `%${search}%`); }
      sql += ' ORDER BY date_creation DESC';
      const [rows] = await db.query(sql, params);
      return res.json(rows);
    }

    // POST — create
    if (req.method === 'POST') {
      const { titre, description, contenu, auteur, image, categorie, statut, user_id } = req.body;
      if (!titre || !contenu) return res.status(400).json({ error: 'Titre et contenu obligatoires' });
      const [result] = await db.query(
        `INSERT INTO articles (titre, description, contenu, auteur, image, categorie, statut, user_id, date_creation, date_modification)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())`,
        [titre, description || '', contenu, auteur || 'Admin', image || '', categorie || '', statut || 'brouillon', user_id || null]
      );
      return res.status(201).json({ id: result.insertId, message: 'Article créé' });
    }

    // PUT — update
    if (req.method === 'PUT') {
      if (!id) return res.status(400).json({ error: 'ID requis' });
      const { titre, description, contenu, auteur, image, categorie, statut } = req.body;
      await db.query(
        `UPDATE articles SET titre=?, description=?, contenu=?, auteur=?, image=?, categorie=?, statut=?, date_modification=NOW() WHERE id=?`,
        [titre, description, contenu, auteur, image, categorie, statut, id]
      );
      return res.json({ message: 'Article mis à jour' });
    }

    // DELETE
    if (req.method === 'DELETE') {
      if (!id) return res.status(400).json({ error: 'ID requis' });
      await db.query('DELETE FROM articles WHERE id = ?', [id]);
      return res.json({ message: 'Article supprimé' });
    }

    res.status(405).json({ error: 'Méthode non autorisée' });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: 'Erreur serveur', detail: err.message });
  }
}
