<?php
class CompraEstadoTipo extends BaseDatos {
    private $idCompraEstadoTipo;
    private $cetDescripcion;
    private $cetDetalle;
    private $mensajeoperacion;


    public function __construct(){
        $this->idCompraEstadoTipo = "";
        $this->cetDescripcion = "";
        $this->cetDetalle = "";
    }


    public function setear($id,$descripcion,$detalle){
        $this->setIDCompraEstadoTipo($id);
        $this->setCetDescripcion($descripcion);
        $this->setCetDetalle($detalle);
    }

    public function getIDCompraEstadoTipo(){
        return $this->idCompraEstadoTipo;
    }
    public function setIDCompraEstadoTipo($valor){
        $this->idCompraEstadoTipo = $valor;
    }

    public function getCetDescripcion(){
        return $this->cetDescripcion;
    }
    public function setCetDescripcion($valor){
        $this->cetDescripcion = $valor;
    }

    public function getCetDetalle(){
        return $this->cetDetalle;
    }
    public function setCetDetalle($valor){
        $this->cetDetalle = $valor;
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
        $sql = "SELECT * FROM compraestadotipo WHERE idcompraestadotipo = '".$this->getIDCompraEstadoTipo()."'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();

                    $this->setear($row['idcompraestadotipo'], $row['cetdescripcion'],$row['cetdetalle']);
                    
                }
            }
        } else {
            $this->setmensajeoperacion("CompraEstadoTipo->listar: ".$base->getError());
        }
        return $resp;
    }



    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compraestadotipo(idcompraestadotipo,cetdescripcion,cetdetalle)  VALUES('".$this->getIDCompraEstadoTipo()."','".$this->getCetDescripcion()."','".$this->getCetDetalle()."');";
        if ($base->Iniciar()) {
            
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("CompraEstadoTipo->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("CompraEstadoTipo->insertar: ".$base->getError());
        }
        return $resp;
    }



    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="UPDATE compraestadotipo SET cetdescripcion='".$this->getCetDescripcion()."', cetdetalle='".$this->getCetDetalle()->getIDCompra()."' WHERE idcompraestadotipo='".$this->getIDCompraEstadoTipo()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Compraestadotipo->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Compraestadotipo->modificar: ".$base->getError());
        }
        return $resp;
    }



    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraestadotipo WHERE idcompraestadotipo='".$this->getIDCompraEstadoTipo()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("CompraEstadoTipo->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("CompraEstadoTipo->eliminar: ".$base->getError());
        }
        return $resp;
    }



    public static function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestadotipo ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new CompraEstadoTipo();
                   
                    $obj->setear($row['idcompraestadotipo'],$row['cetdescripcion'],$row['cetdetalle']);
                    array_push($arreglo, $obj);
                }
               
            }
            
        } else {
            //$this->setmensajeoperacion("CompraEstadoTipo->listar: ".$base->getError());
        }
 
        return $arreglo;
    }

}

?>