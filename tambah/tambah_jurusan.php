<?php
if (isset($_POST['tombol_tambah'])) {

    $id_jurusan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Id_Jurusan FROM jurusan ORDER BY Id_Jurusan DESC LIMIT 1"));

    if ($id_jurusan) {
        $angkaTerakhir = intval(substr($id_jurusan['Id_Jurusan'], 1));
        $noUrut = $angkaTerakhir + 1;
    } else {
        $noUrut = 1;
    }
    $Id = "J" . $noUrut;
    $jurusan = $_POST['jurusan'];

    $hasil = mysqli_query($koneksi, "INSERT INTO jurusan VALUES('$Id', '$jurusan')");

    if (!$hasil) {
        echo "<script>alert('Gagal memasukkan data');window.location.href='halaman_utama.php?page=tambah_jurusan'</script>";
    } else {
        echo "<script>alert('Berhasil menambahkan data');window.location.href='halaman_utama.php?page=jurusan'</script>";
    }
}
?>
<div class="px-28 pb-12">
    <div class="flex justify-between items-center my-5">
        <h1 class="text-3xl font-bold border-b-2 border-accent pb-1">Tambah Jurusan</h1>
    </div>

    <form action="" method="post">
        <div class="form-control w-full">
            <label class="label"><span class="label-text">Nama Jurusan</span></label>
            <input type="text" id="jurusan" name="jurusan" class="input input-bordered w-full" required>
        </div>

        <div class="flex justify-end mt-6">
            <input type="submit" name="tombol_tambah" value="Simpan" class="btn btn-primary">
        </div>
    </form>
</div>