


<?php

  class MySQLDriver{
    private $connessione;
    
    public function __construct(){
      $this->connessione=new mysqli("eu-cdbr-west-03.cleardb.net","b8c9bef0d7c6cd", "3d11d9c8", "heroku_504909cbd12c3c9", 3306);
      $this->connessione->set_charset("utf8");
    }
    public function  query($query){
      return $this->connessione->query($query);
    }
    public function getLastInsertedId(){
      return $this->connessione->insert_id;
    }
  }





?>