<?php
include_once "../../configuracion.php";

$datos = data_submitted();


include_once "../Estructura/headerSeguro.php";
/* +*****************+ preguntar rol +****************+ */

$carrito = new controlCarrito();


$datos['compra'] = $objSession->getCompra();
$datos['compraestado'] = $objSession->getCompraEstado();

if($datos['accion']=='agregar'){

    $repuesta = $carrito->accionAgregar($datos);
    
    $mensaje = null;
    if(!$repuesta['exito']){
        $mensaje = $repuesta['mensaje'];
    }

    header('Location: ../ProductoB/verProductos.php?mensaje='.$mensaje);


}

if($datos['accion']=='eliminar'){
    $unCarrito->accionEliminarProducto($datos);
    header('Location: ../Carrito/verListaCarrito.php');

}


/* echo "<script>location.href = '../ProductoB/verProductos.php?mensaje='".$mensaje."';</script>"; */

?>