<!-- Database.php -->

<?php

class Database {
    private $host = "localhost"; 
    private $username = "root"; 
    private $password = ""; 
    private $database = "tournament_management_system";
    private $conn;

    // Constructor to establish the database connection
    public function __construct() {
        $this->conn = $this->connectDB();
    }

    // Function to establish a database connection
    private function connectDB() {
        $conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    // Function to get the database connection
    public function getConnection() {
        return $this->conn;
    }

    // Function to close the database connection
    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}

?>
