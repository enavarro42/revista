<?php


class manuscritoModel extends Model{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function getRevisiones($id_autor){
        $revisiones = $this->_db->query("SELECT DISTINCT manuscrito.id_manuscrito, revista.nombre, manuscrito.titulo, estatus.estatus, rol.rol, revision.fecha ".
                                  "FROM manuscrito, revista, estatus, obra, autor_obra, rol, responsable, revision " .
                                  "WHERE autor_obra.id_autor = $id_autor and autor_obra.id_obra = obra.id_obra and obra.tipo='Manuscrito' and ". 
                                  "manuscrito.id_obra = obra.id_obra and responsable.id_manuscrito = manuscrito.id_manuscrito and ". 
                                  "responsable.id_rol = rol.id_rol and responsable.id_responsable = revision.id_responsable and revision.id_estatus = estatus.id_estatus ".
                                  "ORDER BY revision.fecha DESC");
        return $revisiones->fetchAll();
    }
    
    
     public function getPersona($id_persona){
        $persona = $this->_db->query("select * from persona where id_persona = $id_persona");
        return $persona->fetch();
    }
    
    public function getObra($id_obra){
        $obra = $this->_db->query("select * from obra where id_obra = $id_obra");
        return $obra;
    }
    
    public function getObraAutor($id_obra){
        $autor = $this->_db->query("select id_autor from autor_obra where id_obra = $id_obra");
        return $autor;
    }
    
    public function getObraManuscrito($id_autor){
        $obra = $this->_db->query("SELECT DISTINCT obra.id_obra FROM obra, autor_obra WHERE autor_obra.id_autor = $id_autor and autor_obra.id_obra = obra.id_obra and obra.tipo='Manuscrito'");
        return $obra;
    }
    
    public function getIdAutor($id_persona){
        $autor = $this->_db->query("select id_autor from autor where id_persona = $id_persona");
        return $autor->fetch();
    }
    
    public function getAutor($id_autor){
        $autor = $this->_db->query("select * from autor where id_autor = $id_autor");
        return $autor->fetch();
    }
    
    public function getIdRol($rol){
        $id_rol = $this->_db->query("select id_rol from rol where rol = $rol");
        return $id_rol->fetch();
    }
    
    public function getRol($id_rol){
        $rol = $this->_db->query("select rol from rol where id_rol = $id_rol");
        return $rol->fetch();
    }
    
    public function getManuscrito($id_obra){

        $manuscrito = $this->_db->query("select * from manuscrito where id_obra = $id_obra");
        return $manuscrito->fetch();
        
    }
    
    public function getResponsable($id_manuscrito){
        $responsable = $this->_db->query("select id_responsable from responsable where id_manuscrito = $id_manuscrito");
        return $responsable->fetch();
    }
    
    public function getRevision($responsables){
        $sql_responsable;
        for($i=0; $i<count($responsables); $i++){
            if($i != 0) $sql_responsable .= ' and ';
            $sql_responsable .= 'id_responsable = '.$responsables[$i];
        }
        
        $revision = $this->_db->query("select * from revision where $sql_responsable order by fecha DESC");
        return $revision->fetch();
        
    }
    
    public function getEstatus($id_estatus){
        $estatus = $this->_db->query("select * from estatus where id_estatus = $id_estatus");
        return $estatus->fetch();
    }
    
    public function getFisico($id_fisico){
        $fisico = $this->_db->query("select * from fisico where id_fisico = $id_fisico");
        return $fisico->fetch();
    }
    
    public function getRevista($id_revista){
        $revista = $this->_db->query("select nombre from revista where id_revista = $id_revista");
        return $revista->fetch();
    }
    
    public function getObraRevista($id_obra){
        $revista = $this->_db->query("select distinct issn from obra_revista_materia where id_obra = $id_obra");
        return $revista->fetch();
    }
    
    public function getMateria($id_materia){
        $materia = $this->_db->query("select nombre from materia where id_materia = $id_materia");
        return $materia->fetch();
    }
    
    public function getObraMeteria($id_obra){
        $materia = $this->_db->query("select distinct id_materia from obra_revista_materia where id_obra = $id_obra");
        return $materia->fetch();
    }
    
}


?>

