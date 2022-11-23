<?php
class AbmUsuarioRol{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return UsuarioRol
     */
    private function cargarObjeto($param){
        $obj = null;
        if( array_key_exists('idusuario',$param) and array_key_exists('idrol',$param) ){
            
            $obj = new UsuarioRol();

            $unUsuario = new Usuario();
            $unUsuario->setIDUsuario($param['idusuario']);
            $unUsuario->cargar();

            $unRol = new Rol();
            $unRol->setIDRol($param['idrol']);
            $unRol->cargar();

            $obj->setear($unUsuario,$unRol);
        }
        return $obj;
    }

    /* 
    private function cargarObjeto($param){
        $obj = null;
        if( array_key_exists('idusuario',$param) and array_key_exists('idrol',$param) ){

            $obj = new UsuarioRol();

            $unUsuario = AbmUsuario::cargarObjetoConClave($param);
            $unRol = AbmRol::cargarObjetoConClave($param);
            
            $obj->setear($unUsuario,$unRol);
        }
        return $obj;
    }
    */


   /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return UsuarioRol
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if(isset($param['idusuario']) AND isset($param['idrol']) ){

            $obj = new UsuarioRol();

            $unUsuario = new Usuario();
            $unUsuario->setIDMenu($param['idusuario']);
            $unUsuario->cargar();

            $unRol = new Rol();
            $unRol->setIDRol($param['idrol']);
            $unRol->cargar();
            
            $obj->setear($unUsuario,$unRol);
            
        }
        return $obj;
    }



    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param){
        $resp = false;

        if (isset($param['idusuario']) AND isset($param['idrol']))
            $resp = true;
        return $resp;
    }



    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $objUsuarioRol = $this->cargarObjeto($param);

        if ($objUsuarioRol!=null and $objUsuarioRol->insertar()){
            $resp = true;
        }
        return $resp;  
    }



    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        
        if ($this->seteadosCamposClaves($param)){
            $objUsuarioRol = $this->cargarObjetoConClave($param);
            //verEstructura($objUsuarioRol);
            if ($objUsuarioRol!=null and $objUsuarioRol->eliminar()){
                $resp = true;
            }
        }
        
        return $resp;
    }



    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        $resp = false;
        
        if ($this->seteadosCamposClaves($param)){
            $objUsuarioRol = $this->cargarObjeto($param);
            //verEstructura($objUsuarioRol);
            if($objUsuarioRol != null and $objUsuarioRol->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }



    /**
     * permite buscar un objeto
     * @param array $param
     * @return boolean
     */
    public function buscar($param){
        $where = " true ";

        if ($param<>NULL){
            if  (isset($param['idusuario']))
                $where.=" and idusuario ='".$param['idusuario']."'";
            if  (isset($param['idrol']))
                 $where.=" and idrol ='".$param['idrol']."'";
        }

        $arreglo = UsuarioRol::listar($where);  
        return $arreglo;
    }

}
?>