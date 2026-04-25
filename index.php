<?php
// var_dump($_ENV);
include 'includes/header.php';
require 'config.php';

$pdo = Database::getInstance()->getPDO();
?>

<h1> <strong> Seoul - La ville de l'âme</strong></h1>

<?php
try {
  $requete = $pdo->prepare("SELECT * FROM articles WHERE CATEGORIE = 'Accueil' AND etat = 'publiée' ORDER BY date_creation ASC");
  $requete->execute();
  // Mode de récuperation des données sous forme de tableau associatif ou les clé sont les noms des colonnes
  $evenements = $requete->fetchAll(PDO::FETCH_ASSOC);

  if ($evenements) {
    foreach ($evenements as $event) {
?>
      <div class="d-flex fd-row jc-c g-16">
        <div class="f-1-1-300">

          <?php if (!empty($event['image'])): ?>
            <?php
            $image_src = '/' . ltrim($image_src, '/');            ?>
            <img class="art-img" src="<?php echo htmlspecialchars($image_src); ?>" alt="" width="450">
          <?php endif; ?>
        </div>

        <div class="text">
          <h2><?php echo htmlspecialchars($event['titre'] ?? "Article"); ?></h2>
          <?php
          $contenu = htmlspecialchars($event['contenu'] ?? "Non renseigné");
          $contenu = str_replace(["\r\n", "\r"], "\n", $contenu);
          $paragraphes = explode("\n", $contenu);
          foreach ($paragraphes as $p) {
            if (trim($p) !== '') {
              echo "<p>" . $p . "</p>";
            }
          }
          ?>
        </div>
      </div>
<?php

    }
  } else {
    echo "<p>Aucun quartier à afficher.</p>";
  }
} catch (PDOException $e) {
  echo "Erreur : " . $e->getMessage();
}
?>

<?php
include 'includes/footer.php';
?>