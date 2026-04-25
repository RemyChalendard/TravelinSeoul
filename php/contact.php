<?php
include '../includes/header.php';
require '../config.php';

$pdo = Database::getInstance()->getPDO();
?>

<style>
  .success {
    outline: 2px solid green;
  }

  .error {
    outline: 2px solid red; 
  }

  .success-checked::before {
    content: "✓ ";
    color: green;
  }

  .message-success {
    background-color: #d4edda;
    color: #155724;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    border: 1px solid #c3e6cb;
  }

  .message-error {
    background-color: #f8d7da;
    color: #721c24;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    border: 1px solid #f5c6cb;
  }
</style>

<?php
// Traiter le formulaire
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $mail = $_POST['mail'] ?? '';
    $message = $_POST['message'] ?? '';
    
    // Validation basique
    if(!empty($nom) && !empty($prenom) && !empty($mail) && !empty($message)){
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_messages (nom, prenom, email, message) VALUES (:nom, :prenom, :email, :message)");
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':email' => $mail,
                ':message' => $message
            ]);
            
            $success_message = "✓ Votre message a été envoyé avec succès !";
        } catch (PDOException $e) {
            $error_message = "Erreur lors de l'envoi du message. Veuillez réessayer.";
        }
    } else {
        $error_message = "Veuillez remplir tous les champs.";
    }
}
?>

<?php if(isset($success_message)): ?>
    <div class="message-success"><?= $success_message ?></div>
<?php endif; ?>

<?php if(isset($error_message)): ?>
    <div class="message-error"><?= $error_message ?></div>
<?php endif; ?>

<div class="d-flex fd-row jc-c g-16">
  <div class="f-1-1-300">
    <form id="contactForm" method="POST" action="">
      <div class="form">
        <div>
          <label for="nom">Nom</label>
          <input type="text" id="nom" name="nom" placeholder="Votre nom" required autocomplete="family-name">
        </div>

        <div>
          <label for="prenom">Prénom</label>
          <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" required autocomplete="name">
        </div>
      </div>

      <div>
        <label for="mail">Email</label>
        <input type="email" id="mail" name="mail" placeholder="exemple@mail.com" required autocomplete="email">
      </div>

      <div>
        <label for="message">Message</label>
        <textarea id="message" name="message" placeholder="Écrivez votre message " rows="10" required></textarea>
      </div>

      <button type="submit" class="btn">Envoyer</button>
    </form>
  </div>
</div>

<script>
  const form = document.getElementById("contactForm");

  const nom = document.getElementById("nom");
  const prenom = document.getElementById("prenom");
  const mail = document.getElementById("mail");
  const message = document.getElementById("message");

  const emailRegex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;

  prenom.addEventListener("input", () => {
    if (prenom.value.length >= 2 && prenom.value.length <= 20) {
      prenom.classList.add("success");
      prenom.classList.remove("error");
    } else {
      prenom.classList.add("error");
      prenom.classList.remove("success");
    }
  });

  nom.addEventListener("input", () => {
    if (nom.value.length >= 2 && nom.value.length <= 20) {
      nom.classList.add("success");
      nom.classList.remove("error");
    } else {
      nom.classList.add("error");
      nom.classList.remove("success");
    }
  });

  mail.addEventListener("input", () => {
    if (emailRegex.test(mail.value)) {
      mail.classList.add("success");
      mail.classList.remove("error");
    } else {
      mail.classList.add("error");
      mail.classList.remove("success");
    }
  });

  // Réinitialiser le formulaire après succès
  form.addEventListener("submit", function(e) {
    // Le formulaire sera soumis normalement
    // PHP traitera l'insertion en base
  });
</script>

<?php
include '../includes/footer.php';
?>