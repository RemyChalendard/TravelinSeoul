<?php
include 'includes/header.php';
require 'config.php';

$pdo = Database::getInstance()->getPDO();

?>

<h1>La création du Hangeul</h1>

<?php
try {
  $stmt = $pdo->prepare("SELECT * FROM articles WHERE CATEGORIE = 'Hangeul' AND etat = 'publiée' ORDER BY date_creation ASC");
  $stmt->execute();
 // Mode de récuperation des données sous forme de tableau associatif ou les clé sont les noms des colonnes
  $evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if ($evenements) {
    foreach ($evenements as $event) {
      ?>
      <div class="d-flex fd-row jc-c g-16">
        <div class="f-1-1-300">

          <?php if (!empty($event['image'])): ?>
            <?php
            $image_src = strpos($event['image'], 'images/') === 0 ? $event['image'] : 'images/' . $event['image'];
            ?>
            <img class="art-img" src="<?php echo htmlspecialchars($image_src); ?>" alt="" width="450">
          <?php endif; ?>
        </div>
        
        <div class="text">
          <h2><?php echo htmlspecialchars($event['titre'] ?? "Article"); ?></h2>
          <p><?php echo htmlspecialchars($event['contenu'] ?? "Non renseigné"); ?></p>
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

<h1>Tableau des lettres Hangeul</h1>

<table id="hangeulTable"></table>

<script>
  const letters = [
    // Consonnes simples
    {
      kr: "ㄱ",
      rom: "g/k"
    }, {
      kr: "ㄴ",
      rom: "n"
    },
    {
      kr: "ㄷ",
      rom: "d/t"
    }, {
      kr: "ㄹ",
      rom: "r/l"
    },
    {
      kr: "ㅁ",
      rom: "m"
    }, {
      kr: "ㅂ",
      rom: "b/p"
    },
    {
      kr: "ㅅ",
      rom: "s"
    }, {
      kr: "ㅇ",
      rom: "ng/—"
    },
    {
      kr: "ㅈ",
      rom: "j"
    }, {
      kr: "ㅊ",
      rom: "ch"
    },
    {
      kr: "ㅋ",
      rom: "k"
    }, {
      kr: "ㅌ",
      rom: "t"
    },
    {
      kr: "ㅍ",
      rom: "p"
    }, {
      kr: "ㅎ",
      rom: "h"
    },

    // Consonnes doubles
    {
      kr: "ㄲ",
      rom: "kk"
    }, {
      kr: "ㄸ",
      rom: "tt"
    },
    {
      kr: "ㅃ",
      rom: "pp"
    }, {
      kr: "ㅆ",
      rom: "ss"
    },
    {
      kr: "ㅉ",
      rom: "jj"
    },

    // Voyelles simples
    {
      kr: "ㅏ",
      rom: "a"
    }, {
      kr: "ㅑ",
      rom: "ya"
    },
    {
      kr: "ㅓ",
      rom: "eo"
    }, {
      kr: "ㅕ",
      rom: "yeo"
    },
    {
      kr: "ㅗ",
      rom: "o"
    }, {
      kr: "ㅛ",
      rom: "yo"
    },
    {
      kr: "ㅜ",
      rom: "u"
    }, {
      kr: "ㅠ",
      rom: "yu"
    },
    {
      kr: "ㅡ",
      rom: "eu"
    }, {
      kr: "ㅣ",
      rom: "i"
    },

    // Voyelles combinées / diphtongues
    {
      kr: "ㅐ",
      rom: "ae"
    }, {
      kr: "ㅒ",
      rom: "yae"
    },
    {
      kr: "ㅔ",
      rom: "e"
    }, {
      kr: "ㅖ",
      rom: "ye"
    },
    {
      kr: "ㅘ",
      rom: "wa"
    }, {
      kr: "ㅙ",
      rom: "wae"
    },
    {
      kr: "ㅚ",
      rom: "oe"
    }, {
      kr: "ㅝ",
      rom: "wo"
    },
    {
      kr: "ㅞ",
      rom: "we"
    }, {
      kr: "ㅟ",
      rom: "wi"
    },
    {
      kr: "ㅢ",
      rom: "ui"
    }
  ];

  //Permet d'interragir avec le hangeulTable du HTML
  const table = document.getElementById("hangeulTable");

  const columns = 5;
  let row;

  letters.forEach((item, index) => {
    if (index % columns === 0) {
      row = document.createElement("tr"); // Tr = Table row
      table.appendChild(row);
    }

    const cell = document.createElement("td"); // Td = Table data
    cell.textContent = item.kr;

    //Permet de changer l'ellement du tableau "cell"
    // Cette partie permet de switché entre kr et rom
    cell.addEventListener("click", () => {
      cell.textContent = (cell.textContent === item.kr) ? item.rom : item.kr;
    });

    row.appendChild(cell);
  });
</script>

<?php
include 'includes/footer.php'
?>