<?php
if (isset($_POST['tombol_tambah'])) {

    $id_jurusan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Id_Jurusan FROM jurusan ORDER BY Id_Jurusan DESC LIMIT 1"));

    if ($id_jurusan) {
        $angkaTerakhir = intval(substr($id_jurusan['Id_Jurusan'], 1));
        $noUrut = $angkaTerakhir + 1;
    } else {
        $noUrut = 1;
    }
    $Id = "J" . $noUrut;
    $jurusan = $_POST['jurusan'];

    $hasil = mysqli_query($koneksi, "INSERT INTO jurusan VALUES('$Id', '$jurusan')");

    if (!$hasil) {
        echo "<script>alert('Gagal memasukkan data');window.location.href='halaman_utama.php?page=tambah_jurusan'</script>";
    } else {
        echo "<script>alert('Berhasil menambahkan data');window.location.href='halaman_utama.php?page=jurusan'</script>";
    }
}
?>
<center>
    <form action="" method="post">
        <table cellspacing="10">
            <tr>
                <td><label for="jurusan">Nama Jurusan</label></td>
                <td><input type="text" id="jurusan" name="jurusan" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="tombol_tambah" style="float:right" value="Simpan">
                </td>
            </tr>
        </table>
    </form>
</center>