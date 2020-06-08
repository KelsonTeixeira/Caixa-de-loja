<?php

  function readMovie($imdbID, $connection){

    $result = $connection -> query(
      "SELECT * FROM Titulo WHERE idImdb = '$imdbID'"
    );

    return $result;
  }

  function addMovie($imdbID, $connection){

    $data = file_get_contents("http://www.omdbapi.com/?apikey=700c6c7d&i=$imdbID");
    $data = json_decode($data);

    $Plot = str_replace("'", " ", $data->Plot);
    $Title = str_replace("'", " ", $data->Title);
    $Actors = str_replace("'", " ", $data->Actors);
    $Director = str_replace("'", " ", $data->Director);

    $titulo = $connection -> query(
      "INSERT INTO Titulo (idImdb, Titulo, Sinopse,DataLancamento, Atores,
      Diretores, Ano, Poster) VALUES ('$data->imdbID', '$Title', '$Plot', 
      '$data->Released', '$Actors', '$Director', '$data->Year', '$data->Poster')"
    );

    return $titulo;
  }

  function verifyMovieOnDataBase($imdbID, $connection){
    
    $result = readMovie($imdbID, $connection);

    if(!$result->num_rows){
      
      addMovie($imdbID, $connection);

      $result = readMovie($imdbID, $connection); 

      return $result;
      
    }else{

      return $result;

    }
  }