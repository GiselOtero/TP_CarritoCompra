<?php
class Usuario extends BaseDatos{

    private $idUsuario;
    private $usNombre;
    private $usPass;
    private $usMail;
    private $usDeshabilitado;
    private $colRoles;
    private $mensajeoperacion;


    public function __construct(){
        $this->idUsuario="";
        $this->usNombre="";
        $this->usMail="";
        $this->usDeshabilitado="";
    }


    public function setear($id,$nombre,$pass,$mail,$deshabilitado){
        $this->setIDUsuario($id);
        $this->setUsNombre($nombre);
        $this->setUsPass($pass);
        $this->setUsMail($mail);
        $this->setUsDeshabilitado($deshabilitado);
        
    }

    public function getIDUsuario(){
        return $this->idUsuario;
    }
    public function setIDUsuario($valor){
        $this->idUsuario=$valor;
    }

    public function getUsNombre(){
        return $this->usNombre;
    }
    public function setUsNombre($valor){
        $this->usNombre=$valor;
    }

    public function getUsPass(){
        return $this->usPass;
    }
    public function setUsPass($valor){
        $this->usPass=$valor;
    }

    public function getUsMail(){
        return $this->usMail;
    }
    public function setUsMail($valor){
        $this->usMail=$valor;
    }

    public function getUsDeshabilitado(){
        return $this->usDeshabilitado;
    }
    public function setUsDeshabilitado($valor){
        $this->usDeshabilitado=$valor;
    }

    public function getcolRol(){
        return $this->colRol;
    }
    public function setcolRol($valor){
        $this->colRol=$valor;
    }

    public function getmensajeoperacion(){
        return $this->mensajeoperacion;
    }
    public function setmensajeoperacion($valor){
        $this->mensajeoperacion=$valor;
    }


    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuario WHERE idusuario = '".$this->getIDUsuario()."'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){

                    $row = $base->Registro();
                    $this->setear($row['idusuario'], $row['usnombre'],$row['uspass'],$row['usmail'],$row['usdeshabilitado']);
                    
                }
            }
        } else {
            $this->setmensajeoperacion("Usuario->listar: ".$base->getError());
        }
        return $resp;
    }


    /* public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql = "INSERT INTO usuario(idusuario,usnombre,uspass,usmail,usdeshabilitado)  VALUES('".$this->getIDUsuario()."','".$this->getUsNombre()."','".$this->getUsPass()."','".$this->getUsMail()."','".$this->getUsDeshabilitado()."');";
        if ($base->Iniciar()) {
            
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Usuario->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Usuario->insertar: ".$base->getError());
        }
        return $resp;
    } */

    /* con autoincrement? */
    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql = "INSERT INTO usuario(usnombre,uspass,usmail,usdeshabilitado)  VALUES('".$this->getUsNombre()."','".$this->getUsPass()."','".$this->getUsMail()."','".$this->getUsDeshabilitado()."');";
        if ($base->Iniciar()) {
            
            if ($id = $base->Ejecutar($sql)) {
                $this->setIDUsuario($id);
                $resp = true;
            } else {
                $this->setmensajeoperacion("Usuario->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Usuario->insertar: ".$base->getError());
        }
        return $resp;
    }



    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql="UPDATE usuario SET usnombre='".$this->getUsNombre()."', uspass='".$this->getUsPass()."', usmail='".$this->getUsMail()."', usdeshabilitado='".$this->getUsDeshabilitado()."' WHERE idusuario='".$this->getIDUsuario()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Usuario->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Usuario->modificar: ".$base->getError());
        }
        return $resp;
    }



    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM usuario WHERE idusuario='".$this->getIDUsuario()."'";
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
        $sql = "SELECT * FROM usuario ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){

                    $obj= new Usuario();
                    
                    $obj->setear($row['idusuario'], $row['usnombre'],$row['uspass'],$row['usmail'],$row['usdeshabilitado']);
                    array_push($arreglo, $obj);
                }
               
            }
            
        } else {
            //$this->setmensajeoperacion("Usuario->listar: ".$base->getError());
        }
 
        return $arreglo;
    }


    public function esDeshabilitado(){
        $resp = true;
        if($this->getUsDeshabilitado() == NULL || $this->getUsDeshabilitado() == "0000-00-00 00:00:00"){
            $resp = false;
        }
        return $resp;
    }


    public function deshabilitar(){
        $unaFecha = date("Y-m-d h:i:sa");
        //echo $unaFecha;
        $this->setUsDeshabilitado($unaFecha);
        $resp=$this->modificar();

        return $resp;
    }
}

?>