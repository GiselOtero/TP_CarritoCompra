<?php
class AbmMenuRol{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return MenuRol
     */
    private function cargarObjeto($param){
        $obj = null;
        if( array_key_exists('idmenu',$param) and array_key_exists('idrol',$param) ){
            
            $obj = new MenuRol();

            $unMenu = new Menu();
            $unMenu->setIDMenu($param['idmenu']);
            $unMenu->cargar();

            $unRol = new Rol();
            $unRol->setIDRol($param['idrol']);
            $unRol->cargar();

            $obj->setear($unMenu,$unRol);
        }
        return $obj;
    }

    /* 
    private function cargarObjeto($param){
        $obj = null;
        if( array_key_exists('idmenu',$param) and array_key_exists('idrol',$param) ){

            $obj = new MenuRol();

            $unMenu = AbmMenu::cargarObjetoConClave($param);
            $unRol = AbmRol::cargarObjetoConClave($param);
            
            $obj->setear($unMenu,$unRol);
        }
        return $obj;
    }
    */



   /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return MenuRol
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if(isset($param['idmenu']) AND isset($param['idrol']) ){

            $obj = new MenuRol();
            
            $unMenu = new Menu();
            $unMenu->setIDMenu($param['idmenu']);
            $unMenu->cargar();

            $unRol = new Rol();
            $unRol->setIDRol($param['idrol']);
            $unRol->cargar();

            $obj->setear($unMenu,$unRol);
            
        }
        return $obj;
    }


    /* 
    private function cargarObjetoConClave($param){
        $obj = null;
        if( array_key_exists('idmenu',$param) and array_key_exists('idrol',$param) ){

            $obj = new MenuRol();

            $unMenu = AbmMenu::cargarObjetoConClave($param);
            $unRol = AbmRol::cargarObjetoConClave($param);
            
            $obj->setear($unMenu,$unRol);
        }
        return $obj;
    }
    */



    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param){
        $resp = false;

        if (isset($param['idmenu']) AND isset($param['idrol']))
            $resp = true;
        return $resp;
    }



    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $objMenuRol = $this->cargarObjeto($param);

        if ($objMenuRol!=null and $objMenuRol->insertar()){
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
            $objMenuRol = $this->cargarObjetoConClave($param);
            //verEstructura($objMenuRol);
            if ($objMenuRol!=null and $objMenuRol->eliminar()){
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
            $objMenuRol = $this->cargarObjeto($param);
            //verEstructura($objMenuRol);
            if($objMenuRol != null and $objMenuRol->modificar()){
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
            if  (isset($param['idrol']))
                 $where.=" and idrol ='".$param['idrol']."'";
        }

        $arreglo = MenuRol::listar($where);  
        return $arreglo;
    }

}
?>