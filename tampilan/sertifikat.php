<?php
if (!@$_COOKIE['level_user']) {
    echo "<script>alert('belum login');window.location.href='../login.php'</script>";
} elseif ($_COOKIE['level_user'] == 'siswa') {
    echo "<script>alert('anda siswa, silahkan kembali');window.location.href='halaman_utama.php?page=sertifikat_siswa'</script>";
}
// Fungsi untuk mendapatkan data sertifikat berdasarkan status dan kegiatan
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

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='px-28 pb-12'>";
        echo "<div class='flex justify-between items-center my-5'>
        <h1 class='text-3xl font-bold border-b-2 border-accent pb-1'>Data Sertifikat</h1>
        </div>";

        // Filter form under Data Sertifikat
        echo "<form method='POST' action='' class='mb-5'>";
        echo "<label class='me-2' for='status'>Pilih Status</label>";
        echo "<select class='select mx-2' name='status'>";
        echo "<option value=''>Semua</option>";
        echo "<option value='Menunggu Validasi'>Menunggu Validasi</option>";
        echo "<option value='Tidak Valid'>Tidak Valid</option>";
        echo "<option value='Valid'>Sudah Tervalidasi</option>";
        echo "</select>";

        echo "<label for='kegiatan'>Pilih Kegiatan</label>";
        echo "<select class='select mx-2' name='kegiatan'>";
        echo "<option value=''>Semua</option>";
        $list_kegiatan = mysqli_query($koneksi, "SELECT DISTINCT Jenis_Kegiatan FROM kegiatan");
        while ($data_kegiatan = mysqli_fetch_assoc($list_kegiatan)) {
            echo "<option value='{$data_kegiatan['Jenis_Kegiatan']}'>{$data_kegiatan['Jenis_Kegiatan']}</option>";
        }
        echo "</select>";
        echo "<input class='btn btn-soft btn-success' type='submit' value='Cari'>";
        echo "</form>";

        echo "<div class='overflow-x-auto rounded-box border border-gray-200 border-base-content/3 bg-base-100'>";
        echo "<table class='table'>";
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
                    <td><a class='link link-accent' href='halaman_utama.php?page=cek_sertifikat&id={$data['Id_Sertifikat']}&file={$data['Sertifikat']}' target='_blank'>Lihat File</a></td>
                  </tr>";
        }
        echo "</table>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "<p>Tidak ada data</p>";
    }
}

if (@$_POST['tombol_cetak_laporan']) {
    $_SESSION['angkatan'] = $_POST['angkatan'];
    $_SESSION['status'] = $_POST['status'];
    echo "<script>window.location.href='../cetak/laporan/laporan.php';</script>";
}

// Ambil nilai filter dari form
$status = isset($_POST['status']) ? $_POST['status'] : '';
$kegiatan = isset($_POST['kegiatan']) ? $_POST['kegiatan'] : '';

// Tampilkan hasil pencarian
getSertifikat($koneksi, $status, $kegiatan);
