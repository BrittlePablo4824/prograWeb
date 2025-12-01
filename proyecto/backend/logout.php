<?php
//Ayuda al Usuario hacer logout.
session_start();
session_destroy();
header("Location: /proyecto/frontend/login.html");
exit;
