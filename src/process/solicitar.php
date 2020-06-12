<?php
  session_start();
  include '../database/connect.php';

  $idSolicitado = $_GET['id'];
  $User = $_SESSION['User']['idUsuario'];
  $search = $_GET['search'];

  $result = $connection -> query(
    "SELECT * FROM SolicitacaoAmizade 
    WHERE idSolicitante = '$User' AND idSolicitado = '$idSolicitado'"
  );

  if(!$result->num_rows){    

    $result = $connection -> query(
      "INSERT INTO SolicitacaoAmizade (idSolicitante, idSolicitado)
      VALUES ('$User', '$idSolicitado')"
    );
  }

  if($result){
    if(isset($_GET['amigo'])){
      header("location: ../amigo/?id=$idSolicitado&request=true");
    }else{
      header("location: ../?search=$search&type=usuario&request=true");
    }
  }else{
    echo "algo deu errado!";
  }
