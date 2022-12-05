<?php
include_once "../../configuracion.php";

$datos = data_submitted();

$objSession = new Session();

$respuesta = array(
    'exito' =>0,
);

if(!$objSession->validar()){
    if(isset($datos['usnombre']) and isset($datos['uspass']) ){

        $resp = $objSession->iniciar($datos['usnombre'],$datos['uspass']);

        if($objSession->validar()){
           
            $respuesta=array(
                'exito'=>1
            );
            
        }
    }

}

echo json_encode($respuesta);

?>