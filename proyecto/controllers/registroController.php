<?php

class registroController extends Controller{
    
    private $_registro;
    
    public function __construct(){
        parent::__construct();
        
        $this->_registro = $this->loadModel('registro');
    }
    
    public function index(){
        if(Session::get('autenticado')){
            $this->redireccionar();
        }
        
        $this->_view->titulo = "Registro";
        if($this->getInt('enviar') == 1){
            $this->_view->datos = $_POST;
            
            
            if(!$this->getSql('nombre')){
                $this->_view->_error = 'Debe introducir su nombre';
                $this->_view->renderizar('index', 'registro');
                exit;
            }
            
            if(!$this->getSql('apellido')){
                $this->_view->_error = 'Debe introducir su apellido';
                $this->_view->renderizar('index', 'registro');
                exit;
            }
            
            if(!$this->getAlphaNum('usuario')){
                $this->_view->_error = 'Debe introducir su nombre de usuario';
                $this->_view->renderizar('index', 'registro');
                exit;
            }
            
            if($this->_registro->verificarUsuario($this->getAlphaNum('usuario'))){
                $this->_view->_error = 'El usuario '. $this->getAlphaNum('usuario') . ' ya existe';
                $this->_view->renderizar('index', 'registro');
                exit;
            }
            
            if(!$this->validarEmail($this->getPostParam('email'))){
                $this->_view->_error = 'La direccion de email es inv&aacute;lida';
                $this->_view->renderizar('index', 'registro');
                exit;
            }
            
            if($this->_registro->verificarEmail($this->getPostParam('email'))){
                $this->_view->_error = 'Esta direccion de correo ya esta registrada';
                $this->_view->renderizar('index', 'registro');
                exit;
            }
            
            if(!$this->getSql('pass')){
                $this->_view->_error = 'Debe introducir su password';
                $this->_view->renderizar('index', 'registro');
                exit;
            }
            
            if($this->getPostParam('pass') != $this->getPostParam('confirmar')){
                $this->_view->_error = 'Los password no coinciden';
                $this->_view->renderizar('index', 'registro');
                exit;
            }
            
            if(!$this->validarParam('cuenta')){
                $this->_view->_error = 'Debe seleccionar por lo menos un tipo de cuenta';
                $this->_view->renderizar('index', 'registro');
                exit;
            }
            
            $this->getLibrary('class.phpmailer');
            $mail = new PHPMailer();
            
            $this->_registro->registrarUsuario(
                    $this->getSql('nombre'),
                    $this->getSql('apellido'),
                    $this->getAlphaNum('usuario'),
                    $this->getSql('pass'),
                    $this->getPostParam('email'),
                    $this->getPostParam('cuenta')
                    );
            $usuario = $this->_registro->verificarUsuario($this->getAlphaNum('usuario'));
            
             if(!$usuario){
                $this->_view->_error = 'Error al registrar el usuario';
                $this->_view->renderizar('index', 'registro');
                exit;
            }

            $mail->From = 'www.fecRevistasCientificas.com';
            $mail->FromName = 'Revistas Cientificas';
            $mail->Subject = 'Activaci&oacute;n de cuenta de usuario';
            $mail->Body = 'Hola <strong>'.$this->getSql('nombre'). '</strong>' .
                    '<p> Se ha registrado en www.fecRevistasCientificas.com para activar '.
                    'su cuenta haga clic sobre el siguiente enlace:<br />'.
                    '<a href="' . BASE_URL . 'registro/activar/'.
                    $usuario['id_usuario'] . '/' . $usuario['codigo'] . '">' .
                    BASE_URL . 'registro/activar/'.
                    $usuario['id_usuario'] . '/' . $usuario['codigo'] .'</a>';
            $mail->AltBody = "Su servidor de correo no soporta html";
            $mail->addAddress($this->getPostParam('email'));
            $mail->Send();
            
            $this->_view->datos = false;
            $this->_view->_mensaje = 'Registro Completado, revise su email para activar su cuenta';
        }
        $this->_view->renderizar('index', 'registro');
    }
    
    public function activar($id, $codigo){
        if(!$this->filtrarInt($id) || !$this->filtrarInt($codigo)){
            $this->_view->_error = "Esta cuenta no existe";
            $this->_view->renderizar('activar', 'registro');
        }
        $row = $this->_registro->getUsuario(
                $this->filtrarInt($id),
                $this->filtrarInt($codigo)
                );
        
        if(!$row){
            $this->_view->_error = "Esta cuenta no existe";
            $this->_view->renderizar('activar', 'registro');
        }
        
        if($row['estado'] == 1){
            $this->_view->_error = "Esta cuenta ya ha sido activada";
            $this->_view->renderizar('activar', 'registro');
        }
        
        $this->_registro->activarUsuario(
                $this->filtrarInt($id),
                $this->filtrarInt($codigo)
                );
        
        $row = $this->_registro->getUsuario(
                $this->filtrarInt($id),
                $this->filtrarInt($codigo)
                );
        
        if($row['estado'] == 0){
            $this->_view->_error = "Error al activar tu cuenta, por favor intentar mas tarde";
            $this->_view->renderizar('activar', 'registro');
        }
        
         $this->_view->_mensaje = "Su cuenta ha sido activada";
         $this->_view->renderizar('activar', 'registro');
    }
    
}

?>
