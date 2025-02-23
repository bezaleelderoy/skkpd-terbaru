<center>
    <?php
if(@$_GET['Id_Kegiatan']){
    $id_kegiatan = htmlspecialchars($_GET['Id_Kegiatan']);
    $data_update = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM kategori INNER JOIN kegiatan USING(Id_Kategori) WHERE Id_Kegiatan='$id_kegiatan'"));

    if(isset($_POST['tombol_update'])){
        $kegiatan       = htmlspecialchars($_POST['kegiatan']);
        $kategori       = htmlspecialchars($_POST['kategori']);
        $sub_kategori   = htmlspecialchars($_POST['sub_kategori']);
        $point          = htmlspecialchars($_POST['point']);
        
        $hasil = mysqli_query($koneksi, "UPDATE kegiatan SET Jenis_Kegiatan='$kegiatan', Angka_Kredit='$point' WHERE Id_Kegiatan = '$id_kegiatan'");    

        if(!$hasil){
            echo "<script>alert('gagal memasukkan data');window.location.href='halaman_utama.php?page=ubah_kategori_kegiatan&Id_Kegiatan=".$id_kegiatan."'</script>";
        }else{
            echo "<script>alert('Berhasil Memperbarui Data');window.location.href='halaman_utama.php?page=kategori_kegiatan'</script>";
        }
    }  
?>



    <form action="" method="post">
        <label>Kategori:</label>
        <input type="text" name="kategori" readonly value="<?=$data_update['Kategori']?>" required><br>

        <label>Sub Kategori:</label>
        <input type="text" name="sub_kategori" readonly value="<?=$data_update['Sub_Kategori']?>" required><br>

        <label>Nama Kegiatan:</label>
        <input type="text" name="kegiatan" value="<?=$data_update['Jenis_Kegiatan']?>" autofocus required><br>

        <label>Angka Kredit / Point:</label>
        <input type="number" name="point" value="<?=$data_update['Angka_Kredit']?>" required><br>

        <input type="submit" name="tombol_update" value="Update">
    </form>

    <?php
}elseif(@$_GET['Id_Kategori']){
    $id_kategori = htmlspecialchars($_GET['Id_Kategori']);
    $data_update = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM kategori WHERE Id_Kategori='$id_kategori'"));

    if(isset($_POST['tombol_update'])){
        $sub_kategori   = htmlspecialchars($_POST['sub_kategori']);
        
        $hasil = mysqli_query($koneksi, "UPDATE kategori SET Sub_Kategori='$sub_kategori' WHERE Id_Kategori = '$id_kategori'");    

        if(!$hasil){
            echo "<script>alert('gagal memasukkan data');window.location.href='halaman_utama.php?page=ubah_kategori_kegiatan&Id_Kegiatan=".$id_kegiatan."'</script>";
        }else{
            echo "<script>alert('Berhasil Memperbarui Data');window.location.href='halaman_utama.php?page=kategori_kegiatan'</script>";
        }
    }  
?>

    <form action="" method="post">
        <label>Kategori:</label>
        <input type="text" name="kategori" readonly value="<?=$data_update['Kategori']?>" required><br>

        <label>Sub Kategori:</label>
        <input type="text" name="sub_kategori" autofocus value="<?=$data_update['Sub_Kategori']?>" required><br>

        <input type="submit" name="tombol_update" value="Update">
    </form>

    <?php
}
?>

</center>