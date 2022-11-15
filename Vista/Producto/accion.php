<?php
include_once "../../configuracion.php";

$datos = data_submitted();

$abmProducto = new Producto();

if(isset($datos['accion'])){
    $respuesta = $abmProducto->accion($datos);
    if(!$respuesta){
        $mensaje = " La accion".$datos['accion']."Producto no pudo concretarse";
    }
}



$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
   
    $retorno['errorMsg']=$mensaje;

}
    echo json_encode($retorno);
?>

?>