<?php

class autorController extends Controller{
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        
        
        if(!Session::get('autenticado')){
            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }else{

            //temporalmenta hasta pensarlo bien...!
            Session::set('level', 'autor');

            $this->_view->titulo = 'Autor';
            $this->redireccionar('manuscrito');
        }
        
        
        
    }
    
}
?>
