<center>
    <?php
    if (@$_GET['Id_Kegiatan']) {
        $id_kegiatan = htmlspecialchars($_GET['Id_Kegiatan']);
        $data_update = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM kategori INNER JOIN kegiatan USING(Id_Kategori) WHERE Id_Kegiatan='$id_kegiatan'"));

        if (isset($_POST['tombol_update'])) {
            $kegiatan       = htmlspecialchars($_POST['kegiatan']);
            $kategori       = htmlspecialchars($_POST['kategori']);
            $sub_kategori   = htmlspecialchars($_POST['sub_kategori']);
            $point          = htmlspecialchars($_POST['point']);

            $hasil = mysqli_query($koneksi, "UPDATE kegiatan SET Jenis_Kegiatan='$kegiatan', Angka_Kredit='$point' WHERE Id_Kegiatan = '$id_kegiatan'");

            if (!$hasil) {
                echo "<script>alert('gagal memasukkan data');window.location.href='halaman_utama.php?page=ubah_kategori_kegiatan&Id_Kegiatan=" . $id_kegiatan . "'</script>";
            } else {
                echo "<script>alert('Berhasil Memperbarui Data');window.location.href='halaman_utama.php?page=kategori_kegiatan'</script>";
            }
        }
    ?>



        <div class="px-28 pb-12">
            <div class="flex justify-between items-center my-5">
                <h1 class="text-3xl font-bold border-b-2 border-accent pb-1">Edit Kegiatan</h1>
            </div>

            <form action="" method="post">
                <div class="grid grid-cols-2 gap-4">
                    <!-- Kategori -->
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text">Kategori</span></label>
                        <input type="text" name="kategori" value="<?= $data_update['Kategori'] ?>"
                            class="input input-bordered w-full" readonly required>
                    </div>

                    <!-- Sub Kategori -->
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text">Sub Kategori</span></label>
                        <input type="text" name="sub_kategori" value="<?= $data_update['Sub_Kategori'] ?>"
                            class="input input-bordered w-full" readonly required>
                    </div>

                    <!-- Nama Kegiatan -->
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text">Nama Kegiatan</span></label>
                        <input type="text" name="kegiatan" value="<?= $data_update['Jenis_Kegiatan'] ?>"
                            class="input input-bordered w-full" autofocus required>
                    </div>

                    <!-- Angka Kredit / Point -->
                    <div class="form-control w-full">
                        <label class="label"><span class="label-text">Angka Kredit / Point</span></label>
                        <input type="number" name="point" value="<?= $data_update['Angka_Kredit'] ?>"
                            class="input input-bordered w-full" required>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end mt-6">
                    <input type="submit" name="tombol_update" value="Update" class="btn btn-primary">
                </div>
            </form>
        </div>


    <?php
    } elseif (@$_GET['Id_Kategori']) {
        $id_kategori = htmlspecialchars($_GET['Id_Kategori']);
        $data_update = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM kategori WHERE Id_Kategori='$id_kategori'"));

        if (isset($_POST['tombol_update'])) {
            $sub_kategori   = htmlspecialchars($_POST['sub_kategori']);

            $hasil = mysqli_query($koneksi, "UPDATE kategori SET Sub_Kategori='$sub_kategori' WHERE Id_Kategori = '$id_kategori'");

            if (!$hasil) {
                echo "<script>alert('gagal memasukkan data');window.location.href='halaman_utama.php?page=ubah_kategori_kegiatan&Id_Kegiatan=" . $id_kegiatan . "'</script>";
            } else {
                echo "<script>alert('Berhasil Memperbarui Data');window.location.href='halaman_utama.php?page=kategori_kegiatan'</script>";
            }
        }
    ?>

        <div class="px-28 pb-12">
            <div class="flex justify-between items-center my-5">
                <h1 class="text-3xl font-bold border-b-2 border-accent pb-1">Edit Sub Kategori</h1>
            </div>

            <form action="" method="post">
                <div class="form-control w-full">
                    <label class="label"><span class="label-text">Kategori</span></label>
                    <input type="text" name="kategori" value="<?= $data_update['Kategori'] ?>"
                        class="input input-bordered w-full" readonly required>
                </div>

                <div class="form-control w-full mt-4">
                    <label class="label"><span class="label-text">Sub Kategori</span></label>
                    <input type="text" name="sub_kategori" value="<?= $data_update['Sub_Kategori'] ?>"
                        class="input input-bordered w-full" autofocus required>
                </div>

                <div class="flex justify-end mt-6">
                    <input type="submit" name="tombol_update" value="Update" class="btn btn-primary">
                </div>
            </form>
        </div>


    <?php
    }
    ?>

</center>