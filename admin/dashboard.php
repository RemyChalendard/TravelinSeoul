<?php
require_once("../admin/db.php");  
include "../admin/header.php";      
?>

<?php
require 'db.php';

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>
<link rel="stylesheet" href="/travelInSeoul/styles/admin.css">

</head>

<body>

<div class="container">

<h1>Gestion des articles</h1>

<a class="logout" href="logout.php">Déconnexion</a>

<h3>Ajouter un article</h3>

<form action="add_article.php" method="POST" enctype="multipart/form-data">

<input type="text" name="titre" placeholder="Titre" required>

<label>Catégorie</label>
<select name="categorie" required>
    <option value="">-- Sélectionner une catégorie --</option>
    <?php
    $categories = $pdo->query("SELECT DISTINCT categorie FROM articles ORDER BY categorie");
    foreach($categories as $cat){
        echo '<option value="' . htmlspecialchars($cat['categorie']) . '">' . htmlspecialchars($cat['categorie']) . '</option>';
    }
    ?>
</select>

<label>Photo</label>
<input type="file" name="images" accept="images/*" required>

<label>État de l'article</label>
<select name="etat" required>
    <option value="brouillon">Brouillon</option>
    <option value="publiée">Publiée</option>
    <option value="archivée">Archivée</option>
</select>

<button type="submit">Publier</button>

</form>

<hr>

<h3>Articles existants</h3>

<?php
$articles = $pdo->query("SELECT * FROM articles ORDER BY id DESC");

foreach($articles as $article){
?>

<div class="article">

<h4><?= htmlspecialchars($article['titre']) ?></h4>

<p><strong>Catégorie :</strong>
<form action="update_categorie.php" method="POST" style="display:inline;">
    <select name="categorie" onchange="this.form.submit()">
        <?php
        $categories = $pdo->query("SELECT DISTINCT categorie FROM articles ORDER BY categorie");
        foreach($categories as $cat){
            $selected = ($article['categorie'] === $cat['categorie']) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($cat['categorie']) . '" ' . $selected . '>' . htmlspecialchars($cat['categorie']) . '</option>';
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
</form>
</p>

<p><strong>État :</strong></p>
<form action="update_etat.php" method="POST" style="margin-bottom: 15px;">
    <input type="hidden" name="id" value="<?= $article['id'] ?>">
</form>

<p><?= substr($article['etat'] ?? '', 0, 150) ?>...</p>

<a href="delete_article.php?id=<?= $article['id'] ?>">Supprimer</a>

</div>

<?php } ?>

</div>

</body>
</html>

<?php include "footer.php"; ?>