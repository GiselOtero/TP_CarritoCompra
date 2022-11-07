<?php header('Content-Type: text/html; charset=utf-8');
header ("Cache-Control: no-cache, must-revalidate ");

/////////////////////////////
// CONFIGURACION APP//
/////////////////////////////

$PROYECTO ='ProgramacionWebDinamica22/TP_CarritoCompra';
/* $PROYECTO ='PWD_2022'; */


//variable que almacena el directorio del proyecto
$ROOT =$_SERVER['DOCUMENT_ROOT']."/$PROYECTO/";

include_once($ROOT.'Utiles/funciones.php');

//include_once($ROOT.'Utiles/vendor/autoload.php');


// // variable que define la pagina principal del proyecto (menu principal)
$PRINCIPAL = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/Vista/index/index.php";


$_SESSION['ROOT']=$ROOT;

?>