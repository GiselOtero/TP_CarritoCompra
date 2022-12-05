<?php
include_once "../../configuracion.php";
//include_once "../Estructura/headerS.php";



$datos = data_submitted();
/* +*****************+ preguntar rol +****************+ */

$objSession = new Session();
$objCarrito = new ControlCarrito();
$datos['idusuario'] = $objSession->getUsuario()->getIDUsuario();


$respuesta = array(
    'exito' => false,
    'mensaje' => 'La accion '.$datos['accion'].' no se realizo correctamente ',
);

if(isset($datos['accion'])){

    $resp = $objCarrito->accionDeposito($datos);
    if($resp){
        $respuesta = array(
            'exito' => true,
            'mensaje' => 'La accion '.$datos['accion'].'  se realizo correctamente',
        );
        
    }
 
}
echo json_encode($respuesta);

?>