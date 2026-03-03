<?php
include 'includes/header.php';
require 'config.php';
?>

<!-- Affichage des événements -->
<h3 id="titre-evenements">Les évenements à venir:</h3>

<div class="tableau" id="evenements">
<?php
try {
    $requete = $pdo->prepare("SELECT * FROM evenements ORDER BY date ASC");
    $requete->execute();
    $evenements = $requete->fetchAll(PDO::FETCH_ASSOC);

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

<div id="evenements"></div>
<div id="activites-container"></div>

<h3>Les Activités</h3>
<!-- <div id="evenements"> -->
<div id="activites-container">
<?php
try {
    $requete = $pdo->prepare("SELECT * FROM articles ORDER BY date_creation ASC");
    $requete->execute();
    $evenements = $requete->fetchAll(PDO::FETCH_ASSOC);

    if ($evenements) {
        foreach ($evenements as $event) {
            echo "<div>";
            echo "<h4>" . htmlspecialchars($event['titre'] ?? "articles") . "</h4>";
            echo "<p><strong>Titre :</strong> " . htmlspecialchars($event['titre'] ?? "Non renseigné") . "</p>";
            echo "<p><strong>Description :</strong> " . htmlspecialchars($event['description'] ?? "Non renseigné") . "</p>";
            echo "<p><strong>Contenu :</strong> " . htmlspecialchars($event['contenu'] ?? "Non renseignée") . "</p>";
            echo "<p><strong>Images :</strong> " . ($event['image'] ?? "Non renseignée") . "</p>";
            echo "<p><strong>Auteur :</strong> " . htmlspecialchars($event['auteur'] ?? "Non renseignée") . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>Aucun événement à venir.</p>";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
<!-- </div> -->
</div>

<?php
include 'includes/footer.php'
?>