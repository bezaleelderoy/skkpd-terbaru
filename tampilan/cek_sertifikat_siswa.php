<?php
if(!@$_COOKIE['level_user']) {
    echo "<script>alert('belum login');window.location.href='../login.php'</script>";
}elseif($_COOKIE['level_user']=='operator') {
    echo "<script>alert('anda operator, silahkan kembali');window.location.href='halaman_utama.php?page=sertifikat'</script>";
}
// Mengambil parameter dari URL
if(isset($_GET['file'])){
    $pdfFile = $_GET['file'];
}else{
    $pdfFile = '';
}
if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    $id = '';
}

// Validasi input
if (!$pdfFile) {
    echo "File PDF tidak ditemukan!";
    exit;
} 

// Ambil data siswa dan sertifikat
$data = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Kategori, Sub_Kategori, Jenis_Kegiatan, Status, Catatan, Sertifikat FROM sertifikat INNER JOIN kegiatan USING(Id_Kegiatan) INNER JOIN kategori USING(Id_Kategori) WHERE Id_Sertifikat = '$id'"));

if(isset($_POST['tombol_upload']) && isset($_FILES["sertifikat"])){
    $tgl            = date("Y-m-d");
    $sertifikat     = $_FILES["sertifikat"]['name'];
    $file           = $_FILES["sertifikat"];
    $folder         = "../sertifikat/";
    $ekstensi       = strtolower(pathinfo($_FILES["sertifikat"]['name'], PATHINFO_EXTENSION));
    $ukuran         = $file["size"];
    $nis            = $_COOKIE['nis'];

    // Validasi file atau cek file
    if($ekstensi !== "pdf"){
        echo "Hanya file .pdf yang diperbolehkan!";
    }elseif($ukuran > 2097152){ // 2MB dalam byte
        echo "Ukuran file terlalu besar! Maksimal 2MB.";
    }else{
        // Generate nama file baru dengan format NIS + 5 random karakter
        do {
            $randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 5);
            $newFileName = $nis . $randomString . ".pdf";
            $targetFile = $folder . $newFileName;
        } while (file_exists($targetFile)); // Cek apakah file sudah ada, jika ada buat ulang

        // Hapus file lama jika ada
        $file_path = "../sertifikat/" . $data['Sertifikat'];
        if (!empty($data['Sertifikat']) && file_exists($file_path)) {
            unlink($file_path);
        }

        // Upload file dengan nama baru
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            // Update database dengan nama file baru
            $update = mysqli_query($koneksi, "UPDATE sertifikat 
                      SET Sertifikat='$newFileName', Status='Menunggu Validasi', Tanggal_Status_Berubah='$tgl' 
                      WHERE Id_Sertifikat='$id'");

            if ($update) {
                echo "<script>alert('Berhasil Mengunggah Ulang Sertifikat');window.location.href='halaman_utama.php?page=cek_sertifikat_siswa&id=".$id."&file=".$newFileName."'</script>";
            } else {
                echo "Gagal mengupdate database: " . mysqli_error($koneksi);
            }
        } else {
            echo "Gagal mengunggah file.";
        }
    }
}


?>

<style>
.container {
    display: flex;
    height: 100vh;
}

.pdf-container {
    flex: 4;
    border-right: 2px solid #ddd;
    padding: 10px;
}

.pdf-container embed {
    width: 100%;
    height: 100vh;
}

.siswa-container {
    flex: 1;
    padding: 20px;
    background-color: #f8f9fa;
    overflow-y: auto;
}
</style>

<div class="container">
    <div class="pdf-container">
        <embed src="../sertifikat/<?= htmlspecialchars($pdfFile) ?>" type="application/pdf">
    </div>

    <div class="siswa-container">
        <h3 style="color:#e5bb11"><?=$data["Status"]?></h3>
        <br><br>

        <h3>Kategori Kegiatan</h3><br>
        <p><strong>Kategori:</strong> <?= $data["Kategori"] ?></p>
        <p><strong>Sub Kategori:</strong> <?= $data["Sub_Kategori"] ?></p>
        <p><strong>Kegiatan:</strong> <?= $data["Jenis_Kegiatan"] ?></p><br><br>



        <?php if ($data["Status"] == "Tidak Valid"){ ?>
        <div id="catatan-container">
            <h3>Catatan</h3>
            <textarea readonly name=" catatan" style="height: 150px"><?= $data["Catatan"] ?></textarea>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" accept=".pdf" name="sertifikat" autofocus required><br><br>
            <input type="submit" name="tombol_upload" value="Upload Ulang">
        </form>
        <?php } ?>
    </div>


    <script>
    function toggleInvalid() {
        document.getElementById('btn-tidak-valid').style.display = 'none';
        document.getElementById('btn-valid').style.display = 'none';
        document.getElementById('btn-batal').style.display = 'inline-block';
        document.getElementById('btn-submit').style.display = 'inline-block';
        document.getElementById('catatan-container').style.display = 'block';
    }

    function cancelInvalid() {
        document.getElementById('btn-tidak-valid').style.display = 'inline-block';
        document.getElementById('btn-valid').style.display = 'inline-block';
        document.getElementById('btn-batal').style.display = 'none';
        document.getElementById('btn-submit').style.display = 'none';
        document.getElementById('catatan-container').style.display = 'none';
    }
    </script>
</div>