<?php
class Connect {
   private $host = 'localhost';
   private $user = 'root';
   private $password = '';
   private $database = 'webphp';
   private $conn;

   public function __construct() {
      $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);
      $this->conn->set_charset("utf8");
   }

   public function connect() {
      return $this->conn;
   }
}
