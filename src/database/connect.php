<?php

$host = 'localhost';
$user = 'root';
$password = '';
$db = 'Socialmovies';

$connection = new mysqli($host, $user, $password, $db) 
              or die('connectios has faild');

$connection->set_charset("utf8");