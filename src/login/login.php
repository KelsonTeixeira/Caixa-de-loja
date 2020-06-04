<?php
  session_start();
  include '../database/connect.php';

  $Username = $_POST['username'];
  $Password = $_POST['password'];

  $result = $connection -> query("SELECT idUsuario, Username, Nome FROM Usuario WHERE Username = '$Username' and Senha = MD5('$Password')");

  $User = $result -> fetch_assoc();

  if($User){
    $_SESSION['User'] = $User;
    $_SESSION['logged'] = true;
    header('location: ../');
  }else{
    header('location: ./?fail=true');
  }