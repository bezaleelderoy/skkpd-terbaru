<?php
$nis = $_GET['nis'];
$data_update = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa WHERE NIS='$nis'"));

if(isset($_POST['tombol_update'])){
    $no_absen           = htmlspecialchars($_POST['no_absen']);
    $nama_siswa         = htmlspecialchars($_POST['nama_siswa']);
    $no_telp            = htmlspecialchars($_POST['no_telp']);
    $email              = htmlspecialchars($_POST['email']);
    $password           = htmlspecialchars($_POST['password']);
    $konfirmasi_pass    = htmlspecialchars($_POST['konfirmasi_pass']);
    $id_jurusan         = htmlspecialchars($_POST['jurusan']);
    $kelas              = htmlspecialchars($_POST['kelas']);
    $angkatan           = htmlspecialchars($_POST['angkatan']);

    if($password == NULL){
        if($password !== $konfirmasi_pass){
            echo "<script>alert('password dengan konfirmasi password tidak sama');window.location.href='halaman_utama.php?page=ubah_siswa&nis=".$nis."'</script>";
        }else{
            $hasil = mysqli_query($koneksi, "UPDATE siswa SET No_Absen = '$no_absen', Nama_Siswa = '$nama_siswa', No_Telp = '$no_telp', Email = '$email', Id_Jurusan = '$id_jurusan ', Kelas = '$kelas', Angkatan = $angkatan WHERE NIS = '$nis'");
            
            if(!$hasil){
                echo "<script>alert('Gagal update data siswa');window.location.href='halaman_utama.php?page=ubah_siswa&nis=$nis'</script>";
            }else{
                echo "<script>alert('Berhasil update data siswa');window.location.href='halaman_utama.php?page=siswa'</script>";
            }
        }
    }else{
        if($password !== $konfirmasi_pass){
            echo "<script>alert('password dengan konfirmasi password tidak sama');window.location.href='halaman_utama.php?page=ubah_siswa&nis=".$nis."'</script>";
        }else{
            $hasil = mysqli_query($koneksi, "UPDATE siswa SET No_Absen = '$no_absen', Nama_Siswa = '$nama_siswa', No_Telp = '$no_telp', Email = '$email', Id_Jurusan = '$id_jurusan ', Kelas = '$kelas', Angkatan = $angkatan WHERE NIS = '$nis'");
            
            $enkrip     = password_hash($password, PASSWORD_DEFAULT);
            $hasil_pengguna = mysqli_query($koneksi, "UPDATE pengguna SET Password = '$enkrip' WHERE NIS = '$nis'");

            if(!$hasil){
                echo "<script>alert('Gagal update data siswa');window.location.href='halaman_utama.php?page=ubah_siswa&nis=$nis'</script>";
            }else{
                echo "<script>alert('Berhasil update data siswa');window.location.href='halaman_utama.php?page=siswa'</script>";
            }
        }
    }
    
}
?>

<center>
    <form action="" method="post">
        <table align="center" cellspacing="10">
            <tr>
                <td>NIS:</td>
                <td><input type="number" name="nis" value="<?=$data_update['NIS']?>" required></td>
            </tr>
            <tr>
                <td>No Absen:</td>
                <td><input type="number" name="no_absen" autocomplete="off" value="<?=$data_update['No_Absen']?>"
                        required>
                </td>
            </tr>
            <tr>
                <td>Nama Siswa:</td>
                <td><input type="text" name="nama_siswa" autocomplete="off" value="<?=$data_update['Nama_Siswa']?>"
                        required></td>
            </tr>
            <tr>
                <td>No Telp:</td>
                <td><input type="text" name="no_telp" autocomplete="off" value="<?=$data_update['No_Telp']?>" required>
                </td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" name="email" autocomplete="off" value="<?=$data_update['Email']?>" required>
                </td>
            </tr>
            <tr>
                <td>Ganti Password:</td>
                <td><input type="text" name="password" autocomplete="off"></td>
            </tr>
            <tr>
                <td>Konfirmasi Password:</td>
                <td><input type="text" name="konfirmasi_pass" autocomplete="off"></td>
            </tr>
            <tr>
                <td>Jurusan:</td>
                <td>
                    <select name="jurusan">
                        <?php
                        $list = mysqli_query($koneksi, "SELECT * FROM jurusan");
                        while($data = mysqli_fetch_assoc($list)){
                    ?>
                        <option value="<?=$data['Id_Jurusan']?>"
                            <?php if($data['Id_Jurusan']==$data_update['Id_Jurusan']){echo "selected";} ?>>
                            <?=$data['Jurusan']?></option>
                        <?php
                        }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Kelas:</td>
                <td><input type="number" name="kelas" autocomplete="off" value="<?=$data_update['Kelas']?>" required>
                </td>
            </tr>
            <tr>
                <td>Angkatan:</td>
                <td><input type="number" name="angkatan" autocomplete="off" value="<?=$data_update['Angkatan']?>"
                        required>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <input type="submit" name="tombol_update" value="Update">
                </td>
            </tr>
        </table>
    </form>
</center>