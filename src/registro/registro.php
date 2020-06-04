<?php
  include './addimage.php';
  include '../database/connect.php';

  $Name = $_POST['name'];
  $Username = $_POST['username'];
  $Password = $_POST['password'];
  $img_url = addImage($_FILES['image'], '../img/');

  $status = $connection -> query("INSERT INTO Usuario (Nome, Username, Senha, FotoUsuario) VALUES ('$Name', '$Username', MD5('$Password'), '$img_url')");

  if($status){
    header('location: ../login');
  }else{
    echo "Something wrong";
  }