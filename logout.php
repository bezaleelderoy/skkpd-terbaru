<?php
setcookie('username', '', time(), '/');
setcookie('level_user', '', time(), '/');
setcookie('nama_lengkap', '', time(), '/');
setcookie('nis', '', time(), '/');
setcookie('angkatan', '', time(), '/');
setcookie('status', '', time(), '/');
echo "<script>alert('Berhasil Logout');window.location.href='login.php'</script>";
?>