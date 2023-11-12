<?php
include("koneksi.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];

    //hapus file
    $queryGetFoto = "SELECT foto FROM siswa WHERE id = $id";
    $resultGetFoto = $koneksi->query($queryGetFoto);

    if($resultGetFoto->num_rows > 0){
        $row = $resultGetFoto->fetch_assoc();
        $foto = $row['foto'];

        if($foto != 'default.jpg'){
            unlink('uploads/' . $foto); // hapus file dari folder uploads
        }
    }
    //hapus data di DB
    $queryDelete = "DELETE FROM siswa WHERE id = $id";
    $resultDelete = $koneksi->query($queryDelete);

    if($resultDelete){
        // echo "Data Berhasil Dihapus";
        header("Location: index.php");
    } else {
        echo "Error" . $queryDelete . "<br>" . $koneksi->error;
    }
} else {
   echo "ID tidak valid"; 
}
?>