<?php
if (isset($_POST['tombol_tambah'])) {

    $nama_lengkap       = htmlspecialchars($_POST['nama_lengkap']);
    $username           = htmlspecialchars($_POST['username']);
    $password           = htmlspecialchars($_POST['password']);
    $konfirmasi_pass    = htmlspecialchars($_POST['konfirmasi_pass']);

    if ($password !== $konfirmasi_pass) {
        echo "<script>alert('password dengan konfirmasi password tidak sama');window.location.href='halaman_utama.php?page=tambah_pegawai'</script>";
    } else {
        $hasil_pegawai  = mysqli_query($koneksi, "INSERT INTO pegawai VALUES('$nama_lengkap', '$username')");
        $enkrip     = password_hash($password, PASSWORD_DEFAULT);
        $hasil_pengguna = mysqli_query($koneksi, "INSERT INTO pengguna VALUES(NULL, '$username', NULL, '$enkrip')");

        if (!$hasil_pengguna) {
            echo "<script>alert('gagal Memasukkan Data');window.location.href='halaman_utama.php?page=tambah_pegawai'</script>";
        } else {
            echo "<script>alert('Berhasil Menambahkan Data');window.location.href='halaman_utama.php?page=tambah_pegawai'</script>";
        }
    }
}
?>


<div class="px-28 pb-12">
    <div class="flex justify-between items-center my-5">
        <h1 class="text-3xl font-bold border-b-2 border-accent pb-1">Daftar Pegawai</h1>
        <button onclick="window.location.href='halaman_utama.php?page=tambah_pegawai';" class="btn btn-soft btn-success">
            + Tambah Pegawai
        </button>
    </div>

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

    <hr class="my-8">

    <h2 class="text-2xl font-semibold mb-4">Tambah Pegawai</h2>
    <form action="" method="post">
        <div class="grid grid-cols-2 gap-4">
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Nama Lengkap</span></label>
                <input type="text" name="nama_lengkap" class="input input-bordered w-full" required>
            </div>
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Username</span></label>
                <input type="text" name="username" class="input input-bordered w-full" required>
            </div>
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Password</span></label>
                <input type="password" name="password" class="input input-bordered w-full" autocomplete="off" required>
            </div>
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Konfirmasi Password</span></label>
                <input type="password" name="konfirmasi_pass" class="input input-bordered w-full" autocomplete="off" required>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <input type="submit" name="tombol_tambah" value="Simpan" class="btn btn-soft btn-primary">
        </div>
    </form>
</div>