<!DOCTYPE html>

<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registro.css">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="shortcut icon" href="../img/CLAQUETE.png" type="image/x-icon">
    <title>RSFS - Registro</title>
  </head>
  <body>
    <div class="registro">
      <div class="bar">
        <div class="logo">
          <img src="../img/CLAQUETE.png" alt="claquete">
          <h1>RSFS</h1>
        </div>

        <div class="link">
          <a href="../login">Login</a>
        </div>
      </div>

      <form class="registro-form" action="login.php" method="post">
        <label for="name">Seu nome</label>
        <input type="text" name="name" id="name" required>

        <label for="username">Crie um username</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Crie uma senha</label>
        <input type="password" name="password" id="password" required>

        <label for="image">Escolha uma foto de perfil</label>
        <input type="file" name="image" id="image" required>
        
        <button type="submit">Registrar-se</button>
      </form>
    </div>
  </body>
</html>