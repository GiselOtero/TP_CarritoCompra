<?php
class AbmCompraEstado{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return CompraEstado
     */
    private function cargarObjeto($param){
        $obj = null;

        if( array_key_exists('idcompraestado',$param) and array_key_exists('idcompra',$param) and array_key_exists('idcompraestadotipo',$param) and array_key_exists('cefechaini',$param) and array_key_exists('cefechafin',$param)){
            
            $obj = new CompraEstado();

            $objCompra =  new Compra();
            $objCompra->setIDCompra($param['idcompra']);
            $objCompra->cargar();
            
            $objCompraEstadoTipo =  new CompraEstadoTipo();
            $objCompraEstadoTipo->setIDCompraEstadoTipo($param['idcompraestadotipo']);
            $objCompraEstadoTipo->cargar();

            $obj->setear($param['idcompraestado'],$objCompra,$objCompraEstadoTipo,$param['cefechaini'],$param['cefechafin']);
        }
        return $obj;
    }



    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return CompraEstado
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if(isset($param['idcompraestado']) ){

            $obj = new CompraEstado();
            
            $obj->setear($param['idcompraestado'],null, null,null,null);
            
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
        
        if (isset($param['idcompraestado'])){

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

        $param['idcompraestado'] = null;

        $objCompraEstado = $this->cargarObjeto($param);

        if ($objCompraEstado!=null and $objCompraEstado->insertar()){
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
            $objCompraEstado = $this->cargarObjetoConClave($param);
            //verEstructura($objCompraEstado);
            if ($objCompraEstado!=null and $objCompraEstado->eliminar()){
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
            $objCompraEstado = $this->cargarObjeto($param);
            //verEstructura($objCompraEstado);
            if($objCompraEstado != null and $objCompraEstado->modificar()){
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
            if  (isset($param['idcompraestado']))
                $where.=" and idcompraestado ='".$param['idcompraestado']."'";
            if  (isset($param['idcompra']))
                 $where.=" and idcompra ='".$param['idcompra']."'";
            if  (isset($param['idcompraestadotipo']))
                $where.=" and idcompraestadotipo ='".$param['idcompraestadotipo']."'";
            if  (isset($param['cefechaini']))
                 $where.=" and cefechaini ='".$param['cefechaini']."'";
        }

        $arreglo = CompraEstado::listar($where);  
        return $arreglo;
    }
}
?>