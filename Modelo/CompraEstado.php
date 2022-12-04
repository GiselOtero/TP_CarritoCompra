<?php
class CompraEstado extends BaseDatos {
    private $idCompraEstado;
    private $compra;
    private $compraEstadoTipo;
    private $ceFechaIni;
    private $ceFechaFin;
    private $mensajeoperacion;


    public function __construct(){
        $this->idCompraEstado = "";
        $this->compra = null;
        $this->compraEstadoTipo = null;
        $this->ceFechaIni = "";
        $this->ceFechaFin = "";
    }

    public function setear($id,$unaCompra,$unaCompraEstadoTipo,$fechaIni,$fechaFin){
        $this->setIDCompraEstado($id);
        $this->setCompra($unaCompra);
        $this->setCompraEstadoTipo($unaCompraEstadoTipo);
        $this->setCeFechaIni($fechaIni);
        $this->setCeFechaFin($fechaFin);
    }

    public function getIDCompraEstado(){
        return $this->idCompraEstado;
    }
    public function setIDCompraEstado($valor){
        $this->idCompraEstado = $valor;
    }

    public function getCompra(){
        return $this->compra;
    }
    public function setCompra($valor){
        $this->compra = $valor;
    }

    public function getCompraEstadoTipo(){
        return $this->compraEstadoTipo;
    }
    public function setCompraEstadoTipo($valor){
        $this->compraEstadoTipo = $valor;
    }

    public function getCeFechaIni(){
        return $this->ceFechaIni;
    }
    public function setCeFechaIni($valor){
        $this->ceFechaIni = $valor;
    }

    public function getCeFechaFin(){
        return $this->ceFechaFin;
    }
    public function setCeFechaFin($valor){
        $this->ceFechaFin = $valor;
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
        $sql = "SELECT * FROM compraestado WHERE idcompraestado = '".$this->getIDCompraEstado()."'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();

                    $objCompra =  new Compra();
                    $objCompra->setIDCompra($row['idcompra']);
                    $objCompra->cargar();

                    $objCompraEstadoTipo =  new CompraEstadoTipo();
                    $objCompraEstadoTipo->setIDCompraEstadoTipo($row['idcompraestadotipo']);
                    $objCompraEstadoTipo->cargar();

                    $this->setear($row['idcompraestado'],$objCompra ,$objCompraEstado, $row['cefechaini'],$row['cefechafin']);
                    
                }
            }
        } else {
            $this->setmensajeoperacion("compraestadotipo->listar: ".$base->getError());
        }
        return $resp;
    }



    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compraestado(idcompra,idcompraestadotipo,cefechaini,cefechafin)  VALUES('".$this->getCompra()->getIDCompra()."','".$this->getCompraEstadoTipo()->getIDCompraEstadoTipo()."','".$this->getCeFechaIni()."','".$this->getCeFechaFin()."');";
        if ($base->Iniciar()) {
            
            if ($id=$base->Ejecutar($sql)) {
                $this->setIDCompraEstado($id);
                $resp = true;
            } else {
                $this->setmensajeoperacion("CompraEstado->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("CompraEstado->insertar: ".$base->getError());
        }
        return $resp;
    }



    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="UPDATE compraestado SET idcompra='".$this->getCompra()->getIDCompra()."', idcompraestadotipo='".$this->getCompraEstadoTipo()->getIDCompraEstadoTipo()."', cefechaini='".$this->getCeFechaIni()."',cefechafin='".$this->getCeFechaFin()."' WHERE idcompraestado='".$this->getIDCompraEstado()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Compraestado->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Compraestado->modificar: ".$base->getError());
        }
        return $resp;
    }



    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraestado WHERE idcompraestado='".$this->getIDCompraEstado()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("CompraEstado->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("CompraEstado->eliminar: ".$base->getError());
        }
        return $resp;
    }



    public static function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestado ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj = new CompraEstado();
                   
                    $objCompra =  new Compra();
                    $objCompra->setIDCompra($row['idcompra']);
                    $objCompra->cargar();

                    $objCompraEstadoTipo =  new CompraEstadoTipo();
                    $objCompraEstadoTipo->setIDCompraEstadoTipo($row['idcompraestadotipo']);
                    $objCompraEstadoTipo->cargar();

                    $obj->setear($row['idcompraestado'],$objCompra,$objCompraEstadoTipo,$row['cefechaini'],$row['cefechafin']);
                    array_push($arreglo, $obj);
                }
               
            }
            
        } else {
            //$this->setmensajeoperacion("CompraEstado->listar: ".$base->getError());
        }
 
        return $arreglo;
    }


    

}
?>