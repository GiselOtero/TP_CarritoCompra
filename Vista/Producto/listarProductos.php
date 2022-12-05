<?php
include_once "../../configuracion.php";

include_once "../Estructura/headerS.php";

$datos = data_submitted();
$abmProductos = new AbmProducto();
$listaProducto = $abmProductos->buscar(null);


$datos = data_submitted();
$mensaje = null;
if(isset($datos['mensaje'])){
    $mensaje = $datos['mensaje'];
}

if(count($listaProducto)>0){
?>

    <div class="row float-left text-center m-3">
        <div class="col-md-12 float-left">
            <?php 
            if($mensaje!=null) {
                echo $mensaje;
            }
                
            ?>
        </div>
    </div>
<table class="table table-striped table-hover ">
            <thead>
                <tr class="table-dark">
                    <th scope="col">ID Producto</th>
                    <th scope="col">Nombre Producto</th>
                    <th scope="col">Detalle</th>
                    <th scope="col">Stock</th>
                    <th scope="col">opcion</th>
                    
                </tr>
            </thead>

            <tbody>
<?php
    foreach($listaProducto as $unProducto){
        echo "<tr>";
        echo "<td>".$unProducto->getIDProducto()."</td>";
        echo "<td>".$unProducto->getProNombre()."</td>";
        echo "<td>".$unProducto->getProDetalle()."</td>";
        echo "<td>".$unProducto->getProCantStock()."</td>";
       
    ?>

        <td>
            <div class="btn-group">
                <a href="nuevoProducto.php?idproducto=<?php  echo $unProducto->getIDProducto()?>" class="btn btn-primary" aria-current="page">Editar</a>
                <a href="accionProducto.php?proaccion='eliminar'&idproducto=<?php  echo $unProducto->getIDProducto()?>" class="btn btn-danger">Eliminar</a>
            </div>
        </td>
    </tr>
    <?php 
    }//fin foreach
    ?>
    </tbody>
</table>
</div>
    <?php
} //fin if(count($listaProducto)>0){
?>


<?php

include_once "../Estructura/footer.php";

?>