<?php

class Main extends Model
{
  public function __construct()
  {
    $this->table('mahasiswa');
    $this->select()->get();
  }
}
