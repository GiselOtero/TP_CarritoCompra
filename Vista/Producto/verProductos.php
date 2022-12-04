<?php
include_once "../../configuracion.php";
include_once "../Estructura/headerS.php";

/* preguntar rol */
$urlActual = $_SERVER["PHP_SELF"];

if($objSession->tienePermiso($urlActual,$rolActual)){

    $datos = data_submitted();
    $abmProducto = new AbmProducto();
    $listaProductos = $abmProducto->buscar(null);

?>

    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Bootstrap Electrodomesticos</h1>
                <!-- <p class="lead fw-normal text-white-50 mb-0"></p> -->
            </div>
        </div>
    </header>
    <!-- mensaje -->
    <div id="resp" class="row float-left text-center" style="display:none">
        <div id="mensajeError" class="col-md-12 float-left alert alert-danger" role="alert" style="display:none">
        </div>
        <div id="mensajeBien" class="col-md-12 float-left alert alert-success" role="alert" style="display:none">
        </div>
    </div>
    <!-- Section-->
    <section class="py-5">
        <?php if(count($listaProductos)>0){ ?>
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php foreach($listaProductos as $unProducto){ ?>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-2">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?php echo $unProducto->getProNombre() ?></h5>
                                    <!-- Product price-->
                                    <span class="">&#36;<?php echo $unProducto->getProPrecio() ?></span>
                                    <p class="text-muted">Stock: <?php echo $unProducto->getProCantStock() ?></p>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer text-center m-auto p-2 pt-0 border-top-0 bg-transparent">
                                <form id="form-comprar" method="post">
                                    <input type="hidden" name="accion" id="accion" value="agregar">
                                    <input type="hidden" name="idproducto" id="idproducto" value="<?php echo $unProducto->getIDProducto();?>">
                                    <div class="mb-2">
                                        <input type="number" name="cicantidad" id="cicantidad" class="form-control my-auto"  min="0" max="<?php echo $unProducto->getProCantStock(); ?>" value= "1">
                                    </div>
                                    <div class=" mb-2">
                                        <?php if($unProducto->getProCantStock()<=0){
                                            ?>
                                            <button type="submit" class="btn btn-outline-dark mt-auto" disabled ><i class="fas fa-cart-plus"></i> Comprar </button>
                                            <?php
                                        }else {?>
                                        <button type="submit" class="btn btn-outline-dark mt-auto" ><i class="fas fa-cart-plus"></i> Comprar </button>
                                        <?php
                                        }?>
                                    </div>
                                    <!-- <input type="submit" class="btn btn-outline-dark mt-auto" value="A&ntilde;adir al carrito"> -->
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php }//fin 'foreach($listaProductos as $unProducto)' ?>
                </div>
                
            </div>
           
            <?php } //fin de if count ?>
    </section>

    <?php 
     }// fin de if tienePermiso 
      else{
        echo "<script>location.href = '../Login/PaginaSegura.php';</script>";
     }
    ?>

    
    
    
    <script type="text/javascript">
        $(document).ready(function(){ 
            console.log("Jquery");
            //no permite que el usuario ingrese otro numero
            $("input").keydown(function() {
                return false
            });
            
            
            $("form").submit(function(e){
                console.log("formulario");
                e.preventDefault();
                var $form = $(this);
                var url = $form.attr('action');
                var dato = $form.find('input');//obtiene todos los elementos hijos del formulario
                console.log($('#accion').val());
                console.log("idproducto: " + $('#idproducto').val());
                $.post(
                    '../Carrito/accionCarrito.php',
                    dato,
                    )
                    .done(function(respuesta){
                        console.log('respuestaaaa');
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
                    
            });
        });
    </script>
<?php
include_once "../Estructura/footer.php";
?>