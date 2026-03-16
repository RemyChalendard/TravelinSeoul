<?php
session_start();
require_once "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $titre = $_POST['titre'] ?? '';
    $categorie = $_POST['categorie'] ?? '';
    $etat = $_POST['etat'] ?? 'brouillon';
    $contenu = $_POST['contenu'] ?? '';
    $image = '';
    
    // Traiter l'upload d'image
    if(isset($_FILES['images']) && $_FILES['images']['error'] === UPLOAD_ERR_OK){
        $photo = $_FILES['images'];
        $upload_dir = '../images/';
        
        if(!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        
        $filename = uniqid() . "_" . basename($photo['name']);
        $filepath = $upload_dir . $filename;
        
        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if(in_array($photo['type'], $allowed)){
            if(move_uploaded_file($photo['tmp_name'], $filepath)){
                $image = $filename;
            }
        }
    }
    
    if(!empty($titre) && !empty($categorie)){
        try {
            $stmt = $pdo->prepare("INSERT INTO articles (titre, categorie, etat, contenu, image) VALUES (:titre, :categorie, :etat, :contenu, :image)");
            $stmt->execute([
                ':titre' => $titre,
                ':categorie' => $categorie,
                ':etat' => $etat,
                ':contenu' => $contenu,
                ':image' => $image
            ]);
            echo '<p style="color: green;">Article créé avec succès !</p>';
        } catch (PDOException $e) {
            echo '<p style="color: red;">Erreur : ' . $e->getMessage() . '</p>';
        }
    } else {
        echo '<p style="color: red;">Veuillez remplir tous les champs obligatoires.</p>';
    }
}

header("Location: dashboard.php");
exit;
?>