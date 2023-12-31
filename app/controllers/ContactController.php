

<?php

use library\MainController;

class ContactController extends MainController
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
      "title" => "Contact",
    ];

    $this->contentIn('contact', $data);
  }
}
