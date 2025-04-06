<?php
// Dont directly access this file
//die;

class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = 'root';
    private $db_name = 'receive_sms';

    private $conn;


    // Constructor with database configuration
    // creates the database and tables if not exist
    public function __construct() {
        // Create connection
        $this->conn = new mysqli($this->host, $this->username, $this->password);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        // Checking if database not yet exist so it can create the database
        $sql = "SELECT COUNT(*) AS `exists` FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMATA.SCHEMA_NAME='$this->db_name'";
        $res = $this->conn->query($sql);
        $row = $res->fetch_object();
        $dbExists = (bool) $row->exists;
        if (! $dbExists) {
            // Create database
            $sql = "CREATE DATABASE IF NOT EXISTS $this->db_name";
            if ($this->conn->query($sql) === TRUE) {
                // echo  "Database created successfully\n";
            } else {
                // echo  "Error creating database: " . $this->conn->error . "\n";
            }
        }

        // Select database
        $this->conn->select_db($this->db_name);

        // Checking if database is new so it can create the required tables
        $sql = "SELECT 1 FROM countries LIMIT 1";
        if ($this->conn->query($sql) === FALSE) {
            // Create countries table
            $sql = "CREATE TABLE IF NOT EXISTS countries (
                country_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(50) NOT NULL UNIQUE,
                alias VARCHAR(10) NOT NULL UNIQUE,
                active_number_count INT NOT NULL DEFAULT 0
            ) ENGINE=InnoDB";

            if ($this->conn->query($sql) === TRUE) {
                // echo  "Table 'countries' created successfully\n";
            } else {
                // echo  "Error creating table 'countries': " . $this->conn->error . "\n";
            }
        }

        // Checking if database is new so it can create the required tables
        $sql = "SELECT 1 FROM phones LIMIT 1";
        if ($this->conn->query($sql) === FALSE) {
            // Create phones table
            $sql = "CREATE TABLE IF NOT EXISTS phones (
                phone_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                country_id INT UNSIGNED NOT NULL,
                number VARCHAR(20) NOT NULL UNIQUE,
                service_status BOOLEAN NOT NULL,
                FOREIGN KEY (country_id) REFERENCES countries(country_id)
            ) ENGINE=InnoDB";

            if ($this->conn->query($sql) === TRUE) {
                // echo  "Table 'phones' created successfully\n";
            } else {
                // echo  "Error creating table 'phones': " . $this->conn->error . "\n";
            }
        }


        // Checking if database is new so it can create the required tables
        $sql = "SELECT 1 FROM messages LIMIT 1";
        if ($this->conn->query($sql) === FALSE) {
            // Create messages table
            $sql = "CREATE TABLE IF NOT EXISTS messages (
                message_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                phone_id INT UNSIGNED NOT NULL,
                sender VARCHAR(20) NOT NULL,
                sms TEXT NOT NULL,
                send_time DATETIME NOT NULL,
                FOREIGN KEY (phone_id) REFERENCES phones(phone_id)
            ) ENGINE=InnoDB";

            if ($this->conn->query($sql) === TRUE) {
                // echo  "Table 'messages' created successfully\n";
            } else {
                // echo  "Error creating table 'messages': " . $this->conn->error . "\n";
            }
        }


        // Checking if database is new so it can create the required tables
        $sql = "SELECT 1 FROM unsent_sms LIMIT 1";
        if ($this->conn->query($sql) === FALSE) {
            // Create unsent_sms table
            $sql = "CREATE TABLE IF NOT EXISTS unsent_sms (
                id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                sender VARCHAR(20) NOT NULL,
                sms TEXT NOT NULL
            ) ENGINE=InnoDB";

            if ($this->conn->query($sql) === TRUE) {
                // echo  "Table 'messages' created successfully\n";
            } else {
                // echo  "Error creating table 'messages': " . $this->conn->error . "\n";
            }
        }
    }


    // Get the database connection
    public function getConnection() {
        return $this->conn;
    }


    // Close connection (optional)
    public function closeConnection() {
        $this->conn->close();
    }

}
?>
