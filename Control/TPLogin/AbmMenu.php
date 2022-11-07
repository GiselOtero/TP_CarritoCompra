<?php
class AbmMebu{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Menu
     */
    private function cargarObjeto($param){
        $obj = null;

        if( array_key_exists('idmenu',$param) and array_key_exists('menombre',$param) and array_key_exists('medescripcion',$param) and array_key_exists('medeshabilitado',$param)){
            
            $obj = new Menu();

            $objPadre = null;
            if(isset($param['idpadre']) && ($param['idpadre'] != null || $param['idpadre'] != '' )){
                $objPadre = new Menu;
                $objPadre->setIDMenu($row['idpadre']);
                $objPadre->cargar();
            }

            $obj->setear($param['idmenu'], $param['menombre'],$param['medescripcion'],$objPadre,$param['medeshabilitado']);
        }
        return $obj;
    }



    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Menu
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if(isset($param['idmenu']) ){

            $obj = new Menu();
            
            $obj->setear($param['idmenu'],null, null,null,null);
            
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
        
        if (isset($param['idmenu'])){

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
        $objMenu = $this->cargarObjeto($param);

        if ($objMenu!=null and $objMenu->insertar()){
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
            $objMenu = $this->cargarObjetoConClave($param);
            //verEstructura($objMenu);
            if ($objMenu!=null and $objMenu->eliminar()){
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
            $objMenu = $this->cargarObjeto($param);
            //verEstructura($objMenu);
            if($objMenu != null and $objMenu->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }



    public function deshabilitar($param){
        $resp = false;
        
        if ($this->seteadosCamposClaves($param)){
            $objMenu = $this->cargarObjeto($param);
            //verEstructura($objMenu);
            if($objMenu != null and $objMenu->deshabilitar()){
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
            if  (isset($param['idmenu']))
                $where.=" and idmenu ='".$param['idmenu']."'";
            if  (isset($param['menombre']))
                 $where.=" and menombre ='".$param['menombre']."'";
            if  (isset($param['medescripcion']))
                $where.=" and medescripcion ='".$param['medescripcion']."'";
            if  (isset($param['idpadre']))
                $where.=" and idpadre ='".$param['idpadre']."'";
            if  (isset($param['medeshabilitado']))
                 $where.=" and medeshabilitado ='".$param['medeshabilitado']."'";
        }

        $arreglo = Menu::listar($where);  
        return $arreglo;
    }
}
?>