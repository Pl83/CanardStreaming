<?php

class User
{
  public function __construct(
    public string $email,
    public string $password,
    public string $password2,
    public string $firstname,
    public string $lastname,
  )
  {
  }

  public function verify(): bool
  {
    $isValid = true;

    if ($this->email === '' || $this->firstname === '' || $this->lastname === '') {
      $isValid = false;
    }
    if ($this->password === '' || $this->password !== $this->password2) {
      $isValid = false;
    }
    if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      $isValid = false;
    }

    return $isValid;
  }
}