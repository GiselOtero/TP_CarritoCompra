<?php
include_once "../../configuracion.php";

$datos = data_submitted();

$objSession = new Session();

$respuesta = array(
    'exito' =>false,
    'mensaje' =>''
);

if(!$objSession->validar()){
    
    $esValido = $objSession->iniciar($datos['usnombre'],$datos['uspass']);
    if($esValido){
        echo "<script>location.href = '../Producto/verProductos.php';</script>" ;
    }else{
        $mensaje = " El usuario o contraseña es invalido ";
        echo "<script>location.href = 'login.php?mensaje=".$mensaje."';</script>";
    }

}else{

}

?>