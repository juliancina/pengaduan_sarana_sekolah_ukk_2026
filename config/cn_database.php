<?php

class Database {
    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "db_pengaduan_sarana_sekolah";

    public $koneksi;

    public function __construct() {
    
        $this->koneksi = new mysqli($this->hostname, $this->username, $this->password, $this->database);

        if ($this->koneksi->connect_error) {
            die("Koneksi Database Gagal: " . $this->koneksi->connect_error);
        }
    }
}
?>