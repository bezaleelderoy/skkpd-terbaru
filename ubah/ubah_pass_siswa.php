<?php
if (!isset($_COOKIE['nis'])) {
    header("Location: ../login.php");
    exit;
}
$nis            = $_COOKIE['nis'];
$data_update    = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa INNER JOIN pengguna USING(NIS) INNER JOIN jurusan using(Id_Jurusan) WHERE NIS = '$nis'"));


if (isset($_POST['tombol_ubah'])) {
    $password       = htmlspecialchars($_POST['password']);
    $konfirmasi_pass = htmlspecialchars($_POST['konfirmasi_pass']);
    if ($password == NULL) {
        echo "<script>alert('Anda tidak ada mengganti password');window.location.href='halaman_utama.php?page=ubah_pass'</script>";
    } else {
        if ($password !== $konfirmasi_pass) {
            echo "<script>alert('password dengan konfirmasi password tidak sama');window.location.href='halaman_utama.php?page=ubah_pass'</script>";
        } else {
            $enkrip     = password_hash($password, PASSWORD_DEFAULT);
            $hasil_pengguna = mysqli_query($koneksi, "UPDATE pengguna SET Password = '$enkrip' WHERE NIS = '$nis'");

            if (!$hasil_pengguna) {
                echo "<script>alert('Gagal update data siswa');window.location.href='halaman_utama.php?page=ubah_pass'</script>";
            } else {
                setcookie('username', '', time(), '/');
                setcookie('level_user', '', time(), '/');
                setcookie('nama_lengkap', '', time(), '/');
                setcookie('nis', '', time(), '/');
                echo "<script>alert('Berhasil update data siswa');window.location.href='../login.php'</script>";
            }
        }
    }
}
?>

<div class="px-28 pb-12">
    <div class="flex justify-between items-center my-5">
        <h1 class="text-3xl font-bold border-b-2 border-accent pb-1">Detail Siswa</h1>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <tbody>
                <tr>
                    <td class="font-semibold">NIS</td>
                    <td class="text-right"><?= $data_update['NIS'] ?></td>
                </tr>
                <tr>
                    <td class="font-semibold">Nama</td>
                    <td class="text-right"><?= $data_update['Nama_Siswa'] ?></td>
                </tr>
                <tr>
                    <td class="font-semibold">No Absen</td>
                    <td class="text-right"><?= $data_update['No_Absen'] ?></td>
                </tr>
                <tr>
                    <td class="font-semibold">No Telp</td>
                    <td class="text-right"><?= $data_update['No_Telp'] ?></td>
                </tr>
                <tr>
                    <td class="font-semibold">Email</td>
                    <td class="text-right"><?= $data_update['Email'] ?></td>
                </tr>
                <tr>
                    <td class="font-semibold">Kelas</td>
                    <td class="text-right"><?= $data_update['Jurusan'] . ' ' . $data_update['Kelas'] ?></td>
                </tr>
                <tr>
                    <td class="font-semibold">Angkatan</td>
                    <td class="text-right"><?= $data_update['Angkatan'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <hr class="my-8">

    <h2 class="text-2xl font-semibold mb-4">Ganti Password</h2>
    <form action="" method="post">
        <div class="grid grid-cols-2 gap-4">
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Password Baru</span></label>
                <input type="password" name="password" class="input input-bordered w-full" autocomplete="off" autofocus required>
            </div>
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Konfirmasi Password</span></label>
                <input type="password" name="konfirmasi_pass" class="input input-bordered w-full" autocomplete="off" required>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <input type="submit" name="tombol_ubah" value="Perbarui" class="btn btn-primary">
        </div>
    </form>
</div>