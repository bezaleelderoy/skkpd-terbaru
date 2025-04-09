<?php
if (isset($_GET['id'])) {
    $id_jurusan = $_GET['id'];
    $hasil_jurusan = mysqli_query($koneksi, "DELETE FROM jurusan WHERE Id_Jurusan='$id_jurusan'");

    if (!$hasil_jurusan) {
        echo "<script>alert('Gagal menghapus data');window.location.href='halaman_utama.php?page=jurusan'</script>";
    } else {
        echo "<script>alert('Berhasil menghapus data');window.location.href='halaman_utama.php?page=jurusan'</script>";
    }
}
?>

<div class="px-4 sm:px-6 md:px-28 pb-12">
    <div class="flex flex-col sm:flex-row justify-between items-center my-5 gap-3">
        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold border-b-2 border-accent pb-1">Data Jurusan</h1>
        <button class="btn btn-success w-full sm:w-auto" onclick="window.location.href='halaman_utama.php?page=tambah_jurusan';">
            Tambah Jurusan
        </button>
    </div>
    <div class="overflow-x-auto rounded-box border border-gray-200 border-base-content/3 bg-base-100">
        <table class="table w-full min-w-max">
            <!-- head -->
            <thead>
                <tr>
                    <th class="px-2 py-3">No</th>
                    <th class="px-2 py-3">Nama Jurusan</th>
                    <th class="px-2 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $data_jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");
                while ($data = mysqli_fetch_assoc($data_jurusan)) {
                ?>
                    <tr>
                        <td class="px-2 py-3"><?= $no++ ?></td>
                        <td class="px-2 py-3"><?= $data['Jurusan']; ?></td>
                        <td class="px-2 py-3 flex flex-col sm:flex-row gap-2">
                            <a class="btn btn-warning w-full sm:w-auto" href="halaman_utama.php?page=ubah_jurusan&id=<?= $data['Id_Jurusan'] ?>">Edit</a>
                            <?php
                            $id_cek = $data['Id_Jurusan'];
                            $cek_data = mysqli_query($koneksi, "SELECT Id_Jurusan FROM siswa WHERE Id_Jurusan='$id_cek'");
                            if (mysqli_num_rows($cek_data) > 0) {
                            ?>
                                <button class="btn btn-error w-full sm:w-auto" disabled>Hapus</button>
                            <?php
                            } else {
                            ?>
                                <a onclick="return confirm('Yakin mau hapus?');"
                                    class="btn btn-error w-full sm:w-auto" href="halaman_utama.php?page=jurusan&id=<?= $data['Id_Jurusan'] ?>">Hapus</a>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>