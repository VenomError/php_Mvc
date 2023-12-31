<?php
class Model
{
  private $dbh;
  private $table;
  private $primary;

  private $data = [
    'select' => '',
    'where' => [],
    'order' => '',
    'limit' => '',
    'join' => [],
  ];

  public function __construct()
  {
    try {
      $this->dbh = new PDO(
        DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASSWORD
      );
      $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      throw new Exception("Koneksi gagal: " . $e->getMessage());
    }
  }

  public function table($table)
  {
    $this->table = $table;
    return $this;
  }

  public function setIdColumn($column)
  {
    $this->primary = $column;
    return $this;
  }

  public function select($columns = "*")
  {
    $this->data['select'] = "SELECT $columns";
    return $this;
  }

  public function where($conditions = [])
  {
    if (!empty($conditions)) {
      foreach ($conditions as $key => $value) {
        $this->data['where'][$key] = $value;
      }
    }
    return $this;
  }

  public function orderBy($column, $order = "ASC")
  {
    $this->data['order'] = "ORDER BY $column $order";
    return $this;
  }

  public function limit($limit, $offset = 0)
  {
    if ($offset > 0) {
      $this->data['limit'] = "LIMIT $offset, $limit";
    } else {
      $this->data['limit'] = "LIMIT $limit";
    }
    return $this;
  }

  public function join($table, $on, $type = 'INNER')
  {
    $this->data['join'][] = "$type JOIN $table ON $on";
    return $this;
  }

  public function get()
  {
    try {
      $sql = $this->data['select'] . " FROM " . $this->table . " " .
        $this->buildJoin() . " " . $this->buildWhere() . " " . $this->data['order'] . " " . $this->data['limit'];

      $stmt = $this->dbh->prepare($sql);
      $this->bindWhereParams($stmt);
      $stmt->execute();

      $data = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
      }

      // Setelah pengambilan data, reset properti "where", "order", dan "limit"
      $this->resetData();

      return $data;
    } catch (PDOException $e) {
      throw new Exception("Tidak dapat menampilkan data: " . $e->getMessage());
    }
  }

  public function create($data)
  {
    try {
      $columns = implode(", ", array_keys($data));
      $values = ":" . implode(", :", array_keys($data));

      $sql = "INSERT INTO $this->table ($columns) VALUES ($values)";
      $stmt = $this->dbh->prepare($sql);

      foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
      }

      return $stmt->execute();
    } catch (PDOException $e) {
      throw new Exception("Create failed: " . $e->getMessage());
    }
  }

  public function update($data)
  {
    try {
      $setClause = '';
      foreach ($data as $key => $value) {
        $setClause .= "$key = :$key, ";
      }
      $setClause = rtrim($setClause, ', ');

      $sql = "UPDATE $this->table SET $setClause " . $this->buildWhere();
      $stmt = $this->dbh->prepare($sql);

      foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
      }
      $this->bindWhereParams($stmt);

      return $stmt->execute();
    } catch (PDOException $e) {
      throw new Exception("Update failed: " . $e->getMessage());
    }
  }

  public function delete()
  {
    try {
      $sql = "DELETE FROM $this->table " . $this->buildWhere();
      $stmt = $this->dbh->prepare($sql);

      $this->bindWhereParams($stmt);

      return $stmt->execute();
    } catch (PDOException $e) {
      throw new Exception("Delete failed: " . $e->getMessage());
    }
  }

  public function find($id)
  {
    try {
      $sql = $this->data['select'] . " FROM " . $this->table . " " . $this->buildWhere();

      $stmt = $this->dbh->prepare($sql);
      $this->bindWhereParams($stmt);

      // Gunakan kolom id yang telah diatur
      $stmt->bindParam(":{$this->primary}", $id);

      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Find failed: " . $e->getMessage());
    }
  }

  public function count()
  {
    try {
      $sql = "SELECT COUNT(*) as count FROM " . $this->table . " " . $this->buildJoin() . " " . $this->buildWhere();

      $stmt = $this->dbh->prepare($sql);
      $this->bindWhereParams($stmt);

      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      return $result['count'];
    } catch (PDOException $e) {
      throw new Exception("Count failed: " . $e->getMessage());
    }
  }

  public function __destruct()
  {
    $this->dbh = NULL;
  }

  private function buildJoin()
  {
    if (!empty($this->data['join'])) {
      return implode(" ", $this->data['join']);
    }
    return '';
  }

  private function buildWhere()
  {
    if (!empty($this->data['where'])) {
      $whereClause = "WHERE ";
      foreach ($this->data['where'] as $key => $value) {
        $whereClause .= "$key = :$key AND ";
      }
      return rtrim($whereClause, ' AND ');
    }
    return '';
  }

  private function bindWhereParams($stmt)
  {
    foreach ($this->data['where'] as $key => $value) {
      $stmt->bindParam(":$key", $value);
    }
  }

  private function resetData()
  {
    $this->data['select'] = '';
    $this->data['where'] = [];
    $this->data['order'] = '';
    $this->data['limit'] = '';
    $this->data['join'] = [];
  }
  public function uploadAvatar($file)
  {
    $targetDirectory = ROOT . DS . 'public' . DS . 'assets' . DS . 'avatars' . DS; // Sesuaikan dengan struktur folder di server Anda
    $uploadOk = 1;

    $fileName = basename($file["name"]);
    $uniqueFileName = uniqid() . '_' . $fileName;
    $targetFile = $targetDirectory . $uniqueFileName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
      // File bukan gambar
      return false;
    }

    if ($file["size"] > 2 * 1024 * 1024) {
      // File terlalu besar
      return false;
    }

    $allowedFormats = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedFormats)) {
      // Format file tidak diizinkan
      return false;
    }

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
      // Upload berhasil, kembalikan nama file unik
      return $uniqueFileName;
    } else {
      // Gagal upload
      return false;
    }
  }
}
