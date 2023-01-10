<?php

require_once 'Connection.php';

session_start();
session_destroy();
header('Location: login.php');
exit;