<?php
class Session{

    

    //inicia session
    public function __construct(){
        
        session_start();
        
    }


    
    /**
     * Actualiza las variables de sesión con los valores ingresados
    */
    public function iniciar($nombreUsuario,$psw){

        //$resp = $this->validar();

        /* $objAbmUsuario = new AbmUsuario(); */
        $resp = $this->validacion($nombreUsuario,$psw); 

        return $resp;
    }
 


    /**
     * Valida si la sesion actual tiene $usuario y $psw(? validos
     * @return boolean
    */
    public function validar(){

        // verifica si esta activa y si hay una varaiable $_SESSION

        $resp = false;

        if($this->activa() && isset($_SESSION['idusuario'])){            
            $resp = true;
        }
        return $resp;
    }

    public function validacion($usuario,$passw){
        $resp = false;

        $condicion = array(
            'usnombre' => $usuario,
            'uspass' => $passw
        );
        $objAbmUsuario = new AbmUsuario();
        $listUsuario = $objAbmUsuario->buscar($condicion);

        if(count($listUsuario) > 0){
            $unUsuario = $listUsuario[0];
            if(!$unUsuario->esDeshabilitado()){
                $_SESSION['idusuario'] = $unUsuario->getIDUsuario();
                $_SESSION['usnombre'] = $unUsuario->getUsNombre();
                //$_SESSION['rolusuario'] ;
                $resp = true;
            }
        }

        return $resp;
    }



    /**
     * Devuelve true o false si la sesión está activa o no.
     * @return boolean
     */
    public function activa(){ //este es el valida()
        $resp = false;
        if( !(session_status() === PHP_SESSION_NONE) ){ 
            $resp = true;
        }

        return $resp;
    }



    /**
     * Devuelve el usuario logeado
     */
    public function getUsuario(){
        $objUsuario = null;
        if($this->validar()){
            $objUsuario = new Usuario();
            $objUsuario->setIDUsuario($_SESSION['idusuario']);
            $objUsuario->cargar();
        }
        return $objUsuario;
         
    }




    /**
     * Devuelve el Rol del usuario logeado
     */
    public function getRol(){
        $roles = array();
        if($this->validar()){
            $dato['idusuario'] = $_SESSION['idusuario'];
            $abmUsRol = new AbmUsuarioRol();
            $abmRol = new AbmRol();
            $roles = array();
            $listaUsuarioRol = $abmUsRol->buscar($dato);
            if(count($listaUsuarioRol) > 0){
                foreach($listaUsuarioRol as $elem){
                    
                    $unRol=$elem->getRol();
                    
                    array_push($roles,$unRol);
                }

            }
        }
        return $roles;
    }



    /**
     * Cierra la sesion actual
    */
    public function cerrar(){
        if($this->validar()){
            $_SESSION['usnombre'] = "";
            session_destroy();
        }
    }





     /* Session Carrito */
     public function getCompra(){
        /* verificar rol usuario */
        $datos['idusuario'] = $_SESSION['idusuario'];

        $unaCompra = null;
        
        $controlCarrito = new controlCarrito();

        $unaCompra = $controlCarrito->obtenerUltimaCompra($datos);

        return $unaCompra;
    }

    public function getCompraEstado(){
        /* verificar rol usuario */
        $unaCompra = $this->getCompra();
        $unaCompraEstado = null;

        if($unaCompra != null){
            $controlCarrito = new ControlCarrito();

            $datos['idcompra'] = $unaCompra->getIDCompra();
            $unaCompraEstado = $controlCarrito->ultimoCompraEstado($datos);

            if($unaCompraEstado == null){
                /* si en caso de existir compra pero no tiene ningun CompraEstado se crea uno iniciandolo en pendiente */
                if($controlCarrito->iniciarCompraPendiente($datos)){
                    $unaCompraEstado = $controlCarrito->ultimoCompraEstado($datos);
                }
            }
        }

        return $unaCompraEstado;
    }

    public function verCarrito(){
        $unaLista = array();
        $controlCarrito = new controlCarrito();
        if($this->validar()){
            $datos['idusuario'] = $_SESSION['idusuario'];
            $objCompra = $controlCarrito->obtenerUltimaCompra($datos);
            if($objCompra!= null){

                $datos['idcompra'] = $objCompra->getIDCompra();
                $unaLista = $controlCarrito->colProductosCompra($datos);
            }
        }
        return $unaLista;
    }
}
?>