<?php
include 'includes/header.php';
require 'config.php';
?>

<div>>
<h1> Les différents quartiers de Séoul</h1>
</div>

<?php
try {
  $requete = $pdo->prepare("SELECT * FROM articles WHERE CATEGORIE = 'Quartiers' ORDER BY date_creation ASC");
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
          <h4><strong>Description :</strong> <?php echo htmlspecialchars($event['description'] ?? "Non renseigné"); ?></h4>
          <p><strong>Contenu :</strong> <?php echo htmlspecialchars($event['contenu'] ?? "Non renseigné"); ?></p>
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

    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d202404.91416445278!2d126.80932527662358!3d37.5650337159301!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x357ca2012d5c39cf%3A0x7e11eca1405bf29b!2zU8Opb3VsLCBDb3LDqWUgZHUgU3Vk!5e0!3m2!1sfr!2sfr!4v1766410323246!5m2!1sfr!2sf"
      width="100%" height="600" allowfullscreen referrerpolicy="no-referrer-when-downgrade">
    </iframe>

    <?php
    include 'includes/footer.php'
    ?>