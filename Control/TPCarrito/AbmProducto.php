<?php
class AbmProducto{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

    

    public function accion($param){
        $resp = false;
        if($param['proaccion'] == 'editar'){
            if($this->modificacion($param)){
                $resp = true;
            }
        }
        if($param['proaccion'] == 'eliminar'){
            if($this->baja($param)){
                $resp =true;
            }
        }
        if($param['proaccion'] == 'nuevo'){

            if($this->alta($param)){
                $resp =true;
                
            }

            
        }
        return $resp;
    }


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Producto
     */
    private function cargarObjeto($param){
        $obj = null;

        if( array_key_exists('idproducto',$param) and array_key_exists('pronombre',$param) and array_key_exists('prodetalle',$param) and array_key_exists('procantstock',$param)){
            
            $obj = new Producto();
            $obj->setear($param['idproducto'], $param['pronombre'],$param['prodetalle'],$param['procantstock']);
        }
        return $obj;
    }



    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Producto
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if(isset($param['idproducto']) ){

            $obj = new Producto();
            
            $obj->setear($param['idproducto'],null, null,null);
            
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
        
        if (isset($param['idproducto'])){

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

        $objProducto = $this->cargarObjeto($param);
        
        if ($objProducto!=null and $objProducto->insertar()){
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
            $objProducto = $this->cargarObjetoConClave($param);
            //verEstructura($objProducto);
            if ($objProducto!=null and $objProducto->eliminar()){
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
        //echo 'modificacion'.$param['idproducto'];
        if ($this->seteadosCamposClaves($param)){
            $objProducto = $this->cargarObjeto($param);
            //verEstructura($objProducto);
            if($objProducto != null and $objProducto->modificar()){
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
            if  (isset($param['idproducto']))
                $where.=" and idproducto ='".$param['idproducto']."'";
            if  (isset($param['pronombre']))
                 $where.=" and pronombre ='".$param['pronombre']."'";
            if  (isset($param['prodetalle']))
                $where.=" and prodetalle ='".$param['prodetalle']."'";
            if  (isset($param['procantstock']))
                 $where.=" and procantstock ='".$param['procantstock']."'";
        }

        $arreglo = Producto::listar($where);  
        return $arreglo;
    }



    public function subirArchivo($datos){
        $nombreArchivoImagen = $datos['idproducto'];
        $dir = '../../Archivos/';


        $tipoArchivo= pathinfo($_FILES["proimagen"]["name"], PATHINFO_EXTENSION);

        $target_file = $dir.$nombreArchivoImagen.".".$tipoArchivo;
        $respuesta = array(
            'mensaje' => ''.$target_file,
            'exito' => true
        );

        if ($_FILES["proimagen"]["error"] <= 0) {
            $respuesta['exito']= true;
            $respuesta['mensaje']= "";
        } else {

            $respuesta['exito'] = false;
            $respuesta['mensaje'] = "ERROR: no se pudo cargar el archivo de imagen. No se pudo acceder al archivo Temporal";
        }

        if ($respuesta['exito'] && $_FILES['proimagen']["size"] / 1024 > 400) {
            $respuesta['mensaje'] = "ERROR: El archivo " . $nombreArchivoImagen . " supera los 400 KB.";
            $respuesta['exito'] = false;
        }

        if ($respuesta['exito'] && !copy($_FILES['proimagen']['tmp_name'], $target_file)) {
            $respuesta['mensaje'] = "ERROR: no se pudo cargar el archivo de imagen.";
            $respuesta['exito'] = false;
        }
        return $respuesta;
    }

    
}
?>