<?php

class Database extends PDO{
    public function __construct(){
        parent::__construct(
                'pgsql:host=' . DB_HOST . 
                ';port=' . DB_PORT . 
                ';dbname=' . DB_NAME . 
                ';user=' . DB_USER .
                ';password=' . DB_PASS /*.
                ';charset=' . DB_CHAR*/
                );
    }
}

?>

