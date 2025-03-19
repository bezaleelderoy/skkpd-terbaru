<?php
if (isset($_POST['tombol_tambah'])) {
    $kategori       = htmlspecialchars($_GET['kategori']);
    $sub_kategori   = htmlspecialchars($_GET['sub_kategori']);
    $kegiatan       = htmlspecialchars($_POST['kegiatan']);
    $cek_kegiatan   = mysqli_query($koneksi, "SELECT Jenis_Kegiatan FROM kegiatan WHERE Jenis_Kegiatan = '$kegiatan'");
    if (mysqli_num_rows($cek_kegiatan) > 0) {
        echo "<script>alert('Data Sudah ada di database, silahkan masukkan jenis kegiatan baru');window.location.href='halaman_utama.php?page=tambah_kegiatan&kategori=" . $kategori . "&sub_kategori=" . $sub_kategori . "'</script>";
    } else {
        $kategori       = htmlspecialchars($_POST['kategori']);
        $sub_kategori   = htmlspecialchars($_POST['sub_kategori']);
        $id_kategori    = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Id_Kategori FROM kategori WHERE Sub_Kategori = '$sub_kategori'"))['Id_Kategori'];
        $point          = htmlspecialchars($_POST['point']);

        $hasil = mysqli_query($koneksi, "INSERT INTO kegiatan VALUES(NULL, '$kegiatan', '$point', '$id_kategori')");

        if (!$hasil) {
            echo "<script>alert('gagal memasukkan data');window.location.href='halaman_utama.php?page=tambah_kegiatan'</script>";
        } else {
            echo "<script>alert('Berhasil Menambahkan Data');window.location.href='halaman_utama.php?page=kategori_kegiatan'</script>";
        }
    }
}
?>

<div class="px-28 pb-12">
    <div class="flex justify-between items-center my-5">
        <h1 class="text-3xl font-bold border-b-2 border-accent pb-1">Tambah Kegiatan</h1>
    </div>

    <!-- Dropdown Kategori -->
    <div class="form-control w-full mb-4">
        <label class="label justify-start"><span class="label-text">Kategori</span></label>
        <select name="kategori" class="select select-bordered w-full" onchange="pilihKategori(this.value)">
            <option selected>Pilih Kategori</option>
            <?php
            $list_kategori = mysqli_query($koneksi, "SELECT Kategori FROM kategori GROUP BY Kategori");
            while ($data_kategori = mysqli_fetch_assoc($list_kategori)) {
            ?>
                <option value="<?= $data_kategori['Kategori'] ?>"
                    <?php if (@$_GET['kategori'] == $data_kategori['Kategori']) {
                        echo "selected";
                    } ?>>
                    <?= $data_kategori['Kategori'] ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <script>
        function pilihKategori(value) {
            window.location.href = 'halaman_utama.php?page=tambah_kegiatan&kategori=' + value;
        }
    </script>

    <?php if (@$_GET['kategori']) {
        $kategori = htmlspecialchars($_GET['kategori']);
    ?>
        <!-- Dropdown Sub Kategori -->
        <div class="form-control w-full mb-4">
            <label class="label justify-start"><span class="label-text">Sub Kategori</span></label>
            <select name="sub_kategori" class="select select-bordered w-full" onchange="pilihSubKategori(this.value)">
                <option selected>Pilih Sub Kategori</option>
                <?php
                $list_kategori = mysqli_query($koneksi, "SELECT Sub_Kategori FROM kategori WHERE Kategori='$kategori'");
                while ($sub_kategori = mysqli_fetch_assoc($list_kategori)) {
                ?>
                    <option value="<?= $sub_kategori['Sub_Kategori'] ?>"
                        <?php if (@$_GET['sub_kategori'] == $sub_kategori['Sub_Kategori']) {
                            echo "selected";
                        } ?>>
                        <?= $sub_kategori['Sub_Kategori'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <script>
            function pilihSubKategori(value) {
                const urlParams = new URLSearchParams(window.location.search);
                const kategori = urlParams.get('kategori');
                window.location.href = `halaman_utama.php?page=tambah_kegiatan&kategori=${kategori}&sub_kategori=${value}`;
            }
        </script>
    <?php } ?>

    <?php if (@$_GET['sub_kategori']) {
        $sub_kategori = htmlspecialchars($_GET['sub_kategori']);
    ?>
        <!-- Form Tambah Kegiatan -->
        <form action="" method="post">
            <input type="hidden" name="kategori" value="<?= $kategori ?>">
            <input type="hidden" name="sub_kategori" value="<?= $sub_kategori ?>">

            <datalist id="kegiatan">
                <?php
                $list_kegiatan = mysqli_query($koneksi, "SELECT Sub_Kategori, Jenis_Kegiatan FROM kegiatan INNER JOIN kategori USING(Id_Kategori) WHERE Sub_Kategori='$sub_kategori'");
                while ($data_kegiatan = mysqli_fetch_assoc($list_kegiatan)) {
                ?>
                    <option value="<?= $data_kegiatan['Jenis_Kegiatan'] ?>"></option>
                <?php } ?>
            </datalist>

            <!-- Nama Kegiatan -->
            <div class="form-control w-full mb-4">
                <label class="label justify-start"><span class="label-text">Nama Kegiatan</span></label>
                <input type="text" list="kegiatan" name="kegiatan" class="input input-bordered w-full" required>
            </div>

            <!-- Angka Kredit / Point -->
            <div class="form-control w-full mb-4">
                <label class="label justify-start"><span class="label-text">Angka Kredit / Point</span></label>
                <input type="number" name="point" class="input input-bordered w-full" required>
            </div>

            <!-- Tombol Simpan -->
            <div class="flex justify-end">
                <input type="submit" name="tombol_tambah" value="Simpan" class="btn btn-primary">
            </div>
        </form>
    <?php } ?>
</div>