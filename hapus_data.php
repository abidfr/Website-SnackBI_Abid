<?php 
include_once('db_connect.php');
$database = new database();
$id = $_GET['id'];
function hapus($id)
{
    global $database;
    mysqli_query($database->koneksi,"DELETE FROM services WHERE id_services = '$id'");
    mysqli_affected_rows($database->koneksi);

}
if(hapus($id) > 0) {
    echo "<script>
        alert('Data Berhasil Di Hapus');
        document.location.href = 'home.php';
    </script>";
} else {
    echo "<script>
        alert('Data Berhasil Di Hapus');
        document.location.href = 'home.php';
    </script>";
}
?>