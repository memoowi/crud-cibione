<?php
include("koneksi.php");
include("layouts/header.php");

if(isset($_POST['save'])){
    $nama = $_POST['nama'];
    $jurusan =$_POST['jurusan']; 

    //upload gambar
    $foto = 'default.jpg';
    if($_FILES['foto']['error'] === 0){
        $extension = pathinfo($foto, PATHINFO_EXTENSION); //ambil extension dari file gambar
        $foto = time() . '_' . rand(1000, 9999) . '.' . $extension; //ubah nama file + kasih extension

        $destination = 'uploads/' . $foto; //path file yang diupload

        move_uploaded_file($_FILES['foto']['tmp_name'], $destination); //memindahkan file yang diupload ke dalam path yang sudah di definisikan
    }

    //simpan ke database
    $query = "INSERT INTO siswa (nama, jurusan, foto) VALUES (?, ?, ?)";
    $statement = $koneksi->prepare($query);
    $statement->bind_param("sss", $nama, $jurusan, $foto);
    $result = $statement->execute();

    if($result){
        // echo "Data berhasil ditambahkan";
        header("Location: index.php");
    } else {
        echo "Error" . $query ."<br>" . $koneksi->error;
    }
}

?>

<!-- content -->
<form method="POST" enctype="multipart/form-data">
    <label class="form-label">Nama :</label>
    <input type="text" name="nama" class="form-control mb-3" required>
    <label class="form-label">Jurusan :</label>
    <input type="text" name="jurusan" class="form-control mb-3" required>
    <label class="form-label">Foto :</label>
    <input type="file" name="foto" class="form-control mb-3" accept="image/*">
    <a href="index.php" class="btn btn-secondary">Back</a>
    <input type="submit" class="btn btn-primary" name="save" value="Tambah">
</form>

<?php
include("layouts/footer.php");
?>