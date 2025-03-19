<?php
if (!@$_COOKIE['level_user']) {
    echo "<script>alert('belum login');window.location.href='../login.php'</script>";
} elseif ($_COOKIE['level_user'] == 'operator') {
    echo "<script>alert('anda operator, silahkan kembali');window.location.href='halaman_utama.php?page=sertifikat'</script>";
}
$nis            = $_COOKIE['nis'];

if (isset($_POST['tombol_upload']) && isset($_FILES["sertifikat"])) {
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
                echo "<script>alert('Berhasil Mengunggah Sertifikat');window.location.href='halaman_utama.php?page=cek_sertifikat_siswa&id=" . $id . "&file=" . $newFileName . "'
</script>";
            } else {
                echo "Gagal Mengunggah File: " . mysqli_error($koneksi);
            }
        }
    }
}
?>

<div class="px-28 py-6">
    <div class="flex flex-col items-center gap-4">
        <!-- Dropdown Kategori -->
        <select name="kategori" onchange="pilihKategori(this.value)" class="select select-bordered w-full md:w-1/2">
            <option value="">Pilih Kategori</option>
            <?php
            $list_kategori = mysqli_query($koneksi, "SELECT Kategori FROM kategori GROUP BY Kategori");
            while ($data_kategori = mysqli_fetch_assoc($list_kategori)) {
            ?>
                <option value="<?= $data_kategori['Kategori'] ?>" <?= (@$_GET['kategori'] == $data_kategori['Kategori']) ? "selected" : "" ?>>
                    <?= $data_kategori['Kategori'] ?>
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

        <?php if (@$_GET['kategori']) {
            $kategori = htmlspecialchars($_GET['kategori']);
        ?>
            <!-- Dropdown Sub Kategori -->
            <select name="sub_kategori" onchange="pilihSubKategori(this.value)" class="select select-bordered w-full md:w-1/2">
                <option value="">Pilih Sub Kategori</option>
                <?php
                $list_kategori = mysqli_query($koneksi, "SELECT Sub_Kategori FROM kategori WHERE Kategori='$kategori'");
                while ($sub_kategori = mysqli_fetch_assoc($list_kategori)) {
                ?>
                    <option value="<?= $sub_kategori['Sub_Kategori'] ?>" <?= (@$_GET['sub_kategori'] == $sub_kategori['Sub_Kategori']) ? "selected" : "" ?>>
                        <?= $sub_kategori['Sub_Kategori'] ?>
                    </option>
                <?php
                }
                ?>
            </select>

            <script>
                function pilihSubKategori(value) {
                    const urlParams = new URLSearchParams(window.location.search);
                    const kategori = urlParams.get('kategori');
                    window.location.href = `halaman_utama.php?page=upload_sertifikat&kategori=${kategori}&sub_kategori=${value}`;
                }
            </script>
        <?php } ?>

        <?php if (@$_GET['sub_kategori']) {
            $kategori = htmlspecialchars($_GET['kategori']);
            $sub_kategori = htmlspecialchars($_GET['sub_kategori']);
            @$Id_Kategori = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Id_Kategori FROM kategori WHERE Sub_Kategori = '$sub_kategori'"))['Id_Kategori'];
        ?>
            <!-- Dropdown Jenis Kegiatan -->
            <select name="jenis_kegiatan" onchange="pilihJenisKegiatan(this.value)" class="select select-bordered w-full md:w-1/2" required>
                <option value="">Pilih Jenis Kegiatan</option>
                <?php
                $list_kategori = mysqli_query($koneksi, "SELECT Jenis_Kegiatan FROM kegiatan WHERE Id_Kategori='$Id_Kategori'");
                $list_kegiatan = mysqli_query($koneksi, "SELECT Jenis_Kegiatan FROM kegiatan INNER JOIN sertifikat USING(Id_Kegiatan) INNER JOIN kategori USING(Id_Kategori) WHERE NIS='$nis' AND Kategori='wajib' GROUP BY Jenis_Kegiatan");

                $kegiatan_terdaftar = [];
                while ($row = mysqli_fetch_assoc($list_kegiatan)) {
                    $kegiatan_terdaftar[] = $row['Jenis_Kegiatan'];
                }

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
                    window.location.href = `halaman_utama.php?page=upload_sertifikat&kategori=${kategori}&sub_kategori=${sub_kategori}&jenis_kegiatan=${value}`;
                }
            </script>
        <?php } ?>

        <?php if (@$_GET['jenis_kegiatan']) {
            $kategori = htmlspecialchars($_GET['kategori']);
            $sub_kategori = htmlspecialchars($_GET['sub_kategori']);
            $jenis_kegiatan = htmlspecialchars($_GET['jenis_kegiatan']);
        ?>
            <!-- Form Upload Sertifikat -->
            <form action="" method="post" enctype="multipart/form-data" class="w-full md:w-1/2 flex flex-col gap-4 bg-base-100 p-6 rounded-lg shadow-md">
                <input type="hidden" name="jenis_kegiatan" value="<?= $jenis_kegiatan ?>">

                <label class="block">
                    <span class="label-text">Unggah Sertifikat (PDF)</span>
                    <input type="file" accept=".pdf" name="sertifikat" required class="file-input file-input-bordered w-full">
                </label>

                <button type="submit" name="tombol_upload" class="btn btn-primary w-full">Upload</button>
            </form>
        <?php } ?>
    </div>
</div>