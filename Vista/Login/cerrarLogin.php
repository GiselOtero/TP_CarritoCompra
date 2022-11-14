<?php
include_once "../../configuracion.php";

$objSession = new Session();
$objSession->cerrar();
header("Status: 301 Moved Permanently");
header("Location: ../home/index.php");
?>