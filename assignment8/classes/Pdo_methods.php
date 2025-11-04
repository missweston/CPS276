<?php

require_once 'classes/Db_conn.php';
class Pdo_methods extends Db_conn {

    private $conn;
    private $db;
    private $sth;
    private $error;

    // SELECT WITH BINDINGS
    public function selectBinded($sql, $bindings) {
        $this->error = false;

        try{
            $this->db_connection();
            $this->sth = $this->conn->prepare($sql);
            $this->createBindings($bindings);
            $this->sth->execute();

            $records = $this->sth->fetchAll(PDO::FETCH_ASSOC);
            $this->conn = null;
            return $records;
        }
        catch(PDOException $e){

            echo $e->getMessage();
            $this->conn = null;
            return 'error';
        }
    }


    // OTHER WITH BINDINGS (INSERT, UPDATE, DELETE)
    public function otherBinded($sql, $bindings) {
        try {
            $this->db_connection();
            $this->sth = $this->conn->prepare($sql);
            $this->createBindings($bindings);
            $result = $this->sth->execute();
            $this->conn = null;
        }
        
        catch (PDOException $e) {
            return "error";
        }
    }

    //open database connection
    private function db_connection() {
        $this->db = new Db_conn();
        $this->conn = $this->db->dbOpen();
    }

    //apply bindings
    private function createBindings($bindings) {
        foreach ($bindings as $value) {
            switch($value[2]) {
                case "int": 
                    $this->sth->bindValue($value[0], $value[1], PDO::PARAM_INT);
                    break;
                case "str":
                    $this->sth->bindValue($value[0], $value[1], PDO::PARAM_STR);
                    break;
            }

        }
    }
}
?>