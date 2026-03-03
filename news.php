<?php
include 'includes/header.php';
require 'config.php';
?>

<h1> <strong> Actualitées</strong></h1>


<?php
try {
  $requete = $pdo->prepare("SELECT * FROM articles WHERE CATEGORIE = 'News' ORDER BY date_creation ASC");
  $requete->execute();
 // Mode de récuperation des données sous forme de tableau associatif ou les clé sont les noms des colonnes
  $evenements = $requete->fetchAll(PDO::FETCH_ASSOC);

  if ($evenements) {
    foreach ($evenements as $event) {
      ?>
      <div class="d-flex fd-row jc-c g-16">
        <div class="f-1-1-300">
          <?php if (!empty($event['image'])): ?>
            <img class="art-img" src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['titre'] ?? 'Image'); ?>" width="450">
          <?php else: ?>
            <img class="art-img" src="https://via.placeholder.com/450x300?text=No+Image" alt="Pas d'image" width="450">
          <?php endif; ?>
        </div>
        
        <div class="text">
          <h2><?php echo htmlspecialchars($event['titre'] ?? "Article"); ?></h2>
          <p><?php echo htmlspecialchars($event['contenu'] ?? "Non renseigné"); ?></p>
          <p><strong>Auteur :</strong> <?php echo htmlspecialchars($event['auteur'] ?? "Non renseigné"); ?></p>
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
include 'includes/footer.php'
?>