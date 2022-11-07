<?php
class AbmRol{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Rol
     */
    private function cargarObjeto($param){
        $obj = null;

        if( array_key_exists('idrol',$param) and array_key_exists('rodescripcion',$param) ){
            
            $obj = new Rol();
            $obj->setear($param['idrol'], $param['rodescripcion']);
        }
        return $obj;
    }


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Rol
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if(isset($param['idrol']) ){

            $obj = new Rol();
            
            $obj->setear($param['idrol'],null);
            
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

        if (isset($param['idrol']))
            $resp = true;
        return $resp;
    }



    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $objRol = $this->cargarObjeto($param);

        if ($objRol!=null and $objRol->insertar()){
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
            $objRol = $this->cargarObjetoConClave($param);
            //verEstructura($objRol);
            if ($objRol!=null and $objRol->eliminar()){
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
            $objRol = $this->cargarObjeto($param);
            //verEstructura($objRol);
            if($objRol != null and $objRol->modificar()){
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
            if  (isset($param['idrol']))
                $where.=" and idrol ='".$param['idrol']."'";
            if  (isset($param['rodescripcion']))
                 $where.=" and rodescripcion ='".$param['rodescripcion']."'";
            
        }

        $arreglo = Rol::listar($where);  
        return $arreglo;
    }

}

?>