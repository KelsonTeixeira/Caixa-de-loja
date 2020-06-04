<?php
session_start();
  include '../database/connect.php';

  $solicitacao = $_GET['solicitacao'];
  $usuario = $_GET['usuario'];
  $id = $_SESSION['User']['idUsuario'];

  $status = $connection -> query("INSERT INTO Amizade (idAmigoUm, idAmigoDois)
  VALUES ('$usuario', '$id')");

  if($status){
    $connection->query("DELETE FROM SolicitacaoAmizade 
    WHERE idSolicitacaoAmizade = '$solicitacao'");
    header('location: ../');
  }else{
    echo "algo deu errado";
  }