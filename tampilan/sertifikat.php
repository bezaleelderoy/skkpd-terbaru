<?php

if (!@$_COOKIE['level_user']) {
    echo "<script>alert('Belum login');window.location.href='../login.php'</script>";
} elseif ($_COOKIE['level_user'] == 'siswa') {
    echo "<script>alert('Anda siswa, silahkan kembali');window.location.href='halaman_utama.php?page=sertifikat_siswa'</script>";
}

function getSertifikat($koneksi, $status = '', $kegiatan = '')
{
    $whereClause = "WHERE 1";

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

    echo "<div class='px-4 md:px-12 pb-8'>";
    echo "<div class='flex flex-col md:flex-row justify-between items-center my-5'>";

    echo "<h1 class='text-2xl md:text-3xl font-bold border-b-2 border-accent pb-1'>Data Sertifikat</h1>";

    echo "<form method='POST' action='' class='flex flex-wrap items-center gap-2 mt-3 md:mt-0'>";
    echo "<select class='select w-full md:w-auto' name='angkatan'>";
    echo "<option value=''>Pilih Angkatan</option>";
    $list_angkatan = mysqli_query($koneksi, "SELECT DISTINCT Angkatan FROM siswa");
    while ($data_angkatan = mysqli_fetch_assoc($list_angkatan)) {
        echo "<option value='{$data_angkatan['Angkatan']}'>{$data_angkatan['Angkatan']}</option>";
    }
    echo "</select>";

    echo "<input type='hidden' name='status' value='$status'>";
    echo "<button type='submit' name='tombol_cetak_laporan' class='btn btn-secondary w-full md:w-auto'>🖨 Cetak Laporan</button>";
    echo "</form>";
    echo "</div>";

    // Filter Form
    echo "<form method='POST' action='' class='flex flex-col md:flex-row md:items-center gap-4 mb-5'>";
    echo "<label for='status' class='block text-sm font-medium'>Pilih Status:</label>";
    echo "<select class='select w-full md:w-auto' name='status'>";
    echo "<option value=''>Semua</option>";
    echo "<option value='Menunggu Validasi'>Menunggu Validasi</option>";
    echo "<option value='Tidak Valid'>Tidak Valid</option>";
    echo "<option value='Valid'>Sudah Tervalidasi</option>";
    echo "</select>";

    echo "<label for='kegiatan' class='block text-sm font-medium'>Pilih Kegiatan:</label>";
    echo "<select class='select w-full md:w-auto' name='kegiatan'>";
    echo "<option value=''>Semua</option>";
    $list_kegiatan = mysqli_query($koneksi, "SELECT DISTINCT Jenis_Kegiatan FROM kegiatan");
    while ($data_kegiatan = mysqli_fetch_assoc($list_kegiatan)) {
        echo "<option value='{$data_kegiatan['Jenis_Kegiatan']}'>{$data_kegiatan['Jenis_Kegiatan']}</option>";
    }
    echo "</select>";

    echo "<input class='btn btn-success w-full md:w-auto' type='submit' value='Cari'>";
    echo "</form>";

    // Responsive Table
    echo "<div class='overflow-x-auto border border-gray-200 bg-base-100 rounded-lg'>";
    echo "<table class='table w-full text-sm md:text-base'>";
    echo "<thead><tr class='bg-gray-100'>
            <th class='p-2'>NIS</th>
            <th class='p-2'>Kategori</th>
            <th class='p-2'>Sub Kategori</th>
            <th class='p-2'>Jenis Kegiatan</th>
            <th class='p-2'>Nama Siswa</th>
            <th class='p-2'>Angkatan</th>
            <th class='p-2'>Status</th>
            <th class='p-2'>Lihat Sertifikat</th>
          </tr></thead>";
    echo "<tbody>";

    if (mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_assoc($result)) {
            echo "<tr class='border-b'>";
            echo "<td class='p-2'>{$data['NIS']}</td>";
            echo "<td class='p-2'>{$data['Kategori']}</td>";
            echo "<td class='p-2'>{$data['Sub_Kategori']}</td>";
            echo "<td class='p-2'>{$data['Jenis_Kegiatan']}</td>";
            echo "<td class='p-2'>{$data['Nama_Siswa']}</td>";
            echo "<td class='p-2'>{$data['Angkatan']}</td>";
            echo "<td class='p-2'>{$data['Status']}</td>";
            echo "<td class='p-2'><a class='text-blue-500 hover:underline' href='halaman_utama.php?page=cek_sertifikat&id={$data['Id_Sertifikat']}&file={$data['Sertifikat']}' target='_blank'>Lihat File</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8' class='text-center py-4 text-gray-500'>Tidak ada data</td></tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
}

if (isset($_POST['tombol_cetak_laporan'])) {
    if (!empty($_POST['angkatan'])) {
        $_SESSION['angkatan'] = $_POST['angkatan'];
        $_SESSION['status'] = isset($_POST['status']) ? $_POST['status'] : '';
        echo "<script>window.location.href='../cetak/laporan/laporan.php';</script>";
        exit();
    } else {
        echo "<script>alert('Pilih angkatan terlebih dahulu!');</script>";
    }
}

$status = isset($_POST['status']) ? $_POST['status'] : '';
$kegiatan = isset($_POST['kegiatan']) ? $_POST['kegiatan'] : '';

getSertifikat($koneksi, $status, $kegiatan);
