<?php
session_start();
session_destroy();
setcookie("contador_cookie", "", time() - 3600);
header("Location: index.php");
exit;
?>
