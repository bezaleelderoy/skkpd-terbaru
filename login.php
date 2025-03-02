<?php
include "koneksi.php";
if(isset($_POST['tombol_login'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];
    
    $cek_operator = mysqli_query($koneksi, "SELECT Username, Password FROM pengguna WHERE Username='$user'");
    $data_operator = mysqli_fetch_assoc($cek_operator);
    
    $cek_siswa = mysqli_query($koneksi, "SELECT NIS, Password FROM pengguna WHERE NIS='$user'");
    $data_siswa = mysqli_fetch_assoc($cek_siswa);
    
    if(mysqli_num_rows($cek_operator) > 0){
        if(password_verify($pass, $data_operator['Password'])){
            $user_operator = $data_operator['Username'];
            $nama_operator = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Nama_Lengkap FROM pegawai WHERE Username = '$user_operator'"));
            setcookie('username', $data_operator['Username'], time() + (60 * 60 * 24 * 7), '/');
            setcookie('nama_lengkap', $nama_operator['Nama_Lengkap'], time() + (60 * 60 * 24 * 7), '/');
            setcookie('level_user', 'operator', time() + (60 * 60 * 24 * 7), '/');
            echo "<script>alert('Berhasil Login');window.location.href='tampilan/halaman_utama.php?page=siswa'</script>";
        }else{
            echo "<script>alert('Gagal Login, Password Salah');window.location.href='login.php'</script>";
        }
        
    }elseif(mysqli_num_rows($cek_siswa) > 0){
        if(password_verify($pass, $data_siswa['Password'])){
            $user_siswa = $data_siswa['NIS'];
            $nama_siswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Nama_Siswa FROM siswa WHERE NIS = '$user_siswa'"));
            setcookie('nis', $data_siswa['NIS'], time() + (60 * 60 * 24 * 7), '/');
            setcookie('level_user', 'siswa', time() + (60 * 60 * 24 * 7), '/');
            setcookie('nama_lengkap', $nama_siswa['Nama_Siswa'], time() + (60 * 60 * 24 * 7), '/');
            echo "<script>alert('Berhasil Login');window.location.href='tampilan/halaman_utama.php?page=upload_sertifikat'</script>";
        }
        else{
            echo "<script>alert('Gagal Login, Password Salah');window.location.href='login.php'</script>";
        }
    }
    else{
        echo "<script>alert('Gagal Login, username atau password salah');window.location.href='login.php'</script>";
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <center>
        <h1>Level_User Operator : </h1>
        <h4> username = yenny</h4>
        <h4> password = admin12345</h4>
        <h1> Level_User Siswa :<h1>
                <h4> username = 7024</h4>
                <h4> password = siswa7024</h4>
    </center>
    <form action="" method="post">
        <table align="center" cellpadding="10">
            <tr>
                <td>Username/NIS:</td>
                <td><input type="text" name="username" autocomplete="off" required></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" autocomplete="off" required></td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <input type="submit" name="tombol_login" value="Login">
                </td>
            </tr>
        </table>
    </form>
</body>

</html>