<?php

    $host       = "localhost";
    $user       = "root";
    $pass       = "";
    $db         = "akademik";

    $koneksi    = mysqli_connect($host, $user, $pass, $db);
    if(!$koneksi){// cek koneksi
        die("Tidak bisa terhubung ke database");
    }

    //private $host       = "localhost";
    //private $user       = "root";
    //private $pass       = "";
    //private $db         = "akademik";
    //private $koneksi;

    //public function __construct(){
    //    try {
    //        $this->koneksi = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
    //    }
    //    catch (Exception $e) {
    //        echo "Tidak dapat terhubung ke database" . $e-> getMessage();
    //    }
    //}
?>