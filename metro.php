<?php
include 'includes/header.php';
require 'config.php';
?>

<h3>Les differentes lignes de métro de Seoul</h3>
<div class="d-flex fd-row jc-c g-16">
  <div class="f-1-1-300">
    <img class="art-img" src="images/metro-de-Seoul.webp" width="450" alt="Les métros">
  </div>
  <div class="text">
    <p> Séoul dispose de l'un des réseaux de métro les plus impressionnants au monde.
      Avec 9 lignes principales numérotées de 1 à 9, auxquelles s'ajoutent plusieurs lignes secondaires,
      le métro dessert l'ensemble de la ville ainsi que sa grande banlieue.
      Inauguré en 1974 avec la ligne 1, le réseau s'est considérablement développé au fil des décennies
      pour atteindre aujourd'hui plus de 300 stations.
      Réputé pour sa ponctualité, sa propreté et sa modernité,
      il est considéré comme l'un des meilleurs systèmes de transport en commun au monde.
      Accessible grâce à la carte T-money, il permet de se déplacer facilement dans toute la métropole à un tarif
      abordable, faisant du métro le moyen de transport privilégié aussi bien des habitants que des touristes.</p>
    <p>Le métro de Séoul est également connu pour son confort et sa sécurité.
      Les rames sont modernes, climatisées et équipées de Wi-Fi gratuit, offrant une expérience agréable aux passagers.
      De plus, le réseau est bien entretenu et surveillé, garantissant la sécurité des usagers à tout moment.
      Les stations sont également dotées de nombreuses commodités, telles que des boutiques, des restaurants et des services de conciergerie,
      ce qui rend l'expérience du métro encore plus agréable pour les voyageurs.</p>
    <p>En plus de son efficacité, le métro de Séoul est également un symbole de la modernité et du dynamisme de la ville.
      Il joue un rôle crucial dans la vie quotidienne des Séouliens, facilitant les déplacements et contribuant à la réduction de la congestion routière.
      Que ce soit pour se rendre au travail, faire du shopping ou explorer les nombreux quartiers de la ville,
      le métro de Séoul est un moyen de transport incontournable pour tous ceux qui souhaitent découvrir cette métropole vibrante.</p>
  </div>
</div>

<?php
try {
  $requete = $pdo->prepare("SELECT * FROM articles WHERE CATEGORIE = 'Metro' AND statut = 'publie' ORDER BY date_creation ASC");
  $requete->execute();
  $articles = $requete->fetchAll(PDO::FETCH_ASSOC);

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