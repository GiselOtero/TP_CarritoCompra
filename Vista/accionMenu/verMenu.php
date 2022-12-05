<?php
include_once "../../configuracion.php";

$objSession = new Session();

$datos = data_submitted();
$abmMenuRol = new AbmMenuRol();
$rol['idrol'] = $datos['idrol'];
$listar = $abmMenuRol->buscar($rol);

if(count($listar)>0){
    foreach ($listar as $unMenu){
        echo '<li class="nav-item">
        <a class="nav-link active" aria-current="page" href="../'.$unMenu->getMenu()->getMeDescripcion().'">'.$unMenu->getMenu()->getMeNombre().'</a>
      </li>';
    }
}

?>