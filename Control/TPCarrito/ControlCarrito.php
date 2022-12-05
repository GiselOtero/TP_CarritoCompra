<?php
class controlCarrito{
    

    /**
     * Carga o elimina  un producto del carrito, 
     * O inicia la compra solo si el estado de la compra espendiente
     * 
     * 
     */
    public function accionCliente($param){
        $exito = false;
        $datos['idusuario'] = $param['idusuario'];
        
        $objCEVigente = $this->buscarEstadoVigente($datos);

        if($objCEVigente == null){

            $objCEVigenteNew = $this->crearCompraPendiente($datos);
            if($objCEVigenteNew != null && $param['accion']=='agregar'){
                $datos['idcompra'] = $objCEVigenteNew->getCompra()->getIDCompra();
                $datos['idproducto'] = $param['idproducto'];
                $datos['cicantidad'] = $param['cicantidad'];

                $exito = $this->altaCompraItem($datos);
            }

        }else if($objCEVigente != null){
            $tipoEstado = $objCEVigente->getCompraEstadoTipo()->getIDCompraEstadoTipo();
            $datos['idcompra'] = $objCEVigente->getCompra()->getIDCompra();
            /* editar */
            switch($param['accion']){
                case 'agregar':

                    $datos['idproducto'] = $param['idproducto'];
                    $datos['cicantidad'] = $param['cicantidad'];
                    if($tipoEstado == 4 || $tipoEstado == 2 ){
                        $objCEVigenteNew = $this->crearCompraPendiente($datos);
                        if($objCEVigenteNew!= null){
                            $datos['idcompra'] = $objCEVigenteNew->getCompra()->getIDCompra();
                            $exito = $this->altaCompraItem($datos);
                        }
                    }else if ($tipoEstado == 5){
                        $exito = $this->altaCompraItem($datos);
                    }

                    break;
                case 'eliminar':

                    if ($tipoEstado == 5){
                        //$exito = true;
                        $datos['idcompraitem'] = $param['idcompraitem'];
                        $exito = $this->eliminarCompraItem($datos);
                    }

                    break;
                case 'iniciarcompra':
                    
                    if ($tipoEstado == 5){
                        //$exito = true;
                        $datos['idcompraestado'] = $objCEVigente->getIDCompraEstado();
                        $exito = $this->iniciarCompra($datos['idcompra']);

                    }
                    
                    break;
                default:
                    $exito = false;
                break;
                
            }
        }

        return $exito;
    }



    public function accionDeposito($param){
        $exito = false;
        $datos['idcompra'] = $param['idcompra'];
        $datos['idcompraestado'] = $param['idcompraestado'];
        switch($param['accion']){
            case 'aceptar':
                //
                $abmCompraEstado = new AbmCompraEstado();
                $listaCE = $abmCompraEstado->buscar($datos);
                if(count($listaCE) > 0){
                    $unaCompraEst = $listaCE[0];
                    if($unaCompraEst->getCompraEstadoTipo()->getIDCompraEstadoTipo() == '1'){
                        $exito = $this->compraAceptada($param);
                    }
                }
                
                break;
            case 'cancelar':

                $exito = $this->cancelarCompra($param);

                break;
            case 'enviar':
                
                $abmCompraEstado = new AbmCompraEstado();
                $listaCE = $abmCompraEstado->buscar($datos);
                if(count($listaCE) > 0){
                    $unaCompraEst = $listaCE[0];
                    if($unaCompraEst->getCompraEstadoTipo()->getIDCompraEstadoTipo() == '2'){
                        $exito = $this->enviarCompra($param);
                    }
                }
                //
                break;
            default:
                $exito = false;
                break;

        }
        
        return $exito;
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
     * 
     * crea y devuelve el objeto compra
     * @param obj
     */
    public function crearCompra($param){
        $unaCompra = null;

        $abmCompra = new AbmCompra();

        //$fechaAct = $this->fechaActual();
        
        $datos = array(
            'idusuario' => $param['idusuario'],
            'cofecha' => $this->fechaActual(),
        );
        $exito = $abmCompra->alta($datos); 
        if($exito){

            $listarCompra = $abmCompra->buscar($datos);
            
            if(count($listarCompra) > 0){
                $unaCompra = $listarCompra[0];
            }
            
        }

        return $unaCompra;
    }


    /**
     * 
     * @param array $param
     * Lista productos del carrito Compra
     * @return array $listaCompra
     * 
     */
    public function colProductosCompra($param){
        $datos['idcompra'] = $param ['idcompra'];
        $colProductos = array();
        $abmCompraItem = new AbmCompraItem();
        $listaCompra = $abmCompraItem->buscar($datos);
        if(count($listaCompra)>0){
            $colProductos = $listaCompra;
        }
        return $colProductos;

    }



    

    /**
     * 
     * @param array
     *   Busca por idCompra Una CompraEstado Vigente y retorna el objVigente 
     * @return obj
     * 
     */
    public function compraEstadoVigente($param){
        $abmCompraEstado = new AbmCompraEstado();
        $compraEstadoVigente = null;
        $datos['idcompra'] = $param['idcompra'];
        $datos['cefechafin'] = '0000-00-00 00:00:00';     
        $listaCE = $abmCompraEstado->buscar($datos);
        if(count($listaCE)>0){
            $estadoVigente = $listaCE[count($listaCE)-1];
        
            $tipoEstado = $estadoVigente->getCompraEstadoTipo()->getIDCompraEstadoTipo();

            if($tipoEstado != 4 && $tipoEstado != 3){ //editar
                $compraEstadoVigente = $estadoVigente;
            }
        }

        return $compraEstadoVigente;
        
    }

    



    /**
     * 
     * Devuelve la lista de pruductos del carrito
     * solo si el estado es Pendiente o Iniciada
     * @return array $listaCompras
     */
    public function verCarrito($param){
        $datos['idusuario'] = $param['idusuario'];
        $objCompraEstado = $this->buscarEstadoVigente($datos);
        $listaCompra = array();
        
        if($objCompraEstado != null){

            $tipoEstadoComp = $objCompraEstado->getCompraEstadoTipo()->getIDCompraEstadoTipo();
            if($tipoEstadoComp == 5 || $tipoEstadoComp == 1){
                $datos['idcompra'] = $objCompraEstado->getCompra()->getIDCompra();
                $listaCompra = $this->colProductosCompra($datos);
            }
            
        }

        return $listaCompra;
    }



    public function iniciarCompra($idcompra){        
        //idCompra, objEstadovigente
        $exito = false;
        $datos['idcompra']=$idcompra;
        $datos['idcetipo'] = '1';//estado tipo "iniciar"
        
        //$resp = $this->cambiarEstado($datos);

        $abmProducto = new AbmProducto();

        if($this->cambiarEstado($datos)){
            $exito = true;
            

        }

        return $exito;

        
    }


    public function compraAceptada($param){
        $exito = false;
        $datos['idcompra']=$param['idcompra'];
        $datos['idcetipo'] = '2';//estado tipo "aceptar", editarrrr
        $abmProducto = new AbmProducto();
        if($this->cambiarEstado($datos)){
            //$exito = true;
            $colProductosCarrito = $this->colProductosCompra($datos);
            foreach ($colProductosCarrito as $unaCompraItem){
                $unProducto = $unaCompraItem->getProducto();
                $nuevoStock = $unProducto->getProCantStock() - $unaCompraItem->getCiCantidad();//la modificacion del stock solo se hace si la compra es aceptada?

                $datosMod = array(
                    'idproducto' => $unProducto->getIDProducto(),
                    'pronombre' => $unProducto->getProNombre(),
                    'prodetalle' => $unProducto->getProDetalle(),
                    'procantstock'=>$nuevoStock, 
                    'proprecio'=>$unProducto->getProPrecio()
                );

                $exito = $abmProducto->modificacion($datosMod);

                 //$exito = $unProducto->cambiarStock($nuevoStock);
            }

        }

        return $exito;
    }



    public function cancelarCompra($param){
        $exito = false;
        $datos['idcompra']=$param['idcompra'];
        $datos['idcetipo'] = '4';//estado tipo "cancelar"
        
        if($this->cambiarEstado($datos)){
            
            if($param['idcompratipo'] == 2){
                $abmProducto = new AbmProducto();
                $colProductosCarrito = $this->colProductosCompra($datos);
                foreach ($colProductosCarrito as $unaCompraItem){
    
                    
    
                    $unProducto = $unaCompraItem->getProducto();
                    $nuevoStock = $unProducto->getProCantStock() + $unaCompraItem->getCiCantidad();//la modificacion del stock solo se hace si la compra es aceptada?
    
                    $datosMod = array(
                        'idproducto' => $unProducto->getIDProducto(),
                        'pronombre' => $unProducto->getProNombre(),
                        'prodetalle' => $unProducto->getProDetalle(),
                        'procantstock'=>$nuevoStock, 
                        'proprecio'=>$unProducto->getProPrecio()
                    );
    
                    $exito = $abmProducto->modificacion($datosMod);
    
                    //$exito = $unProducto->cambiarStock($nuevoStock);
                }
                
            }else{
                $exito = true;
            }
            
        
        }

        return $exito;
    }

    public function enviarCompra($param){
        $exito = false;
        $datos['idcompra']=$param['idcompra'];
        $datos['idcetipo'] = '3';//estado tipo "cancelar"
        
        if($this->cambiarEstado($datos)){
            $exito = true;
        }

        return $exito;
    }



    public function cambiarEstado($param){
        //idcompra,estadovigente, idestadoitemNuevo
        $exito = false;

        $datos['idcompra'] = $param['idcompra'];
        $datos['idcompraestadotipo'] = $param['idcetipo'];

        $objCEVigente = $this->compraEstadoVigente($datos);
        $abmCompraEstado = new AbmCompraEstado();
        $fechaAct = $this->fechaActual();

        if($objCEVigente != null){
            $datosMod = array(
                'idcompraestado' =>$objCEVigente->getIDCompraEstado(),
                'idcompra' => $objCEVigente->getCompra()->getIDCompra(),
                'idcompraestadotipo' => $objCEVigente->getCompraEstadoTipo()->getIDCompraEstadoTipo(),
                'cefechaini' => $objCEVigente->getCeFechaIni(),
                'cefechafin' => $fechaAct
            );

            $respMod = $abmCompraEstado->modificacion($datosMod);
            if($respMod){
                $datosNuevos = array(
                    'idcompra' => $datos['idcompra'],
                    'idcompraestadotipo' => $datos['idcompraestadotipo'],
                    'cefechaini' => $fechaAct,
                    'cefechafin' => 'null'
                );
                $exito = $abmCompraEstado->alta($datosNuevos);
            }
        }

       return $exito;

    }





    public function actualizarFechaCompra($idcompra){
        $exito = true;
        $abmCompra = new AbmCompra();
        $datos['idcompra']=$idcompra;
        $listaCompra = $abmCompra->buscar($datos);
        if( count($listaCompra) > 0 ){
            $unaCompra = $listaCompra[0];
            $datos = array(
                'idcompra' => $unaCompra->getIDCompra(),
                'cofecha' => $this->fechaActual(),
                'idusuario'=>$unaCompra->getUsuario()->getIDUsuario()
            );
            $exito = $abmCompra->modificacion($datos);

        }
    }



    
   







    /* ver si funciona */
    public function colCompras($param){
        //verificar estado
        $abmCompra = new AbmCompra();
        $datos['idusuario'] = $param['idusuario']; 
        $listaCompra = $abmCompra->buscar($datos);
        return $listaCompra;
    }

    public function colComprasEstados($param){
        $abmCompraEstado = new AbmCompraEstado();
        $datos['idcompra'] = $param['idcompra']; 
        $listaCE = $abmCompraEstado->buscar($datos);
        return $listaCE;
    }


    public function buscarEstadoVigente($param){
        $datos['idusuario'] = $param['idusuario'];
        //obtengo todas las compras realizadas por el idusuario
        $listaCompra = $this->colCompras($datos);

        $encontrado = false;
        $compraEstVigente = null;        

        if( count($listaCompra) > 0 ){
            $i = 0;
            $cantCompras = count($listaCompra);
            do{
                $unaCompra = $listaCompra[$i];
                $datos['idcompra'] = $unaCompra->getIDCompra();
                $unaCompraEst = $this->compraEstadoVigente($datos);
                if($unaCompraEst != null){
                    $encontrado = true;
                    $compraEstVigente = $unaCompraEst;
                }else{
                    $i++;
                }

            }while(!$encontrado && $i < $cantCompras);

        }
        //si no hay compra vigente crea una compra?

        return $compraEstVigente;
    }

   
   

    public function crearCompraPendiente($param){
        $exito = false;
        $fechaAct = $this->fechaActual();
        $datos['idusuario'] = $param['idusuario'];

        //en caso de existir compra sin ningun estado


        $unaCompra = $this->crearCompra($datos);
        $abmCompraEstado = new AbmCompraEstado();
        $compraEstVigente = null;
        if($unaCompra != null){
            $datos = array(
                'idcompra' => $unaCompra->getIDCompra(),
                'idcompraestadotipo' => 5,
                'cefechaini' => $fechaAct,
                'cefechafin' => null
            );
            
            if($abmCompraEstado->alta($datos)){
                $exito = true;
            }
        }

        if($exito){
            $listaCE = $abmCompraEstado->buscar($datos);
            if(count($listaCE)){
                $compraEstVigente = $listaCE[0];

            }
        }

        //devolver el obj?
        return $compraEstVigente;

    }
                
                
}
            
                        
            


?>
          