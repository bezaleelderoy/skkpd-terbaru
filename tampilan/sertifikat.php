<?php
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
              $whereClause ORDER BY Sub_Kategori, Tanggal_Upload ASC";

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
                    <td><a href='halaman_utama.php?page=cek_sertifikat&id={$data['Id_Sertifikat']}&file={$data['Sertifikat']}' target='_blank'>Lihat File</a></td>
                  </tr>";
        }
        echo "</table></center>";
    } else {
        echo "<p>Tidak ada data</p>";
    }
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

<?php
// Ambil nilai filter dari form
$status = isset($_POST['status']) ? $_POST['status'] : '';
$kegiatan = isset($_POST['kegiatan']) ? $_POST['kegiatan'] : '';

// Tampilkan hasil pencarian
getSertifikat($koneksi, $status, $kegiatan);
?>