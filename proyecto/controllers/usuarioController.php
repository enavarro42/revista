<?php

class usuarioController extends Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->_view->titulo = 'Usuario';
        $this->_view->renderizar('index', 'usuario');
    }
    
}

?>
