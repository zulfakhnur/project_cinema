<?php
class Database {

    private $host = "localhost";
    private $dbname = "db_bioskop";
    private $user = "root";
    private $pass = "";

    public function koneksi() {
        return new PDO(
            "mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4",
            $this->user,
            $this->pass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }
}