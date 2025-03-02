<?php
if(isset($_POST['tombol_tambah'])){
    $kategori       = htmlspecialchars($_GET['kategori']);
    $sub_kategori   = htmlspecialchars($_GET['sub_kategori']);
    $kegiatan       = htmlspecialchars($_POST['kegiatan']);
    $cek_kegiatan   = mysqli_query($koneksi, "SELECT Jenis_Kegiatan FROM kegiatan WHERE Jenis_Kegiatan = '$kegiatan'");
    if(mysqli_num_rows($cek_kegiatan) > 0){
        echo "<script>alert('Data Sudah ada di database, silahkan masukkan jenis kegiatan baru');window.location.href='halaman_utama.php?page=tambah_kegiatan&kategori=".$kategori."&sub_kategori=".$sub_kategori."'</script>";
    }else{
        $kategori       = htmlspecialchars($_POST['kategori']);
        $sub_kategori   = htmlspecialchars($_POST['sub_kategori']);
        $id_kategori    = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Id_Kategori FROM kategori WHERE Sub_Kategori = '$sub_kategori'"))['Id_Kategori'];
        $point          = htmlspecialchars($_POST['point']);
        
        $hasil = mysqli_query($koneksi, "INSERT INTO kegiatan VALUES(NULL, '$kegiatan', '$point', '$id_kategori')");    
    
        if(!$hasil){
            echo "<script>alert('gagal memasukkan data');window.location.href='halaman_utama.php?page=tambah_kegiatan'</script>";
        }else{
            echo "<script>alert('Berhasil Menambahkan Data');window.location.href='halaman_utama.php?page=kategori_kegiatan'</script>";
        }
    }
    
}
?>


<center>
    <select name="kategori" onchange="pilihKategori(this.value)">
        <option selected>Pilih Kategori</option>
        <?php
    $list_kategori = mysqli_query($koneksi, "SELECT Kategori FROM kategori GROUP BY Kategori");
    while ($data_kategori = mysqli_fetch_assoc($list_kategori)) {
    ?>
        <option value="<?= $data_kategori['Kategori'] ?>"
            <?php if (@$_GET['kategori'] == $data_kategori['Kategori']) { echo "selected"; } ?>>
            <?= $data_kategori['Kategori'] ?>
        </option>
        <?php
    }
    ?>
    </select><br><br>

    <script>
    function pilihKategori(value) {
        window.location.href = 'halaman_utama.php?page=tambah_kegiatan&kategori=' + value;
    }
    </script>

    <?php
if (@$_GET['kategori']) {
    $kategori = htmlspecialchars($_GET['kategori']);
?>
    <select name="sub_kategori" onchange="pilihSubKategori(this.value)">
        <option selected>Pilih Sub Kategori</option>
        <?php
        $list_kategori = mysqli_query($koneksi, "SELECT Sub_Kategori FROM kategori WHERE Kategori='$kategori'");
        while ($sub_kategori = mysqli_fetch_assoc($list_kategori)) {
        ?>
        <option value="<?= $sub_kategori['Sub_Kategori'] ?>"
            <?php if (@$_GET['sub_kategori'] == $sub_kategori['Sub_Kategori']) { echo "selected"; } ?>>
            <?= $sub_kategori['Sub_Kategori'] ?>
        </option>
        <?php
        }
        ?>
    </select><br><br>

    <script>
    function pilihSubKategori(value) {
        const urlParams = new URLSearchParams(window.location.search);
        const kategori = urlParams.get('kategori');
        window.location.href = `halaman_utama.php?page=tambah_kegiatan&kategori=${kategori}&sub_kategori=${value}`;
    }
    </script>
    <?php
}
?>

    <?php
if (@$_GET['sub_kategori']) {
    $kategori = htmlspecialchars($_GET['kategori']);
    $sub_kategori = htmlspecialchars($_GET['sub_kategori']);
?>
    <form action="" method="post">
        <input type="hidden" name="kategori" value="<?= $kategori ?>">
        <input type="hidden" name="sub_kategori" value="<?= $sub_kategori ?>">

        <datalist id="kegiatan">
            <?php
            $list_kategori = mysqli_query($koneksi, "SELECT Sub_Kategori, Jenis_Kegiatan FROM kegiatan INNER JOIN kategori USING(Id_Kategori) WHERE Sub_Kategori='$sub_kategori'");
            while ($data_kegiatan = mysqli_fetch_assoc($list_kategori)) {
            ?>
            <option value="<?= $data_kegiatan['Jenis_Kegiatan'] ?>">
            </option>
            <?php
            }
            ?>
        </datalist>

        <label for="kegiatan">Nama Kegiatan:</label>
        <input type="text" list="kegiatan" name="kegiatan" required><br><br>

        <label for="point">Angka Kredit / Point:</label>
        <input type="number" name="point" required><br><br>

        <input type="submit" name="tombol_tambah" value="Simpan">
    </form>
    <?php
}
?>
</center>