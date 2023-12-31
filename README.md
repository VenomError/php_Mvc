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

2.  buatlah file untuk views page **app/views/page.view.php**

3.  **head.view.php** -> sesuaikan dengan path di HomeController (views/components/head) , contoh :

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

4. **navbar.view.php** -> sesuaikan dengan path di HomeController (views/components/navbar) , contoh :

```html
<nav>
  <div class="row">
    <h2>HIMASAR</h2>
  </div>
  <div class="row">
    <ul>
      <a class="<?php echo $active == 'home' ? 'active' : ''; ?>" href="<?= BASE_PATH ?>home">HOME</a>
    </ul>
    <ul>
      <a class="<?php echo $active == 'about' ? 'active' : ''; ?>" href="<?= BASE_PATH ?>about">ABOUT</a>
    </ul>
    <ul>
      <a class="<?php echo $active == 'contact' ? 'active' : ''; ?>" href="<?= BASE_PATH ?>contact">CONTACT</a>
    </ul>
    </ul>
    <ul style="margin-left: 400px;">
      <a href="<?= BASE_PATH ?>login/logout">LOGOUT</a>
    </ul>
  </div>
</nav>
```

5.  **footer.view.php** -> sesuaikan dengan path di HomeController (views/components/footer) , contoh :

```html
</body>

<!-- Js Source Src="<?= BASE_ASSETS ?>assets/your_js_assets" -->

</html>
```

6.  **home.view.php** -> sesuaikan dengan path di HomeController (views/home) , contoh :

```html
</body>

<!-- Js Source Src="<?= BASE_ASSETS ?>assets/your_js_assets" -->

</html>
```

###### Penambahan Model

1. inisiasi

```php
public function your_method()
  {
    $this->model('model_name');
  }
```

2. Directori Model di **app/models/model_name.model.php**

3. model Classes inisiasi

```php
<?php

class Model_name extends Model
{
  public function __construct()
  {
    parent::__construct();
    $this->table('table_name');
    $this->setIdColumn('id_table_name');
  }
}
```

####### METHOD CRUD

1. **`table($table)`**

   - **Deskripsi**: Menentukan nama tabel yang akan digunakan dalam query.
   - **Contoh Penggunaan**: `$model->table('mahasiswa')`

2. **`setPrimaryKey($primaryKey)`**

   - **Deskripsi**: Menentukan nama kolom yang merupakan primary key pada tabel.
   - **Contoh Penggunaan**: `$model->setPrimaryKey('id_mahasiswa')`

3. **`select($columns = "*")`**

   - **Deskripsi**: Menentukan kolom-kolom yang akan dipilih dalam query SELECT.
   - **Contoh Penggunaan**: `$model->select('nama, nim, jurusan')`

4. **`where($conditions = [])`**

   - **Deskripsi**: Menentukan kondisi untuk query WHERE.
   - **Contoh Penggunaan**: `$model->where(['id_mahasiswa' => 1, 'jurusan' => 'Teknik Informatika'])`

5. **`orderBy($column, $order = "ASC")`**

   - **Deskripsi**: Menentukan urutan pengurutan data (ORDER BY).
   - **Contoh Penggunaan**: `$model->orderBy('nama', 'DESC')`

6. **`limit($limit, $offset = 0)`**

   - **Deskripsi**: Menentukan batasan jumlah data yang diambil (LIMIT).
   - **Contoh Penggunaan**: `$model->limit(10, 20)`

7. **`join($table, $on, $type = 'INNER')`**

   - **Deskripsi**: Menambahkan operasi JOIN pada query.
   - **Contoh Penggunaan**: `$model->join('jurusan', 'mahasiswa.jurusan = jurusan.id_jurusan')`

8. **`get()`**

   - **Deskripsi**: Menjalankan query SELECT dan mengembalikan hasilnya.
   - **Contoh Penggunaan**: `$data = $model->get()`

9. **`create($data)`**

   - **Deskripsi**: Menambahkan data baru ke dalam tabel.
   - **Contoh Penggunaan**: `$model->create(['nama' => 'John Doe', 'nim' => 'NIM123'])`

10. **`update($data)`**

    - **Deskripsi**: Memperbarui data berdasarkan kondisi yang telah ditentukan.
    - **Contoh Penggunaan**: `$model->where(['id' => 1])->update(['nama' => 'New Name'])`

11. **`delete()`**

    - **Deskripsi**: Menghapus data berdasarkan kondisi yang telah ditentukan.
    - **Contoh Penggunaan**: `$model->where(['id' => 1])->delete()`

12. **`find($id)`**

    - **Deskripsi**: Mencari data berdasarkan nilai primary key.
    - **Contoh Penggunaan**: `$data = $model->find(1)`

13. **`count()`**

    - **Deskripsi**: Menghitung jumlah data berdasarkan kondisi yang telah ditentukan.
    - **Contoh Penggunaan**: `$count = $model->where(['status' => 'active'])->count()`

14. **`uploadAvatar($file)`**

    - **Deskripsi**: Mengunggah file avatar ke direktori dan mengembalikan nama file yang diunggah.
    - **Contoh Penggunaan**: `$avatar = $model->uploadAvatar($_FILES['avatar'])`

Terima kasih telah menggunakan proyek PHP MVC sederhana ini! Jangan ragu untuk berkreasi dan mengembangkan lebih lanjut. Happy coding! 🚀
