<?php
include '../includes/header.php';
require '../config.php';

$pdo = Database::getInstance()->getPDO();
?>

<h1>Les differentes lignes de Bus de Seoul</h1>
<div class="d-flex fd-row jc-c g-16">
  <div class="f-1-1-300">
    <img class="art-img" src="../images/buses.webp" width="450" alt="Les bus">
  </div>
  <div class="text">
    <p>Seoul dispose d'un vaste réseau de bus qui couvre toute la ville et ses environs. Les bus sont un moyen de transport populaire pour les résidents et les visiteurs, offrant une alternative pratique au métro. Il existe plusieurs types de bus à Seoul, chacun avec ses propres caractéristiques et itinéraires.</p>
    <p>Les bus à Seoul sont généralement classés en trois catégories : les bus urbains, les bus express et les bus de nuit. Les bus urbains desservent les quartiers de la ville et sont souvent utilisés pour les trajets courts. Les bus express, quant à eux, relient les zones périphériques à des points centraux de la ville, offrant un service plus rapide pour les trajets plus longs. Enfin, les bus de nuit fonctionnent pendant les heures creuses pour assurer une mobilité continue dans la ville.</p>
    <p>Les bus à Seoul sont équipés de systèmes de paiement électroniques, ce qui facilite l'accès et le paiement pour les passagers. De plus, de nombreux bus sont équipés de Wi-Fi gratuit, offrant aux passagers la possibilité de rester connectés pendant leur trajet. Le réseau de bus de Seoul est bien développé et constitue un moyen efficace de se déplacer dans la ville, en particulier pour ceux qui souhaitent explorer des zones moins accessibles par le métro.</p>
  </div>
</div>

<?php
try {
  $requete = $pdo->prepare("SELECT * FROM articles WHERE CATEGORIE = 'Bus' AND etat = 'publiée' ORDER BY date_creation ASC");
  $requete->execute();
  $articles = $requete->fetchAll(PDO::FETCH_ASSOC);

  if ($articles) {
    foreach ($articles as $article) {
?>
      <div class="d-flex fd-row jc-c g-16">
        <div class="f-1-1-300">

          <?php if (!empty($article['image'])): ?>
            <img class="art-img" src="/<?php echo htmlspecialchars($article['image']); ?>" alt="" width="450">
          <?php endif; ?>
        </div>

        <div class="text">
          <h2><?php echo htmlspecialchars($article['titre'] ?? "Article"); ?></h2>
          <?php
          $description = htmlspecialchars($article['description'] ?? "Non renseigné");
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

<?php include '../includes/footer.php'; ?>