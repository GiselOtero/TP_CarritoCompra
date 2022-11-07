<?php
class MenuRol extends BaseDatos {
    private $menu;
    private $rol;
    private $mensajeoperacion;

    public function __construct(){
        $this->menu = null;
        $this->rol = null;
    }

    public function getMenu(){
        return $this->menu;
    }
    public function setMenu($valor){
        $this->menu = $valor;
    }

    public function getRol(){
        return $this->rol;
    }
    public function setRol($valor){
        $this->rol = $valor;
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
        $sql = "SELECT * FROM menurol WHERE idmenu='".$this->getMenu()->getIDMenu()."'  AND idrol='".$this->getRol()->getIDRol()."'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();

                    $unMenu = new Menu();
                    $unMenu->setIDMenu($row['idmenu']);
                    $unMenu->cargar();

                    $unRol = new Rol();
                    $unRol->setIDRol($row['idrol']);
                    $unRol->cargar();

                    $this->setear($unMenu,$unRol);
                    
                }
            }
        } else {
            $this->setmensajeoperacion("MenuRol->listar: ".$base->getError());
        }
        return $resp;
    }



    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO menurol(idmenu,idrol)  VALUES('".$this->getMenu()->getIDMenu()."','".$this->getRol()->getIDRol()."');";
        if ($base->Iniciar()) {
            
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("MenuRol->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("MenuRol->insertar: ".$base->getError());
        }
        return $resp;
    }



    public function modificar(){
        $resp = false;
        return $resp;
    }



    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM usuario WHERE idusuario='".$this->getUsuario()->getIDUsuario()."'  AND idrol='".$this->getRol()->getIDRol()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("Usuario->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Usuario->eliminar: ".$base->getError());
        }
        return $resp;
    }



    public static function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM menurol ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new MenuRol();

                   

                    $unMenu = new Menu();
                    $unMenu->setIDMenu($row['idmenu']);
                    $unMenu->cargar();

                    $unRol = new Rol();
                    $unRol->setIDRol($row['idrol']);
                    $unRol->cargar();

                    $obj->setear($unMenu,$unRol);
                    array_push($arreglo,$obj);
                }
               
            }
            
        } else {
            //$this->setmensajeoperacion("MenuRol->listar: ".$base->getError());
        }
 
        return $arreglo;
    }

    
}
?>