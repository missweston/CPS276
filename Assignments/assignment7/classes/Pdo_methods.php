<?php

require_once 'classes/Db_conn.php';
class PdoMethods extends Db_conn {

    private $conn;
    private $db;
    private $sth;
    private $error;

    // SELECT WITHOUT BINDINGS
    public function selectNotBinded($sql) {

        try {
            $this->db_connection();
            $this->sth = $this->conn->prepare($sql);
            $this->sth->execute();
            $records = $this->sth->fetchAll(PDO::FETCH_ASSOC);
            $this->conn = null;
            return $records; 

        }
        catch (PDOException $e) {
            echo $e->getMessage();
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
            if ($result){ 
                return "noerror"; 
            }
            else { 
                return "error"; 
            }
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
                case "str": 
                    $this->sth->bindParam($value[0], $value[1], PDO::PARAM_STR);
                    break;
                case "int":
                    $this->sth->bindParam($value[0], $value[1], PDO::PARAM_INT);
                    break;
            }

        }
    }
}
?>