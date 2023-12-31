<?php

namespace library;

use Controller;



class MainController extends Controller
{
  protected $headLoc = "";
  protected $navLoc = "";
  protected $footLoc = "";
  public function __construct()
  {
    if (empty($_SESSION['username']) and empty($_SESSION['password'])) {
      // $this->redirect('login');
    }
  }
  public function headerIn($viewName, $data = array())
  {
    $this->headLoc = $viewName;

    return $this;
  }
  public function navbarIn($viewName, $data = array())
  {
    $this->navLoc = $viewName;
    return $this;
  }
  public function contentIn($viewName, $data = array(), $msg = '')
  {

    $view = $this->view($viewName);
    $view->bind('data', $data);
    $view->bind('active', ucfirst($viewName));
    $view->bind('msg', $msg);




    if (isset($this->headLoc) && !empty($this->headLoc)) {
      $head = $this->view($this->headLoc);
      $head->bind('data', $data);
      $head->bind('title', ucfirst($viewName));
      $head->render();
    }

    // Cek apakah $navLoc memiliki nilai sebelum memanggil render
    if (isset($this->navLoc) && !empty($this->navLoc)) {
      $nav = $this->view($this->navLoc);
      $nav->bind('data', $data);
      $nav->bind('active', $viewName);

      $nav->render();
    }

    // Cek apakah $footLoc memiliki nilai sebelum memanggil render
    if (isset($this->footLoc) && !empty($this->footLoc)) {
      $foot = $this->view($this->footLoc);
      $foot->bind('data', $data);


      $foot->render();
    }

    $view->render();
  }
  public function footerIn($viewName, $data = array())
  {
    $this->footLoc = $viewName;
    return $this;
  }
}
