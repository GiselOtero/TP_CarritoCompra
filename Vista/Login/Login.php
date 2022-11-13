<?php
include_once "../../configuracion.php";
include_once "../Estructura/header.php"; //llamar header inseguro?

$datos = data_submitted();
$mensaje = null;
if(isset($datos['mensaje'])){
    $mensaje = $datos['mensaje'];
}
?>

<div>
    <form action="verificarLogin.php" method="post" name="formularioLogin" id="formularioLogin">
        <div>
            <label for="usnombre">Nombre Usuario</label>
            <input type="text" name="usnombre" id="usnombre">
        </div>
        <div>
            <label for="uspass">Contrase&ntilde;a</label>
            <input type="text" name="uspass" id="uspass">
        </div>
        <div>

            <input type="submit" value="Ingresar">
        </div>
        <div>
            <!-- registar -->
        </div>
    </form>
    
    <div class="row float-left">
        <div class="col-md-12 float-left">
            <?php 
            if($mensaje!=null) {
                echo $mensaje;
            }
                
            ?>
        </div>
    </div>
</div>


<script>
    function formSubmit(){
        var password =  document.getElementById("uspass").value;
        //alert(password);
        var passhash = CryptoJS.MD5(password).toString();
        //alert(passhash);
        document.getElementById("uspass").value = passhash;
    
        setTimeout(function(){ 
            document.getElementById("formularioLogin").submit();
    
        }, 500);
    }
</script>

<?php
include_once "../Estructura/footer.php";
?>
