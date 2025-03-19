<?php
if (isset($_POST['tombol_tambah'])) {
    $nis        = htmlspecialchars($_POST['nis']);
    $no_absen   = htmlspecialchars($_POST['no_absen']);
    $nama_siswa = htmlspecialchars($_POST['nama_siswa']);
    $no_telp    = htmlspecialchars($_POST['no_telp']);
    $email      = htmlspecialchars($_POST['email']);
    $id_jurusan = htmlspecialchars($_POST['jurusan']);
    $kelas      = htmlspecialchars($_POST['kelas']);
    $angkatan   = htmlspecialchars($_POST['angkatan']);

    $pass       = "siswa" . $nis;
    $enkrip     = password_hash($pass, PASSWORD_DEFAULT);

    $hasil = mysqli_query($koneksi, "INSERT INTO siswa VALUES('$nis', '$no_absen', '$nama_siswa', '$no_telp', '$email', '$id_jurusan', '$kelas', '$angkatan')");
    $hasil_pengguna = mysqli_query($koneksi, "INSERT INTO pengguna VALUES(NULL, NULL, '$nis', '$enkrip')");


    if (!$hasil) {
        echo "<script>alert('gagal memasukkan data');window.location.href='halaman_utama.php?page=tambah_siswa'</script>";
    } else {
        echo "<script>alert('Berhasil Menambahkan Data');window.location.href='halaman_utama.php?page=siswa'</script>";
    }
}
?>
<div class="px-28 pb-12">
    <div class="flex justify-between items-center my-5">
        <h1 class="text-3xl font-bold border-b-2 border-accent pb-1">Tambah Siswa</h1>
    </div>
    <form action="" method="post">
        <div class="grid grid-cols-2 gap-4">
            <div class="form-control w-full">
                <label class="label"><span class="label-text">NIS</span></label>
                <input type="number" name="nis" class="input input-bordered w-full" required>
            </div>
            <div class="form-control w-full">
                <label class="label"><span class="label-text">No Absen</span></label>
                <input type="number" name="no_absen" class="input input-bordered w-full" autocomplete="off" required>
            </div>
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Nama Siswa</span></label>
                <input type="text" name="nama_siswa" class="input input-bordered w-full" autocomplete="off" required>
            </div>
            <div class="form-control w-full">
                <label class="label"><span class="label-text">No Telp</span></label>
                <input type="text" name="no_telp" class="input input-bordered w-full" autocomplete="off" required>
            </div>
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Email</span></label>
                <input type="email" name="email" class="input input-bordered w-full" autocomplete="off" required>
            </div>
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Jurusan</span></label>
                <select name="jurusan" class="select select-bordered w-full">
                    <?php
                    $list = mysqli_query($koneksi, "SELECT * FROM jurusan");
                    while ($data = mysqli_fetch_assoc($list)) {
                    ?>
                        <option value="<?= $data['Id_Jurusan'] ?>"><?= $data['Jurusan'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Kelas</span></label>
                <input type="number" name="kelas" class="input input-bordered w-full" autocomplete="off" required>
            </div>
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Angkatan</span></label>
                <input type="number" name="angkatan" class="input input-bordered w-full" autocomplete="off" required>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <input type="submit" name="tombol_tambah" value="Simpan" class="btn btn-primary">
        </div>
    </form>
</div>