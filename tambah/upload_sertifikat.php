<?php
if(!@$_COOKIE['level_user']) {
    echo "<script>alert('belum login');window.location.href='../login.php'</script>";
}elseif($_COOKIE['level_user']=='operator') {
    echo "<script>alert('anda operator, silahkan kembali');window.location.href='halaman_utama.php?page=sertifikat'</script>";
}
$nis            = $_COOKIE['nis'];

if(isset($_POST['tombol_upload']) && isset($_FILES["sertifikat"])){
    $tgl_Upload     = date("Y-m-d");
    $sertifikat     = $_FILES["sertifikat"]['name'];
    $kegiatan       = htmlspecialchars($_POST['jenis_kegiatan']);
    $id_kegiatan    = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Id_Kegiatan FROM kegiatan WHERE Jenis_Kegiatan = '$kegiatan'"))['Id_Kegiatan'];
    $file           = $_FILES["sertifikat"];
    $folder         = "../sertifikat/";
    $ekstensi       = strtolower(pathinfo($_FILES["sertifikat"]['name'], PATHINFO_EXTENSION));
    $ukuran         = $file["size"];


    // Validasi file atau cek file
    if ($ekstensi !== "pdf") {
        echo "Hanya file .pdf yang diperbolehkan!";
    } elseif ($ukuran > 2097152) { // 2MB dalam byte
        echo "Ukuran file terlalu besar! Maksimal 2MB.";
    } else {
        // Generate nama file baru dengan format NIS + 5 random karakter
        do {
            $randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 5);
            $newFileName = $nis . $randomString . ".pdf";
            $targetFile = $folder . $newFileName;
        } while (file_exists($targetFile)); // Cek apakah file sudah ada, jika ada buat ulang
        
        // Proses upload
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            $hasil = mysqli_query($koneksi, "INSERT INTO sertifikat VALUES(NULL, '$tgl_Upload', NULL, '$newFileName', 'Menunggu Validasi', NULL, '$nis', '$id_kegiatan')");

            $id = mysqli_fetch_row(mysqli_query($koneksi, "SELECT LAST_INSERT_ID()"))[0];
            
            if ($hasil) {
                echo "<script>alert('Berhasil Mengunggah Sertifikat');window.location.href='halaman_utama.php?page=cek_sertifikat_siswa&id=".$id."&file=".$newFileName."'
</script>";
} else {
echo "Gagal Mengunggah File: " . mysqli_error($koneksi);
}
}
}
}
?>

<center>
    <select name="kategori" onchange="pilihKategori(this.options[this.selectedIndex].value)">
        <option value="">Pilih Kategori</option>
        <?php
        $list_kategori = mysqli_query($koneksi, "SELECT Kategori FROM kategori GROUP BY Kategori");
        while($data_kategori = mysqli_fetch_assoc($list_kategori)){
        ?>
        <option value="<?=$data_kategori['Kategori']?>"
            <?php if(@$_GET['kategori']==$data_kategori['Kategori']){ echo "selected";}?>>
            <?=$data_kategori['Kategori']?>
        </option>
        <?php
        }
        ?>
    </select>
    <script>
    function pilihKategori(value) {
        window.location.href = 'halaman_utama.php?page=upload_sertifikat&kategori=' + value;
    }
    </script>




    <?php
    if(@$_GET['kategori']){
        $kategori = htmlspecialchars($_GET['kategori']);                
    ?>
    <select name="sub_kategori" onchange="pilihSubKategori(this.options[this.selectedIndex].value)">
        <option value="">Pilih Sub Kategori</option>
        <?php
        $list_kategori = mysqli_query($koneksi, "SELECT Sub_Kategori FROM kategori WHERE Kategori='$kategori'");
        while($sub_kategori = mysqli_fetch_assoc($list_kategori)){
        ?>
        <option value="<?=$sub_kategori['Sub_Kategori']?>"
            <?php if(@$_GET['sub_kategori']==$sub_kategori['Sub_Kategori']){ echo "selected";}?>>
            <?=$sub_kategori['Sub_Kategori']?>
        </option>
        <?php
        }
        ?>
    </select>
    <script>
    function pilihSubKategori(value) {
        const urlParams = new URLSearchParams(window.location.search);
        const kategori = urlParams.get('kategori');
        window.location.href =
            `halaman_utama.php?page=upload_sertifikat&kategori=${kategori}&sub_kategori=${value}`;
    }
    </script>
    <?php
    }
    ?>




    <?php
    if(@$_GET['sub_kategori']){
        $kategori = htmlspecialchars($_GET['kategori']);
        $sub_kategori = htmlspecialchars($_GET['sub_kategori']);   
        @$Id_Kategori = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Id_Kategori FROM kategori WHERE Sub_Kategori = '$sub_kategori'"))['Id_Kategori'];         
    ?>
    <select name="jenis_kegiatan" onchange="pilihJenisKegiatan(this.value)" required>
        <option value="">Pilih Jenis Kegiatan</option>
        <?php
        // Ambil daftar kegiatan berdasarkan kategori
        $list_kategori = mysqli_query($koneksi, "SELECT Jenis_Kegiatan FROM kegiatan WHERE Id_Kategori='$Id_Kategori'");
        
        // Ambil daftar kegiatan yang sudah diikuti oleh siswa (untuk disable option)
        $list_kegiatan = mysqli_query($koneksi, "SELECT Jenis_Kegiatan FROM kegiatan INNER JOIN sertifikat USING(Id_Kegiatan) INNER JOIN kategori USING(Id_Kategori) WHERE NIS='$nis' AND Kategori='wajib' GROUP BY Jenis_Kegiatan");
        
        // Buat array untuk menyimpan kegiatan yang sudah diikuti
        $kegiatan_terdaftar = [];
        while ($row = mysqli_fetch_assoc($list_kegiatan)) {
            $kegiatan_terdaftar[] = $row['Jenis_Kegiatan'];
        }

        // Loop daftar kegiatan dan tampilkan dalam <option>
        while ($jenis_kegiatan = mysqli_fetch_assoc($list_kategori)) {
            $nama_kegiatan = $jenis_kegiatan['Jenis_Kegiatan'];
            $isDisabled = in_array($nama_kegiatan, $kegiatan_terdaftar) ? "disabled" : "";
            $isSelected = (isset($_GET['jenis_kegiatan']) && $_GET['jenis_kegiatan'] === $nama_kegiatan) ? "selected" : "";
        ?>
        <option value="<?= htmlspecialchars($nama_kegiatan) ?>" <?= $isDisabled ?> <?= $isSelected ?>>
            <?= htmlspecialchars($nama_kegiatan) ?>
        </option>
        <?php
        }
        ?>
    </select>
    <script>
    function pilihJenisKegiatan(value) {
        const urlParams = new URLSearchParams(window.location.search);
        const kategori = urlParams.get('kategori');
        const sub_kategori = urlParams.get('sub_kategori');
        window.location.href =
            `halaman_utama.php?page=upload_sertifikat&kategori=${kategori}&sub_kategori=${sub_kategori}&jenis_kegiatan=${value}`;
    }
    </script>
    <?php
    }
    ?>
    <br><br>


    <?php
    if(@$_GET['jenis_kegiatan']){
        $kategori = htmlspecialchars($_GET['kategori']);
        $sub_kategori = htmlspecialchars($_GET['sub_kategori']);
        $jenis_kegiatan = htmlspecialchars($_GET['jenis_kegiatan']);   
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" hidden name="jenis_kegiatan" value="<?=$jenis_kegiatan?>">
        <input type="file" accept=".pdf" name="sertifikat" required>


        <input type="submit" name="tombol_upload" value="Upload">
    </form>
    <?php
            }
            ?>


</center>