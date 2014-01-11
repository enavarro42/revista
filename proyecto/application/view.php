<?php

class View{
    private $_controlador;
    private $_js;
    
    public function __construct(Request $peticion){
        $this->_controlador = $peticion->getControlador();
        $this->_js = array();
    }
    
    public function renderizar($vista, $item = false){
        
        $menu_horizontal = array(
            array(
                'id' => 'inicio',
                'titulo' => 'Inicio',
                'enlace' => BASE_URL
            ),
            /*revistas*/
            array(
                'id' => 'post',
                'titulo' => 'Post',
                'enlace' => BASE_URL . 'post'
            ),
            
            array(
                'id' => 'buscar',
                'titulo' => 'Buscar',
                'enlace' => BASE_URL
            ),
            
            array(
                'id' => 'actual',
                'titulo' => 'Actual',
                'enlace' => BASE_URL
            ),
            
            array(
                'id' => 'archivos',
                'titulo' => 'Archivos',
                'enlace' => BASE_URL
            ),
            
            array(
                'id' => 'informacion',
                'titulo' => 'Informaci&oacute;n',
                'enlace' => BASE_URL
            )
        );
        
        if(Session::get('autenticado')){
            $menu_top = array(
                array(
                    'id' => 'perfil',
                    'titulo' => Session::get('usuario'),
                    'enlace' => BASE_URL . 'perfil'
                ),
                
                array(
                    'id' => 'login',
                    'titulo' => 'Cerrar Sesi&oacute;n',
                    'enlace' => BASE_URL . 'login/cerrar'
                )
             
            );
        }else{
            $menu_top = array(
                array(
                    'id' => 'login',
                    'titulo' => 'Iniciar Sesi&oacute;n',
                    'enlace' => BASE_URL . 'login'
                ),
                array(
                    'id' => 'registro',
                    'titulo' => 'Registro',
                    'enlace' => BASE_URL . 'registro'
                )
            );
        }
        
        $js = array();
        
        if(count($this->_js)){
            $js = $this->_js;
        }
        
        $_layoutParams = array(
            'ruta_css' => BASE_URL . 'views/layout/'. DEFAULT_LAYOUT . '/css/',
            'ruta_img' => BASE_URL . 'views/layout/'. DEFAULT_LAYOUT . '/img/',
            'ruta_js' => BASE_URL . 'views/layout/'. DEFAULT_LAYOUT . '/js/',
            'menu_horizontal' => $menu_horizontal,
            'menu_top' => $menu_top,
            'js' => $js,
            'root' => BASE_URL
        );
        
        
        $rutaView = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.phtml';
        
        if(is_readable($rutaView)){
            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php';
            include_once $rutaView;
            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php';
        }else{
            throw new Exception('Error de Vista');
        }
    }
    
    public function setJs(array $js){
        if(is_array($js) && count($js)){
            for($i=0; $i<count($js); $i++){
                $this->_js[] = BASE_URL . 'views/' . $this->_controlador . '/js/' . $js[$i] . '.js';
            }
        }else{
            throw new Exception('Error de js');
        }
    }
}

?>

