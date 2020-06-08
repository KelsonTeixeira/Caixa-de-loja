<?php
  session_start();
  include '../database/connect.php';

  $idTitulo = $_POST['idTitulo'];
  $idImdb = $_POST['idImdb'];
  $like = $_POST['like'];
  $opiniao = $_POST['opiniao'];
  $idUsuario = $_SESSION['User']['idUsuario'];

  $opiniao = str_replace("'", " ", $opiniao);

  $result = $connection -> query(
    "SELECT * FROM Assistido WHERE idTitulo = '$idTitulo' and 
    idUsuario = '$idUsuario'"
  );

  if(!$result->num_rows){
    $result = $connection -> query(
      "INSERT INTO Assistido (Opiniao, Gostou, idTitulo, idUsuario) VALUES 
      ('$opiniao', '$like', '$idTitulo', '$idUsuario')"
    ); 

    if($result){
      header("location: ../?titulo=$idImdb");
    }else{
      echo "algo deu errado!";
    }
  }


