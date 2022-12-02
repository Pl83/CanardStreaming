<?php

class Connection
{
  private PDO $pdo;

  public function __construct()
  {
    $this->pdo = new PDO("mysql:host=localhost;dbname=canard-stream", "root", "");
  }

  public function insertU(User $user): bool
  {
    $query = 'INSERT INTO user (email, password, first_name, last_name)
              VALUES (:email, :password, :first_name, :last_name)';
    $statement = $this->pdo->prepare($query);

    return $statement->execute([
      'email' => $user->email,
      'password' => md5($user->password . 'SALT'),
      'first_name' => $user->firstname,
      'last_name' => $user->lastname
    ]);


  }




  public function loginuser($email, $password): bool|array
  {
    $log = $this->pdo->prepare('SELECT * FROM user WHERE email ="' . $email . '"');
    $log->execute();

    $result = $log->fetchAll(PDO::FETCH_ASSOC)[0];

    if (md5($password . 'SALT') === $result['password']) {

      return $result;
    } else {
      return false;
    }
  }




}