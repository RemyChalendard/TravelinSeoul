const url = "http://127.0.0.1:5500/evenements.json";

fetch(url)
  .then((response) => {
    console.log(response);
    return response.json();
  })
  .then((data) => {
    console.log(data);
    console.log(data[0].name);

    // Sélectionner l'élément où les articles vont être ajoutés
    const evenements = document.getElementById("evenements");

    // Parcourir les données pour créer et ajouter des articles
    for (let i = 0; i < data.length; i++) {
      const article = document.createElement("article");
      article.innerHTML = `
        <h2>${data[i].name}</h2>
        <p>${data[i].description}</p>
      `;
      evenements.appendChild(article);
    }
  })
  .catch((error) => {
    console.error("Erreur lors de la récupération des données:", error);
  });
