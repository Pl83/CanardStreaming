<?php

require_once 'Connection.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] === ''){
    header('Location: login.php');
}
require 'doctype.template.php';
require 'Header.template.php';


$album_id = $_POST['album_id'];

    $connection = new connection();
    $connection->likealbum($album_id, $_SESSION['id']);
    var_dump('bonjou');
    header('Location: album.php?names=album&ids=' .$album_id);