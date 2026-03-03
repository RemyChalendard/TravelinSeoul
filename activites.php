<?php
require 'config.php';
?>

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
    <nav>
      <a href="index.php">HOME</a>
      <a href="news.php">NEWS</a>
      <a href="restautant.php">FOODS</a>
      <a href="activites.php">ACTIVITIES</a>
      <a href="Quartiers.php">DISTRICTS</a>
      <a href="language.php">HANGEUL</a>
      <a href="bus.php">LIGNES DE BUS</a>
      <a href="metro.php">LIGNES DE METRO</a>
      <a href="contact.php">CONTACT</a>
    </nav>
  </header>

  <main>
    <!-- Affichage des événements -->
    <h3 id="titre-evenements">Les évenements à venir:</h3>
    <div class="tableau" id="evenements"></div>

    <h3>Les Activités</h3>
    <div id="evenements"></div>
    <div id="activites-container"></div>
  </main>

  <footer>
    <h5>CONTACTEZ-NOUS</h5>
    
    <section id="logo">
      <a href="https://facebook.com/seoulcitykorea">
        <img class="art-img" src="https://cdn-icons-png.flaticon.com/128/739/739135.png" width="50" height="50"
          alt="Facebook">
      </a>
      <a href="https://www.instagram.com/seoulcity?igsh=MXBmaXN4eGx5eiQ3aQ==">
        <img class="art-img" src="https://cdn-icons-png.flaticon.com/128/1409/1409946.png" width="50" height="50"
          alt="Instagram">
      </a>
      <a href="https://www.instagram.com/seoulcity?igsh=MXBmaXN4eGx5eiQ3aQ==">
        <img class="art-img" src="images/Naver_Icon_1.webp" width="50" height="50" alt="Naver" />
      </a>
      <h5>Un projet de :Chalendard Rémy</h5>
    </section>
  </footer>

    <!-- Tableau activitées -->
  <script>
    fetch('./evenements.json')
      .then(response => response.json())
      .then(data => {
        const container = document.getElementById('evenements');

        if (data.evenements && data.evenements.length) {
          data.evenements.forEach(event => {
            const div = document.createElement('div');
            div.innerHTML = `
          <h4>${event.type || "Événement"}</h4>
          <p><strong>Lieu :</strong> ${event.lieu || "Non renseigné"}</p>
          <p><strong>Date :</strong> ${event.date || "Non renseignée"}</p>
        `;
            container.appendChild(div);
          });
        } else {
          container.innerHTML = "<p>Aucun événement à venir.</p>";
        }
      })
      .catch(err => console.error("Erreur lors du chargement du JSON événements :", err));
  </script>

    <!-- Article des activitées -->
  <script>
    fetch('activites.json')
      .then(response => response.json())
      .then(data => {
        const container = document.getElementById('activites-container');

        data.activites.forEach(act => {
          const card = document.createElement('div');
          card.classList.add('d-flex', 'fd-row', 'jc-c', 'g-16');

          const imgDiv = document.createElement('div');
          imgDiv.classList.add('f-1-1-300');
          imgDiv.innerHTML = `<img class="art-img" src="${act.image}" width="450" alt="${act.titre}">`;

          const textDiv = document.createElement('div');
          textDiv.classList.add('text');
          textDiv.innerHTML = `
            <h2>${act.titre}</h2>
            ${act.lieu ? `<h4>${act.lieu}</h4>` : ""}
            <p>${act.description}</p>
            ${act.bouton ? `<p><strong>Visiter le site officiel: ${act.bouton}</strong></p>` : ""}
          `;

          card.appendChild(imgDiv);
          card.appendChild(textDiv);
          container.appendChild(card);
        });
      })
      .catch(err => console.error("Erreur lors du chargement du JSON :", err));
  </script>
  
</body>

</html>
