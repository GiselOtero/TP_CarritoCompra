<?php
class CompraItem extends BaseDatos {
    private $idCompraItem;
    private $producto;
    private $compra;
    private $ciCantidad;
    private $mensajeoperacion;

    public function __construct(){
        $this->idCompraItem = "";
        $this->producto = null;
        $this->compra = null;
        $this->ciCantidad = "";
    }

    public function setear($id,$unProducto,$unaCompra,$cantProd){
        $this->setIDCompraItem($id);
        $this->setProducto($unProducto);
        $this->setCompra($unaCompra);
        $this->setCiCantidad($cantProd);
    }

    public function getIDCompraItem(){
        return $this->idCompraItem;
    }
    public function setIDCompraItem($valor){
        $this->idCompraItem = $valor;
    }

    public function getProducto(){
        return $this->producto;
    }
    public function setProducto($valor){
        $this->producto = $valor;
    }

    public function getCompra(){
        return $this->compra;
    }
    public function setCompra($valor){
        $this->compra = $valor;
    }

    public function getCiCantidad(){
        return $this->ciCantidad;
    }
    public function setCiCantidad($valor){
        $this->ciCantidad = $valor;
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
        $sql = "SELECT * FROM compraitem WHERE idcompraitem = '".$this->getIDCompraItem()."'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();

                    $objProducto = new Producto;
                    $objProducto->setIDProducto($row['idproducto']);
                    $objProducto->cargar();

                    $objCompra =  new Compra();
                    $objCompra->setIDCompra($row['idcompra']);
                    $objCompra->cargar();

                    $this->setear($row['idcompraitem'],$objProducto ,$objCompra, $row['cicantidad']);
                    
                }
            }
        } else {
            $this->setmensajeoperacion("CompraItem->listar: ".$base->getError());
        }
        return $resp;
    }



    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql = "INSERT INTO compraitem(idcompra,idproducto,cicantidad)  VALUES('".$this->getCompra()->getIDCompra()."','".$this->getProducto()->getIDProducto()."','".$this->getCiCantidad()."');";
        if ($base->Iniciar()) {
            
            if ($id = $base->Ejecutar($sql)) {
                $this->setIDCompraItem($id);
                $resp = true;
            } else {
                $this->setmensajeoperacion("CompraItem->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("CompraItem->insertar: ".$base->getError());
        }
        return $resp;
    }



    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="UPDATE compraitem SET idproducto='".$this->getProducto()->getIDProducto()."', idcompra='".$this->getCompra()->getIDCompra()."', cicantidad='".$this->getCiCantidad()."' WHERE idcompraitem='".$this->getIDCompraItem()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("CompraItem->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("CompraItem->modificar: ".$base->getError());
        }
        return $resp;
    }



    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraitem WHERE idcompraitem='".$this->getIDCompraItem()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("CompraItem->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("CompraItem->eliminar: ".$base->getError());
        }
        return $resp;
    }



    public static function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraitem ";
        if ($parametro!="") {
            $sql.=' WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj = new CompraItem();
                    
                    $objProducto = new Producto();
                    $objProducto->setIDProducto($row['idproducto']);
                    $objProducto->cargar();

                    $objCompra =  new Compra();
                    $objCompra->setIDCompra($row['idcompra']);
                    $objCompra->cargar();

                    $obj->setear($row['idcompraitem'],$objProducto,$objCompra,$row['cicantidad']);
                    
                    array_push($arreglo, $obj);
                }
               
            }
            
        } else {
            //$this->setmensajeoperacion("CompraItem->listar: ".$base->getError());
        }
 
        return $arreglo;
    }

}
?>