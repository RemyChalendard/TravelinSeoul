<?php
include 'includes/header.php';
require 'config.php';
$pdo = Database::getInstance()->getPDO();

?>

<h1>Les differentes lignes de métro de Seoul</h1>

<?php
try {
  $stmt = $pdo->prepare("SELECT * FROM articles WHERE CATEGORIE = 'Metro' AND etat = 'publiée' ORDER BY date_creation ASC");
  $stmt->execute();
  $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if ($articles) {
    foreach ($articles as $article) {
?>
      <div class="d-flex fd-row jc-c g-16">
        <div class="f-1-1-300">
          <?php if (!empty($article['image'])): ?>
            <img class="art-img" src="<?php echo htmlspecialchars($article['image']); ?>" alt="<?php echo htmlspecialchars($article['titre'] ?? 'Article'); ?>" width="450">
          <?php else: ?>
            <img class="art-img" src="https://via.placeholder.com/450x300?text=No+Image" alt="Pas d'image" width="450">
          <?php endif; ?>
        </div>

        <div class="text">
          <h2><?php echo htmlspecialchars($article['titre'] ?? "Article"); ?></h2>
          <?php
          $description = htmlspecialchars($article[''] ?? "");
          $description = str_replace(["\r\n", "\r"], "\n", $description);
          foreach (explode("\n", $description) as $p) {
            if (trim($p) !== '') echo "<p>" . $p . "</p>";
          }
          ?>
          <?php
          $contenu = htmlspecialchars($article['contenu'] ?? "Non renseigné");
          $contenu = str_replace(["\r\n", "\r"], "\n", $contenu);
          foreach (explode("\n", $contenu) as $p) {
            if (trim($p) !== '') echo "<p>" . $p . "</p>";
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
  echo "<p style='color: red;'><strong>Erreur :</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>

<?php include 'includes/footer.php'; ?>