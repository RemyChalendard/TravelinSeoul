<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"
    content="Découvrez les meilleures activités à Séoul : visites culturelles, balades, marchés, spectacles et expériences uniques pour profiter pleinement de la capitale coréenne.">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <title>Travel In Seoul</title>
</head>

<body>
  <header>
    <h1>TRAVEL IN SEOUL</h1>
     <nav class="navbar">
      <div class="nav-container">
        <button class="burger-menu" id="burgerMenu">
          <span></span>
          <span></span>
          <span></span>
        </button>
        
        <div class="nav-links" id="navLinks">
          <a href="index.php">HOME</a>
          <a href="news.php">NEWS</a>
          <a href="restautant.php">FOODS</a>
          <a href="activites.php">ACTIVITIES</a>
          <a href="Quartiers.php">DISTRICTS</a>
          <a href="language.php">HANGEUL</a>
          <a href="bus.php">LIGNES DE BUS</a>
          <a href="metro.php">LIGNES DE METRO</a>
          <a href="contact.php">CONTACT</a>
        </div>
      </div>
    </nav>
  </header>
  <main>

  <script>
    const burgerMenu = document.getElementById('burgerMenu');
    const navLinks = document.getElementById('navLinks');

    burgerMenu.addEventListener('click', () => {
      burgerMenu.classList.toggle('active');
      navLinks.classList.toggle('active');
    });

    navLinks.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        burgerMenu.classList.remove('active');
        navLinks.classList.remove('active');
      });
    });
  </script>
