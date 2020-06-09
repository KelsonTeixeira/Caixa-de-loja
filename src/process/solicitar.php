<?php
  session_start();
  include '../database/connect.php';

  $idSolicitado = $_GET['id'];
  $User = $_SESSION['User']['idUsuario'];

  $status = $connection -> query("INSERT INTO SolicitacaoAmizade (idSolicitante,
  idSolicitado) VALUES ('$User', '$idSolicitado')");

  if($status){
    header('location: ../');
  }else{
    echo "algo deu errado!";
  }
