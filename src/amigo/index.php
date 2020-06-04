<?php
  session_start();
  if(!$_SESSION['logged']){
    header('location: ./login/');
    exit();
  }else{
    include '../database/connect.php';
    $id = $_GET['id'];
    $result = $connection -> query("SELECT Nome, Username, FotoUsuario,
    idUsuario FROM Usuario WHERE idUsuario = '$id'");

    $User = $result -> fetch_assoc();
    
  }

?>

<!DOCTYPE html>

<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="shortcut icon" href="../img/CLAQUETE.png" type="image/x-icon">
    <title>RSFS - Amigo</title>
  </head>
  <body>
    <div class="app">
      <div class="bar">
        <a href="../" class="logo">
          <img src="../img/CLAQUETE.png" alt="claquete">
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
        
        <div class="link">
          <a href="../login/logoff.php">
            <i class="fas fa-toggle-on"></i>
          </a>
        </div>
      </div>
        
      <div class="user">
        <img src="<?php echo $User['FotoUsuario'] ?>" alt="foto-perfil">
        <h1><?php echo $User['Nome'] ?></h1>
        <h2><?php echo $User['Username'] ?></h2>        
      </div>
      <div class="feed"></div>
      <div class="friend-sugestions">
        <div class="friend">
          <h2>Amigos</h2>
          <div class="display">
          <?php 

            $userId = $User['idUsuario'];

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
              <a href="./?id=<?php echo $friend['idUsuario'] ?>">
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
    
  </body>
</html>