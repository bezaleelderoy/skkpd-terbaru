<?php
if (!isset($_COOKIE['username'])) {
    echo "<script>alert('anda belum login');window.location.href='../login.php'</script>";
}

$username       = $_COOKIE['username'];
$data_update    = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pegawai INNER JOIN pengguna USING(Username) WHERE Username = '$username'"));


if (isset($_POST['tombol_ubah'])) {
    $nama_lengkap   = htmlspecialchars($_POST['nama_lengkap']);
    $password       = htmlspecialchars($_POST['password']);
    $konfirmasi_pass = htmlspecialchars($_POST['konfirmasi_pass']);
    if ($password == NULL) {
        if ($password !== $konfirmasi_pass) {
            echo "<script>alert('password dengan konfirmasi password tidak sama');window.location.href='halaman_utama.php?page=ubah_pegawai&username=" . $username . "'</script>";
        } else {
            $hasil = mysqli_query($koneksi, "UPDATE pegawai SET Nama_Lengkap='$nama_lengkap' WHERE Username = '$username'");

            if (!$hasil) {
                echo "<script>alert('Gagal update data pegawai');window.location.href='halaman_utama.php?page=ubah_pegawai&username=" . $username . "'</script>";
            } else {
                echo "<script>alert('Berhasil update data pegawai');window.location.href='../logout.php';</script>";
            }
        }
    } else {
        if ($password !== $konfirmasi_pass) {
            echo "<script>alert('password dengan konfirmasi password tidak sama');window.location.href='halaman_utama.php?page=ubah_pegawai&username=" . $username . "'</script>";
        } else {
            $hasil = mysqli_query($koneksi, "UPDATE pegawai SET Nama_Lengkap='$nama_lengkap' WHERE Username = '$username'");
            $enkrip     = password_hash($password, PASSWORD_DEFAULT);
            $hasil_pengguna = mysqli_query($koneksi, "UPDATE pengguna SET Password = '$enkrip' WHERE Username = '$username'");

            if (!$hasil) {
                echo "<script>alert('Gagal update data pegawai');window.location.href='halaman_utama.php?page=ubah_pegawai&username=" . $username . "'</script>";
            } else {
                echo "<script>alert('Berhasil update data pegawai');window.location.href='../logout.php';</script>";
            }
        }
    }
}


if (isset($_POST['tombol_delete'])) {
    echo '<center>
            <form action="" method="post">
                <h3>Konfirmasi Penghapusan</h3>
                <p>Masukkan password Anda untuk menghapus akun:</p><br>
                <input type="password" name="pass" required>
                <br><br>
                <button type="submit" name="delete_akun" class="btn btn-danger">Hapus Data Saya</button> | 
                <button onclick=window.location.href="halaman_utama.php?page=ubah_pegawai&username=' . $_COOKIE["username"] . '" class="btn btn-secondary">Batal</button>
            </form>
        </center>
        ';
} elseif (isset($_POST['delete_akun'])) {
    $pass = $_POST['pass'];
    $pass_database = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Password FROM pengguna WHERE Username = '$username'"))['Password'];
    if (password_verify($pass, $pass_database)) {
        $delete_pengguna = mysqli_query($koneksi, "DELETE FROM pengguna WHERE Username = '$username'");
        $delete_pegawai = mysqli_query($koneksi, "DELETE FROM pegawai WHERE Username = '$username'");
        if (!$delete_pengguna) {
            echo "<script>alert('gagal menghapus data pegawai');window.location.href='halaman_utama.php?page=ubah_pegawai&username=" . $username . "'</script>";
        } else {
            echo "<script>alert('berhasil menghapus data');window.location.href='../logout.php';</script>";
        }
    } else {
        echo "<script>alert('Password Salah');window.location.href='halaman_utama.php?page=ubah_pegawai&username=" . $username . "'</script>";
    }
} else {
?>

    <div class="px-28 pb-12">
        <div class="flex justify-between items-center my-5">
            <h1 class="text-3xl font-bold border-b-2 border-accent pb-1">Edit Pegawai</h1>
        </div>
        <form action="" method="post">
            <div class="grid grid-cols-2 gap-4">
                <div class="form-control w-full">
                    <label class="label"><span class="label-text">Nama Lengkap</span></label>
                    <input type="text" name="nama_lengkap" value="<?= $data_update['Nama_Lengkap'] ?>" class="input input-bordered w-full" required>
                </div>
                <div class="form-control w-full">
                    <label class="label"><span class="label-text">Username</span></label>
                    <input type="text" disabled="disabled" name="username" value="<?= $data_update['Username'] ?>" class="input input-bordered w-full" readonly required>
                </div>
                <div class="form-control w-full">
                    <label class="label"><span class="label-text">Ganti Password</span></label>
                    <input type="password" name="password" class="input input-bordered w-full" autocomplete="off">
                </div>
                <div class="form-control w-full">
                    <label class="label"><span class="label-text">Konfirmasi Password</span></label>
                    <input type="password" name="konfirmasi_pass" class="input input-bordered w-full" autocomplete="off">
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <input type="submit" name="tombol_delete" value="Delete" class="btn btn-soft btn-error">
                <input type="submit" name="tombol_ubah" value="Update" class="btn btn-soft btn-primary">
            </div>
        </form>

        <hr class="my-8">

        <h2 class="text-2xl font-semibold mb-4">Daftar Nama Pegawai</h2>
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>Nama Pegawai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data_pegawai = mysqli_query($koneksi, "SELECT * FROM pegawai");
                    while ($data = mysqli_fetch_assoc($data_pegawai)) {
                    ?>
                        <tr>
                            <td><b><?= $data['Username'] ?></b> - <?= $data['Nama_Lengkap'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="flex justify-end mt-4">
            <button onclick="window.location.href='halaman_utama.php?page=tambah_pegawai';" class="btn btn-soft btn-success">
                Tambah Pegawai
            </button>
        </div>
    </div>




<?php
}
?>