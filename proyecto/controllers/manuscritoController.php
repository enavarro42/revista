<?php

class manuscritoController extends Controller{
    
    private $_manuscrito;
    
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        $this->_view->titulo = 'Mis manuscritos';
        $this->_view->renderizar('index', 'manuscrito');
    }
    
}

?>
