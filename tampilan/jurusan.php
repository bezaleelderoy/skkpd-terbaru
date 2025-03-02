<?php
if(isset($_GET['id'])){
    
    $id_jurusan = $_GET['id'];
    $hasil_jurusan = mysqli_query($koneksi, "DELETE FROM jurusan WHERE Id_Jurusan='$id_jurusan'");

    if(!$hasil_jurusan){
        echo "<script>alert('Gagal menghapus data');window.location.href='halaman_utama.php?page=jurusan'</script>";
    }else{
        echo "<script>alert('Berhasil menghapus data');window.location.href='halaman_utama.php?page=jurusan'</script>";
    }
}
?>
<center>
    <button onclick="window.location.href='halaman_utama.php?page=tambah_jurusan';">+ Tambah Jurusan</button><br><br>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Jurusan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php    
        $no = 1;  
        $data_jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");
        while($data = mysqli_fetch_assoc($data_jurusan)){
        ?>
            <tr>
                <td><?=$no++?></td>
                <td><?=$data['Jurusan'];?></td>
                <td>
                    <a href="halaman_utama.php?page=ubah_jurusan&id=<?=$data['Id_Jurusan']?>">Update</a> |
                    <?php
                $id_cek = $data['Id_Jurusan'];
                $cek_data = mysqli_query($koneksi, "SELECT Id_Jurusan FROM siswa WHERE Id_Jurusan='$id_cek'");
                if(mysqli_num_rows($cek_data) > 0){
                ?>
                    <span style="color: gray;">Delete</span>
                    <?php
                }else{
                ?>
                    <a onclick="return confirm('Yakin mau hapus?');"
                        href="halaman_utama.php?page=jurusan&id=<?=$data['Id_Jurusan']?>">Delete</a>
                    <?php
                }
                ?>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</center>