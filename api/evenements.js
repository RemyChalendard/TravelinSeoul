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
    if (req.method === 'GET') {
      if (id) {
        const [rows] = await db.query('SELECT * FROM evenements WHERE id = ?', [id]);
        if (!rows.length) return res.status(404).json({ error: 'Événement non trouvé' });
        return res.json(rows[0]);
      }
      const { type, search } = req.query;
      let sql = 'SELECT * FROM evenements WHERE 1=1';
      const params = [];
      if (type)   { sql += ' AND type = ?';              params.push(type); }
      if (search) { sql += ' AND (titre LIKE ? OR lieu LIKE ?)'; params.push(`%${search}%`, `%${search}%`); }
      sql += ' ORDER BY date ASC';
      const [rows] = await db.query(sql, params);
      return res.json(rows);
    }

    if (req.method === 'POST') {
      const { titre, lieu, date, type, user_id } = req.body;
      if (!titre || !date) return res.status(400).json({ error: 'Titre et date obligatoires' });
      const [result] = await db.query(
        'INSERT INTO evenements (titre, lieu, date, type, user_id, created_at) VALUES (?, ?, ?, ?, ?, NOW())',
        [titre, lieu || '', date, type || '', user_id || null]
      );
      return res.status(201).json({ id: result.insertId, message: 'Événement créé' });
    }

    if (req.method === 'PUT') {
      if (!id) return res.status(400).json({ error: 'ID requis' });
      const { titre, lieu, date, type } = req.body;
      await db.query(
        'UPDATE evenements SET titre=?, lieu=?, date=?, type=? WHERE id=?',
        [titre, lieu, date, type, id]
      );
      return res.json({ message: 'Événement mis à jour' });
    }

    if (req.method === 'DELETE') {
      if (!id) return res.status(400).json({ error: 'ID requis' });
      await db.query('DELETE FROM evenements WHERE id = ?', [id]);
      return res.json({ message: 'Événement supprimé' });
    }

    res.status(405).json({ error: 'Méthode non autorisée' });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: 'Erreur serveur', detail: err.message });
  }
}
