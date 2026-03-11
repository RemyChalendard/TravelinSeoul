<?php
require_once("../admin/db.php");  
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

// Déterminer quelle section afficher
$section = $_GET['section'] ?? 'articles';
$categorie_filter = $_GET['categorie'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>
<link rel="stylesheet" href="/travelInSeoul/styles/admin.css">
<style>
textarea[name="contenu"] {
    height: 300px;
    resize: vertical;
}

.dashboard-wrapper {
    display: flex;
    gap: 20px;
    margin-top: 20px;
}

.left-column {
    width: 300px;
}

.form-add {
    background: #2A6EBB;
    color: white;
    padding: 20px;
    border-radius: 6px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.form-add h3 {
    color: white;
    margin-top: 0;
    margin-bottom: 20px;
    border-bottom: 1px solid rgba(255,255,255,0.3);
    padding-bottom: 15px;
}

.form-add input[type="text"],
.form-add select,
.form-add textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 4px;
    font-family: "Roboto", sans-serif;
    box-sizing: border-box;
}

.form-add input[type="text"],
.form-add select,
.form-add textarea {
    background: white;
    color: #333;
}

.form-add label {
    color: white;
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

.form-add button {
    background: white;
    color: #2A6EBB;
    border: none;
    padding: 12px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
    border-radius: 4px;
    font-weight: bold;
    transition: 0.3s;
}

.form-add button:hover {
    background: rgba(255,255,255,0.9);
}

.right-column {
    flex: 1;
}

/* Style le menu en haut */
.sidebar {
    width: 250px;
    background: #2A6EBB;
    color: white;
    padding: 20px;
    position: fixed;
    height: 100vh;
    overflow-y: auto;
    left: 0;
    top: 0;
}

.sidebar h2 {
    margin: 0 0 20px 0;
    padding-bottom: 15px;
    border-bottom: 1px solid rgba(255,255,255,0.3);
    font-size: 1.3em;
}

.sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar a {
    display: block;
    padding: 12px 15px;
    color: white;
    text-decoration: none;
    border-left: 4px solid transparent;
    transition: 0.3s;
}

.sidebar a:hover,
.sidebar a.active {
    background: rgba(255,255,255,0.2);
    border-left-color: white;
}

.main-content {
    margin-left: 250px;
    padding: 20px;
    flex: 1;
}

body {
    display: flex;
    margin: 0;
    padding: 0;
}

textarea[name="contenu"] {
    height: 300px;
    resize: vertical;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <h2>Dashboard</h2>
    
    <ul>
        <li><a href="?section=articles" class="<?= $section === 'articles' ? 'active' : '' ?>">Tous les articles</a></li>
        
        <li style="margin-top: 20px; padding: 0 15px;">
            <strong style="color: rgba(255,255,255,0.7); font-size: 12px;">CATÉGORIES</strong>
        </li>
        
        <?php
        $categories = $pdo->query("SELECT DISTINCT categorie FROM articles WHERE categorie IS NOT NULL AND categorie != '' ORDER BY categorie");
        foreach($categories as $cat){
            if(!empty($cat['categorie'])){
                $active = ($section === 'categorie' && $categorie_filter === $cat['categorie']) ? 'active' : '';
                echo '<li><a href="?section=categorie&categorie=' . htmlspecialchars($cat['categorie']) . '" class="' . $active . '">' . htmlspecialchars($cat['categorie']) . '</a></li>';
            }
        }
        ?>
        
        <li style="margin-top: 20px;"><a href="?section=contact" class="<?= $section === 'contact' ? 'active' : '' ?>">💬 Messages de contact</a></li>
    </ul>
</aside>

<!-- MAIN CONTENT -->
<main class="main-content">

<div class="container">

<div class="header-top">
    <h1>Gestion des articles</h1>
    <a class="logout" href="logout.php">Déconnexion</a>
</div>

<!-- LAYOUT DEUX COLONNES -->
<div class="dashboard-wrapper">

    <!-- COLONNE GAUCHE - FORMULAIRE BLEU -->
    <div class="left-column">
        <div class="form-add">
            <h3>Ajouter un article</h3>

            <form action="add_article.php" method="POST" enctype="multipart/form-data" style="background: transparent; padding: 0; box-shadow: none;">

            <input type="text" name="titre" placeholder="Titre" required>

            <label>Catégorie</label>
            <select name="categorie" required>
                <option value="">-- Sélectionner une catégorie --</option>
                <?php
                $categories = $pdo->query("SELECT DISTINCT categorie FROM articles WHERE categorie IS NOT NULL AND categorie != '' ORDER BY categorie");
                foreach($categories as $cat){
                    if(!empty($cat['categorie'])){
                        echo '<option value="' . htmlspecialchars($cat['categorie']) . '">' . htmlspecialchars($cat['categorie']) . '</option>';
                    }
                }
                ?>
            </select>

            <label>Photo</label>
            <input type="file" name="images" accept="image/*" required>

            <label>État de l'article</label>
            <select name="etat" required>
                <option value="brouillon">Brouillon</option>
                <option value="publiée">Publiée</option>
                <option value="archivée">Archivée</option>
            </select>

            <textarea name="contenu" placeholder="Contenu"></textarea>

            <button type="submit">Publier</button>

            </form>
        </div>
    </div>

    <!-- COLONNE DROITE - ARTICLES -->
    <div class="right-column">
        <?php if($section === 'articles' || ($section === 'categorie' && $categorie_filter)): ?>
            <h3><?= $section === 'categorie' ? htmlspecialchars($categorie_filter) : 'Les derniers articles' ?></h3>

            <?php
            if($section === 'categorie' && $categorie_filter){
                $articles = $pdo->prepare("SELECT * FROM articles WHERE categorie = :categorie ORDER BY id DESC");
                $articles->execute([':categorie' => $categorie_filter]);
                $articles = $articles->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $articles = $pdo->query("SELECT * FROM articles ORDER BY id DESC");
            }

            foreach($articles as $article){
            ?>

            <div class="article">

            <h4><?= htmlspecialchars($article['titre']) ?></h4>

            <p><strong>Catégorie :</strong>
            <form action="update_categorie.php" method="POST" style="display:inline;">
                <select name="categorie" onchange="this.form.submit()">
                    <?php
                    $cats = $pdo->query("SELECT DISTINCT categorie FROM articles WHERE categorie IS NOT NULL AND categorie != '' ORDER BY categorie");
                    foreach($cats as $cat){
                        if(!empty($cat['categorie'])){
                            $selected = ($article['categorie'] === $cat['categorie']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($cat['categorie']) . '" ' . $selected . '>' . htmlspecialchars($cat['categorie']) . '</option>';
                        }
                    }
                    ?>
                </select>
                <input type="hidden" name="id" value="<?= $article['id'] ?>">
            </form>
            </p>

            <p><strong>État :</strong>
            <form action="update_etat.php" method="POST" style="display:inline;">
                <select name="etat" onchange="this.form.submit()">
                    <option value="brouillon" <?= ($article['etat'] === 'brouillon') ? 'selected' : '' ?>>Brouillon</option>
                    <option value="publiée" <?= ($article['etat'] === 'publiée') ? 'selected' : '' ?>>Publiée</option>
                    <option value="archivée" <?= ($article['etat'] === 'archivée') ? 'selected' : '' ?>>Archivée</option>
                </select>
                <input type="hidden" name="id" value="<?= $article['id'] ?>">
            </form>
            </p>

            <p><strong>Photo :</strong>
            <form action="update_photo.php" method="POST" enctype="multipart/form-data" style="display:inline;">
                <input type="file" name="photo" accept="image/*" required>
                <input type="hidden" name="id" value="<?= $article['id'] ?>">
                <button type="submit">Mettre à jour</button>
            </form>
            </p>

            <p><strong>Contenu :</strong></p>
            <form action="update_contenu.php" method="POST" style="margin-bottom: 15px;">
                <textarea name="contenu" style="width:100%; height:150px;"><?= htmlspecialchars($article['contenu']) ?></textarea>
                <input type="hidden" name="id" value="<?= $article['id'] ?>">
                <button type="submit">Mettre à jour le contenu</button>
            </form>

            <p><?= substr($article['contenu'] ?? '', 0, 150) ?>...</p>

            <a href="delete_article.php?id=<?= $article['id'] ?>">Supprimer</a>

            </div>

            <?php } ?>
        <?php endif; ?>

        <!-- SECTION : MESSAGES DE CONTACT -->
        <?php if($section === 'contact'): ?>
            <h3>Messages de contact</h3>

            <?php
            try {
                $messages = $pdo->query("SELECT * FROM contacts ORDER BY date_creation DESC");
                $messages = $messages->fetchAll(PDO::FETCH_ASSOC);
                
                if(empty($messages)){
                    echo '<p style="text-align: center; color: #999;">Aucun message pour le moment.</p>';
                } else {
                    foreach($messages as $msg){
                    ?>
                    <div class="message">
                        <h4><?= htmlspecialchars($msg['nom'] ?? 'Sans nom') ?></h4>
                        <p><strong>Email :</strong> <a href="mailto:<?= htmlspecialchars($msg['email'] ?? '') ?>"><?= htmlspecialchars($msg['email'] ?? '') ?></a></p>
                        <p><strong>Sujet :</strong> <?= htmlspecialchars($msg['sujet'] ?? '') ?></p>
                        <p><strong>Message :</strong></p>
                        <p><?= nl2br(htmlspecialchars($msg['message'] ?? '')) ?></p>
                        <div class="message-meta">
                            <p>Reçu le : <?= isset($msg['date_creation']) ? date('d/m/Y à H:i', strtotime($msg['date_creation'])) : 'Date inconnue' ?></p>
                            <a href="delete_message.php?id=<?= $msg['id'] ?>" class="delete-btn" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
                        </div>
                    </div>
                    <?php }
                }
            } catch (PDOException $e) {
                echo '<p style="color: #e74c3c;">La table contacts n\'existe pas encore.</p>';
            }
            ?>
        <?php endif; ?>
    </div>

</div>

</div>

</main>

</body>
</html>