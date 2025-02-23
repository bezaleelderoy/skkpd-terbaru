<?php
if(!isset($_COOKIE['username'])) {
    header("Location: ../login.php");
    exit;
}

$username       = $_COOKIE['username'];
$data_update    = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pegawai INNER JOIN pengguna USING(Username) WHERE Username = '$username'"));

if (isset($_GET['delete_confirm'])) {
    echo '<form action="" method="post">
            <h3>Konfirmasi Penghapusan</h3>
            <p>Masukkan password Anda untuk menghapus akun:</p>
            <input type="password" name="delete_akun" required>
            <br>
            <button type="submit" class="btn btn-danger">Hapus Data Saya</button>
            <a href="halaman_utama.php?page=pegawai" class="btn btn-secondary">Batal</a>
          </form>';
} else {
?>

<center>
    <form action="" method="post">
        <table cellspacing="10">
            <tr>
                <td colspan="2" align="center">
                    <h3>Edit Pegawai</h3>
                </td>
            </tr>
            <tr>
                <td>Nama Lengkap</td>
                <td><input type="text" name="nama_lengkap" value="<?=$data_update['Nama_Lengkap']?>" required></td>
            </tr>
            <tr>
                <td>Username</td>
                <td><input type="text" name="username" readonly value="<?=$data_update['Username']?>" required></td>
            </tr>
            <tr>
                <td>Ganti Password</td>
                <td><input type="password" name="password" autocomplete="off" autofocus></td>
            </tr>
            <tr>
                <td>Konfirmasi Password</td>
                <td><input type="password" name="konfirmasi_pass" autocomplete="off"></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td><button onclick="window.location.href='halaman_utama.php?page=pegawai&delete_confirm=true';">
                        Delete</button> | <input type="submit" name="tombol_ubah" value="Update"></td>
            </tr>
        </table>
    </form><br>
    <hr>
    <br><br>
    <table border="1" cellpadding="10" cellspacing="0">

        <tr>
            <td align="center">Daftar Nama Pegawai</td>
        </tr>
        <?php    
            $data_pegawai = mysqli_query($koneksi, "SELECT * FROM pegawai");
            while($data = mysqli_fetch_assoc($data_pegawai)){
        ?>
        <tr>
            <td><b><?=$data['Username']?></b> - <?=$data['Nama_Lengkap']?>
            </td>
        </tr>
        <?php
            }
        ?>
        <tr>
            <td><button onclick="window.location.href='halaman_utama.php?page=tambah_pegawai';"
                    style="float:right;">Tambah Pegawai</button>
            </td>
        </tr>

    </table>
</center>
<br><br>



<?php
}
?>