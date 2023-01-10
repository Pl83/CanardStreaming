<?php
require_once 'Connection.php';
require_once 'User.php';
session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
<form method="POST">
  <h2>Login</h2>

  <p>Votre email<input type="email" name="email"></p>
  <p>Votre Mot de passe<input type="password" name="password"></p>
  <p><input type="submit" name="login" value="Envoyer"></p>
  <a href="Register.php">Pas de compte</a>
</form>
</body>
</html>
<?php
if ($_POST) {
  $connection = new Connection();
//print_r(md5($_POST['password'] . 'SALT'));
  $try = $connection->loginuser($_POST['email'], $_POST['password']);
  if($try != false){
    header('Location: index.php');
  }

  $_SESSION['user'] = $try;
  $_SESSION['id'] = $try['id'];
}

