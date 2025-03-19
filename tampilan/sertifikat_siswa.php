<?php
if (!@$_COOKIE['level_user']) {
    echo "<script>alert('belum login');window.location.href='../login.php'</script>";
} elseif ($_COOKIE['level_user'] == 'operator') {
    echo "<script>alert('anda operator, silahkan kembali');window.location.href='halaman_utama.php?page=sertifikat'</script>";
}
$nis = $_COOKIE['nis'];
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

    $nis = $_COOKIE['nis'];
    $query = "SELECT * FROM sertifikat 
              INNER JOIN kegiatan USING(Id_Kegiatan) 
              INNER JOIN kategori USING(Id_Kategori) 
              INNER JOIN siswa USING(NIS) 
              $whereClause AND NIS='$nis' ORDER BY Status, Sub_Kategori, Tanggal_Upload ASC";

    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        function getBadgeClass($status)
        {
            switch ($status) {
                case "Valid":
                    return "badge-success";
                case "Menunggu Validasi":
                    return "badge-warning";
                case "Tidak Valid":
                    return "badge-error";
                default:
                    return "badge-secondary";
            }
        }
        echo "<div class='px-6 pb-8'>";
        echo "<div class='flex justify-between items-center my-5'>
            <h1 class='text-3xl font-bold border-b-2 border-accent pb-1'>Data Sertifikat</h1>
          </div>";

        echo "<div class='overflow-x-auto rounded-box border border-gray-200 bg-base-100'>";
        echo "<table class='table w-full'>";
        echo "<thead>
            <tr class='bg-gray-200 text-gray-700'>
                <th>Kategori</th>
                <th>Sub Kategori</th>
                <th>Jenis Kegiatan</th>
                <th>Nama Siswa</th>
                <th>Angkatan</th>
                <th>Status</th>
                <th>Lihat Sertifikat</th>
            </tr>
          </thead>";
        echo "<tbody>";

        while ($data = mysqli_fetch_assoc($result)) {
            echo "<tr class='hover:bg-gray-100'>
                <td>{$data['Kategori']}</td>
                <td>{$data['Sub_Kategori']}</td>
                <td>{$data['Jenis_Kegiatan']}</td>
                <td>{$data['Nama_Siswa']}</td>
                <td>{$data['Angkatan']}</td>
                <td>
                    <span class='badge " . getBadgeClass($data['Status']) . "'>{$data['Status']}</span>
                </td>
                <td>
                    <a href='halaman_utama.php?page=cek_sertifikat_siswa&id={$data['Id_Sertifikat']}&file={$data['Sertifikat']}' target='_blank' class='btn btn-sm btn-accent'>
                        Lihat File
                    </a>
                </td>
              </tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "<div class='alert alert-warning shadow-lg mt-5'>
            <div>
                <span>Tidak ada data sertifikat.</span>
            </div>
          </div>";
    }

    // Fungsi untuk menentukan warna badge status

}
?>
<div class="px-28 pb-12">
    <div class="flex justify-between items-center my-5">
        <h1 class="text-3xl font-bold border-b-2 border-accent pb-1">Status Sertifikat</h1>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr class="bg-primary text-white">
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Point Terkumpul</td>
                    <td>
                        <?php
                        $total_point = mysqli_fetch_row(mysqli_query($koneksi, "SELECT SUM(Angka_Kredit) FROM sertifikat INNER JOIN kegiatan USING(Id_Kegiatan) WHERE Status='Valid' AND NIS='$nis'"))[0];
                        echo $total_point . "/30 Point";
                        if ($total_point >= 30) {
                            echo "<br><a href='../cetak/sertifikat_skkpd/generate_sertifikat.php' class='btn btn-accent mt-2'>Cetak Sertifikat SKKPd</a>";
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
            </tbody>
        </table>
    </div>

    <!-- Tombol Upload -->
    <div class="flex justify-end mt-5">
        <button onclick="window.location.href='halaman_utama.php?page=upload_sertifikat';" class="btn btn-primary">+ Upload Sertifikat</button>
    </div>

    <!-- Form Filter -->
    <div class="mt-10 bg-base-200 p-5 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-3">Filter Sertifikat</h2>
        <form method="POST" action="" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-control">
                <label class="label"><span class="label-text">Pilih Status</span></label>
                <select name="status" class="select select-bordered">
                    <option value="">Semua</option>
                    <option value="Menunggu Validasi">Menunggu Validasi</option>
                    <option value="Tidak Valid">Tidak Valid</option>
                    <option value="Valid">Sudah Tervalidasi</option>
                </select>
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text">Pilih Kegiatan</span></label>
                <select name="kegiatan" class="select select-bordered">
                    <option value="">Semua</option>
                    <?php
                    $list_kegiatan = mysqli_query($koneksi, "SELECT DISTINCT Jenis_Kegiatan FROM kegiatan");
                    while ($data_kegiatan = mysqli_fetch_assoc($list_kegiatan)) {
                        echo "<option value='{$data_kegiatan['Jenis_Kegiatan']}'>{$data_kegiatan['Jenis_Kegiatan']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-control mt-3">
                <input type="submit" value="Cari" class="btn btn-secondary">
            </div>
        </form>
    </div>
</div>


<?php
// Ambil nilai filter dari form
$status = isset($_POST['status']) ? $_POST['status'] : '';
$kegiatan = isset($_POST['kegiatan']) ? $_POST['kegiatan'] : '';

// Tampilkan hasil pencarian
getSertifikat($koneksi, $status, $kegiatan);
?>