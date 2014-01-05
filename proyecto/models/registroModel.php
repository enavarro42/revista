<?php

class registroModel extends Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function verificarUsuario($usuario){
        $id = $this->_db->query(
                "SELECT id_usuario, codigo from usuarios WHERE usuario = '$usuario'"
                );
        return $id->fetch();
    }
    
    public function verificarEmail($email){
        $id = $this->_db->query(
                "SELECT id_usuario from usuarios WHERE email = '$email'"
                );
        if($id->fetch()){
            return true;
        }
        
        return false;
    }
    
    public function registrarUsuario($nombre, $apellido, $usuario, $password, $email, $cuenta){
       
       $random = rand(1782598471, 9999999999);
       
       $this->_db->prepare(
                "insert into persona(nombre, apellido) VALUES (:nombre, :apellido)"
                )
                ->execute(
                        array(
                        ':nombre' => $nombre,
                        ':apellido' => $apellido
                        )
                );
       
       
        $persona = $this->_db->query("SELECT MAX(id_persona) AS id_persona FROM persona");
        
        $persona = $persona->fetch();
        
        for($i = 0; $i < count($cuenta); $i++){
            $this->_db->prepare("insert into persona_rol(id_persona, id_rol) VALUES (:id_persona, :id_rol)")
                    ->execute(array(
                       ':id_persona' => $persona['id_persona'],
                       ':id_rol' => $cuenta[$i]
                    ));
        }

        
        $this->_db->prepare(
                "insert into usuarios(usuario, pass, estado, id_persona, email, fecha, codigo) VALUES (:usuario, :pass, 0, :id_persona, :email, now(), :codigo)"
                )
                ->execute(array(
                   ':usuario' => $usuario,
                   ':pass' => Hash::getHash('md5', $password, HASH_KEY),
                   ':id_persona' => $persona['id_persona'],
                   ':email' => $email,
                   ':codigo' => $random
                ));
    }
    
    public function getUsuario($id, $codigo){
        $usuario = $this->_db->query(
                "select * from usuarios where id_usuario = $id and codigo = $codigo"
                );
        return $usuario->fetch();
    }
    
    public function activarUsuario($id, $codigo){
        $this->_db->query(
                "update usuarios set estado = 1 ".
                "where id_usuario = $id and codigo = $codigo"
                );
    }
}

?>
