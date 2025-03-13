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
<div class="px-28 pb-12">
    <div class="flex justify-between items-center my-5">
        <h1 class="text-3xl font-bold border-b-2 border-accent pb-1">Data Jurusan</h1>
        <button class="btn btn-soft btn-success" onclick="window.location.href='halaman_utama.php?page=tambah_jurusan';">
            Tambah Jurusan
        </button>
    </div>
    <div class="overflow-x-auto rounded-box border border-gray-200 border-base-content/3 bg-base-100">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $data_jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");
                while ($data = mysqli_fetch_assoc($data_jurusan)) {
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $data['Jurusan']; ?></td>
                        <td>
                            <a class="btn btn-soft btn-warning" href="halaman_utama.php?page=ubah_jurusan&id=<?= $data['Id_Jurusan'] ?>">Edit</a>
                            <?php
                            $id_cek = $data['Id_Jurusan'];
                            $cek_data = mysqli_query($koneksi, "SELECT Id_Jurusan FROM siswa WHERE Id_Jurusan='$id_cek'");
                            if (mysqli_num_rows($cek_data) > 0) {
                            ?>
                                <button class="btn btn-soft btn-error" disabled="disabled">Hapus</button>
                            <?php
                            } else {
                            ?>
                                <a onclick="return confirm('Yakin mau hapus?');"
                                    class="btn btn-soft btn-error" href="halaman_utama.php?page=jurusan&id=<?= $data['Id_Jurusan'] ?>">Hapus</a>
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