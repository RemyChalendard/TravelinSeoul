const url = "http://127.0.0.1:5500/evenements.json";

fetch(url)
  .then((response) => {
    console.log(response);
    return response.json();
  })

  .then((data) => {
    console.log(data);
    console.log(data[0])

    const tableau = document.querySelector(".tableau");

    for (let i = 0; i < data.evenements.length; i++) {
      const article = document.createElement("article");
      article.innerHTML = `
        <h3>${data.evenements[i].lieu}</h3>
        <p>${data.evenements[i].date}</p>
      `;

      tableau.appendChild(article);
    }
  })

