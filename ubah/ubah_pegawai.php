<?php
if(!isset($_COOKIE['username'])) {
    echo "<script>alert('anda belum login');window.location.href='../login.php'</script>";
}

$username       = $_COOKIE['username'];
$data_update    = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pegawai INNER JOIN pengguna USING(Username) WHERE Username = '$username'"));


if(isset($_POST['tombol_ubah'])){
    $nama_lengkap   = htmlspecialchars($_POST['nama_lengkap']);
    $password       = htmlspecialchars($_POST['password']);
    $konfirmasi_pass = htmlspecialchars($_POST['konfirmasi_pass']);
    if($password == NULL){
        if($password !== $konfirmasi_pass){
            echo "<script>alert('password dengan konfirmasi password tidak sama');window.location.href='halaman_utama.php?page=ubah_pegawai&username=".$username."'</script>";
        }else{
            $hasil = mysqli_query($koneksi, "UPDATE pegawai SET Nama_Lengkap='$nama_lengkap' WHERE Username = '$username'");
            
            if(!$hasil){
                echo "<script>alert('Gagal update data pegawai');window.location.href='halaman_utama.php?page=ubah_pegawai&username=".$username."'</script>";
            }else{
                echo "<script>alert('Berhasil update data pegawai');window.location.href='../logout.php';</script>";
            }
        }
    }else{
        if($password !== $konfirmasi_pass){
            echo "<script>alert('password dengan konfirmasi password tidak sama');window.location.href='halaman_utama.php?page=ubah_pegawai&username=".$username."'</script>";
        }else{
            $hasil = mysqli_query($koneksi, "UPDATE pegawai SET Nama_Lengkap='$nama_lengkap' WHERE Username = '$username'");
            $enkrip     = password_hash($password, PASSWORD_DEFAULT);
            $hasil_pengguna = mysqli_query($koneksi, "UPDATE pengguna SET Password = '$enkrip' WHERE Username = '$username'");

            if(!$hasil){
                echo "<script>alert('Gagal update data pegawai');window.location.href='halaman_utama.php?page=ubah_pegawai&username=".$username."'</script>";
            }else{
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
                <button onclick=window.location.href="halaman_utama.php?page=ubah_pegawai&username='.$_COOKIE["username"].'" class="btn btn-secondary">Batal</button>
            </form>
        </center>
        ';
}elseif(isset($_POST['delete_akun'])){ 
    $pass = $_POST['pass'];
    $pass_database = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Password FROM pengguna WHERE Username = '$username'"))['Password'];
    if(password_verify($pass, $pass_database)){
        $delete_pengguna = mysqli_query($koneksi, "DELETE FROM pengguna WHERE Username = '$username'");
        $delete_pegawai = mysqli_query($koneksi, "DELETE FROM pegawai WHERE Username = '$username'");
        if(!$delete_pengguna){
            echo "<script>alert('gagal menghapus data pegawai');window.location.href='halaman_utama.php?page=ubah_pegawai&username=".$username."'</script>";
        }else{
            echo "<script>alert('berhasil menghapus data');window.location.href='../logout.php';</script>";
        }
    }else{
        echo "<script>alert('Password Salah');window.location.href='halaman_utama.php?page=ubah_pegawai&username=".$username."'</script>";
    }
}
else {
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
                <td><input type="submit" name="tombol_delete" value="Delete">
                    | <input type="submit" name="tombol_ubah" value="Update"></td>
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