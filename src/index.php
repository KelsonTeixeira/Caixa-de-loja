<?php
session_start();
  if(!$_SESSION['logged']){
    header('location: ./login/');
    exit();
  }else{
    $User = $_SESSION['User'];
    include './database/connect.php';
    include './database/query.php';
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
    <title>RSFS</title>
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
          
          <?php $userId = $User['idUsuario'] ?>

          <?php $solicitacoes = friendshipRequestList($userId, $connection) ?>

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
        <a href="./">
          <h1><?php echo $User['Nome'] ?></h1>
        </a>
        <h2><?php echo $User['Username'] ?></h2>
        <a href="./?meustitulos=true">Minhas Opiniões</a>
        
      </div>

      <div class="feed">
        <?php if(isset($_GET['search'])): ?>

          <?php $type = $_GET['type'] ?>

          <?php $search = $_GET['search'] ?>

          <?php if($type == 'usuario'): ?>

            <h2>Usuários Encontrados:</h2>

            <?php $usuarios = userSearchList($search, $connection) ?>

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
            <h2>Títulos Encontrados:</h2>
            <script src="./script/titulo_search.js"></script>
            <script> titleSearchList("<?php echo $search ?>")</script>            
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
          <div class="all-opinions">
            <?php 
              $idTitulo = $Titulo['idTitulo'];
              $allOpinions = allOpinions($idTitulo, $connection);
            ?>
            <?php while($opinion = $allOpinions->fetch_assoc()): ?>
              <div class="user-opinion">
                <img src="<?php echo $opinion['FotoUsuario'] ?>" alt="foto_usuario">
                <div class="user-opinion-info">
                  <strong>
                    <?php echo $opinion['Nome'] ?>
                    <span>
                      <?php 
                        $up = '<i class="fas fa-thumbs-up"></i>';
                        $down = '<i class="fas fa-thumbs-down"></i>';
                        echo ($opinion['Gostou'] ? $up : $down); 
                      ?>
                    </span>
                  </strong>
                  <p><?php echo $opinion['Opiniao'] ?></p>
                </div>
              </div>
            <?php endwhile ?>
          </div>
        <?php elseif(isset($_GET['meustitulos'])): ?>
          <div class="all-opinions">
            <h2>Minhas Opiniões</h2>
            <?php 
              $idUsuario = $_SESSION['User']['idUsuario'];
              $myOpinions = myOpinions($idUsuario, $connection);
            ?>
            <?php while($myOpinion = $myOpinions->fetch_assoc()): ?>
              <div class="user-opinion">
                <img src="<?php echo $myOpinion['Poster'] ?>" alt="poster">
                <div class="user-opinion-info">
                  <a href="./?titulo=<?php echo $myOpinion['idImdb'] ?>">
                    <strong>
                      <?php echo $myOpinion['Titulo'] ?>
                      <span>
                        <?php 
                          $up = '<i class="fas fa-thumbs-up"></i>';
                          $down = '<i class="fas fa-thumbs-down"></i>';
                          echo ($myOpinion['Gostou'] ? $up : $down); 
                        ?>
                      </span>
                    </strong>
                  </a>
                  <p><?php echo $myOpinion['Opiniao'] ?></p>
                </div>
              </div>
            <?php endwhile ?>
          </div>
        <?php else: ?>
          <div class="all-opinions">
            <h2>O que seus amigos estão dizendo</h2>
            <?php 
              $idUsuario = $_SESSION['User']['idUsuario'];
              $friendsOpinions = friendsOpinions($idUsuario, $connection);
            ?>
            <?php while($friendOpinion = $friendsOpinions->fetch_assoc()): ?>
              <div class="friend-opinion">
                <img 
                  src="<?php echo $friendOpinion['FotoUsuario'] ?>" 
                  alt="foto_perfil"
                  class="user-photo">
                <div class="friend-opinion-info">
                  <strong> <?php echo $friendOpinion['Nome'] ?> </strong>
                  <a href="./?titulo=<?php echo $friendOpinion['idImdb'] ?>">
                    <p>
                      <span>Assistiu: </span>
                      <?php echo $friendOpinion['Titulo'] ?>
                    </p>
                  </a>                    
                  
                  <p>
                    <span>Opinião: </span>
                    <?php echo $friendOpinion['Opiniao'] ?>
                  </p>
                </div>
                <div class="poster">
                  <span>
                    <?php 
                      $up = '<i class="fas fa-thumbs-up"></i>';
                      $down = '<i class="fas fa-thumbs-down"></i>';
                      echo ($friendOpinion['Gostou'] ? $up : $down); 
                    ?>
                  </span>
                  <a href="./?titulo=<?php echo $friendOpinion['idImdb'] ?>">
                    <img src="<?php echo $friendOpinion['Poster'] ?>" alt="poster">
                  </a>
                </div>
              </div>
            <?php endwhile ?>
          </div>
        <?php endif ?>
      </div>

      <div class="friend-sugestions">
        <div class="friend">
          <h2>Amigos</h2>
          <div class="display">

          <?php $friends = friendsList($userId, $connection); ?>

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