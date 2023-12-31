# PHP MVC Proyek Sederhana 🚀

![Static Badge](https://img.shields.io/badge/mvc-black?style=plastic&label=php&labelColor=blue)

Proyek PHP MVC sederhana untuk memulai pengembangan web Anda. Proyek ini memanfaatkan konsep Model-View-Controller (MVC) untuk membuat struktur yang mudah dipahami dan dikelola.

## Instalasi 🛠️

1. **Clone Repositori:**
   ```bash
   git clone https://github.com/VenomError/php_Mvc.git
   ```
2. **Masuk Ke Directory**
   ```bash
   cd php_Mvc
   ```

### Structur Directory 📁

```plaintext
php_Mvc/
|-- app/
|   |-- controllers/
|   |-- models/
|   |-- views/
|-- config/
|   |-- config.php
|-- library/
|   |-- controller.class.php
|   |-- MainController.php
|   |-- model.class.php
|   |-- view.class.php
|-- public/
|   |-- assets/
|       |-- css/
|       |-- js/
|   |-- index.php
|-- tmp/
|   |-- log/
|       |-- error.log
|-- README.md
```

#### 🧩 Komponen Utama

1. **app/controllers**
   Direktori ini berisi kontroler aplikasi yang mengelola logika aplikasi dan berkomunikasi dengan model dan view.
2. **app/models**
   Direktori ini berisi model-model aplikasi yang berinteraksi dengan database atau menyediakan logika bisnis.
3. **app/views**
   Direktori ini berisi file-file view yang menangani tampilan dan presentasi data kepada pengguna.
4. **library/MainController.php**
   Inisialisasi antar Tampilan dan pengiriman data ke tampilan , juga mengatur susunan page yang terdiri dari
   ```plaintext
   ----| head |-----
   -----------------
   ----| navbar |---
   -----------------
   ----| body |-----
   -----------------
   ----| footer |---
   ```
5. **config/config.php**
   Directory ini berisi Constanta Utama dalam menyediakan root dan configurasi database

   ```plaintext
   <?php
   define("DEVELOPMENT_ENVIRONMENT", true); //pengatasan error , jika false error akan di tampilkan di error.log
   define("BASE_PATH", 'http://localhost/framework/'); //base path
   define("BASE_ASSETS", 'http://localhost/framework/public/'); //base assets path
   define('DEFAULT_CONTROLLER', 'home'); //default controller
   define('DB_DRIVER', 'mysql');
   define('DB_NAME', 'your_db_name');
   define('DB_USER', 'root');
   define('DB_PASSWORD', '');
   define('DB_HOST', 'localhost');
   ```

##### 🕹️ Cara Penggunaan

1. Buatlah satu file di **app/controllers/** sesuaikan nama url
   --> contoh

```plaintext
HomeController.php
```

--> inisialisi file **HomeController.php**

```php
<?php
use library\MainController;
class HomeController extends MainController
{
function __construct()
{
 parent::__construct();
 $this->headerIn("components/head");//directory header untuk page
 $this->navbarIn('components/navbar'); //directory navbar untuk page , hapus atau abaikan jika tidak butuh navbar
 $this->footerIn("components/footer");//directory footer untuk page
}
public function index() //method default page ('page_name/index')
{
 $data = [
   "title" => "HOME",
 ];

 $this->contentIn('home', $data); //directori view (app/views/home.view.php)
 $this->contentIn('directory/home', $data); //directori view (app/views/directory/home.view.php)
}
}
```

--> buatlah file untuk views page **app/views/page.view.php**

-> **head.view.php** -> sesuaikan dengan path di HomeController (components/head) , contoh :

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $data['title'] ?></title>
    <!-- ASSETS -->
    <!-- <link rel="stylesheet" href="<?= BASE_ASSETS ?>your_css_assets"> -->
    <link rel="stylesheet" href="<?= BASE_ASSETS ?>assets/css/style.css" />
  </head>
  <body></body>
</html>
```
