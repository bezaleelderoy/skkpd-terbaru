<?php

if (!@$_COOKIE['level_user']) {
    echo "<script>alert('Belum login');window.location.href='../login.php'</script>";
} elseif ($_COOKIE['level_user'] == 'siswa') {
    echo "<script>alert('Anda siswa, silahkan kembali');window.location.href='halaman_utama.php?page=sertifikat_siswa'</script>";
}

// Fungsi untuk mendapatkan data sertifikat berdasarkan filter
function getSertifikat($koneksi, $status = '', $kegiatan = '')
{
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

    echo "<div class='px-28 pb-12'>";
    echo "<div class='flex justify-between items-center my-5'>";
    echo "<h1 class='text-3xl font-bold border-b-2 border-accent pb-1'>Data Sertifikat</h1>";

    // Form Cetak Laporan
    echo "<form method='POST' action='' class='flex items-center space-x-2'>";
    echo "<select class='select' name='angkatan'>";
    echo "<option value=''>Pilih Angkatan</option>";
    $list_angkatan = mysqli_query($koneksi, "SELECT DISTINCT Angkatan FROM siswa");
    while ($data_angkatan = mysqli_fetch_assoc($list_angkatan)) {
        echo "<option value='{$data_angkatan['Angkatan']}'>{$data_angkatan['Angkatan']}</option>";
    }
    echo "</select>";

    echo "<input type='hidden' name='status' value='$status'>";
    echo "<button type='submit' name='tombol_cetak_laporan' class='btn btn-secondary'>🖨 Cetak Laporan</button>";
    echo "</form>";
    echo "</div>";

    // Form Filter Data Sertifikat
    echo "<form method='POST' action='' class='mb-5 flex items-center space-x-4'>";
    echo "<label class='me-2' for='status'>Pilih Status:</label>";
    echo "<select class='select mx-2' name='status'>";
    echo "<option value=''>Semua</option>";
    echo "<option value='Menunggu Validasi'>Menunggu Validasi</option>";
    echo "<option value='Tidak Valid'>Tidak Valid</option>";
    echo "<option value='Valid'>Sudah Tervalidasi</option>";
    echo "</select>";

    echo "<label for='kegiatan'>Pilih Kegiatan:</label>";
    echo "<select class='select mx-2' name='kegiatan'>";
    echo "<option value=''>Semua</option>";
    $list_kegiatan = mysqli_query($koneksi, "SELECT DISTINCT Jenis_Kegiatan FROM kegiatan");
    while ($data_kegiatan = mysqli_fetch_assoc($list_kegiatan)) {
        echo "<option value='{$data_kegiatan['Jenis_Kegiatan']}'>{$data_kegiatan['Jenis_Kegiatan']}</option>";
    }
    echo "</select>";

    echo "<input class='btn btn-success' type='submit' value='Cari'>";
    echo "</form>";

    // Tabel Data Sertifikat
    echo "<div class='overflow-x-auto rounded-box border border-gray-200 bg-base-100'>";
    echo "<table class='table w-full'>";
    echo "<thead><tr>
            <th>NIS</th>
            <th>Kategori</th>
            <th>Sub Kategori</th>
            <th>Jenis Kegiatan</th>
            <th>Nama Siswa</th>
            <th>Angkatan</th>
            <th>Status</th>
            <th>Lihat Sertifikat</th>
          </tr></thead>";
    echo "<tbody>";

    if (mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$data['NIS']}</td>
                    <td>{$data['Kategori']}</td>
                    <td>{$data['Sub_Kategori']}</td>
                    <td>{$data['Jenis_Kegiatan']}</td>
                    <td>{$data['Nama_Siswa']}</td>
                    <td>{$data['Angkatan']}</td>
                    <td>{$data['Status']}</td>
                    <td><a class='link link-accent' href='halaman_utama.php?page=cek_sertifikat&id={$data['Id_Sertifikat']}&file={$data['Sertifikat']}' target='_blank'>Lihat File</a></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='8' class='text-center py-4'>Tidak ada data</td></tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
}

// Cek jika tombol cetak laporan ditekan
if (isset($_POST['tombol_cetak_laporan'])) {
    if (!empty($_POST['angkatan'])) {
        $_SESSION['angkatan'] = $_POST['angkatan'];
        $_SESSION['status'] = isset($_POST['status']) ? $_POST['status'] : '';
        echo "<script>window.location.href='../cetak/laporan/laporan.php';</script>";
        exit(); // Pastikan tidak ada eksekusi lebih lanjut
    } else {
        echo "<script>alert('Pilih angkatan terlebih dahulu!');</script>";
    }
}

// Ambil nilai filter dari form
$status = isset($_POST['status']) ? $_POST['status'] : '';
$kegiatan = isset($_POST['kegiatan']) ? $_POST['kegiatan'] : '';

// Tampilkan hasil pencarian
getSertifikat($koneksi, $status, $kegiatan);
