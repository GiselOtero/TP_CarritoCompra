<?php
include_once "../../configuracion.php";

/* *********************** Preguntar Rol de usuario********************** */
/* $objSession = new Session(); */

include_once "../Estructura/headerSeguro.php";

$carrito = new controlCarrito();
/* $arrayCarrito = $objSession->verCarrito(); */

$datos['idcompra'] = 1;
$arrayCarrito = $carrito->colProductosCompra($datos);

?>

<?php
if(count($arrayCarrito) > 0){
    ?>


<table class="table text-center">
  <thead class="table-light">
    <tr class="text-center">
      <th scope="col">Producto</th>
      <th scope="col">Cantidad</th>
      <th scope="col">--</th>
      
      <!-- <th scope="col">Precio</th>
      <th scope="col">Precio total</th> -->
    </tr>

  </thead>
  <tbody>

    <?php
    /*  <th> <?php echo $unaCompraItem->getProducto()->getProNombre(); ?> </th>
     <th> <?php echo $unaCompraItem->getCiCantidad(); ?> </th> */
      foreach($arrayCarrito as $unaCompraItem){ 
        echo '<tr >';
        echo '<td>'.$unaCompraItem->getProducto()->getProNombre().' </td>';
        echo '<td> '.$unaCompraItem->getCiCantidad().' </td>';
        ?>
         <td> 
            <form action="accionCarrito.php" method="post">
              <input type="hidden" name="idproducto" id="idproducto" value="<?php echo $unaCompraItem->getProducto()->getIDProdcto(); ?>" >
              <input type="hidden" name="accion" id="accion" value="eliminar">
              
              <button type="button" class="btn btn-danger">Eliminar</button>

            </form>
          </td> 
        </tr>;
      <?php } //fin foreach ?>

  </tbody>
</table>

<div>
  <form action="../Compra/IniciarCompra.php"  method="post">
    <button type="submit" class="btn btn-success">Iniciar Compra</button>
  </form>
</div>

<?php
}else{

    echo "El carrito se encuentra Vacio";
}
?>
<?php?>

<?php
include_once "../Estructura/footer.php"
?>