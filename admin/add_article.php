<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'] ?? '';
    $categorie = $_POST['categorie'] ?? '';
    $etat = $_POST['etat'] ?? 'brouillon';
    $contenu = $_POST['contenu'] ?? '';
    $image = '';

    // DEBUG
    echo "Fichier reçu: " . (isset($_FILES['images']) ? "OUI" : "NON") . "<br>";
    
    // Uploader image
    if (isset($_FILES['images']) && $_FILES['images']['name']) {
        $dossier = dirname(__DIR__) . '/images/';
        echo "Dossier: " . $dossier . "<br>";
        echo "Existe: " . (is_dir($dossier) ? "OUI" : "NON") . "<br>";
        
        if (!is_dir($dossier)) mkdir($dossier, 0755, true);
        
        $image = basename($_FILES['images']['name']);
        echo "Image: " . $image . "<br>";
        
        if (move_uploaded_file($_FILES['images']['tmp_name'], $dossier . $image)) {
            echo "✅ Image uploadée !<br>";
        } else {
            echo "❌ Erreur upload<br>";
        }
    }

    echo "Image variable: " . ($image ? $image : "VIDE") . "<br>";
    
    // Insérer en BDD
    if (!empty($titre) && !empty($categorie)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO articles (titre, categorie, etat, contenu, image) VALUES (:titre, :categorie, :etat, :contenu, :image)");
            $stmt->execute([
                ':titre' => $titre,
                ':categorie' => $categorie,
                ':etat' => $etat,
                ':contenu' => $contenu,
                ':image' => $image
            ]);
            echo "✅ Article créé en BDD avec image: " . $image . "<br>";
        } catch (PDOException $e) {
            echo "❌ Erreur BDD: " . $e->getMessage() . "<br>";
        }
    }
}

// Pas de redirect pour voir les messages
// header("Location: dashboard.php");
// exit;
?>