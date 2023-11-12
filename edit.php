<?php
include("koneksi.php");
include("layouts/header.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];

    // AMBIL DATA DARI DB
    $query = "SELECT * FROM siswa WHERE id = $id";
    $result = $koneksi->query($query);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $nama = $row['nama'];
        $jurusan = $row['jurusan'];
        $foto = $row['foto'];
    }else{
        echo 'Data Tidak Ditemukan';
        exit();
    }
} else {
    echo "ID tidak VALID";
    exit();
}

if(isset($_POST['update'])){
    $nama = $_POST['nama'];
    $jurusan =$_POST['jurusan']; 

    // upload gambar
    $foto = $row['foto']; // gambar tetap sama kalau tidak diubah
    if($_FILES['foto']['error'] === 0){
        // hapus file lama
        if ($foto != 'default.jpg'){
            unlink('uploads/' . $foto);
        }

        //upload gambar baru
        $extension = pathinfo($foto, PATHINFO_EXTENSION); //ambil extension dari file gambar
        $foto = time() . '_' . rand(1000, 9999) . '.' . $extension; //ubah nama file + kasih extension

        $destination = 'uploads/' . $foto; //path file yang diupload
    
        move_uploaded_file($_FILES['foto']['tmp_name'], $destination); //memindahkan file yang diupload ke dalam path yang sudah di definisikan
    }

    //update ke database
    $queryUpdate = "UPDATE siswa SET nama = ?, jurusan = ?, foto = ? WHERE id = ?";
    $statement = $koneksi->prepare($queryUpdate);
    $statement->bind_param("sssi", $nama, $jurusan, $foto, $id);
    $resultUpdate = $statement->execute();

    if($resultUpdate){
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
    <input type="text" name="nama" class="form-control mb-3" value="<?php echo $nama; ?>" required>
    <label class="form-label">Jurusan :</label>
    <input type="text" name="jurusan" class="form-control mb-3" value="<?php echo $jurusan; ?>" required>
    <label class="form-label">Foto :</label>
    <input type="file" name="foto" class="form-control mb-3" accept="image/*">
    <img src="uploads/<?php echo $foto; ?>" alt="" class="mb-3"><br>
    <a href="index.php" class="btn btn-secondary">Back</a>
    <input type="submit" class="btn btn-primary" name="update" value="Tambah">
</form>

<?php
include("layouts/footer.php");
?>