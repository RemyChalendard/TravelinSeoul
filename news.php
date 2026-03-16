<?php
include 'includes/header.php';
require 'config.php';
$pdo = Database::getInstance()->getPDO();

?>

<h1><strong>Actualitées</strong></h1>

<?php
try {
  $stmt = $pdo->prepare("SELECT * FROM articles WHERE categorie = 'News' AND etat = 'publiée' ORDER BY id DESC");
  $stmt->execute();
  $evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if ($evenements) {
    foreach ($evenements as $event) {
?>
      <div class="d-flex fd-row jc-c g-16">
        <div class="f-1-1-300">

          <?php if (!empty($event['image'])): ?>
            <?php
            $image_src = strpos($event['image'], 'images/') === 0 ? $event['image'] : 'images/' . $event['image'];
            ?>
            <img src="<?php echo htmlspecialchars($image_src); ?>" alt="" width="450">
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
    echo "<p>Aucun article à afficher.</p>";
  }
} catch (PDOException $e) {
  echo "Erreur : " . $e->getMessage();
}
?>

<?php
include 'includes/footer.php';
?>