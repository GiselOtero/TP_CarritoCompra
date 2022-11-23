<?php
include_once "../../configuracion.php";

$cantCarrito = 0;
$objSession = new Session();
if(!$objSession->validar()){
    $mensaje = "Inicie Sesion";
    echo "<script>location.href = '../Login/Login.php?mensaje=".$mensaje."';</script>";
    
    
}else{
    /*$unCarrito = new controlCarrito();
     if(count($unCarrito->getProductosCarrito())>0){
        $cantCarrito = count($unCarrito->getProductosCarrito());
    } */
    $cantCarrito = 0;
    if(count($objSession->verCarrito()) > 0){ 
        $cantCarrito = count($objSession->verCarrito());
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- bootstrap -->
    <link rel="stylesheet" href="../CSS/bootstrap-5.2.2/bootstrap.min.css">
    <!-- Fontawesone -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">

    <style>
        body .page-content {
            margin-top: 110px;
            /* background-color: #27292a; */
            padding: 60px;
            border-radius: 23px;
         }
    </style>

    <!-- ******************* -->
    <!-- JS validator -->
    <script src="../JS/validator.js" type="text/javascript"></script>
    <!-- JQuery easyui -->
    <link rel="stylesheet" type="text/css" href="../JS/jquery-easyui-1.6.6/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="../JS/jquery-easyui-1.6.6/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="../JS/jquery-easyui-1.6.6/themes/color.css">
    <link rel="stylesheet" type="text/css" href="../JS/jquery-easyui-1.6.6/demo/demo.css">
    <script type="text/javascript" src="../JS/jquery-easyui-1.6.6/jquery.min.js"></script>
    <script type="text/javascript" src="../JS/jquery-easyui-1.6.6/jquery.easyui.min.js"></script>

    <!-- ******************** -->

</head>
<body>

    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light  fixed-top">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!">Bootstrap</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                
    
    
                <!-- editar por Rol-->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="../ProductoB/verProductos.php">verProductos</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#!">All Products</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                            <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                        </ul>
                    </li>
                </ul>
    
    
    
                <div class="d-flex">
                    <div class="mx-3"><a href="../Carrito/verListaCarrito.php" class="btn btn-outline-primary"><i class="fas fa-shopping-cart"></i> <?php echo $cantCarrito ?></a></div>
                    <div class="mx-3"><a href="../Login/cerrarLogin.php" class="btn btn-outline-danger"><i class="fas fa-sign-out-alt"></i> Salir</a></div>
                </div>
            </div>
        </div>
    </nav>
    <main class="container m-3 py-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-content">

        


<?php } ?>
<!--     
</body>
</html> -->

