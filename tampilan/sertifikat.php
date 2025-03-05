<?php
if(!@$_COOKIE['level_user']) {
    echo "<script>alert('belum login');window.location.href='../login.php'</script>";
}elseif($_COOKIE['level_user']=='siswa') {
    echo "<script>alert('anda siswa, silahkan kembali');window.location.href='halaman_utama.php?page=sertifikat_siswa'</script>";
}
// Fungsi untuk mendapatkan data sertifikat berdasarkan status dan kegiatan
function getSertifikat($koneksi, $status = '', $kegiatan = '') {
    $whereClause = "WHERE 1"; // Default kondisi WHERE
    
    if (!empty($status)) {
        $whereClause .= " AND Status='" . mysqli_real_escape_string($koneksi, $status) . "'";
    }
    if (!empty($kegiatan)) {
        $whereClause .= " AND Jenis_Kegiatan LIKE '%" . mysqli_real_escape_string($koneksi, $kegiatan) . "%'";
    }

    $query = "SELECT * FROM sertifikat 
              INNER JOIN kegiatan USING(Id_Kegiatan) 
              INNER JOIN kategori USING(Id_Kategori) 
              INNER JOIN siswa USING(NIS) 
              $whereClause ORDER BY Status, Sub_Kategori, Tanggal_Upload ASC";

    $result = mysqli_query($koneksi, $query);
    
    if (mysqli_num_rows($result) > 0) {
        echo "<center><table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr>
                <th>NIS</th>
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
                    <td>{$data['NIS']}</td>
                    <td>{$data['Kategori']}</td>
                    <td>{$data['Sub_Kategori']}</td>
                    <td>{$data['Jenis_Kegiatan']}</td>
                    <td>{$data['Nama_Siswa']}</td>
                    <td>{$data['Angkatan']}</td>
                    <td>{$data['Status']}</td>
                    <td><a href='halaman_utama.php?page=cek_sertifikat&id={$data['Id_Sertifikat']}&file={$data['Sertifikat']}' target='_blank'>Lihat File</a></td>
                  </tr>";
        }
        echo "</table></center>";
    } else {
        echo "<p>Tidak ada data</p>";
    }
}


if(@$_POST['tombol_cetak_laporan']){
    setcookie('angkatan', $_POST['angkatan'], time() + (60 * 60 * 24 * 7), '/');
    setcookie('status', $_POST['status'], time() + (60 * 60 * 24 * 7), '/');
    echo "<script>window.location.href='../cetak/laporan/laporan.php';</script>";
}

?>
<center>
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
<center>
    <!-- <form method="POST" action="">
        <input type="submit" value="Cetak Laporan">
    </form> -->



    <button type="button" onclick="document.getElementById('exampleModal').showModal();">
        Cetak Laporan
    </button>

    <dialog id="exampleModal">
        <form method="post">
            <h2>Saring/Filter</h2>

            <label for="angkatan">Pilih Angkatan:</label>
            <select name="angkatan" id="angkatan">
                <option hidden value="">Pilih Angkatan</option>
                <option value="semua">Semua</option>
                <?php
            $data_angkatan = mysqli_query($koneksi, "SELECT Angkatan FROM siswa GROUP BY Angkatan");
            while($angkatan = mysqli_fetch_assoc($data_angkatan)){
            ?>
                <option value="<?=$angkatan['Angkatan']?>"><?=$angkatan['Angkatan']?></option>
                <?php
            }
            ?>
            </select>

            <label for="status">Pilih Status:</label>
            <select name="status" id="status">
                <option hidden value="">Pilih Status</option>
                <option value="semua">Semua</option>
                <?php
            $data_status = mysqli_query($koneksi, "SELECT Status FROM sertifikat GROUP BY Status");
            while($status = mysqli_fetch_assoc($data_status)){
            ?>
                <option value="<?=$status['Status']?>"><?=$status['Status']?></option>
                <?php
            }
            ?>
            </select>

            <div style="margin-top: 10px;">
                <button type="button" onclick="document.getElementById('exampleModal').close();">Batal</button>
                <input type="submit" name="tombol_cetak_laporan" value="Cetak Laporan">
            </div>
        </form>
    </dialog>
</center>
<br><br>

<?php
// Ambil nilai filter dari form
if (isset($_POST['status'])) {
    $status = $_POST['status'];
} else {
    $status = '';
}

if (isset($_POST['kegiatan'])) {
    $kegiatan = $_POST['kegiatan'];
} else {
    $kegiatan = '';
}

// Tampilkan hasil pencarian
getSertifikat($koneksi, $status, $kegiatan);
?>