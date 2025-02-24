<?php
include "../koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>
    <style>
    .nav-menu,
    .user-menu {
        list-style: none;
        display: flex
    }

    .nav-menu a,
    .user-menu a {
        text-decoration: none;
        color: #fff;
        transition: .3s
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box
    }

    body {
        font-family: Arial, sans-serif
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #000;
        color: #fff;
        padding: 15px 50px;
        position: sticky;
        top: 0;
        width: 100%;
        z-index: 1000
    }

    .navbar h2 {
        margin: 0;
        font-size: 24px
    }

    .nav-menu {
        gap: 20px
    }

    .nav-menu li,
    .user-menu li {
        display: inline
    }

    .nav-menu a {
        font-size: 18px;
        padding: 8px 12px;
        border: 1px solid #fff
    }

    .nav-menu a:hover,
    .user-menu a:hover {
        background: #555;
        border-radius: 5px
    }

    .user-menu {
        gap: 10px
    }

    .user-menu a {
        font-size: 16px;
        padding: 5px 10px;
        border: 1px solid #fff
    }

    .logout a {
        color: red
    }
    </style>
</head>

<body>

    <!-- Navbar -->
    <div class="navbar">
        <h2>SKKPd</h2>
        <nav>
            <ul class="nav-menu">
                <?php
                if ($_COOKIE['level_user'] == 'operator') {
                ?>
                <li><a href="halaman_utama.php?page=siswa">Siswa</a></li>
                <li><a href="halaman_utama.php?page=jurusan">Jurusan</a></li>
                <li><a href="halaman_utama.php?page=kategori_kegiatan">Kategori</a></li>
                <li><a href="halaman_utama.php?page=sertifikat">Sertifikat</a></li>
                <?php
                } elseif ($_COOKIE['level_user'] == 'siswa') {
                ?>
                <li><a href="halaman_utama.php?page=upload_sertifikat">Sertifikat</a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
        <div>
            <span><?=$_COOKIE['nama_lengkap']?></span>
            <ul class="user-menu">
                <?php
                if ($_COOKIE['level_user'] == 'operator') {
                ?>
                <li><a href="halaman_utama.php?page=ubah_pegawai&username=<?=$_COOKIE['username']?>">Edit Profil</a>
                </li>
                <?php
                } else {
                ?>
                <li><a href="halaman_utama.php?page=ubah_pass">Ganti Password</a></li>
                <?php
                }
                ?>
                <li class="logout"><a href="../logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
    <br><br>
    <!-- Navbar -->

    <?php
    switch ($_GET['page']) {
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
        case "sertifikat":
            include "sertifikat.php";
            break;
    }
    ?>

</body>

</html>

<?php
mysqli_close($koneksi);
?>