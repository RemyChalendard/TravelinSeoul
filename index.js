const url = "https://remychalendard.github.io/evenements.json";

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
        <h5>${data.evenements[i].lieu}</h5>
        <h6>${data.evenements[i].date}</h6>
      `;

      tableau.appendChild(article);
    }
  })

