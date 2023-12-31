<?php

class View
{
  public $viewName = NULL;
  public $isRender = FALSE;
  public $data = array();

  public function __construct($view)
  {
    $this->viewName = $view;
  }

  public function bind($name, $value = '')
  {
    $this->data[$name] = $value;
  }

  public function render()
  {
    $this->isRender = TRUE;
    extract($this->data);
    $view = ROOT . "/app/views/" . $this->viewName . ".view.php";
    if (file_exists($view)) {
      require_once $view;
    } else {
      echo "View Not Found In " . $view;
    }
  }

  public function __destruct()
  {
    if (!$this->isRender) $this->render();
  }
}
