<?php
class AbmUsuario{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

    

    public function accion($param){
        $resp = false;
        if($param['accion'] == 'editar'){
            if($this->modificacion($param)){
                $resp = true;
            }
        }
        if($param['accion'] == 'eliminar'){
            if($this->baja($param)){
                $resp =true;
            }
        }
        if($param['accion'] == 'nuevo'){
            if($this->alta($param)){
                $resp =true;
            }
            
        }
        return $resp;
    }


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Usuario
     */
    private function cargarObjeto($param){
        $obj = null;

        if( array_key_exists('idusuario',$param) and array_key_exists('usnombre',$param) and array_key_exists('uspass',$param) and array_key_exists('usmail',$param) and array_key_exists('usdeshabilitado',$param)){
            
            $obj = new Usuario();
            $obj->setear($param['idusuario'], $param['usnombre'],$param['uspass'],$param['usmail'],$param['usdeshabilitado']);
        }
        return $obj;
    }



    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Usuario
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if(isset($param['idusuario']) ){

            $obj = new Usuario();
            
            $obj->setear($param['idusuario'],null, null,null,null);
            
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
        
        if (isset($param['idusuario'])){

            $resp = true;
        }
        return $resp;
    }



    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;

        $param['idproducto'] = null; //con increment
        
        $objUsuario = $this->cargarObjeto($param);

        if ($objUsuario!=null and $objUsuario->insertar()){
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
            $objUsuario = $this->cargarObjetoConClave($param);
            //verEstructura($objUsuario);
            if ($objUsuario!=null and $objUsuario->eliminar()){
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
            $objUsuario = $this->cargarObjeto($param);
            //verEstructura($objUsuario);
            if($objUsuario != null and $objUsuario->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }


    public function deshabilitar($param){
        $resp = false;
        
        if ($this->seteadosCamposClaves($param)){
            $objUsuario = $this->cargarObjeto($param);
            //verEstructura($objUsuario);
            if($objUsuario != null and $objUsuario->deshabilitar()){
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
            if  (isset($param['usnombre']))
                 $where.=" and usnombre ='".$param['usnombre']."'";
            if  (isset($param['uspass']))
                $where.=" and uspass ='".$param['uspass']."'";
            if  (isset($param['usmail']))
                 $where.=" and usmail ='".$param['usmail']."'";
        }

        $arreglo = Usuario::listar($where);  
        return $arreglo;
    }



    
}
?>