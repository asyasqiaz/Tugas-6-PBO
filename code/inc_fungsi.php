<?php

function mhs_foto($id){
    global $koneksi;
    $sql2   = "select * from tbl_mhs where id = '$id'";
    $q2     = mysqli_query($koneksi,$sql2);
    $r2     = mysqli_fetch_array($q2);
    $foto   = $r2['foto'];

    if($foto){
        return $foto;
    }
    else {
        return 'mhs_default_picture.png';
    }
}

?>