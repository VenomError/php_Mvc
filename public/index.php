<?php

session_start();

// membuat konstanta ROOT
define("ROOT", dirname(dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);

// menyimpandata url pada variabel $url
$url = isset($_GET['url']) ? $_GET['url'] : '';

// memanggil file configurasi library yang dibutuhkan 
require_once(ROOT . '/config/config.php');
require_once(ROOT . '/library/model.class.php');
require_once(ROOT . '/library/view.class.php');
require_once(ROOT . '/library/controller.class.php');

//membuat function autoload
spl_autoload_register(function ($className) {
  $dir = ROOT . DS . str_replace("\\", DS, $className) . '.php';
  if (file_exists($dir)) require($dir);
});

// // membuat function unutkmengatur pesan error
// Membuat fungsi untuk mengatur pesan error
// Membuat fungsi untuk mengatur pesan error
function setReporting()
{
  if (defined('DEVELOPMENT_ENVIRONMENT') && DEVELOPMENT_ENVIRONMENT == true) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');
  } else {
    error_reporting(E_ALL);
    ini_set('display_errors', 'off');
    ini_set('log_errors', 'on');

    // Pastikan direktori log dapat ditulis oleh PHP
    $logFilePath = ROOT . "/tmp/log/error.log";
    if (!file_exists($logFilePath)) {
      if (!mkdir(dirname($logFilePath), 0777, true)) {
        die('Failed to create log directory');
      }
    }

    ini_set('error_log', $logFilePath);
  }
}





//membuat funcion untuk memanggil controller sesuai nilai $url 
function callHook()
{
  $configPath = ROOT . '/config/config.php';
  if (!file_exists($configPath)) {
    die('Config file not found! ' . $configPath);
  }
  require_once($configPath);

  global $url;
  $urlArray = explode('/', $url);

  $controller = (!empty($urlArray[0])) ? $urlArray[0] : DEFAULT_CONTROLLER;
  $controllerPath = ROOT . DS . 'app' . DS . 'controllers' . DS . ucfirst($controller) . 'Controller.php';

  // $controllerPath = ROOT . '/app/controllers/' . ucfirst($controller) . 'Controller.php';
  if (file_exists($controllerPath)) {
    array_shift($urlArray);
    $action = (!empty($urlArray[0])) ? $urlArray[0] : 'index';
    array_shift($urlArray);
    $parameter = $urlArray;

    require_once($controllerPath);
    $controllerName = ucfirst($controller) . 'Controller';
    $object = new $controllerName;
    if (method_exists($object, $action)) {
      call_user_func_array(array($object, $action), $parameter);
    } else {
      // die('Action Not Found !');
      if (method_exists($object, 'index')) {
        call_user_func_array(array(
          $object, 'index'
        ), $parameter);
      } else {
        die('Action Not Found !');
      }
    }
  } else {
    header('Location: ' . BASE_PATH . '' . DEFAULT_CONTROLLER);
    exit();
  }
}
setReporting();
callHook();
