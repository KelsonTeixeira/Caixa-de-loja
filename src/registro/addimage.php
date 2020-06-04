<?php

  function url($fileName){
    $ssl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 
          'https://' : 'http://';
    $imageUrl = $ssl. $_SERVER['SERVER_NAME']. "/images/$fileName";
    return $imageUrl;
  }
  
  function addImage($image, $path){
    $id = uniqid();
    $temp = $image['tmp_name'];
    $type = explode('/', $image['type']);
    $fileName = "$id.$type[1]";

    if(move_uploaded_file($temp, $path.$fileName)){
      return url($fileName);
    }else{
      return false;
    }
  }

