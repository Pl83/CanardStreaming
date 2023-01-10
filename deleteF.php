<?php

require_once 'Connection.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] === ''){
    header('Location: login.php');
}
require 'doctype.template.php';
require 'Header.template.php';


$album_id = $_POST['album_id'];
$movie_id = $_POST['movie_id'];

print_r($album_id);
print_r($movie_id);
$connection = new connection();
$connection->film_del($album_id, $movie_id);
header('Location: album.php?names=album&ids='.$album_id);