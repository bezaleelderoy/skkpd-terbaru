<?php
$id = $_GET['id'];
$data_update = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM jurusan WHERE Id_Jurusan='$id'"));

if(isset($_POST['tombol_update'])){
    $jurusan    = $_POST['jurusan'];
    $hasil = mysqli_query($koneksi, "UPDATE jurusan SET Jurusan = '$jurusan' WHERE Id_Jurusan='$id'");
    
    if(!$hasil){
        echo "<script>alert('Gagal update data jurusan');window.location.href='halaman_utama.php?page=ubah_jurusan&nis=$nis'</script>";
    }else{
        echo "<script>alert('Berhasil update data jurusan');window.location.href='halaman_utama.php?page=jurusan'</script>";
    }
}
?>
<center>
    <form action="" method="post">
        <label for="jurusan">Nama Jurusan</label>
        <input type="text" id="jurusan" name="jurusan" value="<?=$data_update['Jurusan']?>" required>
        <input type="submit" name="tombol_tambah" value="Update">
    </form>
</center>