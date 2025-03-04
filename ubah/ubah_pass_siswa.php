<?php
if(!isset($_COOKIE['nis'])) {
    header("Location: ../login.php");
    exit;
}
$nis            = $_COOKIE['nis'];
$data_update    = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa INNER JOIN pengguna USING(NIS) INNER JOIN jurusan using(Id_Jurusan) WHERE NIS = '$nis'"));


if(isset($_POST['tombol_ubah'])){
    $password       = htmlspecialchars($_POST['password']);
    $konfirmasi_pass = htmlspecialchars($_POST['konfirmasi_pass']);
    if($password == NULL){
        echo "<script>alert('Anda tidak ada mengganti password');window.location.href='halaman_utama.php?page=ubah_pass'</script>";
    }else{
        if($password !== $konfirmasi_pass){
            echo "<script>alert('password dengan konfirmasi password tidak sama');window.location.href='halaman_utama.php?page=ubah_pass'</script>";
        }else{
            $enkrip     = password_hash($password, PASSWORD_DEFAULT);
            $hasil_pengguna = mysqli_query($koneksi, "UPDATE pengguna SET Password = '$enkrip' WHERE NIS = '$nis'");

            if(!$hasil_pengguna){
                echo "<script>alert('Gagal update data siswa');window.location.href='halaman_utama.php?page=ubah_pass'</script>";
            }else{
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

<center>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th colspan="2">Detail Siswa</th>
        </tr>
        <tr>
            <td><strong>NIS</strong></td>
            <td align="right"><?= $data_update['NIS'] ?></td>
        </tr>
        <tr>
            <td><strong>Nama</strong></td>
            <td align="right"><?= $data_update['Nama_Siswa'] ?></td>
        </tr>
        <tr>
            <td><strong>No Absen</strong></td>
            <td align="right"><?= $data_update['No_Absen'] ?></td>
        </tr>
        <tr>
            <td><strong>No Telp</strong></td>
            <td align="right"><?= $data_update['No_Telp'] ?></td>
        </tr>
        <tr>
            <td><strong>Email</strong></td>
            <td align="right"><?= $data_update['Email'] ?></td>
        </tr>
        <tr>
            <td><strong>Kelas</strong></td>
            <td align="right"><?= $data_update['Jurusan'] . ' ' . $data_update['Kelas'] ?></td>
        </tr>
        <tr>
            <td><strong>Angkatan</strong></td>
            <td align="right"><?= $data_update['Angkatan'] ?></td>
        </tr>
    </table>

    <br>

    <form action="" method="post">
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th colspan="2">Ganti Password</th>
            </tr>
            <tr>
                <td>Password Baru</td>
                <td><input type="password" name="password" autocomplete="off" autofocus></td>
            </tr>
            <tr>
                <td>Konfirmasi Password</td>
                <td><input type="password" name="konfirmasi_pass" autocomplete="off"></td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <input type="submit" name="tombol_ubah" value="Perbarui">
                </td>
            </tr>
        </table>
    </form>
</center>