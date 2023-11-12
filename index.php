<?php
include("koneksi.php");
include("layouts/header.php");

$query = "SELECT * FROM siswa";
$result = $koneksi->query($query);
?>

<!-- content -->
<a href="create.php" class="btn btn-primary mb-3">Tambah</a>
<table class="table table-striped">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Jurusan</th>
        <th>Foto</th>
        <th>Actions</th>
    </tr>

    <?php
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
    ?>
        <tr>
            <td><?php echo "{$row['id']}" ?></td>
            <td><?php echo "{$row['nama']}" ?></td>
            <td><?php echo "{$row['jurusan']}" ?></td>
            <td>
                <img src="uploads/<?php echo "{$row['foto']}" ?>" width="100">
            </td>
            <td>
                <a href="edit.php?id=<?php echo "{$row['id']}" ?>" class="btn btn-warning">Edit</a>
                <a href="delete.php?id=<?php echo "{$row['id']}" ?>" class="btn btn-danger" onclick="return confirm('Yakin nich?')">Delete</a>
            </td>
        </tr>
    <?php
        }
        } else{
            echo "<tr><td colspan='5' class='text-center'>Tidak ada data</td></tr>";
        }
    ?>
</table>

<?php
include("layouts/footer.php");
?>