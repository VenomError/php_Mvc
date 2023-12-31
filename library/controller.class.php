<?php

class Controller
{

  protected function view($viewName)
  {
    return new View($viewName);
  }


  protected function model($modelName)
  {
    require_once(ROOT . "/app/models/" . $modelName . ".model.php");
    $model = new $modelName();
    return $model;
  }

  protected function template($viewName, $data = array())
  {
    $view = $this->view('template');
    $view->bind('viewName', $viewName);
    $view->bind('data', $data);

    return $view;
  }


  public function back()
  {
    echo "
    <script>
    history.go(-1)
    </script>
    ";
  }

  public function redirect($url = "")
  {
    header('location: ' . BASE_PATH . DS . $url);
  }

  public function redirectData($url = "", $data = array())
  {
    // Simpan data di sesi

    foreach ($data as $key => $value) {
      $_SESSION[$key] = $value;
    }
    // Lakukan redirect
    header('location: ' . BASE_PATH . $url);
    exit();
  }

  public function sendData($viewName, $data = array())
  {
    $this->template($viewName, $data)->render();
  }

  protected function validate($data)
  {
    return htmlentities(trim(strip_tags($data)));
  }
}
