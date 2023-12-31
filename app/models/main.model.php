<?php

class Main extends Model
{
  public function __construct()
  {
     parent::__construct();
    $this->table('table_name');
    $this->setIdColumn('id_name');
  }
}
