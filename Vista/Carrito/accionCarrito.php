<?php
include_once "../../configuracion.php";
//include_once "../Estructura/headerS.php";



$datos = data_submitted();
/* +*****************+ preguntar rol +****************+ */

$objSession = new Session();
$objCarrito = new ControlCarrito();
$datos['idusuario'] = $objSession->getUsuario()->getIDUsuario();



$objCEVigente = $objCarrito->buscarEstadoVigente($datos);
$id= $objCEVigente->getCompraEstadoTipo()->getIDCompraEstadoTipo();


$respuesta = array(
    'exito' => false,
    'mensaje' => 'La accion '.$datos['accion'].' no se realizo correctamente ',
);
/* $respuesta = array(
    'exito' => false,
    'mensaje' => 'La accion'.$datos['accion'].' no se realizo correctamente '.$datos['idproducto'],
); */
if(isset($datos['accion'])){

    $resp = $objCarrito->accionCliente($datos);
    if($resp){
        $respuesta = array(
            'exito' => true,
            'mensaje' => 'La accion '.$datos['accion'].'  se realizo correctamente',
        );
        
    }

    // header('Location: ../ProductoB/verProductos.php?mensaje='.$mensaje);

   
}
echo json_encode($respuesta);


/* echo json_encode(); */

//echo "<script>location.href = 'verListaCarrito.php?mensaje=".$mensaje."</script>";

?>