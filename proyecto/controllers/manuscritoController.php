<?php

class manuscritoController extends Controller{
    
    private $_manuscrito;
    
    public function __construct(){
        parent::__construct();
        $this->_manuscrito = $this->loadModel('manuscrito');
    }
    
    public function index($pagina = false){
        
        Session::accesoEstricto(array('autor'));
        
        if(!$this->filtrarInt($pagina)){
            $pagina = false;
        }else{
            $pagina = (int) $pagina;
        }
        
        $this->getLibrary('paginador');
        $paginador = new Paginador();
        
        
        $id_persona = Session::get('id_persona');
        
        $autor = $this->_manuscrito->getIdAutor($id_persona);
        
        $obras = $this->_manuscrito->getObraManuscrito($autor['id_autor']);
        
        //$autores = array();
        $this->_view->autores = array();
        
        while($obra = $obras->fetch()){
            $id_autor = $this->_manuscrito->getObraAutor($obra['id_obra']); //obtenemos el id_autor
            $manusc = $this->_manuscrito->getManuscrito($obra['id_obra']); // obtenemos el manuscrito
            $iter = 0;
            while($fila = $id_autor->fetch()){
                $temp = $this->_manuscrito->getAutor($fila['id_autor']); //obtenemos el id_persona
                $persona = $temp['id_persona']; //lo asignamos
                $datos_persona = $this->_manuscrito->getPersona($persona);
                $array_autor['persona_'.$iter] = $datos_persona['nombre'] . " " . $datos_persona['apellido']; //almaceno los autores
                $array_autor['id_persona_'.$iter] = $datos_persona['id_persona'];
                
                $iter++;
            }
            $this->_view->autores[$manusc['id_manuscrito']] = $array_autor;
            //$autores[$manusc['id_manuscrito']] = $array_autor;
        }
        
        //echo '<pre>';
        //print_r($autores);
        
       // echo "contador = " . count($autores) . "<br />";
        
        
        //$this->_view->revisiones = $this->_manuscrito->getRevisiones($autor['id_autor']);
        
        $this->_view->manuscritos = $paginador->paginar($this->_manuscrito->getRevisiones($autor['id_autor']), $pagina);
        
        $this->_view->pagina = $pagina;
       
        //print_r($this->_view->revisiones);
        
        //exit;
        
        $this->_view->paginacion = $paginador->getView('prueba', 'manuscrito/index');
        
        $this->_view->titulo = 'Mis manuscritos';
        $this->_view->renderizar('index', 'manuscrito');
    }
    
}

?>
