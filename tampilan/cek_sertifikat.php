<?php
if (!@$_COOKIE['level_user']) {
    echo "<script>alert('belum login');window.location.href='../login.php'</script>";
} elseif ($_COOKIE['level_user'] == 'siswa') {
    echo "<script>alert('anda siswa, silahkan kembali');window.location.href='halaman_utama.php?page=sertifikat_siswa'</script>";
}
// Mengambil parameter dari URL
if (isset($_GET['file'])) {
    $pdfFile = $_GET['file'];
} else {
    $pdfFile = '';
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = '';
}

// Validasi input
if (!$pdfFile) {
    echo "File PDF tidak ditemukan!";
    exit;
}

// Ambil data siswa dan sertifikat
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Nama_Siswa, NIS, Jurusan, Kelas, No_Telp, Email, Angkatan, Kategori, Sub_Kategori, Jenis_Kegiatan, Status, Catatan FROM sertifikat INNER JOIN kegiatan USING(Id_Kegiatan) INNER JOIN kategori USING(Id_Kategori) INNER JOIN siswa USING(NIS) INNER JOIN jurusan USING(Id_Jurusan) WHERE Id_Sertifikat = '$id'"));

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



<div class="px-28 py-10 mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- PDF Viewer -->
        <div class="bg-base-200 p-5 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold mb-3">Sertifikat</h2>
            <embed src="../sertifikat/<?= htmlspecialchars($pdfFile) ?>" type="application/pdf" class="w-full h-96 rounded-lg shadow-md">
        </div>

        <!-- Detail Siswa & Kegiatan -->
        <div class="bg-base-100 p-5 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold mb-3">Detail Siswa</h2>
            <div class="space-y-2">
                <p><strong>Nama:</strong> <?= $data["Nama_Siswa"] ?></p>
                <p><strong>NIS:</strong> <?= $data["NIS"] ?></p>
                <p><strong>Kelas:</strong> <?= $data["Jurusan"] . " " . $data["Kelas"] ?></p>
                <p><strong>Telepon:</strong> <?= $data["No_Telp"] ?></p>
                <p><strong>Email:</strong> <?= $data["Email"] ?></p>
                <p><strong>Angkatan:</strong> <?= $data["Angkatan"] ?></p>
            </div>

            <hr class="my-4">

            <h2 class="text-xl font-bold mb-3">Kategori Kegiatan</h2>
            <div class="space-y-2">
                <p><strong>Kategori:</strong> <?= $data["Kategori"] ?></p>
                <p><strong>Sub Kategori:</strong> <?= $data["Sub_Kategori"] ?></p>
                <p><strong>Kegiatan:</strong> <?= $data["Jenis_Kegiatan"] ?></p>
            </div>

            <hr class="my-4">

            <!-- Validasi Sertifikat -->
            <?php if ($data["Status"] == "Menunggu Validasi") { ?>
                <div class="flex justify-between mt-4">
                    <button id="btn-tidak-valid" type="button" onclick="toggleInvalid()" class="btn btn-error">Tidak Valid</button>
                    <form action="" method="POST">
                        <input type="hidden" name="status" value="Valid">
                        <button type="submit" id="btn-valid" name="tombol_submit" class="btn btn-primary">✅ Valid</button>
                    </form>
                </div>

                <div id="catatan-container" class="hidden mt-4">
                    <textarea name="catatan" placeholder="Tulis catatan di sini..." rows="4" class="textarea textarea-bordered w-full"></textarea>
                    <div class="flex justify-between mt-3">
                        <button id="btn-batal" type="button" class="btn btn-secondary" onclick="cancelInvalid()">Batal</button>
                        <form action="" method="POST">
                            <input type="hidden" name="status" value="Tidak Valid">
                            <button type="submit" name="tombol_submit" id="btn-submit" class="btn btn-error">Submit</button>
                        </form>
                    </div>
                </div>

            <?php } elseif ($data["Status"] == "Tidak Valid") { ?>
                <div id="catatan-container">
                    <label class="label">Catatan:</label>
                    <textarea readonly class="textarea textarea-bordered w-full"><?= $data["Catatan"] ?></textarea>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    function toggleInvalid() {
        document.getElementById('btn-tidak-valid').classList.add('hidden');
        document.getElementById('btn-valid').classList.add('hidden');
        document.getElementById('catatan-container').classList.remove('hidden');
    }

    function cancelInvalid() {
        document.getElementById('btn-tidak-valid').classList.remove('hidden');
        document.getElementById('btn-valid').classList.remove('hidden');
        document.getElementById('catatan-container').classList.add('hidden');
    }
</script>