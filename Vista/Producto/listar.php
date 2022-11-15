<?php
include_once ('../../configuracion.php');
$data = data_submitted();
$objControl = new AbmProducto();
$listaProducto = $objControl->buscar(null);
$arreglo_salida =  array();
foreach ($listaProducto as $unProducto ){
    
    $nuevoElem['idproducto'] = $unProducto->getIDProducto();
    $nuevoElem["pronombre"]=$unProducto->getProNombre();
    $nuevoElem["prodetalle"]=$unProducto->getProDetalle();
    $nuevoElem["procantstock"]=$unProducto->getProCantStock();
   
    array_push($arreglo_salida,$nuevoElem);
}
//verEstructura($arreglo_salida);
echo json_encode($arreglo_salida,null,2);

?>