<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'] ?? '';
    $categorie = $_POST['categorie'] ?? '';
    $etat = $_POST['etat'] ?? 'brouillon';
    $contenu = $_POST['contenu'] ?? '';
    $image = '';

    // Uploader image
    if (isset($_FILES['images']) && $_FILES['images']['name']) {
        $dossier = dirname(__DIR__) . '/images/';
        
        if (!is_dir($dossier)) mkdir($dossier, 0755, true);
        
        $image = basename($_FILES['images']['name']);
        move_uploaded_file($_FILES['images']['tmp_name'], $dossier . $image);
    }
    
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
            $success = true;
        } catch (PDOException $e) {
            echo "❌ Erreur : " . $e->getMessage();
        }
    }
}

if ($success) {
    echo "✅ Article créé avec succès ! Redirection dans 5 secondes...";
    echo "<script>
        setTimeout(function() {
            window.location.href = 'dashboard.php';
        }, 5000);
    </script>";
    exit;
}
?>