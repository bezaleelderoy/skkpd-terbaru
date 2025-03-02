<?php
if(!@$_COOKIE['level_user']) {
    echo "<script>alert('belum login');window.location.href='../login.php'</script>";
}elseif($_COOKIE['level_user']=='siswa') {
    echo "<script>alert('anda siswa, silahkan kembali');window.location.href='halaman_utama.php?page=sertifikat_siswa'</script>";
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
if (!$pdfFile){
    echo "File PDF tidak ditemukan!";
    exit;
} 

// Ambil data siswa dan sertifikat
$data = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Nama_Siswa, NIS, Jurusan, Kelas, No_Telp, Email, Angkatan, Kategori, Sub_Kategori, Jenis_Kegiatan, Status, Catatan FROM sertifikat INNER JOIN kegiatan USING(Id_Kegiatan) INNER JOIN kategori USING(Id_Kategori) INNER JOIN siswa USING(NIS) INNER JOIN jurusan USING(Id_Jurusan) WHERE Id_Sertifikat = '$id'"));

$tgl = date("Y-m-d");

// Proses update status sertifikat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tombol_submit'])) {
    $status = $_POST['status'];
    $catatan = isset($_POST['catatan']) ? mysqli_real_escape_string($koneksi, $_POST['catatan']) : NULL;

    $updateQuery = "UPDATE sertifikat SET 
                    Catatan = " . ($status === 'Tidak Valid' ? "'$catatan'" : "NULL") . ", 
                    Status = '$status', 
                    Tanggal_Status_Berubah = '$tgl' 
                    WHERE Id_Sertifikat='$id'";

    $hasil = mysqli_query($koneksi, $updateQuery);
    if (!$hasil) {
        echo "<script>alert('Gagal update data');window.location.href='halaman_utama.php?page=cek_sertifikat&id=$id&file=$pdfFile'</script>";
    } else {
        echo "<script>alert('Berhasil update data');window.location.href='halaman_utama.php?page=sertifikat'</script>";
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
        <h3>Detail Siswa</h3><br>
        <p><strong>Nama:</strong> <?= $data["Nama_Siswa"] ?></p>
        <p><strong>NIS:</strong> <?= $data["NIS"] ?></p>
        <p><strong>Kelas:</strong> <?= $data["Jurusan"] . " " . $data["Kelas"] ?></p>
        <p><strong>Telepon:</strong> <?= $data["No_Telp"] ?></p>
        <p><strong>Email:</strong> <?= $data["Email"] ?></p>
        <p><strong>Angkatan:</strong> <?= $data["Angkatan"] ?></p>
        <br><br>

        <h3>Kategori Kegiatan</h3><br>
        <p><strong>Kategori:</strong> <?= $data["Kategori"] ?></p>
        <p><strong>Sub Kategori:</strong> <?= $data["Sub_Kategori"] ?></p>
        <p><strong>Kegiatan:</strong> <?= $data["Jenis_Kegiatan"] ?></p><br><br>




        <?php if ($data["Status"] == "Menunggu Validasi"){ ?>
        <button id="btn-tidak-valid" type="button" onclick="toggleInvalid()" style="float:left;">Tidak Valid</button>
        <button id="btn-batal" type="button" style="display: none;" onclick="cancelInvalid()">Batal</button>
        <form action="" method="POST">
            <input type="hidden" name="status" value="Valid">
            <button type="submit" id="btn-valid" style="float:right;" name="tombol_submit">✅ Valid</button>
        </form>

        <form action="" method="POST">
            <div id="catatan-container" style="display: none;"><br>
                <textarea name="catatan" placeholder="Tulis catatan di sini..." rows="10" cols="38"></textarea>
            </div>
            <input type="hidden" name="status" value="Tidak Valid">
            <button type="submit" name="tombol_submit" id="btn-submit"
                style="display: none; float:right;">Submit</button>
        </form>

        <?php }elseif ($data["Status"] == "Tidak Valid"){ ?>
        <div id="catatan-container">
            <textarea readonly name=" catatan" placeholder="Tulis catatan di sini..."
                style="height: 150px"><?= $data["Catatan"] ?></textarea>
        </div>
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