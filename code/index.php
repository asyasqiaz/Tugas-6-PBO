<?php 
include ("../inc/inc_koneksi.php");
include ("../inc/inc_fungsi.php");
//include 'inc_fungsi.php';

$nim            = "";
$namamhs        = "";
$jk             = "";
$alamat         = "";
$kota           = "";
$email          = "";
$foto           = "";
$error          = "";
$sukses         = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}
else {
    $op = "";
}

if($op == 'hapus'){
    $id     = $_GET['id'];
    $sql1   = "select foto from tbl_mhs where id='$id'";
    $q1     = mysqli_query($koneksi, $sql1);
    $r1     = mysqli_fetch_array($q1);
    @unlink("../foto/".$r1['foto']);

    $sql1   = "delete from tbl_mhs where id = '$id'";
    $q1     = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }
    else {
        $error = "Gagal menghapus data";
    }
}


if($op == 'edit'){
    $id         = $_GET['id'];
    $sql1       = "select * from tbl_mhs where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    $r1         = mysqli_fetch_array($q1);
    $nim        = $r1['nim'];
    $namamhs    = $r1['namamhs'];
    $jk         = $r1['jk'];
    $alamat     = $r1['alamat'];
    $kota       = $r1['kota'];
    $email      = $r1['email'];
    $foto       = $r1['foto'];

    if($nim == ''){
        $error = "Data tidak temukan";
    }
}

if(isset($_POST['simpan'])){ // untuk create
    $nim            = $_POST['nim'];
    $namamhs        = $_POST['namamhs'];
    $jk             = $_POST['jk'];
    $alamat         = $_POST['alamat'];
    $kota           = $_POST['kota'];
    $email          = $_POST['email'];
    $foto           = $_FILES['foto']['name'];

    if($nim && $namamhs && $jk && $alamat && $kota && $email && $foto){
        
        if($_FILES['foto']['name']){
            $foto_name = $_FILES['foto']['name'];
            $foto_file = $_FILES['foto']['tmp_name'];
    
            $detail_file = pathinfo($foto_name);
            $foto_ekstensi = $detail_file['extension'];
            
    
            $x = explode('.', $foto);
            $foto_ekstensi = strtolower(end($x));
    
            $ekstensi_yang_diperbolehkan = array('png','jpg','jpeg');
            if(!in_array($foto_ekstensi, $ekstensi_yang_diperbolehkan)){
                $error = "Ekstensi foto yang diperbolehkan hanya png, jpg, dan jpeg";
            }
        }
    
        if (empty($error)) {
            if($foto_name) {
                $direktori = "../foto";

                @unlink($direktori."/$foto"); // hapus data

                $foto_name = "mhs_".time()."_".$foto_name;
                move_uploaded_file($foto_file, $direktori."/".$foto_name);

                $foto = $foto_name;
            }
            else {
                $foto_name = $foto; // memasukkan data dari data yang sudah ada
            }
        }
        
        if($op == 'edit'){ // update
            $sql1       = "update tbl_mhs set nim ='$nim', namamhs = '$namamhs', jk = '$jk', alamat = '$alamat', kota = '$kota', email = '$email', foto = '$foto_name' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if($q1){
                $sukses = "Data berhasil diupdate";
            }
            else {
                $error = "Data gagal diupdate";
            }
        }
        else { // insert
            $sql1   = "insert into tbl_mhs(nim, namamhs, jk, alamat, kota, email, foto) values ('$nim', '$namamhs', '$jk', '$alamat', '$kota', '$email', '$foto_name')";
            $q1     = mysqli_query($koneksi,$sql1);
            if($q1){
                $sukses     = "Berhasil memasukkan data baru"; 
            }
            else {
                $error      = "Gagal memasukkan data";
            }
        }
        
    }
    else {
        $error  = "Silakan masukkan semua data";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background: -webkit-linear-gradient(bottom, #C89595, #DDBEBE);
            background-repeat: no-repeat;
            
        }
        .mx-auto 
        { 
            width: 1150px;
            border-radius: 8px;
        }
        .card 
        { 
            box-shadow: 1px 2px 8px rgba(0, 0, 0, 0.65);
            margin: 30px 0px;
            
        }
        .card-header
        {
            background-color: #ba8d8d;
            font-family: "Raleway Thin", sans-serif;
            color: white;
            letter-spacing: 4px;
            padding: 13px;
            font-weight: bold;
            text-align: center;
        }
        
        .card-body 
        { 
            background-color: #FBFBFB;
            font-family: "Raleway Regular", sans-serif;
        }
        .col-12 {
            text-align: center;
        }
        
        #simpan-btn 
        {
            background: -webkit-linear-gradient(right, #DDBEBE, #C89595);
            border: none;
            border-radius: 21px;
            box-shadow: 0px 1px 8px #DDBEBE;
            color: white;
            font-family: "Raleway Thin", sans-serif;
            font-weight: bold;
            letter-spacing: 1.5px;
            height: 42.3px;
            margin: 25px 0px;
            transition: 0.25s;
            width: 160px;
        }
        #simpan-btn:hover, #edit-btn:hover, #hapus-btn:hover {
            box-shadow: 0px 1px 18px #DDBEBE;
        }
        #edit-btn{
            background-color: #DDBEBE;
            border: none;
            box-shadow: 0px 1px 8px #DDBEBE;
            color: white;
            font-family: "Raleway Thin", sans-serif;
            font-weight: bold;
            letter-spacing: 1.5px;
            height: 32.3px;
            transition: 0.25s;
        }
        #hapus-btn{
            border: none;
            background-color: #C89595;
            box-shadow: 0px 1px 8px #C89595;
            color: white;
            font-family: "Raleway Thin", sans-serif;
            font-weight: bold;
            letter-spacing: 1.5px;
            height: 32.3px;
            transition: 0.25s;
        }

    </style>
</head>
<body>

    <div class="mx-auto">
        <!-- menginputkan data --> 
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                    if($error){
                        ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error ?>
                            </div>
                        <?php
                            header("refresh:5;url=index.php"); // 5 detik
                    }
                ?>
                <?php
                    if($sukses){
                        ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $sukses ?>
                            </div>
                        <?php
                            header("refresh:5;url=index.php"); // 5 detik
                    }
                ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3 row">
                        <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="namamhs" class="col-sm-2 col-form-label">Nama Mahasiswa</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="namamhs" name="namamhs" value="<?php echo $namamhs?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="jk" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="jk" id="jk">
                                <option selected>Pilih Jenis Kelamin</option>
                                <option value="1">L</option>
                                <option value="2">P</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="kota" class="col-sm-2 col-form-label">Kota</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kota" name="kota" value="<?php echo $kota?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="email" placeholder="nama@mhs.unesa.ac.id">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="foto" class="col-sm-2 col-form-label">Foto</label>
                        <div class="col-sm-10">
                            <?php 
                            if($foto) {
                                echo "<img src='../foto/$foto' style='max-height: 200px; max-width:200px;'>";
                            }
                            ?>
                            <input class="form-control" type="file" name="foto" id="foto">
                        </div>
                    </div>

                    <div class="col-12">
                        <input id="simpan-btn" type="submit" name="simpan" value="Simpan Data" class="btn btn-primary"/>
                    </div>
                </form>
            </div>
        </div>

        <!-- mengeluarkan data -->
        <div class="card">
            <div class="card-header">
                Data Mahasiswa
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama Mahasiswa</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Kota</th>
                            <th scope="col">Email</th>
                            <th class="col-2">Foto</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Hapus</th>
                        </tr>
                        <tbody>
                            <?php
                            
                            $sql2   = "select * from tbl_mhs order by id desc";
                            $q2     = mysqli_query($koneksi, $sql2);
                            $urut   = 1;
                            while($r2 = mysqli_fetch_array($q2)){
                                $id         = $r2['id'];
                                $nim        = $r2['nim'];
                                $namamhs    = $r2['namamhs'];
                                $jk         = $r2['jk'];
                                $alamat     = $r2['alamat'];
                                $kota       = $r2['kota'];
                                $email      = $r2['email'];
                                $foto       = $r2['foto'];

                                ?>
                                <tr>
                                    <th scope="row"><?php echo $urut++ ?></th>
                                    <td scope="row"><?php echo $nim ?></td>
                                    <td scope="row"><?php echo $namamhs ?></td>
                                    <td scope="row"><?php echo $jk ?></td>
                                    <td scope="row"><?php echo $alamat ?></td>
                                    <td scope="row"><?php echo $kota ?></td>
                                    <td scope="row"><?php echo $email ?></td>
                                    <td><img src="../foto/<?php echo mhs_foto($r2['id'])?>" style="max-height:200px; max-width:200px;"/></td>
                                    <td scope="row">
                                        <a href="index.php?op=edit&id=<?php echo $id?>"><button id="edit-btn" type="button" class="btn btn-warning">Edit</button></a>
                                    </td>
                                    <td scope="row">
                                    <a href="index.php?op=hapus&id=<?php echo $id?>" onclick="return confirm('Anda yakin mau menghapus data?')"><button id="hapus-btn" type="button" class="btn btn-danger">Hapus</button></a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</body>
</html>


?>