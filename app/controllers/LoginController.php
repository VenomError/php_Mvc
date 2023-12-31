

<?php

use library\MainController;

class LoginController extends MainController
{
  function __construct()
  {
    parent::__construct();
    $this->headerIn("components/head");
    $this->footerIn("components/footer");
  }
  public function index()
  {

    $data = [
      "title" => "Login",
    ];

    $this->contentIn('login', $data);
  }

  public function check()
  {
    $data = [
      'username' => $_POST['username'],
      'password' => $_POST['password']
    ];
    // var_dump($data);
    $this->redirectData('home', $data);
    // $this->sendData('home', $data);
  }
}
