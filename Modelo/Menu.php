<?php
class Menu extends BaseDatos {
    private $idMenu;
    private $meNombre;
    private $meDescripcion;//link
    private $objMenuPadre;
    private $meDeshabilitado;
    private $mensajeoperacion;

    public function __construct(){
        $this->idMenu = "";
        $this->meNombre = "";
        $this->meDescripcion = "";
        $this->objMenuPadre = null;
        $this->meDeshabilitado = "";
    }


    public function setear($id,$nombre,$descripcion,$menuPadre,$deshabilitado){
        $this->setIDMenu($id);
        $this->setMeNombre($nombre);
        $this->setMeDescripcion($descripcion);
        $this->setObjMenuPadre($menuPadre);
        $this->setMeDeshabilitado($deshabilitado);

    }


    public function getIDMenu(){
        return $this->idMenu;
    }
    public function setIDMenu($valor){
        $this->idMenu = $valor;
    }

    public function getMeNombre(){
        return $this->meNombre;
    }
    public function setMeNombre($valor){
        $this->meNombre = $valor;
    }

    public function getMeDescripcion(){
        return $this->meDescripcion;
    }
    public function setMeDescripcion($valor){
        $this->meDescripcion = $valor;
    }

    public function getObjMenuPadre(){
        return $this->objMenuPadre;
    }
    public function setObjMenuPadre($valor){
        $this->objMenuPadre = $valor;
    }

    public function getMeDeshabilitado(){
        return $this->meDeshabilitado;
    }
    public function setMeDeshabilitado($valor){
        $this->meDeshabilitado = $valor;
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
        $sql = "SELECT * FROM menu WHERE idmenu = '".$this->getIDMenu()."'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){

                    $row = $base->Registro();

                    $objPadre = null;
                    if($row['idpadre'] != 0 || $row['idpadre'] != null){
                        $objPadre = new Menu;
                        $objPadre->setIDMenu($row['idpadre']);
                        $objPadre->cargar();
                    }

                    $this->setear($row['idmenu'], $row['menombre'],$row['medescripcion'],$objPadre,$row['medeshabilitado']);
                    
                }
            }
        } else {
            $this->setmensajeoperacion("Menu->listar: ".$base->getError());
        }
        return $resp;
    }



    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql = "INSERT INTO menu(idmenu,menombre,medescripcion,idpadre,medeshabilitado)  VALUES('".$this->getIDmenu()."','".$this->getMeNombre()."','".$this->getMeDescripcion()."','".$this->getObjMenuPadre()->getIDMenu()."','".$this->getMeDeshabilitado()."');";
        if ($base->Iniciar()) {
            
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("menu->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("menu->insertar: ".$base->getError());
        }
        return $resp;
    }



    public function modificar(){
        $resp = false;
        $base = new BaseDatos();

        $idPadre = null;
        if($this->getObjMenuPadre() != null || $this->getObjMenuPadre() != ''){
            $idPadre = $this->getObjMenuPadre()->getIDMenu();
        }
        

        $sql="UPDATE menu SET menombre='".$this->getMeNombre()."', medescripcion='".$this->getMeDescripcion()."', idpadre='".$idPadre."', medeshabilitado='".$this->getMeDeshabilitado()."' WHERE idmenu='".$this->getIDMenu()."'";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Menu->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Menu->modificar: ".$base->getError());
        }
        return $resp;
    }



    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM menu WHERE idmenu='".$this->getIDMenu()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("Menu->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Menu->eliminar: ".$base->getError());
        }
        return $resp;
    }



    public static function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM menu ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new Menu();
                    
                    $objPadre = null;
                    if($row['idpadre'] != 0 || $row['idpadre'] != null){
                        $objPadre = new Menu;
                        $objPadre->setIDMenu($row['idpadre']);
                        $objPadre->cargar();
                    }

                    $obj->setear($row['idmenu'], $row['menombre'],$row['medescripcion'],$objPadre,$row['medeshabilitado']);
                    array_push($arreglo, $obj);
                }
               
            }
            
        } else {
            //$this->setmensajeoperacion("menu->listar: ".$base->getError());
        }
 
        return $arreglo;
    }


}
?>