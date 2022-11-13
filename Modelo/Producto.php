<?php
class Producto extends BaseDatos {
    private $idProducto;
    private $proNombre;
    private $proDetalle;
    private $proCantStock;
    private $mensajeoperacion;


    public function __construct(){
        $this->idProducto = "";
        $this->proNombre = "";
        $this->proDetalle = "";
        $this->proCantStock = "";
    }


    public function setear($id,$nombre,$detalle,$stock){
        $this->setIDProducto($id);
        $this->setProNombre($nombre);
        $this->setProDetalle($detalle);
        $this->setProCantStock($stock);
    }

    public function getIDProducto(){
        return $this->idProducto;
    }
    public function setIDProducto($valor){
        $this->idProducto = $valor;
    }

    public function getProNombre(){
        return $this->proNombre;
    }
    public function setProNombre($valor){
        $this->proNombre = $valor;
    }

    public function getProDetalle(){
        return $this->proDetalle;
    }
    public function setProDetalle($valor){
        $this->proDetalle = $valor;
    }

    public function getProCantStock(){
        return $this->proCantStock;
    }
    public function setProCantStock($valor){
        $this->proCantStock = $valor;
    }

    public function getmensajeoperacion(){
        return $this->mensajeoperacion;
    }
    public function setmensajeoperacion($valor){
        $this->mensajeoperacion = $valor;
    }



    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM producto WHERE idproducto = '".$this->getIDProducto()."'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();


                    $this->setear($row['idproducto'],$row['pronombre'] ,$row['prodetalle'], $row['procantstock']);
                    
                }
            }
        } else {
            $this->setmensajeoperacion("Producto->listar: ".$base->getError());
        }
        return $resp;
    }



    /* public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql = "INSERT INTO producto(idproducto,pronombre,prodetalle,procantstock)  VALUES('".$this->getIDProducto()."','".$this->getProNombre()."','".$this->getProDetalle()."','".$this->getProCantStock()."');";
        if ($base->Iniciar()) {
            
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Producto->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Producto->insertar: ".$base->getError());
        }
        return $resp;
    } */
    /* con autoincrement? */
    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql = "INSERT INTO producto(pronombre,prodetalle,procantstock)  VALUES('".$this->getProNombre()."','".$this->getProDetalle()."','".$this->getProCantStock()."');";
        if ($base->Iniciar()) {
            
            if ($id = $base->Ejecutar($sql)) {
                $this->setIDProducto($id);
                $resp = true;
            } else {
                $this->setmensajeoperacion("Producto->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Producto->insertar: ".$base->getError());
        }
        return $resp;
    }



    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="UPDATE producto SET pronombre='".$this->getProNombre()."', prodetalle='".$this->getProDetalle()."', procantstock='".$this->getCiCantidad()."' WHERE idProducto='".$this->getProCantStock()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Producto->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Producto->modificar: ".$base->getError());
        }
        return $resp;
    }



    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM producto WHERE idproducto='".$this->getIDProducto()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("Producto->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Producto->eliminar: ".$base->getError());
        }
        return $resp;
    }



    public static function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM producto ";
        if ($parametro!="") {
            $sql.=' WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new Producto();
                   
                    $obj->setear($row['idproducto'],$row['pronombre'],$row['prodetalle'],$row['procantstock']);
                    array_push($arreglo, $obj);
                }
               
            }
            
        } else {
            //$this->setmensajeoperacion("Producto->listar: ".$base->getError());
        }
 
        return $arreglo;
    }


}
?>