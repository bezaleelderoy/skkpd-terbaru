<?php
setcookie('username', '', time(), '/');
setcookie('level_user', '', time(), '/');
setcookie('nama_lengkap', '', time(), '/');
setcookie('nis', '', time(), '/');

echo "<script>alert('Berhasil Logout');window.location.href='login.php'</script>";
?>