<?php
require_once 'Connection.php';
require_once 'User.php';
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
  <h2>Inscrivez-vous</h2>
  <p>Votre prenom<input type="text" name="firstname"></p>
  <p>Votre nom<input type="text" name="lastname"></p>
  <p>Votre adresse mail<input type="email" name="email"></p>
  <p>Votre mot de passe<input type="password" name="password"></p>
  <p>Confirmez votre mot de passe<input type="password" name="password2"></p>
  <input type="hidden" name="admin" value="0">
  <p><input type="submit" name="inscription" value="Envoyer"></p>
</form>
</div>
</body>
</html>



<?php
if ($_POST) {

    $user = new User(
      $_POST['email'],
      $_POST['password'],
      $_POST['password2'],
      $_POST['firstname'],
      $_POST['lastname'],
    );
    if ($user->verify()) {
      // save in database
      $connection = new Connection();
      $result = $connection->insertU($user);
      $user->password = md5($user->password . 'SALT');
      header('Location: login.php');
    } else {
      echo ' Form has an error';}
}

