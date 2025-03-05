<?php
if(!@$_COOKIE['level_user']) {
    echo "<script>alert('belum login');window.location.href='../login.php'</script>";
}elseif($_COOKIE['level_user']=='operator') {
    echo "<script>alert('anda operator, silahkan kembali');window.location.href='halaman_utama.php?page=sertifikat'</script>";
}
$nis = $_COOKIE['nis'];
// Fungsi untuk mendapatkan data sertifikat berdasarkan status dan kegiatan
function getSertifikat($koneksi, $status = '', $kegiatan = '') {
    $whereClause = "WHERE 1"; // Default kondisi WHERE
    
    if (!empty($status)) {
        $whereClause .= " AND Status='" . mysqli_real_escape_string($koneksi, $status) . "'";
    }
    if (!empty($kegiatan)) {
        $whereClause .= " AND Jenis_Kegiatan LIKE '%" . mysqli_real_escape_string($koneksi, $kegiatan) . "%'";
    }

    $nis = $_COOKIE['nis'];
    $query = "SELECT * FROM sertifikat 
              INNER JOIN kegiatan USING(Id_Kegiatan) 
              INNER JOIN kategori USING(Id_Kategori) 
              INNER JOIN siswa USING(NIS) 
              $whereClause AND NIS='$nis' ORDER BY Status, Sub_Kategori, Tanggal_Upload ASC";

    $result = mysqli_query($koneksi, $query);
    
    if (mysqli_num_rows($result) > 0) {
        echo "<center><table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr>
                <th>Kategori</th>
                <th>Sub Kategori</th>
                <th>Jenis Kegiatan</th>
                <th>Nama Siswa</th>
                <th>Angkatan</th>
                <th>Status</th>
                <th>Lihat Sertifikat</th>
              </tr>";
        
        while ($data = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$data['Kategori']}</td>
                    <td>{$data['Sub_Kategori']}</td>
                    <td>{$data['Jenis_Kegiatan']}</td>
                    <td>{$data['Nama_Siswa']}</td>
                    <td>{$data['Angkatan']}</td>
                    <td>{$data['Status']}</td>
                    <td><a href='halaman_utama.php?page=cek_sertifikat_siswa&id={$data['Id_Sertifikat']}&file={$data['Sertifikat']}' target='_blank'>Lihat File</a></td>
                  </tr>";
        }
        echo "</table></center>";
    } else {
        echo "<p>Tidak ada data</p>";
    }
}
?>
<center>



    <table border="1">
        <tr>
            <th>Keterangan</th>
            <th>Jumlah</th>
        </tr>
        <tr>
            <td>Point Terkumpul</td>
            <td>
                <?php
            $total_point = mysqli_fetch_row(mysqli_query($koneksi, "SELECT SUM(Angka_Kredit) FROM sertifikat INNER JOIN kegiatan USING(Id_Kegiatan) WHERE Status='Valid' AND NIS='$nis'"))[0];
            echo $total_point . "/30 Point";
            
            if ($total_point >= 30) {
                echo "<br><a href='../cetak/sertifikat_skkpd/generate_sertifikat.php'>Cetak Sertifikat SKKPd</a>";
            }
            ?>
            </td>
        </tr>
        <tr>
            <td>Menunggu Validasi</td>
            <td>
                <?php
            $total_point = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM sertifikat WHERE Status='Menunggu Validasi' AND NIS='$nis'"))[0];
            echo $total_point . " Sertifikat";
            ?>
            </td>
        </tr>
        <tr>
            <td>Tidak Valid</td>
            <td>
                <?php
            $total_point = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM sertifikat WHERE Status='Tidak Valid' AND NIS='$nis'"))[0];
            echo $total_point . " Sertifikat";
            ?>
            </td>
        </tr>
        <tr>
            <td>Valid</td>
            <td>
                <?php
            $total_point = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM sertifikat WHERE Status='Valid' AND NIS='$nis'"))[0];
            echo $total_point . " Sertifikat";
            ?>
            </td>
        </tr>
    </table><br><br>



    <button onclick="window.location.href='halaman_utama.php?page=upload_sertifikat';">+ Upload
        Sertifikat</button> <br><br>
    <form method="POST" action="">
        <label for="status">Pilih Status:</label>
        <select name="status">
            <option value="">Semua</option>
            <option value="Menunggu Validasi">Menunggu Validasi</option>
            <option value="Tidak Valid">Tidak Valid</option>
            <option value="Valid">Sudah Tervalidasi</option>
        </select>

        <label for="kegiatan">Pilih Kegiatan:</label>
        <select name="kegiatan">
            <option value="">Semua</option>
            <?php
        $list_kegiatan = mysqli_query($koneksi, "SELECT DISTINCT Jenis_Kegiatan FROM kegiatan");
        while ($data_kegiatan = mysqli_fetch_assoc($list_kegiatan)) {
            echo "<option value='{$data_kegiatan['Jenis_Kegiatan']}'>{$data_kegiatan['Jenis_Kegiatan']}</option>";
        }
        ?>
        </select>

        <input type="submit" value="Cari">
    </form>
</center>
<br><br>

<?php
// Ambil nilai filter dari form
$status = isset($_POST['status']) ? $_POST['status'] : '';
$kegiatan = isset($_POST['kegiatan']) ? $_POST['kegiatan'] : '';

// Tampilkan hasil pencarian
getSertifikat($koneksi, $status, $kegiatan);
?>