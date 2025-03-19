<?php
$id = $_GET['id'];
$data_update = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM jurusan WHERE Id_Jurusan='$id'"));

if (isset($_POST['tombol_update'])) {
    $jurusan    = $_POST['jurusan'];
    $hasil = mysqli_query($koneksi, "UPDATE jurusan SET Jurusan = '$jurusan' WHERE Id_Jurusan='$id'");

    if (!$hasil) {
        echo "<script>alert('Gagal update data jurusan');window.location.href='halaman_utama.php?page=ubah_jurusan&nis=$nis'</script>";
    } else {
        echo "<script>alert('Berhasil update data jurusan');window.location.href='halaman_utama.php?page=jurusan'</script>";
    }
}
?>
<div class="px-28 pb-12">
    <div class="flex justify-between items-center my-5">
        <h1 class="text-3xl font-bold border-b-2 border-accent pb-1">Edit Jurusan</h1>
    </div>

    <form action="" method="post">
        <div class="form-control w-full">
            <label class="label"><span class="label-text">Nama Jurusan</span></label>
            <input type="text" id="jurusan" name="jurusan" value="<?= $data_update['Jurusan'] ?>"
                class="input input-bordered w-full" required>
        </div>

        <div class="flex justify-end mt-6">
            <input type="submit" name="tombol_tambah" value="Update" class="btn btn-primary">
        </div>
    </form>
</div>