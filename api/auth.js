import mysql from 'mysql2/promise';
import bcrypt from 'bcryptjs';
import jwt from 'jsonwebtoken';

const db = mysql.createPool({
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME,
  ssl: { rejectUnauthorized: true }
});

const JWT_SECRET = process.env.JWT_SECRET || 'travelinseoul_secret_change_me';

export default async function handler(req, res) {
  res.setHeader('Access-Control-Allow-Origin', '*');
  res.setHeader('Access-Control-Allow-Methods', 'POST,OPTIONS');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type');
  if (req.method === 'OPTIONS') return res.status(200).end();
  if (req.method !== 'POST') return res.status(405).json({ error: 'Méthode non autorisée' });

  const { action } = req.query;

  try {
    // ── REGISTER ──
    if (action === 'register') {
      const { name, email, password, role, admin_key } = req.body;
      if (!name || !email || !password) return res.status(400).json({ error: 'Champs obligatoires manquants' });
      if (password.length < 8) return res.status(400).json({ error: 'Mot de passe trop court (min. 8 caractères)' });

      // Clé admin requise pour créer un compte admin
      if (role === 'admin' && admin_key !== process.env.ADMIN_KEY) {
        return res.status(403).json({ error: 'Clé administrateur incorrecte' });
      }

      const [existing] = await db.query('SELECT id FROM users WHERE email = ?', [email]);
      if (existing.length) return res.status(409).json({ error: 'Email déjà utilisé' });

      const hashed = await bcrypt.hash(password, 12);
      const [result] = await db.query(
        'INSERT INTO users (name, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())',
        [name, email, hashed, role === 'admin' ? 'admin' : 'user']
      );

      const token = jwt.sign({ id: result.insertId, email, role: role === 'admin' ? 'admin' : 'user' }, JWT_SECRET, { expiresIn: '7d' });
      return res.status(201).json({ token, user: { id: result.insertId, name, email, role } });
    }

    // ── LOGIN ──
    if (action === 'login') {
      const { email, password } = req.body;
      if (!email || !password) return res.status(400).json({ error: 'Email et mot de passe requis' });

      const [rows] = await db.query('SELECT * FROM users WHERE email = ?', [email]);
      if (!rows.length) return res.status(401).json({ error: 'Identifiants incorrects' });

      const user = rows[0];
      const valid = await bcrypt.compare(password, user.password);
      if (!valid) return res.status(401).json({ error: 'Identifiants incorrects' });

      if (user.role !== 'admin') return res.status(403).json({ error: 'Accès réservé aux administrateurs' });

      const token = jwt.sign({ id: user.id, email: user.email, role: user.role }, JWT_SECRET, { expiresIn: '7d' });
      return res.json({ token, user: { id: user.id, name: user.name, email: user.email, role: user.role } });
    }

    res.status(400).json({ error: 'Action inconnue. Utilisez ?action=login ou ?action=register' });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: 'Erreur serveur', detail: err.message });
  }
}
