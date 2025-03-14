<?php
include "koneksi.php";
if (isset($_POST['tombol_login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $cek_operator = mysqli_query($koneksi, "SELECT Username, Password FROM pengguna WHERE Username='$user'");
    $data_operator = mysqli_fetch_assoc($cek_operator);

    $cek_siswa = mysqli_query($koneksi, "SELECT NIS, Password FROM pengguna WHERE NIS='$user'");
    $data_siswa = mysqli_fetch_assoc($cek_siswa);

    if (mysqli_num_rows($cek_operator) > 0) {
        if (password_verify($pass, $data_operator['Password'])) {
            $user_operator = $data_operator['Username'];
            $nama_operator = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Nama_Lengkap FROM pegawai WHERE Username = '$user_operator'"));
            setcookie('username', $data_operator['Username'], time() + (60 * 60 * 24 * 7), '/');
            setcookie('nama_lengkap', $nama_operator['Nama_Lengkap'], time() + (60 * 60 * 24 * 7), '/');
            setcookie('level_user', 'operator', time() + (60 * 60 * 24 * 7), '/');
            echo "<script>alert('Berhasil Login');window.location.href='tampilan/halaman_utama.php'</script>";
        } else {
            echo "<script>alert('Gagal Login, Password Salah');window.location.href='login.php'</script>";
        }
    } elseif (mysqli_num_rows($cek_siswa) > 0) {
        if (password_verify($pass, $data_siswa['Password'])) {
            $user_siswa = $data_siswa['NIS'];
            $nama_siswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Nama_Siswa FROM siswa WHERE NIS = '$user_siswa'"));
            setcookie('nis', $data_siswa['NIS'], time() + (60 * 60 * 24 * 7), '/');
            setcookie('level_user', 'siswa', time() + (60 * 60 * 24 * 7), '/');
            setcookie('nama_lengkap', $nama_siswa['Nama_Siswa'], time() + (60 * 60 * 24 * 7), '/');
            echo "<script>alert('Berhasil Login');window.location.href='tampilan/halaman_utama.php?page=sertifikat_siswa'</script>";
        } else {
            echo "<script>alert('Gagal Login, Password Salah');window.location.href='login.php'</script>";
        }
    } else {
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
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-base-200 flex justify-center items-center min-h-screen">

    <div class="card w-96 bg-base-100 shadow-xl p-6">
        <h2 class="text-center text-2xl font-bold">Login</h2>
        
        <form action="" method="post" class="mt-4">
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Username/NIS</span>
                </label>
                <input type="text" name="username" placeholder="Enter your username/NIS" class="input input-bordered w-full" required />
            </div>
            
            <div class="form-control mt-4">
                <label class="label">
                    <span class="label-text">Password</span>
                </label>
                <input type="password" name="password" placeholder="Enter your password" class="input input-bordered w-full" required />
            </div>
            
            <div class="form-control mt-4">
                <button name="tombol_login" class="btn btn-soft btn-accent w-full">Login</button>
            </div>
        </form>
    </div>

</body>

</html>


<!-- <center>
        <h1>Level_User Operator : </h1>
        <h4> username = yenny</h4>
        <h4> password = admin12345</h4>
        <h1> Level_User Siswa :<h1>
                <h4> username = 7024</h4>
                <h4> password = siswa7024</h4>
    </center> -->