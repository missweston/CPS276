<?php
class Db_conn {
    private $conn;

    public function dbOpen(){

        try {
            $dbHost ='localhost';
            $dbName = 'tyweston';
            $dbUsr = 'tyweston';
            $dbPass = 'fToUcD02lgR2zlk';

            $this->conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsr, $dbPass);


            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->conn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            $this->conn->setAttribute(PDO::ATTR_AUTOCOMMIT,true);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->conn;

        
        }
        catch (PDOException $e) {

            echo $e->getMessage();
        }
        

    }
}