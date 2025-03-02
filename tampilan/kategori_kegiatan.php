<?php
if(isset($_GET['Id_Kegiatan'])){
    $Id_Kegiatan = $_GET['Id_Kegiatan'];
    $hasil_kegiatan = mysqli_query($koneksi, "DELETE FROM kegiatan WHERE Id_Kegiatan='$Id_Kegiatan'");

    if(!$hasil_kegiatan){
        echo "<script>alert('gagal menghapus data');window.location.href='halaman_utama.php?page=kategori_kegiatan'</script>";
    }else{
        echo "<script>alert('berhasil menghapus data');window.location.href='halaman_utama.php?page=kategori_kegiatan'</script>";
    }
}
?>
<center>
    <button onclick="window.location.href='halaman_utama.php?page=tambah_kegiatan';">+ Tambah Kategori
        Kegiatan</button><br><br>

    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Kegiatan</th>
                <th>Angka Kredit/Point</th>
                <th colspan="2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
        $query = mysqli_query($koneksi, "SELECT * FROM kategori INNER JOIN kegiatan ON kategori.Id_Kategori = kegiatan.Id_Kategori ORDER BY kategori.Sub_Kategori");

        $last_kategori_id = null;
        $no = 1;
        while ($baris = mysqli_fetch_assoc($query)) {
            if ($last_kategori_id !== $baris['Id_Kategori']) {
                if ($last_kategori_id !== null) {
                    echo "<tr><td colspan='5'>&nbsp;</td></tr>";
                }
                echo "<tr><td colspan='3'><strong>" . htmlspecialchars($baris['Kategori']) . " - " . htmlspecialchars($baris['Sub_Kategori']) . "</strong></td>
                      <td><a href='halaman_utama.php?page=ubah_kategori_kegiatan&Id_Kategori=" . htmlspecialchars($baris['Id_Kategori']) . "'>Update</a></td>
                      <td></td></tr>";
                $no = 1;
            }
        ?>
            <tr>
                <td><?=$no++?></td>
                <td><?=htmlspecialchars($baris['Jenis_Kegiatan'])?></td>
                <td><?=htmlspecialchars($baris['Angka_Kredit'])?></td>
                <td><a
                        href="halaman_utama.php?page=ubah_kategori_kegiatan&Id_Kegiatan=<?=htmlspecialchars($baris['Id_Kegiatan'])?>">Update</a>
                </td>
                <td><a href="halaman_utama.php?page=kategori_kegiatan&Id_Kegiatan=<?=htmlspecialchars($baris['Id_Kegiatan'])?>"
                        onclick="return confirm('Yakin ingin menghapus kegiatan ini?');">Hapus</a></td>
            </tr>
            <?php
            $last_kategori_id = $baris['Id_Kategori'];
        }
        ?>
        </tbody>
    </table>
</center>