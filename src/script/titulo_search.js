
const titleSearchList = (search) => {
  const feed = document.querySelector('.feed');

  fetch(`http://www.omdbapi.com/?apikey=700c6c7d&s=${search}`)
  .then(response => response.json())
  .then(response => {
    if(response.Response == 'True'){
      response.Search.map(titulo => {
        let link = document.createElement('a');
        let img = document.createElement('img');
        let span = document.createElement('span');
        let strong = document.createElement('strong');
        let text = document.createElement('p');

        text.textContent = `Ano: ${titulo.Year}`;
        strong.textContent = titulo.Title;
        img.src = (titulo.Poster != 'N/A') ? titulo.Poster : './img/dog_eat.jpg';
        img.alt = 'Poster';
        link.href = `./?titulo=${titulo.imdbID}`;
        link.classList.add("titulos");

        span.appendChild(strong);
        span.appendChild(text);
        link.appendChild(img);
        link.appendChild(span);
        feed.appendChild(link);
      });
    }else{
      let strong = document.createElement('strong');

      if(response.Error == 'Movie not found!'){
        strong.textContent = "Nenhum resultado Encontrado";
      }else if(response.Error == 'Too many results.'){
        strong.textContent = "Muitos resultados encontrados, seja mais específico";
      }else{
        strong.textContent = response.Error;
      }
      
      feed.appendChild(strong);
    }
  });
} 