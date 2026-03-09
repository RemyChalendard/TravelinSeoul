<?php
include 'includes/header.php';
require 'config.php';
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
</style>


<div class="d-flex fd-row jc-c g-16">
  <div class="f-1-1-300">
    <form id="contactForm">
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

  form.email.addEventListener("input", (e) => {
    if (emailRegex.test(form.email.value)) {
      form.email.classList.remove("error");
      form.email.classList.add("success");
      console.log("ok");
    } else {
      form.email.classList.remove("success");
      form.email.classList.add("error");
      console.log("KO");
    }
  });
</script>

<?php
include 'includes/footer.php'
?>