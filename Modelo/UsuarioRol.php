<?php
class UsuarioRol extends BaseDatos{
    private $usuario;
    private $rol;
    private $mensajeoperacion;

    public function __construct(){
        $usuario = null;
        $rol = null;
    }


    public function setear($objUsuario,$objRol){
        $this->setUsuario($objUsuario);
        $this->setRol($objRol);
    }

    /*
    public function setear($objUsuario,$objRol){
        
        $this->setUsuario($objUsuario);
        $this->setRol($objRol);
    } 
     */

    public function getUsuario(){
        return $this->usuario;
    }
    public function setUsuario($valor){
        $this->usuario = $valor;
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
        $sql = "SELECT * FROM usuariorol WHERE idusuario='".$this->getUsuario()->getIDUsuario()."'  AND idrol='".$this->getRol()->getIDRol()."'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();

                    $unUsuario = new Usuario();
                    $unUsuario->setIDUsuario($row['idusuario']);
                    $unUsuario->cargar();

                    $unRol = new Rol();
                    $unRol->setIDRol($row['idrol']);
                    $unRol->cargar();

                    $this->setear($unUsuario,$unRol);
                    
                }
            }
        } else {
            $this->setmensajeoperacion("UsuarioRol->listar: ".$base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO usuariorol(idusuario,idrol)  VALUES('".$this->getUsuario()->getIDUsuario()."','".$this->getRol()->getIDRol()."');";
        if ($base->Iniciar()) {
            
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("UsuarioRol->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("UsuarioRol->insertar: ".$base->getError());
        }
        return $resp;
    }

    /* ???????? */
   /*  public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="UPDATE usuariorol SET idusuario='".$this->getUsuario()->getIDUsuario()."', idrol='".$this->getRol()->getIDRol()."' WHERE idusuario='".$this->getUsuario()->getIDUsuario()."'  AND idrol='".$this->getRol()->getIDRol()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("UsuarioRol->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("UsuarioRol->modificar: ".$base->getError());
        }
        return $resp;
    } */
    public function modificar(){
        $resp = false;
        return $resp;
    }


    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM usuariorol WHERE idusuario='".$this->getUsuario()->getIDUsuario()."'  AND idrol='".$this->getRol()->getIDRol()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("UsuarioRol->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("UsuarioRol->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuariorol ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $obj= new UsuarioRol();

                   

                    $unUsuario = new Usuario();
                    $unUsuario->setIDUsuario($row['idusuario']);
                    $unUsuario->cargar();

                    $unRol = new Rol();
                    $unRol->setIDRol($row['idrol']);
                    $unRol->cargar();

                    $obj->setear($unUsuario,$unRol);
                    array_push($arreglo,$obj);
                }
               
            }
            
        } else {
            //$this->setmensajeoperacion("UsuarioRol->listar: ".$base->getError());
        }
 
        return $arreglo;
    }

}
?>