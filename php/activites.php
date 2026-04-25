<?php
include '../includes/header.php';
require '../config.php';

$pdo = Database::getInstance()->getPDO();
?>

<div>
  <h1 id="titre-evenements">Les évenements à venir:</h1>
</div>

<div class="tableau" id="evenements">
  <div id="activites-container">
    <div class="d-flex fd-row jc-c g-16">
      <div class="f-1-1-300">
        <div class="flex">
          <?php
          try {
            $stmt = $pdo->prepare("SELECT * FROM evenements ORDER BY date ASC");
            $stmt->execute();
            $evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($evenements) {
              foreach ($evenements as $event) {
                echo "<div>";
                echo "<h4>" . htmlspecialchars($event['titre'] ?? "Événement") . "</h4>";
                echo "<p><strong>Type :</strong> " . htmlspecialchars($event['type'] ?? "Non renseigné") . "</p>";
                echo "<p><strong>Lieu :</strong> " . htmlspecialchars($event['lieu'] ?? "Non renseigné") . "</p>";
                echo "<p><strong>Date :</strong> " . htmlspecialchars($event['date'] ?? "Non renseignée") . "</p>";
                echo "</div>";
              }
            } else {
              echo "<p>Aucun événement à venir.</p>";
            }
          } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<h1>Les Activités</h1>


<?php
try {
  $requete = $pdo->prepare("SELECT * FROM articles WHERE CATEGORIE = 'Evenements' AND etat = 'publiée' ORDER BY date_creation DESC");
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
          <p><strong> </strong> <?php echo (htmlspecialchars($article['contenu'] ?? "Non renseigné")); ?></p>
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

<?php
include '../includes/footer.php';
?>