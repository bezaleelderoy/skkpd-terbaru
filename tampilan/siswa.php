<?php
if(!@$_COOKIE['level_user']) {
    echo "<script>alert('belum login');window.location.href='../login.php'</script>";
}elseif($_COOKIE['level_user']=='siswa') {
    echo "<script>alert('anda siswa, silahkan kembali ke halaman utama siswa');window.location.href='halaman_utama.php?page=upload_sertifikat'</script>";
}

if(isset($_GET['nis'])){ 
    $nis = $_GET['nis'];

    $delete_pengguna = mysqli_query($koneksi, "DELETE FROM pengguna WHERE NIS='$nis'");
    $delete_sertifikat = mysqli_query($koneksi, "DELETE FROM sertifikat WHERE NIS='$nis'");
    $delete_siswa = mysqli_query($koneksi, "DELETE FROM siswa WHERE NIS='$nis'");
   
    if(!$delete_siswa){
        echo "<script>alert('gagal menghapus data');window.location.href='halaman_utama.php?page=siswa'</script>";
    }else{
        echo "<script>alert('berhasil menghapus data');window.location.href='halaman_utama.php?page=siswa'</script>";
    }
}
?>
<center>
    <h2>Daftar Siswa</h2><br>
    <button onclick="window.location.href='halaman_utama.php?page=tambah_siswa';">+ Tambah Siswa</button><br><br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>NIS</th>
            <th>Nama</th>
            <th>Absen</th>
            <th>Jurusan</th>
            <th>Kelas</th>
            <th>Angkatan</th>
            <th>Email</th>
            <th>No. Telp</th>
            <th>Aksi</th>
        </tr>
        <?php      
    $data_siswa = mysqli_query($koneksi, "SELECT * FROM siswa INNER JOIN jurusan USING(Id_Jurusan)");
    while($data = mysqli_fetch_assoc($data_siswa)){
    ?>
        <tr>
            <td><?= $data['NIS'] ?></td>
            <td><?= $data['Nama_Siswa'] ?></td>
            <td><?= $data['No_Absen'] ?></td>
            <td><?= $data['Jurusan'] ?></td>
            <td><?= $data['Kelas'] ?></td>
            <td><?= $data['Angkatan'] ?></td>
            <td><?= $data['Email'] ?></td>
            <td><?= $data['No_Telp'] ?></td>
            <td>
                <a href="halaman_utama.php?page=ubah_siswa&nis=<?= $data['NIS'] ?>">Update</a>
                <a href="halaman_utama.php?page=siswa&nis=<?= $data['NIS'] ?>"
                    onclick="return confirm('Yakin mau hapus?');">Delete</a>
            </td>
        </tr>
        <?php
    }
    ?>
    </table>
</center>