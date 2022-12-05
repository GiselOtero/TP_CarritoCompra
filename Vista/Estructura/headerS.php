<?php
include_once "../../configuracion.php";

$cantCarrito = 0;
$objSession = new Session();
$objCarrito = new controlCarrito();
if(!$objSession->validar()){
    $mensaje = "Inicie Sesion";
    echo "<script>location.href = '../Login/Login.php';</script>";
    
    
}else{
    $abmMenuRol = new AbmMenuRol();
    $roles = $objSession->getRol();
    if(count($roles) == 1){
        $rolActual=$roles[0];
        $rol['idrol'] = $rolActual->getIDRol();
        $listarMenu = $abmMenuRol->buscar($rol);
        $esUnRol = true;
    }else{
        $esUnRol = false;
    }


?>
<!-- html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap</title>

    
    <!-- Fontawesone -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
    
        <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <!-- <link href="css/styles.css" rel="stylesheet" /> -->
    <link rel="stylesheet" href="../CSS/bootstrap-5.2.2/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/bootstrap-5.2.2/bootstrap.min.css.map">
    <!-- Bootstrap core JS-->
    <script src="../JS/bootstrap-5.2.2/bootstrap.min.js"></script>
    <script src="../JS/bootstrap-5.2.2/bootstrap.bundle.min.js"></script>
    <script src="../JS/bootstrap-5.2.2/bootstrap.bundle.min.js.map"></script>
    <script src="../JS/bootstrap-5.2.2/bootstrap.min.js.map"></script>


    <!-- jQuery -->
    <script src="../JS/Jquery-3.6.1/jquery-3.6.1.min.js" type="text/javascript"></script>
    
    <!-- MD5 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/core.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/md5.js"></script>

</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!">Bootstrap</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul id="listamenu" class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    
                    <!-- <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li> -->
                    
                    <?php 
                        if($esUnRol){
                            foreach ($listarMenu as $unMenu){
                                echo '<li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="../'.$unMenu->getMenu()->getMeDescripcion().'">'.$unMenu->getMenu()->getMeNombre().'</a>
                                </li>';
                                
                            }
                        }
                        ?>
                    
                </ul>
                
                <div class="d-flex">
                    <div class="mx-3">
                        <?php if ($esUnRol==false){?>
                            <form class="d-flex" method="post">
                                <select name="roles" id="roles" class="form-select">
                                     <option selected>Selecionar Rol</option>
                                    <?php
                                        if(count($roles)>=0){
                                            
                                            ?>
                                        
                                        <?php foreach($roles as $unRol ){  ?>
                                            <option value="<?php echo $unRol->getIDRol();?>"><?php echo $unRol->getRoDescripcion();?></option>
                                            
                                            <?php
                                            $rolActual=$unRol;
                                                } 
                                            }
                                        ?>
                                    </select>
                                </form>
                            <?php } ?>
                        </div>
                    <?php if($rolActual->getIDRol() == '3'){ 
                            $param['idusuario'] = $objSession->getUsuario()->getIDUsuario();
                            $cantCarrito = 0;
                            if(count($objCarrito->verCarrito($param)) > 0){ 
                                $cantCarrito = count($objCarrito->verCarrito($param));
                            } 
                        ?>

                        <div class="mx-3">
                            <a href="../Carrito/verListaCarrito.php" class="btn btn-outline-dark">
                             <i class="fas fa-shopping-cart"></i><span class="badge bg-dark text-white ms-1 rounded-pill" > <?php echo $cantCarrito ?> </span>
                            </a>
                        </div>
                    <?php } ?>
                        <div class="mx-3">
                            <a href="../Login/cerrarLogin.php" class="btn btn-outline-danger"><i class="fas fa-sign-out-alt">

                            </i> Salir</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

<?php } ?>



<script type="text/javascript">
$(document).ready(function(){

  $('#roles').change(function(){
    console.log("elegir rol");

    var idrol = $(this).val();
    console.log("rol seleccionado: "+idrol);

    if(idrol.length > 0){
      $.ajax({
        url:'../accionMenu/verMenu.php',
        type: 'POST',
        dataType:'html',
        data:{idrol:idrol},
      }).done(function(data){
        $('#listamenu').html(data);
      });
    }

  });

});
</script>