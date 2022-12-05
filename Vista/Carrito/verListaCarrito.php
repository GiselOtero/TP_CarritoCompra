<?php
include_once "../../configuracion.php";

include_once "../Estructura/headerS.php";

/* *********************** Preguntar Rol de usuario********************** */
/* solo puede ver el rol cliente */
$urlActual = $_SERVER["PHP_SELF"];
if($objSession->tienePermiso($urlActual,$rolActual)){ //editar, no se debe usar el rol actual en las paginas(?
  $param['idusuario'] = $objSession->getUsuario()->getIDUsuario();
  $arrayCarrito =$objCarrito->verCarrito($param);
  //Para Ver el Estado del Carrito
  $estadoVigente = $objCarrito->buscarEstadoVigente($param);
  $estadoTipo = $estadoVigente->getCompraEstadoTipo();
  //echo " estado Vigente= ".$estadoTipo."  idcompra= " .$estadoVigente->getCompra()->getIDCompra()."<br>";
?>
  <!-- mensaje -->
  <div id="resp" class="row float-left my-4 text-center" style="display:none">
      <div id="mensajeError" class="col-md-12 float-left alert alert-danger" role="alert" style="display:none">
          
  
      </div>
      <div id="mensajeBien" class="col-md-12 float-left alert alert-success" role="alert" style="display:none">
  
      </div>
  </div>
<section class="py-5">
<div class="container px-4 px-lg-5 mt-5">


<?php if( count($arrayCarrito) > 0){ ?>

<div id="Estado Carrito" class="col-md-12 float-left alert alert-primary" role="alert" >
  <?php 
    echo "Estado Actual del carrito: '".$estadoTipo->getCetDescripcion()."'"; 
    ?>

</div>

<table id="tabla" class="table text-center table-light">
  <thead >
    <tr class="text-center">
      <th scope="col">Producto</th>
      <th scope="col">Precio Unitario</th>
      <th scope="col">Cantidad</th>
      <th scope="col">--</th>
      <!--  <th scope="col">Precio total</th> -->
    </tr>

  </thead>
  <tbody>
<?php
  foreach($arrayCarrito as $unaCompraItem){ 
    $unProducto = $unaCompraItem->getProducto();
    echo "<tr>";
    echo "<td>".$unProducto->getProNombre()." </td>";
    echo "<td>&#36; ".$unProducto->getProPrecio()." </td>";
    echo "<td>".$unaCompraItem->getCiCantidad()." </td>";
  ?>
    
    <td> 
      <div>
      <?php if($estadoTipo->getIDCompraEstadoTipo() == 5){  ?>
         <form  method="post">
            <input type="hidden" name="idcompraitem" id="idcompraitem" value="<?php echo $unaCompraItem->getIDCompraItem(); ?>" >
            <input type="hidden" name="accion" id="accion" value="eliminar">
            <input type="submit" class="btn btn-outline-danger" value="eliminar">
        </form>
        <?php } ?>
        </div>
      </td> 
  </tr>
    <?php } //fin foreach ?>

  </tbody>
</table>

<div>
  <?php if($estadoTipo->getIDCompraEstadoTipo() == 5){
    ?>
  <form   method="post">
    <input type="hidden" name="accion" id="accion" value="iniciarcompra">
    <button type="submit" class="btn btn-outline-success">Iniciar Compra</button>
  </form>
  <?php } ?>
</div>

    <?php
      }else{  
        echo '<div class="alert alert-primary text-center" role="alert">
        El carrito se encuentra vacio
      </div>
      ';
      }
    ?>
    </div>
</section>
<?php
}//fin rol
else{
  echo "<script>location.href = '../Login/PaginaSegura.php';</script>";

}
?>
<?php?>

<script type="text/javascript">
  console.log("javascript");
  $(document).ready(function(){
    
    console.log("jquery");
    
    $("form").submit(function(e){
            console.log("formulario Carrito");
            e.preventDefault();
            
            var $form = $(this);
            //var url = $form.attr('action');
            var dato = $form.find('input');//obtiene todos los elementos hijos del formulario
            console.log($('#accion').val());

            console.log("idcompraitem: " + $('#idcompraitem').val());

            $.post(
                'accionCarrito.php',
                dato, 
            )
            .done(function(respuesta){
                console.log('respuestaaaaaaaaaaaaaaaaaaaaaaa');
                console.log(respuesta);
                var result = JSON.parse(respuesta);
                if(result.exito){
                  console.log("exito");
                  $('#resp').show('4000');
                  $('#mensajeBien').html(result.mensaje).css("display", "block");
                  //location.reload();
                }else{
                  console.log("mensaje error");
                  $('#resp').show('4000');
                  $('#mensajeError').html(result.mensaje).css("display", "block");
                }
                  
            })
            .fail(function(){
                console.log("fallo el envio de datos");
            });
        }

        );


    });


</script>


<?php
include_once "../Estructura/footer.php";
/*  <th> <?php echo $unaCompraItem->getProducto()->getProNombre(); ?> </th>
 <th> <?php echo $unaCompraItem->getCiCantidad(); ?> </th> */
?>