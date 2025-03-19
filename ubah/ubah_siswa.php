<?php
$nis = $_GET['nis'];
$data_update = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa WHERE NIS='$nis'"));

if (isset($_POST['tombol_update'])) {
    $no_absen           = htmlspecialchars($_POST['no_absen']);
    $nama_siswa         = htmlspecialchars($_POST['nama_siswa']);
    $no_telp            = htmlspecialchars($_POST['no_telp']);
    $email              = htmlspecialchars($_POST['email']);
    $password           = htmlspecialchars($_POST['password']);
    $konfirmasi_pass    = htmlspecialchars($_POST['konfirmasi_pass']);
    $id_jurusan         = htmlspecialchars($_POST['jurusan']);
    $kelas              = htmlspecialchars($_POST['kelas']);
    $angkatan           = htmlspecialchars($_POST['angkatan']);

    if ($password == NULL) {
        if ($password !== $konfirmasi_pass) {
            echo "<script>alert('password dengan konfirmasi password tidak sama');window.location.href='halaman_utama.php?page=ubah_siswa&nis=" . $nis . "'</script>";
        } else {
            $hasil = mysqli_query($koneksi, "UPDATE siswa SET No_Absen = '$no_absen', Nama_Siswa = '$nama_siswa', No_Telp = '$no_telp', Email = '$email', Id_Jurusan = '$id_jurusan ', Kelas = '$kelas', Angkatan = $angkatan WHERE NIS = '$nis'");

            if (!$hasil) {
                echo "<script>alert('Gagal update data siswa');window.location.href='halaman_utama.php?page=ubah_siswa&nis=$nis'</script>";
            } else {
                echo "<script>alert('Berhasil update data siswa');window.location.href='halaman_utama.php?page=siswa'</script>";
            }
        }
    } else {
        if ($password !== $konfirmasi_pass) {
            echo "<script>alert('password dengan konfirmasi password tidak sama');window.location.href='halaman_utama.php?page=ubah_siswa&nis=" . $nis . "'</script>";
        } else {
            $hasil = mysqli_query($koneksi, "UPDATE siswa SET No_Absen = '$no_absen', Nama_Siswa = '$nama_siswa', No_Telp = '$no_telp', Email = '$email', Id_Jurusan = '$id_jurusan ', Kelas = '$kelas', Angkatan = $angkatan WHERE NIS = '$nis'");

            $enkrip     = password_hash($password, PASSWORD_DEFAULT);
            $hasil_pengguna = mysqli_query($koneksi, "UPDATE pengguna SET Password = '$enkrip' WHERE NIS = '$nis'");

            if (!$hasil) {
                echo "<script>alert('Gagal update data siswa');window.location.href='halaman_utama.php?page=ubah_siswa&nis=$nis'</script>";
            } else {
                echo "<script>alert('Berhasil update data siswa');window.location.href='halaman_utama.php?page=siswa'</script>";
            }
        }
    }
}
?>

<div class="px-28 pb-12">
    <div class="flex justify-between items-center my-5">
        <h1 class="text-3xl font-bold border-b-2 border-accent pb-1">Edit Siswa</h1>
    </div>

    <form action="" method="post">
        <div class="grid grid-cols-2 gap-4">
            <!-- NIS -->
            <div class="form-control w-full">
                <label class="label"><span class="label-text">NIS</span></label>
                <input type="number" name="nis" value="<?= $data_update['NIS'] ?>" class="input input-bordered w-full" required>
            </div>

            <!-- No Absen -->
            <div class="form-control w-full">
                <label class="label"><span class="label-text">No Absen</span></label>
                <input type="number" name="no_absen" value="<?= $data_update['No_Absen'] ?>" class="input input-bordered w-full" required>
            </div>

            <!-- Nama Siswa -->
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Nama Siswa</span></label>
                <input type="text" name="nama_siswa" value="<?= $data_update['Nama_Siswa'] ?>" class="input input-bordered w-full" required>
            </div>

            <!-- No Telp -->
            <div class="form-control w-full">
                <label class="label"><span class="label-text">No Telp</span></label>
                <input type="text" name="no_telp" value="<?= $data_update['No_Telp'] ?>" class="input input-bordered w-full" required>
            </div>

            <!-- Email -->
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Email</span></label>
                <input type="email" name="email" value="<?= $data_update['Email'] ?>" class="input input-bordered w-full" required>
            </div>

            <!-- Ganti Password -->
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Ganti Password</span></label>
                <input type="password" name="password" class="input input-bordered w-full" autocomplete="off">
            </div>

            <!-- Konfirmasi Password -->
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Konfirmasi Password</span></label>
                <input type="password" name="konfirmasi_pass" class="input input-bordered w-full" autocomplete="off">
            </div>

            <!-- Jurusan -->
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Jurusan</span></label>
                <select name="jurusan" class="select select-bordered w-full">
                    <?php
                    $list = mysqli_query($koneksi, "SELECT * FROM jurusan");
                    while ($data = mysqli_fetch_assoc($list)) {
                    ?>
                        <option value="<?= $data['Id_Jurusan'] ?>"
                            <?php if ($data['Id_Jurusan'] == $data_update['Id_Jurusan']) {
                                echo "selected";
                            } ?>>
                            <?= $data['Jurusan'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <!-- Kelas -->
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Kelas</span></label>
                <input type="number" name="kelas" value="<?= $data_update['Kelas'] ?>" class="input input-bordered w-full" required>
            </div>

            <!-- Angkatan -->
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Angkatan</span></label>
                <input type="number" name="angkatan" value="<?= $data_update['Angkatan'] ?>" class="input input-bordered w-full" required>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <input type="submit" name="tombol_update" value="Update" class="btn btn-primary">
        </div>
    </form>
</div>