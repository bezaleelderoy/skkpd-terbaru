<?php
if (!@$_COOKIE['level_user']) {
    echo "<script>alert('belum login');window.location.href='../login.php'</script>";
} elseif ($_COOKIE['level_user'] == 'siswa') {
    echo "<script>alert('anda siswa, silahkan kembali ke halaman utama siswa');window.location.href='halaman_utama.php?page=upload_sertifikat'</script>";
}

if (isset($_GET['nis'])) {
    $nis = $_GET['nis'];

    $delete_pengguna = mysqli_query($koneksi, "DELETE FROM pengguna WHERE NIS='$nis'");
    $delete_sertifikat = mysqli_query($koneksi, "DELETE FROM sertifikat WHERE NIS='$nis'");
    $delete_siswa = mysqli_query($koneksi, "DELETE FROM siswa WHERE NIS='$nis'");

    if (!$delete_siswa) {
        echo "<script>alert('gagal menghapus data');window.location.href='halaman_utama.php?page=siswa'</script>";
    } else {
        echo "<script>alert('berhasil menghapus data');window.location.href='halaman_utama.php?page=siswa'</script>";
    }
}
?>
<div class="px-4 sm:px-10 md:px-20 lg:px-28 pb-12">
    <div class="flex flex-col sm:flex-row justify-between items-center my-5 gap-4">
        <h1 class="text-2xl sm:text-3xl font-bold border-b-2 border-accent pb-1">Data Siswa</h1>
        <button class="btn btn-soft btn-success w-full sm:w-auto" onclick="window.location.href='halaman_utama.php?page=tambah_siswa';">
            Tambah Siswa
        </button>
    </div>
    <div class="overflow-x-auto rounded-box border border-gray-200 border-base-content/3 bg-base-100">
        <table class="table w-full text-sm sm:text-base">
            <!-- head -->
            <thead>
                <tr>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Absen</th>
                    <th>Jurusan</th>
                    <th>Kelas</th>
                    <th>Angkatan</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data_siswa = mysqli_query($koneksi, "SELECT * FROM siswa INNER JOIN jurusan USING(Id_Jurusan)");
                while ($data = mysqli_fetch_assoc($data_siswa)) {
                ?>
                    <tr>
                        <th><?= $data['NIS'] ?></th>
                        <td><?= $data['Nama_Siswa'] ?></td>
                        <td><?= $data['No_Absen'] ?></td>
                        <td><?= $data['Jurusan'] ?></td>
                        <td><?= $data['Kelas'] ?></td>
                        <td><?= $data['Angkatan'] ?></td>
                        <td><?= $data['Email'] ?></td>
                        <td><?= $data['No_Telp'] ?></td>
                        <td class="flex flex-wrap gap-2">
                            <a href="halaman_utama.php?page=ubah_siswa&nis=<?= $data['NIS'] ?>" class="btn btn-soft btn-warning text-xs sm:text-sm">Edit</a>
                            <a href="halaman_utama.php?page=siswa&nis=<?= $data['NIS'] ?>" onclick="return confirm('Yakin mau hapus?');" class="btn btn-soft btn-error text-xs sm:text-sm">Hapus</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>