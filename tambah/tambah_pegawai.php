<?php
if(isset($_POST['tombol_tambah'])){
    
    $nama_lengkap       = htmlspecialchars($_POST['nama_lengkap']);
    $username           = htmlspecialchars($_POST['username']);
    $password           = htmlspecialchars($_POST['password']);
    $konfirmasi_pass    = htmlspecialchars($_POST['konfirmasi_pass']);
    
    if($password !== $konfirmasi_pass){
        echo "<script>alert('password dengan konfirmasi password tidak sama');window.location.href='halaman_utama.php?page=tambah_pegawai'</script>";
    }else{
        $hasil_pegawai  = mysqli_query($koneksi, "INSERT INTO pegawai VALUES('$nama_lengkap', '$username')");
        $enkrip     = password_hash($password, PASSWORD_DEFAULT);
        $hasil_pengguna = mysqli_query($koneksi, "INSERT INTO pengguna VALUES(NULL, '$username', NULL, '$enkrip')");

        if(!$hasil_pengguna){
            echo "<script>alert('gagal Memasukkan Data');window.location.href='halaman_utama.php?page=tambah_pegawai'</script>";
        }else{
            echo "<script>alert('Berhasil Menambahkan Data');window.location.href='halaman_utama.php?page=tambah_pegawai'</script>";
        }
    }
}
?>


<center>

    <table border="1">
        <tr><button onclick="window.location.href='halaman_utama.php?page=tambah_pegawai';">+ Tambah Pegawai</button>
        </tr>
        <tr>
            <td align="center">Daftar Nama Pegawai</td>
        </tr>
        <?php    
            $data_pegawai = mysqli_query($koneksi, "SELECT * FROM pegawai");
            while($data = mysqli_fetch_assoc($data_pegawai)){
        ?>
        <li>
            <tr>
                <td><b><?=$data['Username']?></b> - <?=$data['Nama_Lengkap']?>
                </td>
            </tr>
        </li>
        <?php
            }
        ?>

    </table>

    <hr>

    <h3>Tambah Pegawai</h3>
    <form action="" method="post">
        <label for="nama_lengkap">Nama Lengkap:</label>
        <input type="text" name="nama_lengkap" required>

        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" autocomplete="off" required>

        <label for="konfirmasi_pass">Konfirmasi Password:</label>
        <input type="password" name="konfirmasi_pass" autocomplete="off" required>

        <input type="submit" name="tombol_tambah" value="Simpan">
    </form>

</center>