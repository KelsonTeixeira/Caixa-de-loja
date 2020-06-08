<?php

use function PHPSTORM_META\type;

session_start();
  if(!$_SESSION['logged']){
    header('location: ./login/');
    exit();
  }else{
    $User = $_SESSION['User'];
    include './database/connect.php';
  }

?>

<!DOCTYPE html>

<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/general.css">
    <link rel="shortcut icon" href="./img/CLAQUETE.png" type="image/x-icon">
    <title>RSFS - Login</title>
  </head>
  <body>
    <div class="app">
      <div class="bar">
        <a href="./" class="logo">
          <img src="./img/CLAQUETE.png" alt="claquete">
          <h1>RSFS</h1>
        </a>

        <form action="./" method="get" class="search">
          <input type="text" name="search" id="search">
          <select name="type" id="type">
            <option value="titulo">Título</option>
            <option value="usuario">Usuário</option>
          </select>
          <button type="submit">
            <i class="fas fa-search"></i>
          </button>
        </form>
        
        <div class="buttons">
          <i class="fas fa-user-friends" id="solicitacao"></i>
          <a href="./login/logoff.php">
            <i class="fas fa-toggle-on"></i>
          </a>
        </div>
        <div class="solicitacao">
          <?php  

            $userId = $User['idUsuario'];

            $solicitacoes = $connection -> query("SELECT Usuario.Nome,
            Usuario.FotoUsuario, Usuario.idUsuario,
            SolicitacaoAmizade.idSolicitacaoAmizade FROM Usuario
            JOIN SolicitacaoAmizade WHERE
            Usuario.idUsuario = SolicitacaoAmizade.idSolicitante
            and SolicitacaoAmizade.idSolicitado = '$userId';")
          ?>

          <?php while($solicitacao = $solicitacoes->fetch_assoc()): ?>
            <article id='solicitacao-bloco'>
              <img src="<?php echo $solicitacao['FotoUsuario'] ?>" alt="foto_perfil">
              <a href="./amigo/?id=<?php echo $solicitacao['idUsuario'] ?>">
                <strong><?php echo $solicitacao['Nome'] ?></strong>
              </a>
              <a class="aceita"
                href="./process/aceitar.php?solicitacao=<? echo $solicitacao['idSolicitacaoAmizade']?>&usuario=<?php echo $solicitacao['idUsuario'] ?>">
                  Aceitar
              </a>
            </article>
          <?php endwhile ?>
        </div>
      </div>
        
      <div class="user">
        <img src="<?php echo $User['FotoUsuario'] ?>" alt="foto-perfil">
        <h1><?php echo $User['Nome'] ?></h1>
        <h2><?php echo $User['Username'] ?></h2>
        <a href="./?meustitulos=true">Meus Títulos</a>
        
      </div>

      <div class="feed">
        <?php if(isset($_GET['search'])): ?>

          <?php $type = $_GET['type'] ?>

          <?php $search = $_GET['search'] ?>

          <?php if($type == 'usuario'): ?>
            <?php
              $usuarios = $connection -> query("SELECT Nome, idUsuario,
              FotoUsuario FROM Usuario WHERE Nome like '%$search%'");
            ?>
            <?php while($usuario = $usuarios->fetch_assoc()): ?>
              <article class="usuario">
                <img src="<?php echo $usuario['FotoUsuario']?>" alt="foto_perfil">
                <div class="link-usuario">
                  <a href="./amigo/?id=<?php echo $usuario['idUsuario'] ?>">
                    <strong><?php echo $usuario['Nome'] ?></strong>
                  </a>
                  <a 
                    href="./process/solicitar.php/?id=<?php echo $usuario['idUsuario'] ?>"
                    class="solicita">
                    Solicitar Amizade
                  </a>
                </div>
              </article>

            <?php endwhile ?>

          <?php elseif($type == 'titulo'): ?>
            <script>
              const feed = document.querySelector('.feed');
              var search = "<?php echo $search ?>";

              fetch(`http://www.omdbapi.com/?apikey=700c6c7d&s=${search}`)
              .then(response => response.json())
              .then(response => {
                console.log(response);
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
            </script>            
          <?php endif ?>

        <?php elseif(isset($_GET['titulo'])): ?>
          <?php include './process/addtitulo.php' ?>
          <?php $imdbID = $_GET['titulo'];?>
          <?php $titulo = verifyMovieOnDataBase($imdbID, $connection) ?>
          <?php $Titulo = $titulo->fetch_assoc() ?>

          <div class="titulo-display">
            <img src="<?php echo $Titulo['Poster'] ?>" alt="poster">
            <div class="titulo-info">
              <strong><?php echo $Titulo['Titulo'] ?></strong>
              <p>
                <span>Lançamento: </span>
                <?php echo $Titulo['DataLancamento'] ?>
              </p>
              <p>
                <span>Atores: </span>
                <?php echo $Titulo['Atores'] ?>
              </p>
              <p>
                <span>Diretores: </span>
                <?php echo $Titulo['Diretores'] ?>
              </p>
              <p>
                <span>Sinopse: </span>
                <?php echo $Titulo['Sinopse'] ?>
              </p>
            </div>
          </div>
          <button class="assisti">Já Assisti</button>
          <form action="./process/opiniao.php" method="post" class="opiniao-form">
            <input 
              type="hidden" 
              name="idTitulo" 
              value="<?php echo $Titulo['idTitulo'] ?>"
            >

            <input 
              type="hidden" 
              name="idImdb" 
              value="<?php echo $Titulo['idImdb'] ?>"
            >

            <div class="radio">

              <p>Você Gostou?</p>

              <input type="radio" name="like" id="like" value="1" required>
              <label for="like">
                <i class="fas fa-thumbs-up"></i>
              </label>

              <input type="radio" name="like" id="dont-like" value="0" required>
              <label for="dont-like">
                <i class="fas fa-thumbs-down"></i>
              </label>
              
            </div>

            <label for="opiniao">Qual sua opinião? (Opicional)</label>
            <textarea name="opiniao" id="opiniao"></textarea>

            <button type="submit">Enviar</button>

          </form>
        <?php else: ?>
        <?php endif ?>
      </div>

      <div class="friend-sugestions">
        <div class="friend">
          <h2>Amigos</h2>
          <div class="display">
          <?php 

            $friends = $connection -> query("SELECT DISTINCT Usuario.FotoUsuario,
            Usuario.Nome, Usuario.idUsuario FROM Usuario join Amizade on 
            Usuario.idUsuario = Amizade.idAmigoUm or 
            Usuario.idUsuario = Amizade.idAmigoDois Where 
            (Amizade.idAmigoUm = '$userId' 
            or Amizade.idAmigoDois = '$userId') and Usuario.idUsuario != '$userId'") 

          ?>
          <?php while($friend = $friends -> fetch_assoc()): ?>
            
            <article>
              <img src="<?php echo $friend['FotoUsuario'] ?>" alt="foto_perfil">
              <a href="./amigo/?id=<?php echo $friend['idUsuario'] ?>">
                <strong><?php echo $friend['Nome'] ?></strong>
              </a> 
            </article>

          <?php endwhile ?>
          </div>
          
        </div>
        <div class="sugestions">
          <h2>Sugestões</h2>
        </div>
      </div>
    </div>
    
    <script src="./script/script.js"></script>
  </body>
</html>