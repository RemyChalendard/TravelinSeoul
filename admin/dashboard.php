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
<input type="file" name="photo" accept="image/*" required>

<textarea name="contenu" placeholder="Contenu"></textarea>

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

<p><?= htmlspecialchars($article['categorie']) ?></p>

<p><?= substr($article['contenu'],0,150) ?>...</p>

<a href="delete_article.php?id=<?= $article['id'] ?>">Supprimer</a>

</div>

<?php } ?>

</div>

</body>
</html>

<?php include "footer.php"; ?>