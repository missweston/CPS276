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

/* 

Explain why were are using the DB_conn class
To connnect to the database 

Explain why we are using the Pdo_methods class
To handle database operations like select, insert, update, and delete using PDO.
Easier to manage database interactions.

Why are we storing the PDF files on the web server and not in the database
Storing files on the server can be more efficient for performance and storage.

The PdoMethods class extends DatabaseConn. Explain the benefits of this inheritance structure and how it promotes code reusability and separation of concerns.
db_conn class handles database connection details, while pdo_methods class handles queries

In the fileUploadProc.php, the code uses prepared statements with bindings. Explain how this approach prevents SQL injection attacks and why it's considered a security best practice.
It's turned into a string or value so it cant be executed as SQL code.
It's securirty best practice because it prevents malicious code from being injected into the database. 
*/
