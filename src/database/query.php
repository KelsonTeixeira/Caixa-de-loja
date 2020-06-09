<?php

  function allOpinions($idTitulo, $connection){
    $result = $connection->query(
      "SELECT Usuario.Nome, Usuario.Username, Usuario.FotoUsuario, 
      Assistido.Opiniao, Assistido.Gostou FROM Usuario JOIN Assistido 
      WHERE Assistido.idTitulo = '$idTitulo' and 
      Usuario.idUsuario = Assistido.idUsuario 
      ORDER BY Assistido.idAssistido DESC"
    );

    return $result;
  }

  function myOpinions($idUsuario, $connection){
    $result = $connection->query(
      "SELECT Titulo.Titulo, Titulo.Poster, Titulo.idImdb, 
      Assistido.idAssistido, Assistido.Opiniao, Assistido.Gostou 
      FROM Titulo JOIN Assistido WHERE Assistido.idUsuario = '$idUsuario'
      and Assistido.idTitulo = Titulo.idTitulo
      ORDER BY Assistido.idAssistido DESC"
    );

    return $result;
  }

  function friendsOpinions($idUsuario, $connection){
    $result = $connection->query(
      "SELECT DISTINCT Usuario.Username, Usuario.Nome, Usuario.FotoUsuario, 
      Assistido.Opiniao, Assistido.Gostou, Titulo.Titulo, Titulo.Poster, 
      Titulo.idImdb FROM Usuario JOIN Assistido JOIN Amizade join Titulo 
      on Usuario.idUsuario = Amizade.idAmigoUm or 
      Usuario.idUsuario = Amizade.idAmigoDois 
      WHERE (Amizade.idAmigoUm = '$idUsuario' or Amizade.idAmigoDois = '$idUsuario')
      and (Usuario.idUsuario != '$idUsuario') and 
      (Assistido.idUsuario = Usuario.idUsuario)
      and (Assistido.idTitulo = Titulo.idTitulo)
      ORDER BY Assistido.idAssistido DESC"
    );

    return $result;
  }

  function friendsList($idUsuario, $connection){

    $result = $connection -> query(
      "SELECT DISTINCT Usuario.FotoUsuario, Usuario.Nome, Usuario.idUsuario 
      FROM Usuario join Amizade on Usuario.idUsuario = Amizade.idAmigoUm or 
      Usuario.idUsuario = Amizade.idAmigoDois 
      Where (Amizade.idAmigoUm = '$idUsuario' or 
      Amizade.idAmigoDois = '$idUsuario') and Usuario.idUsuario != '$idUsuario'"
    );

    return $result;
  }

  function friendshipRequestList($idUsuario, $connection){

    $result = $connection -> query(
      "SELECT Usuario.Nome, Usuario.FotoUsuario, Usuario.idUsuario,
      SolicitacaoAmizade.idSolicitacaoAmizade FROM Usuario JOIN SolicitacaoAmizade
      WHERE Usuario.idUsuario = SolicitacaoAmizade.idSolicitante and 
      SolicitacaoAmizade.idSolicitado = '$idUsuario'"
      );

    return $result;
  }

  function userSearchList($search, $connection){

    $result = $connection -> query(
      "SELECT Nome, idUsuario,FotoUsuario FROM Usuario WHERE Nome 
      like '%$search%'"
    );

    return $result;
  }

  function sugestionList($idUsuario, $connection){

    $result = $connection -> query(
      "SELECT DISTINCT Titulo.Titulo, Titulo.Poster, Titulo.idImdb 
      FROM Usuario JOIN Assistido Join Titulo
      WHERE Assistido.idUsuario IN (
        SELECT DISTINCT idUsuario FROM Assistido 
        WHERE Gostou ='1' AND idTitulo IN (
          SELECT idTitulo FROM Assistido 
          WHERE Gostou ='1' AND idUsuario = '$idUsuario'
        ) AND idUsuario != '$idUsuario'
      ) AND Titulo.idTitulo = Assistido.idTitulo
      AND Titulo.idTitulo NOT IN (
        SELECT idTitulo FROM Assistido
        WHERE idUsuario = '$idUsuario'
      ) LIMIT 20"
    );

    return $result;
  }



  