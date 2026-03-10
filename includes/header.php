<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"
    content="Découvrez les meilleures activités à Séoul : visites culturelles, balades, marchés, spectacles et expériences uniques pour profiter pleinement de la capitale coréenne.">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles/styles.css">

  <title>Travel In Seoul</title>

  <style>
    /* Seoul Widget */
    #seoul-info {
      background: linear-gradient(135deg, #2A6EBB 0%, #1a416e 100%);
      color: white;
      padding: 15px 20px;
      border-radius: 5px;
      text-align: center;
      font-weight: 500;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      font-size: 16px;
      letter-spacing: 0.5px;
      margin-top: 15px;
      margin-bottom: 0;
    }

    #seoul-info #time {
      font-size: 18px;
      margin-bottom: 8px;
      font-weight: bold;
    }

    #seoul-info #weather {
      font-size: 16px;
      opacity: 0.95;
    }

    /* Responsive Mobile */
    @media (max-width: 780px) {
      #seoul-info {
        padding: 12px 15px;
        font-size: 14px;
        margin-top: 12px;
      }

      #seoul-info #time {
        font-size: 16px;
        margin-bottom: 6px;
      }

      #seoul-info #weather {
        font-size: 14px;
      }
    }
  </style>
</head>

<body>
  <header>
    <img src="images/logoseoul.png" alt="Logo Seoul" width="200" height="200">
    <h1>TRAVEL IN SEOUL</h1>

    <!-- Widget Séoul -->
    <div id="seoul-info">
      <div id="time"></div>
      <div id="weather"></div>
    </div>

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
          <a href="restaurant.php">FOODS</a>
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
      // Burger Menu
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
      

      // Seoul Widget - Heure et Météo
      function updateTime() {
        const seoulTime = new Date().toLocaleString('fr-FR', {
          timeZone: 'Asia/Seoul',
          hour: '2-digit',
          minute: '2-digit',
          second: '2-digit'
        });
        document.getElementById('time').textContent = '🕐 Séoul: ' + seoulTime;
      }

      async function getWeather() {
        try {
          const response = await fetch(
            'https://api.open-meteo.com/v1/forecast?latitude=37.5665&longitude=126.9780&current=temperature_2m,weather_code'
          );
          const data = await response.json();
          const temp = data.current.temperature_2m;
          document.getElementById('weather').textContent = `🌡️ Météo: ${temp}°C`;
        } catch (error) {
          console.error('Erreur météo:', error);
        }
      }

      // Initialisation et mise à jour
      updateTime();
      getWeather();
      setInterval(updateTime, 1000);
      setInterval(getWeather, 600000); // Mise à jour météo toutes les 10 minutes
    </script>