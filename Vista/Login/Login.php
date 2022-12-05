<?php
include_once "../../configuracion.php";
include_once "../Estructura/header.php"; //llamar header inseguro?

$datos = data_submitted();
$mensaje = null;
/* if(isset($datos['mensaje'])){
    $mensaje = $datos['mensaje'];
} */
?>
<section class="py-5">
  <div class="container px-4 px-lg-5 mt-5">
    <div class="">
      <div class="card p-3 m-auto" style="width: 18rem;">
        <form method="post" name="form-login" id="form-login">
          <div class="mb-3">
            <label class="form-label" for="usnombre">Usuario</label>
            <div class="input-group mb-2 m-auto">
              <span class="input-group-text" id="icon"
              style="background-color: #fff; border-right: none">
              <i class="fas fa-user-alt"></i>
            </span>
            <input class="form-control" type="text" name="usnombre" id="usnombre" required  style="border-left: none" >
          </div>
          
          </div>
          <div class="mb-3">
            <label class="form-label" for="uspass">Contrase&ntilde;a</label>
            <div class="input-group mb-2 m-auto">
              <span class="input-group-text" id="iconPassword" style="background-color: #fff; border-right: none">
                <i class="fas fa-lock"></i>
              </span>
              <input class="form-control" type="password" name="uspass" id="uspass" required style="border-left: none">
            </div>
          </div>
          
          <div class="m-auto text-center">
            <input type="submit" value="Ingresar" class="btn btn-outline-success"">
          </div>
          <div>
            <!-- registar -->
          </div>
        </form>
      </div>
      
    </div>
    
    <div id='resp' class="justify-content-center align-items-center  mt-5"  style="display:none" >
      <!-- usuario y/o contraseña es incorrecto -->
      <div class='alert alert-danger w-25 mx-auto d-flex justify-content-center align-items-center  mt-5' role='alert'>
        usuario y/o contraseña es incorrecto
      </div>
    </div>
    
  </div>
</section>


<script  type="text/javascript">
    $(document).ready(function(){ 

      $('#form-login').submit(function(e){
        console.log("buuuuenas");
        e.preventDefault();
        
        const datos = {
          usnombre: $('#usnombre').val(),
          uspass: CryptoJS.MD5($('#uspass').val()).toString()
        };


        console.log($('#usnombre').val());
        $.post(
          'verificarLogin.php',
          datos,

        )
        .done(function(respuesta){
            console.log('respuestaaaaaaaaaaaaaaaaaaaaaaa');
            console.log(respuesta);
            var result = JSON.parse(respuesta);
            if(result.exito == "1"){
              console.log("exito");
              location.href = "PaginaSegura.php";
            }else{
              console.log("usuario o contraseña incorrecta");
              //$('#resp').html("usuario y/o contraseña es incorrecto");
              $('#resp').show('4000');
            }
            
          })
        .fail(function(){
          console.log("fallo el envio de datos");
        });
        
      });

  });

  function mostrarResp(respuesta){

      console.log("respuesta2");
      if(respuesta.exito == "1"){
        location.href = "../Producto/verProductos.php";
      }else{
        //$('#resp').html("usuario y/o contraseña es incorrecto");
        $('#resp').show('4000');
      }
  }

</script>

<?php
include_once "../Estructura/footer.php";
?>
