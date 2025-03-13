<?php
include "../koneksi.php";
session_start();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>

    <!-- Navbar -->
    <!-- Navbar -->
    <div class="navbar bg-accent shadow-sm">
        <div class="flex-1">
            <a class="btn btn-ghost text-xl text-white font-bold">daisyUI</a>
        </div>
        <div class="flex-none">
            <ul class="menu menu-horizontal px-1">
                <?php
                if ($_COOKIE['level_user'] == 'operator') {
                ?>
                    <li><a class="text-white font-bold" href="halaman_utama.php">Halaman Utama</a></li>
                    <li><a class="text-white font-bold" href="halaman_utama.php?page=siswa">Siswa</a></li>
                    <li><a class="text-white font-bold" href="halaman_utama.php?page=jurusan">Jurusan</a></li>
                    <li><a class="text-white font-bold" href="halaman_utama.php?page=kategori_kegiatan">Kategori</a></li>
                    <li><a class="text-white font-bold" href="halaman_utama.php?page=sertifikat">Sertifikat</a></li>
                <?php
                } elseif ($_COOKIE['level_user'] == 'siswa') {
                ?>
                    <li><a class="text-white font-bold" href="halaman_utama.php?page=sertifikat_siswa">Sertifikat</a></li>
                <?php
                }
                ?>
                <li>
                    <details>
                        <summary class="text-white font-bold"><?= $_COOKIE['nama_lengkap'] ?></summary>
                        <ul class="bg-accent rounded-t-none p-2">
                            <?php if ($_COOKIE['level_user'] == 'operator') { ?>
                                <li>
                                    <a class="text-white font-bold" href="halaman_utama.php?page=ubah_pegawai&username=<?= $_COOKIE['username'] ?>">Edit Profil</a>
                                </li>
                            <?php } else { ?>
                                <li>
                                    <a class="text-white font-bold" href="halaman_utama.php?page=ubah_pass">Ganti Password</a>
                                </li>
                            <?php } ?>
                            <li>
                                <a class="text-white font-bold" href="../logout.php">Logout</a>
                            </li>
                        </ul>
                    </details>
                </li>
            </ul>
        </div>
    </div>

    <?php
    switch (@$_GET['page']) {
        case "siswa":
            include "siswa.php";
            break;
        case "tambah_siswa":
            include "../tambah/tambah_siswa.php";
            break;
        case "ubah_siswa":
            include "../ubah/ubah_siswa.php";
            break;
        case "jurusan":
            include "jurusan.php";
            break;
        case "tambah_jurusan":
            include "../tambah/tambah_jurusan.php";
            break;
        case "ubah_jurusan":
            include "../ubah/ubah_jurusan.php";
            break;
        case "tambah_pegawai":
            include "../tambah/tambah_pegawai.php";
            break;
        case "ubah_pegawai":
            include "../ubah/ubah_pegawai.php";
            break;
        case "ubah_pass":
            include "../ubah/ubah_pass_siswa.php";
            break;
        case "kategori_kegiatan":
            include "kategori_kegiatan.php";
            break;
        case "tambah_kegiatan":
            include "../tambah/tambah_kategori_kegiatan.php";
            break;
        case "ubah_kategori_kegiatan":
            include "../ubah/ubah_kategori_kegiatan.php";
            break;
        case "upload_sertifikat":
            include "../tambah/upload_sertifikat.php";
            break;
        case "sertifikat_siswa":
            include "sertifikat_siswa.php";
            break;
        case "sertifikat":
            include "sertifikat.php";
            break;
        case "cek_sertifikat":
            include "cek_sertifikat.php";
            break;
        case "cek_sertifikat_siswa":
            include "cek_sertifikat_siswa.php";
            break;


        default:
            if ($_COOKIE['level_user'] == 'operator') {
    ?>
                <div class="flex flex-wrap gap-4 mt-5 justify-center">
                    <!-- Siswa Card -->
                    <div class="card w-52 bg-white shadow-md p-4">
                        <div class="text-lg font-bold text-gray-700 border-b-4 border-accent pb-1">Siswa</div>
                        <div class="text-xl font-semibold text-gray-900 mt-2">
                            <?php
                            $siswa = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM siswa"))[0];
                            echo $siswa . " Siswa";
                            ?>
                        </div>
                    </div>

                    <!-- Jurusan Card -->
                    <div class="card w-52 bg-white shadow-md p-4">
                        <div class="text-lg font-bold text-gray-700 border-b-4 border-accent pb-1">Jurusan</div>
                        <div class="text-xl font-semibold text-gray-900 mt-2">
                            <?php
                            $jurusan = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM jurusan"))[0];
                            echo $jurusan . " Jurusan";
                            ?>
                        </div>
                    </div>

                    <!-- Kategori & Kegiatan Card -->
                    <div class="card w-52 bg-white shadow-md p-4">
                        <div class="text-lg font-bold text-gray-700 border-b-4 border-accent pb-1">Kategori</div>
                        <div class="text-xl font-semibold text-gray-900 mt-2">
                            <?php
                            $kategori = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM kategori"))[0];
                            echo $kategori . " Kategori ➡️ ";
                            $kegiatan = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM kegiatan"))[0];
                            echo $kegiatan . " Kegiatan";
                            ?>
                        </div>
                    </div>

                    <!-- Sertifikat Card -->
                    <div class="card w-52 bg-white shadow-md p-4">
                        <div class="text-lg font-bold text-gray-700 border-b-4 border-accent pb-1">Sertifikat</div>
                        <div class="text-xl font-semibold text-gray-900 mt-2">
                            <?php
                            $sertifikat = mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM sertifikat"))[0];
                            echo $sertifikat . " Sertifikat";
                            ?>
                        </div>
                    </div>
                </div>


    <?php
            } elseif ($_COOKIE['level_user'] == 'siswa') {
                include "sertifikat_siswa.php";
            }
            break;
    }
    ?>
</body>

</html>

<?php
mysqli_close($koneksi);
?>