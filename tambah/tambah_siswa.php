<?php
if(isset($_POST['tombol_tambah'])){
    $nis        = htmlspecialchars($_POST['nis']);
    $no_absen   = htmlspecialchars($_POST['no_absen']);
    $nama_siswa = htmlspecialchars($_POST['nama_siswa']);
    $no_telp    = htmlspecialchars($_POST['no_telp']);
    $email      = htmlspecialchars($_POST['email']);
    $id_jurusan = htmlspecialchars($_POST['jurusan']);
    $kelas      = htmlspecialchars($_POST['kelas']);
    $angkatan   = htmlspecialchars($_POST['angkatan']);
    
    $pass       = "siswa".$nis;
    $enkrip     = password_hash($pass, PASSWORD_DEFAULT);

    $hasil = mysqli_query($koneksi, "INSERT INTO siswa VALUES('$nis', '$no_absen', '$nama_siswa', '$no_telp', '$email', '$id_jurusan', '$kelas', '$angkatan')");    
    $hasil_pengguna = mysqli_query($koneksi, "INSERT INTO pengguna VALUES(NULL, NULL, '$nis', '$enkrip')");


    if(!$hasil){
        echo "<script>alert('gagal memasukkan data');window.location.href='halaman_utama.php?page=tambah_siswa'</script>";
    }else{
        echo "<script>alert('Berhasil Menambahkan Data');window.location.href='halaman_utama.php?page=siswa'</script>";
    }
    
}
?>
<center>
    <form action="" method="post">
        <table align="center" cellspacing="10">
            <tr>
                <td>NIS:</td>
                <td><input type="number" name="nis" required></td>
            </tr>
            <tr>
                <td>No Absen:</td>
                <td><input type="number" name="no_absen" autocomplete="off" required>
                </td>
            </tr>
            <tr>
                <td>Nama Siswa:</td>
                <td><input type="text" name="nama_siswa" autocomplete="off" required></td>
            </tr>
            <tr>
                <td>No Telp:</td>
                <td><input type="text" name="no_telp" autocomplete="off" required></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" name="email" autocomplete="off" required></td>
            </tr>
            <tr>
                <td>Jurusan:</td>
                <td>
                    <select name="jurusan">
                        <?php
                        $list = mysqli_query($koneksi, "SELECT * FROM jurusan");
                        while($data = mysqli_fetch_assoc($list)){
                    ?>
                        <option value="<?=$data['Id_Jurusan']?>"> <?=$data['Jurusan']?></option>
                        <?php
                        }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Kelas:</td>
                <td><input type="number" name="kelas" autocomplete="off" required></td>
            </tr>
            <tr>
                <td>Angkatan:</td>
                <td><input type="number" name="angkatan" autocomplete="off" required>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <input type="submit" name="tombol_tambah" value="Simpan">
                </td>
            </tr>
        </table>
    </form>
</center>