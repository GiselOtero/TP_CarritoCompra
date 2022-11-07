<?php
class AbmCompra{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Compra
     */
    private function cargarObjeto($param){
        $obj = null;

        if( array_key_exists('idcompra',$param) and array_key_exists('cofecha',$param) and array_key_exists('idusuario',$param)){
            
            $obj = new Compra();
            
            $objUsuario = new Usuario();
            $objUsuario->setIDUsuario($param['idusuario']);
            $objUsuario->cargar();

            $obj->setear($param['idcompra'], $param['cofecha'],$objUsuario,$param['procantstock']);
        }
        return $obj;
    }



    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Compra
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if(isset($param['idcompra']) ){

            $obj = new Compra();
            
            $obj->setear($param['idcompra'],null, null);
            
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
        
        if (isset($param['idcompra'])){

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
        $objCompra = $this->cargarObjeto($param);

        if ($objCompra!=null and $objCompra->insertar()){
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
            $objCompra = $this->cargarObjetoConClave($param);
            //verEstructura($objCompra);
            if ($objCompra!=null and $objCompra->eliminar()){
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
            $objCompra = $this->cargarObjeto($param);
            //verEstructura($objCompra);
            if($objCompra != null and $objCompra->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }



    public function deshabilitar($param){
        $resp = false;
        
        if ($this->seteadosCamposClaves($param)){
            $objCompra = $this->cargarObjeto($param);
            //verEstructura($objCompra);
            if($objCompra != null and $objCompra->deshabilitar()){
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
            if  (isset($param['idcompra']))
                $where.=" and idcompra ='".$param['idcompra']."'";
            if  (isset($param['cofecha']))
                 $where.=" and cofecha ='".$param['cofecha']."'";
            if  (isset($param['idusuario']))
                $where.=" and idusuario ='".$param['idusuario']."'";
            
        }

        $arreglo = Compra::listar($where);  
        return $arreglo;
    }
}
?>