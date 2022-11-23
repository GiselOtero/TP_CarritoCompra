<?php
class Compra extends BaseDatos {
    private $idCompra;
    private $coFecha;
    private $usuario;
    private $mensajeoperacion;

    public function __construct(){
        $this->idCompra = "";
        $this->coFecha = "";
        $this->usuario = null;

    }


    public function setear($id,$fecha,$unUsuario){
        $this->setIDCompra($id);
        $this->setCofecha($fecha);
        $this->setUsuario($unUsuario);
    }

    public function getIDCompra(){
        return $this->idCompra;
    }
    public function setIDCompra($valor){
        $this->idCompra = $valor;
    }

    public function getCofecha(){
        return $this->coFecha;
    }
    public function setCofecha($valor){
        $this->coFecha = $valor;
    }

    public function getUsuario(){
        return $this->usuario;
    }
    public function setUsuario($valor){
        $this->usuario = $valor;
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
        $sql = "SELECT * FROM compra WHERE idcompra = '".$this->getIDCompra()."'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();

                    $objUsuario =  new Usuario();
                    $objUsuario->setIDUsuario($row['idusuario']);
                    $objUsuario->cargar();

                    $this->setear($row['idcompra'], $row['cofecha'],$objUsuario);
                    
                }
            }
        } else {
            $this->setmensajeoperacion("Compra->listar: ".$base->getError());
        }
        return $resp;
    }

    

    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql = "INSERT INTO compra(cofecha,idusuario)  VALUES('".$this->getCofecha()."','".$this->getUsuario()->getIDUsuario()."');";
        if ($base->Iniciar()) {
            
            if ($id = $base->Ejecutar($sql)) {
                $this->setIDCompra($id);
                $resp = true;
            } else {
                $this->setmensajeoperacion("Compra->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Compra->insertar: ".$base->getError());
        }
        return $resp;
    }



    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="UPDATE compra SET cofecha='".$this->getCofecha()."', idusuario='".$this->getUsuario()->getIDUsuario()."' WHERE idcompra='".$this->getIDCompra()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Compra->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Compra->modificar: ".$base->getError());
        }
        return $resp;
    }



    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compra WHERE idcompra='".$this->getIDCompra()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("Compra->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Compra->eliminar: ".$base->getError());
        }
        return $resp;
    }



    public static function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new Compra();
                    
                    $objUsuario = new Usuario();
                    $objUsuario->setIDUsuario($row['idusuario']);
                    $objUsuario->cargar();

                    $obj->setear($row['idcompra'], $row['cofecha'],$objUsuario);
                    array_push($arreglo, $obj);
                }
               
            }
            
        } else {
            //$this->setmensajeoperacion("Compra->listar: ".$base->getError());
        }
 
        return $arreglo;
    }

}
?>