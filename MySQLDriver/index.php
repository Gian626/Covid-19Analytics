


<?php

  class MySQLDriver{
    private $connessione;
    
    public function __construct(){
      $this->connessione=new mysqli("sql2.freemysqlhosting.net","sql2342765", " uY4%eC4!", "sql2342765", 3306);
    }
    public function  query($query){
      return $this->connessione->query($query);
    }
  }





?>