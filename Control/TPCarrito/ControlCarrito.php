<?php
class controlCarrito{
    


    /* *************editar************ */
    /**
     * 
     * @param array $param['idcompra']
     * Inicia la compra en  estadi pendiente
     * @return boolean $exito
     * 
     */
    public function iniciarCompraPendiente($param){
        $exito = false;
        $fechaAct = $this->fechaActual();
        
        /* 5 = pendiente */
        
        $datos = array(
            'idcompra' => $param['idcompra'],
            'idcompraestadotipo' => 5,
            'cefechaini' => $fechaAct,
            'cefechafin' => null
        );
        
        $abmCompraEstado = new AbmCompraEstado();
        if($abmCompraEstado->alta($datos)){
            $exito = true;
        }
        
        return $exito;

    }



    /**
     * 
     * @param array
     * agrega un producto al carrito si y solo si el estado compra es pendiente 
     * en caso contrario devolvera false
     * @return array
     * 
     */
    public function accionAgregar($param){
       
        $respuesta = array(
            'exito' => false,
            'mensaje' => 'Surgio un error al agregar el producto al carrito'
        );

        $objCompraEstado = $param['compraestado'];
        $estado = $objCompraEstado->getCompraEstadoTipo();
        if($estado->getIDCompraEstadoTipo() != 5){
            /* 5: pendiente */
            return $respuesta=array(
                'exito' => false,
                'mensaje'=> "No se puede agregar productos al carrito"
            ); 
        }else if($estado->getCeFechaFin() == null || $estado->getCeFechaFin() == '0000-00-00 00:00:00' ){
            $datos['idcompra']=$objCompraEstado->getCompra()->getIDCompra();
            $datos['idproducto']=$param['idproducto'];
            $datos['cicantidad']=$param['cantProd']; 
            if($this->altaCompraItem($datos)){
                $respuesta = array(
                    'exito' => true,
                    'mensaje' => 'El producto se agrego correcatemnte al carrito'
                );
                
            }
        }

        return $respuesta;

    }



    public function accionEliminarProducto($param){

        $respuesta = array(
            'exito' => false,
            'mensaje' => 'Surgio un error al eliminar el producto al carrito'
        );

        $objCompraEstado = $param['compraestado'];
        $estado = $objCompraEstado->getCompraEstadoTipo();
        if($estado->getIDCompraEstadoTipo() != 5){
            /* 5: pendiente */
            return $respuesta=array(
                'exito' => false,
                'mensaje'=> "No se puede eliminar productos al carrito"
            ); 
        }else if($objCompraEstado->getCeFechaFin() == null || $objCompraEstado->getCeFechaFin() == '0000-00-00 00:00:00' ){
            $datos['idcompra']=$objCompraEstado->getCompra()->getIDCompra();
            $datos['idcompraitem']=$param['idcompraitem'];
            /* $datos['cicantidad']=$param['cantProd'];  */
            if($this->eliminarCompraItem($datos)){
                $respuesta = array(
                    'exito' => true,
                    'mensaje' => 'El producto se elimino correcatemnte del carrito'
                );
                
            }
        }

        return $respuesta;
    }



    





    /* ********************************************************************************* */



    /**
     * 
     * @param array $param['idusuario']
     * Obtiene la Utilma Compra del Usuario, en caso de no tener ninguna compra registrada 
     * retorna nulo
     * @return obj $objCompra
     * 
     */
    public function obtenerUltimaCompra($param){ 

        $objCompra = null;
        $abmCompra = new AbmCompra();
        $listaCompra = $abmCompra->buscar($param);
        if(count($listaCompra) > 0){
            $i = count($listaCompra);
            $objCompra = $listaCompra[$i-1];
        }

        return $objCompra;
        
    }



    /**
     * 
     * @param array $param['idcompra]
     * busca el ultima CompraEstado devuelve el objCompraEstado 
     * en caso contrario devuelve null
     * @return obj $objCompraEstado
     * 
     */
    public function ultimoCompraEstado($param){
        /* solo buscar el compraEstado con ifecha fin es nulo */
        $dato['idcompra'] = $param['idcompra'];
        $unaCompraEstado = null;
        $abmCompraEstado = new AbmCompraEstado();
        $listarCE = $abmCompraEstado->buscar($dato);
        $cantCE = count($listarCE);
        if($cantCE > 0){
            $unaCompraEstado = $listarCE[$cantCE-1];

        }

        return $unaCompraEstado;
    }

    

    /**
     * Devuelve la fecha actual en formato '0000-00-00 00:00:00'
     * @return date
    */
    public function fechaActual(){
        $unaFecha = date("Y-m-d h:i:sa");
        return $unaFecha;
    }


    /**
     * da de alta una compraItem
     * @return boolean $exito
     */
    public function altaCompraItem($param){
        $abmCompraItem = new AbmCompraItem();
        $exito = false;

        if($abmCompraItem->alta($param)){
            $exito = true;
        }

        return $exito;
    }

    /**
     * da de baja una compraItem
     * @return boolean $exito
     */
    public function eliminarCompraItem($param){
        $abmCompraItem = new AbmCompraItem();
        $exito = false;

        if($abmCompraItem->baja($param)){
            $exito = true;
        }

        return $exito;
    }
    
    /**
     * crea y devuelve el objeto compra
     * @param obj
     */
    public function crearCompra($param){
        $unaCompra = null;

        $abmCompra = new AbmCompra();

        $fechaAct = $this->fechaActual();
        $datos = array(
            'idusuario' => $param['idusuario'],
            'cofecha' => $fechaAct,
        ); 
        if($abmCompra->alta($datos)){
            $listarCompras = $abmCompra->buscar($datos);
            
            if(count($listarCompras)>0){
                $unaCompra = $listaCompra[0];
            }
            
        }

        return $unaCompra;
    }



    public function colProductosCompra($param){
        $datos['idcompra'] = $param ['idcompra'];
        $colProductos = array();
        $abmCompraItem = new AbmCompraItem();
        $listaCompra = $abmCompraItem->buscar($datos);
        if(count($listaCompra)>0){
            $colProductos = $listaCompra;
        }
        return $listaCompra;

    }



    public function iniciarCompraIniciada(){

    }



    /**
     * 
     */
    public function estadoVigente($param){
        $abmCompraEstado = new AbmCompraEstado();
        $estadoVigente = null;
        $datos['idcompra'] = $param['idcompra'];
        $datos['cedeshabilitado'] = '0000-00-00 00:00:00';     
        $listaCE = $abmCompraEstado->buscar($datos);
        if(count($listaCE)>0){
            $estadoVigente = $listaCE[0];
        }

        
        return $estadoVigente;
        
    }

}





?>