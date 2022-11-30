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
        $resp = false;
        $objAbmUsuario = new AbmUsuario();
        $param = array(
            'usnombre' => $nombreUsuario,
            'uspass' => $psw
        );
        
        //verEstructura($listUsuario);
        $listar = $objAbmUsuario->buscar($param);
        if(count($listar)>0){
            $objUsuario = $listar[0];
            if($objUsuario->getUsDeshabilitado() == null || $objUsuario->getUsDeshabilitado() == "0000-00-00 00:00:00" ){
                $_SESSION['idusuario']=$objUsuario->getIdUsuario();
                $_SESSION['usnombre']=$param['usnombre'];
                /* $_SESSION['rol'] = $this->getRol(); */
                $resp = true;
            }
        }

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

    /* public function validacion($usuario,$psw){
        $resp = false;
        $objAbmUsuario = new AbmUsuario();
        $condicion = array(
            'usnombre' => $usuario,
            'uspass' => $psw
        );
        $listUsuario = $objAbmUsuario->buscar($condicion);
        //verEstructura($listUsuario);
        $listar = $obj->buscar($param);
        if(count($listar)>0){
            $objUsuario = $listar[0];
            if($objUsuario->getUsDeshabilitado() == null || $objUsuario->getUsDeshabilitado() == "0000-00-00 00:00:00" ){
                $_SESSION['idusuario']=$objUsuario->getIdUsuario();
                $_SESSION['usnombre']=$param['usnombre'];
                //$_SESSION['rol'] = $this->getRol();
                $resp = true;
            }
        }


        return $resp;
    } */



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




    /* editar */
    public function getMenuRol(){
        $roles = $this->getRol();
        $abmMenuRol = new AbmMenuRol();
        $array = array();
        if(count($roles)>0){

            foreach($roles as $unRol ){
                $datos['idrol'] = $unRol->getIDRol();
                $listar = $abmMenuRol->buscar($datos);
                if(count($listar)>0){
                    
                    $arrayMenu = array(
                        'rol'=> $unRol->getIDRol(),
                        'listamenu' => $listar, 
                    );
                    array_push($array,$arrayMenu);
                }
            }
        }

        return $array;
        
    }


}