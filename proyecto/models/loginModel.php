<?php

class loginModel extends Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function getUsuario($usuario, $password){
        $datos = $this->_db->query(
                "select * from usuarios ".
                "where usuario = '$usuario' ".
                "and pass = '" . md5($password) . "'"
                );
       return $datos->fetch();
    }
    
    public function getPersonaRol($id_persona){
        $datos = $this->_db->query(
                "SELECT * from persona_rol " .
                "WHERE id_persona = $id_persona "
                );
        return $datos->fetchAll();
    }
    
    public function getRol($id_rol){
        
        $id_rol = (int) $id_rol;
        
        $datos = $this->_db->query(
                "SELECT rol from rol " .
                "WHERE id_rol = $id_rol "
                );
        return $datos->fetch();
    }
}

?>
