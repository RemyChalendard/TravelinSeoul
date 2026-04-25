<?php
require_once("../admin/db.php");
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$section = $_GET['section'] ?? 'articles';
$categorie_filter = $_GET['categorie'] ?? '';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
 <link rel="stylesheet" href="../styles/admin.css">
<link rel="stylesheet" href="../styles/dashboard.css">>
    <style>

    </style>
</head>

<body>

    <!-- Barre Latérale -->
    <aside class="sidebar">
        <h2>Dashboard</h2>

        <ul>
            <li><a href="?section=articles" class="<?= $section === 'articles' ? 'active' : '' ?>">Tous les articles</a></li>

            <li style="margin-top: 20px; padding: 0 15px;">
                <strong style="color: rgba(255,255,255,0.7); font-size: 12px;">CATÉGORIES</strong>
            </li>

            <?php
            $categories = $pdo->query("SELECT DISTINCT categorie FROM articles WHERE categorie IS NOT NULL AND categorie != '' ORDER BY categorie");
            foreach ($categories as $cat) {
                if (!empty($cat['categorie'])) {
                    $active = ($section === 'categorie' && $categorie_filter === $cat['categorie']) ? 'active' : '';
                    echo '<li><a href="?section=categorie&categorie=' . htmlspecialchars($cat['categorie']) . '" class="' . $active . '">' . htmlspecialchars($cat['categorie']) . '</a></li>';
                }
            }
            ?>

            <li style="margin-top: 20px;"><a href="?section=contact" class="<?= $section === 'contact' ? 'active' : '' ?>">Messages de contact</a></li>
        </ul>
    </aside>

    <!-- Barre du haut de page -->
    <main class="main-content">

        <div class="container">

            <div class="header-top">
                <h1>Gestion des articles</h1>
                <a class="logout" href="logout.php">Déconnexion</a>
            </div>

            <div class="dashboard-wrapper">

                <!-- Contenu Principal -->
                <div class="left-column">
                    <div class="form-add">
                        <h3>Ajouter un article</h3>

                        <form action="add_article.php" method="POST" enctype="multipart/form-data" style="background: transparent; padding: 0; box-shadow: none;">

                            <input type="text" name="titre" placeholder="Titre" required>

                            <label>Catégorie</label>
                            <select name="categorie" required>
                                <option value="">-- Sélectionner une catégorie --</option>
                                <?php
                                $categories = $pdo->query("SELECT DISTINCT categorie FROM articles WHERE categorie IS NOT NULL AND categorie != '' ORDER BY categorie");
                                foreach ($categories as $cat) {
                                    if (!empty($cat['categorie'])) {
                                        echo '<option value="' . htmlspecialchars($cat['categorie']) . '">' . htmlspecialchars($cat['categorie']) . '</option>';
                                    }
                                }
                                ?>
                            </select>

                            <label>Photo</label>
                            <input type="file" name="images" required>


                            <select name="etat" required>
                                <option value="brouillon">Brouillon</option>
                                <option value="publiée">Publiée</option>
                                <option value="archivée">Archivée</option>
                            </select>

                            <textarea name="contenu" placeholder="Contenu"></textarea>

                            <button type="submit">Publier</button>

                        </form>
                    </div>
                </div>

                <div class="right-column">
                    <?php if ($section === 'articles' || ($section === 'categorie' && $categorie_filter)): ?>
                        <h3><?= $section === 'categorie' ? htmlspecialchars($categorie_filter) : 'Les derniers articles' ?></h3>

                        <?php
                        if ($section === 'categorie' && $categorie_filter) {
                            $articles = $pdo->prepare("SELECT * FROM articles WHERE categorie = :categorie ORDER BY id DESC");
                            $articles->execute([':categorie' => $categorie_filter]);
                            $articles = $articles->fetchAll(PDO::FETCH_ASSOC);
                        } else {
                            $articles = $pdo->query("SELECT * FROM articles ORDER BY id DESC");
                        }

                        foreach ($articles as $article) {
                        ?>

                            <div class="article">

                                <h4><?= htmlspecialchars($article['titre']) ?></h4>

                                <p><strong>Catégorie :</strong>
                                <form action="update_categorie.php" method="POST" style="display:inline;">
                                    <select name="categorie" onchange="this.form.submit()">
                                        <?php
                                        $cats = $pdo->query("SELECT DISTINCT categorie FROM articles WHERE categorie IS NOT NULL AND categorie != '' ORDER BY categorie");
                                        foreach ($cats as $cat) {
                                            if (!empty($cat['categorie'])) {
                                                $selected = ($article['categorie'] === $cat['categorie']) ? 'selected' : '';
                                                echo '<option value="' . htmlspecialchars($cat['categorie']) . '" ' . $selected . '>' . htmlspecialchars($cat['categorie']) . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <input type="hidden" name="id" value="<?= $article['id'] ?>">
                                </form>
                                </p>

                                <p><strong>État :</strong>
                                <form action="update_etat.php" method="POST" style="display:inline;">
                                    <select name="etat" onchange="this.form.submit()">
                                        <option value="brouillon" <?= ($article['etat'] === 'brouillon') ? 'selected' : '' ?>>Brouillon</option>
                                        <option value="publiée" <?= ($article['etat'] === 'publiée') ? 'selected' : '' ?>>Publiée</option>
                                        <option value="archivée" <?= ($article['etat'] === 'archivée') ? 'selected' : '' ?>>Archivée</option>
                                    </select>
                                    <input type="hidden" name="id" value="<?= $article['id'] ?>">
                                </form>
                                </p>

                                <p><strong>Photo :</strong>
                                <form action="update_photo.php" method="POST" enctype="multipart/form-data" style="display:inline;">
                                    <input type="file" name="photo" accept="image/*" required>
                                    <input type="hidden" name="id" value="<?= $article['id'] ?>">
                                    <button type="submit">Mettre à jour</button>
                                </form>
                                </p>

                                <p><strong>Contenu :</strong></p>
                                <form action="update_contenu.php" method="POST" style="margin-bottom: 15px;">
                                    <textarea name="contenu" style="width:100%; height:150px;"><?= htmlspecialchars($article['contenu']) ?></textarea>
                                    <input type="hidden" name="id" value="<?= $article['id'] ?>">
                                    <button type="submit">Mettre à jour le contenu</button>
                                </form>

                                <p><?= substr($article['contenu'] ?? '', 0, 150) ?>...</p>

                                <a href="delete_article.php?id=<?= $article['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">Supprimer</a>

                            </div>

                        <?php } ?>
                    <?php endif; ?>

                    <!-- CONTACT -->
                    <?php if ($section === 'contact'): ?>
                        <h3>Messages de contact</h3>

                        <?php
                        try {

                            $messages = $pdo->query("SELECT * FROM contact_messages ORDER BY date_envoi DESC");

                            if ($messages === false) {
                                echo '<p style="color: red;">Erreur SQL</p>';
                            } else {
                                $messages = $messages->fetchAll(PDO::FETCH_ASSOC);

                                if (empty($messages)) {
                                    echo '<p style="text-align: center; color: #999;">Aucun message pour le moment.</p>';
                                } else {
                                    echo '<p>Messages trouvés : ' . count($messages) . '</p>';
                                    foreach ($messages as $msg) {
                        ?>
                                        <div class="message">
                                            <h4><?= htmlspecialchars($msg['nom'] ?? 'Sans nom') ?> <?= htmlspecialchars($msg['prenom'] ?? '') ?></h4>
                                            <p><strong>Email :</strong> <?= htmlspecialchars($msg['email'] ?? 'N/A') ?></p>
                                            <p><strong>Message :</strong></p>
                                            <p><?= nl2br(htmlspecialchars($msg['message'] ?? 'N/A')) ?></p>
                                            <div class="message-meta">
                                                <p>Reçu le : <?= $msg['date_envoi'] ?? 'Date inconnue' ?></p>
                                                <a href="response.php?id=<?= $msg['id'] ?>" class="btn-repondre">Répondre</a>
                                                <a href="/admin/delete_article.php?id=<?= $msg['id'] ?>" class="delete-btn">Supprimer</a>
                                            </div>
                                        </div>
                        <?php }
                                }
                            }
                        } catch (PDOException $e) {
                            echo '<p style="color: red;">Erreur : ' . $e->getMessage() . '</p>';
                        }
                        ?>
                    <?php endif; ?>
                </div>

            </div>

        </div>

    </main>

</body>

</html>