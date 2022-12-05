<?php
include_once "../../configuracion.php";

include_once "../Estructura/headerS.php";

/* preguntar rol */

$datos = data_submitted();
?>

<div class="text-center">
    <p class="display-1 fw-bold">Bienvenid@ <?php echo $objSession->getUsuario()->getUsNombre() ?></p>
</div>
<?php
include_once "../Estructura/footer.php";

?>
