

<?php

use library\MainController;

class HomeController extends MainController
{
  function __construct()
  {
    parent::__construct();
    $this->navbarIn('components/navbar');
    $this->headerIn("components/headHome");
    $this->footerIn("components/footer");
  }
  public function index()
  {
    session_destroy();
    $data = [
      "title" => "HOME",
    ];

    $this->contentIn('home', $data);
  }
  public function tes()
  {
    $data = [
      "title" => "Dashboard",
    ];


    $this->contentIn('home', $data);
  }
}
