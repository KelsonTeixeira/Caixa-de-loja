<!DOCTYPE html>

<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="shortcut icon" href="../img/CLAQUETE.png" type="image/x-icon">
    <title>RSFS - Login</title>
  </head>
  <body>
    <div class="login">
      <div class="bar">
        <div class="logo">
          <img src="../img/CLAQUETE.png" alt="claquete">
          <h1>RSFS</h1>
        </div>
        
        <div class="link">
          <a href="../registro">Registrar-se</a>
        </div>
      </div>

      <form class="login-form" action="login.php" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="username">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <button type="submit">Login</button>
      </form>
    </div>
    
  </body>
</html>