<?php
include_once "../../configuracion.php";

include_once "../Estructura/headerS.php";

/* *********************** Preguntar Rol de admin deposito********************** */
/* solo puede ver el rol admin/deposito */
$urlActual = $_SERVER["PHP_SELF"];
if($objSession->tienePermiso($urlActual,$rolActual)){
    $param['idusuario'] = $objSession->getUsuario()->getIDUsuario();

?>
<?php 
$abmCompraEstado = new AbmCompraEstado();
$datos['idcompraestadotipo'] = '1'; 
$datos['cefechafin'] = '0000-00-00 00:00:00';
$listarCE = $abmCompraEstado ->buscarEstadoVigente(null);
if( count($listarCE) > 0 ){


?>

<!-- memsaje -->
<div id="resp" class="row float-left my-4" style="display:none">
    <div id="mensajeError" class="col-md-12 float-left alert alert-danger" role="alert" style="display:none">
      
    </div>
    <div id="mensajeBien" class="col-md-12 float-left alert alert-success" role="alert" style="display:none">

    </div>
</div>

<section class="py-5">
<div class="container px-4 px-lg-5 mt-5">

<table class="table text-center table-light table-hover">
  <thead >
    <tr class="text-center">
      <th scope="col">ID Compra Estado</th>
      <th scope="col">ID Compra </th>
      <th scope="col">Estado</th>
      <th scope="col">Fecha Inicio</th>
       <th scope="col">Fecha Fin</th>
       <th scope="col">--</th>
       
    </tr>

  </thead>
  <tbody>
<?php
  foreach($listarCE as $unaCompraEstado){ 
    $unaCompraET = $unaCompraEstado->getCompraEstadoTipo();
    echo "<tr>";
    echo "<td>".$unaCompraEstado->getIDCompraEstado()." </td>";
    echo "<td>".$unaCompraEstado->getCompra()->getIDCompra()." </td>";
    echo "<td>".$unaCompraET->getCetDescripcion()." </td>";
    echo "<td>".$unaCompraEstado->getCeFechaIni()." </td>";
    echo "<td>".$unaCompraEstado->getCeFechaFin()." </td>";

  ?>
    
    <td> 
      <div class="m-auto mb-2">
        <?php if($unaCompraET->getIDCompraEstadoTipo() == 1 && $unaCompraEstado->getCeFechaFin() == '0000-00-00 00:00:00' ) { ?>
         <form  method="post">
            <input type="hidden" name="idcompraestado" id="idcompraestado" value="<?php echo $unaCompraEstado->getIDCompraEstado(); ?>" >
            <input type="hidden" name="idcompra" id="idcompra" value="<?php echo $unaCompraEstado->getCompra()->getIDCompra(); ?>" >
            <input type="hidden" name="accion" id="accion" value="aceptar">
            <input type="submit" class="btn btn-primary" value="Aceptar Compra">
        </form>
        <?php }?>
        </div>
        <div class="m-auto">
        <?php if($unaCompraET->getIDCompraEstadoTipo() != 4 && $unaCompraEstado->getCeFechaFin() == '0000-00-00 00:00:00' ) { ?>

         <form  method="post">
            <input type="hidden" name="idcompraestado" id="idcompraestado" value="<?php echo $unaCompraEstado->getIDCompraEstado(); ?>" >
            <input type="hidden" name="idcompra" id="idcompra" value="<?php echo $unaCompraEstado->getCompra()->getIDCompra(); ?>" >
            <input type="hidden" name="idcompraestadotipo" id="idcompraestadotipo"  value="<?php echo $unaCompraET->getIDCompraEstadoTipo(); ?>" >
            <input type="hidden" name="accion" id="accion" value="cancelar">
            <input type="submit" class="btn btn-primary" value="Cancelar">
        </form>
        <?php }?>

        </div>

        <div class="m-auto">
        <?php if($unaCompraET->getIDCompraEstadoTipo() == 2 && $unaCompraEstado->getCeFechaFin() == '0000-00-00 00:00:00' ) { ?>

         <form  method="post">
            <input type="hidden" name="idcompraestado" id="idcompraestado" value="<?php echo $unaCompraEstado->getIDCompraEstado(); ?>" >
            <input type="hidden" name="idcompra" id="idcompra" value="<?php echo $unaCompraEstado->getCompra()->getIDCompra(); ?>" >
            <input type="hidden" name="idcompraestadotipo" id="idcompraestadotipo"  value="<?php echo $unaCompraET->getIDCompraEstadoTipo(); ?>">
            <input type="hidden" name="accion" id="accion" value="enviar">
            <input type="submit" class="btn btn-primary" value="Enviar">
        </form>
        <?php }?>

        </div>
      </td> 
  </tr>
    <?php } //fin foreach ?>

  </tbody>
</table>


<?php
    }//fin Lista ComprEstado
        else{
            
            echo '<div class="alert alert-primary text-center" role="alert">
            El Listado de compras se encuentra Vacio
      </div>
      ';
    }
?>
</div>
  </section>
<?php

}//fin permiso
else{

    include_once "../Login/PaginaSegura.php";
}

?>

<script type="text/javascript">
  console.log("javascript");
  $(document).ready(function(){

    console.log("jquery");
    
    $("form").submit(function(e){
            console.log("formulario Compras");
            e.preventDefault();
            //const datos = {
            //    accion: $('#accion').val(),
              //  idproducto: $('#idproducto').val(),
              //  cicantidad:$('#cicantidad').val(),
            //};
            var $form = $(this);
            var url = $form.attr('action');
            var dato = $form.find('input');//obtiene todos los elementos hijos del formulario
            console.log($('#accion').val());

            console.log("idcompraitem: " + $('#idcompraitem').val());

            $.post(
                'accionDeposito.php',
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

?>