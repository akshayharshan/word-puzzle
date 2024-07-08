<?php
class DbConnect
{
    private static $instance =  NULL;
    private $conn;
    private $servername = "mariadb";
    private $username = "root";
    private $password = "aqwe123";
    private $dbname = "puzzle_db";
    private $tableName = "ranks";

    private function __construct()
    {
        try {
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

            if ($this->conn->connect_error) {
                throw new Exception($this->conn->connect_error);
            }

            $result = $this->conn->query("SHOW TABLES LIKE '$this->tableName'");

            if (!$result->num_rows > 0) {
                // sql to create table
                $sql = "CREATE TABLE ranks (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    scores INT(30) NOT NULL,
                    words TEXT NOT NULL,
                    time_of_submission TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                    )";

                if ($this->conn->query($sql) === TRUE) {
                    echo "Table ranks created successfully.";
                } else {
                    throw new Exception("Error creating table: " . $this->conn->error);
                }
            }


            // $this->conn->close();
        } catch (Exception $e) {

            echo "Error: " . $e->getMessage();
        }
    }
    public static function getInstance()
    {

        if (!self::$instance) {
            self::$instance = new dbConnect();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}

$instance = DbConnect::getInstance();
$conn = $instance->getConnection();