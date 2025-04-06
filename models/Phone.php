<?php
// Dont directly access this file
//die;


class Phone {
    // Database connection and table name
    private $conn;
    private $table = 'phones';

    // Object properties
    public $phone_id;
    public $country_id;
    public $number;
    public $service_status;
    public $messages = []; // For related messages

    //
    public $country_alias;


    // Constructor with dependency(DB connection) injection
    public function __construct($db) {
        $this->conn = $db;
    }


    // Get all phones
    public function getAll() {
        $query = "SELECT
                    phones.phone_id,
                    phones.country_id,
                    phones.number,
                    phones.service_status,
                    countries.name AS country_name,
                    countries.alias AS country_alias
                  FROM phones
                  LEFT JOIN countries
                    ON phones.country_id = countries.country_id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;

        // the above will return a merger of both the phone numbers in phones and their reference key data from countries like so:
        // phone_id	country_id      number      service_status	country_name	country_alias
        //        1      1          +14155550135	1               United States	USA
        //        2      2          +16135551234	0               Canada          CA
    }



    // Create new phone number
    public function create() {
        // So, since this phones table has a key named country_id that is a child of another key
        // in countries also named country_id, the proper insert approach would be to first ensure
        // the country alias we have received exists in the countries table. If yes,
        // Then pick the country_id from the countries table and use it to insert into the phones table.
        // The database remains clean as a result of this relationship.

        // Prepare the search and retrieve statement
        $stmt = $this->conn->prepare("SELECT country_id FROM countries WHERE alias = ?");
        $stmt->bind_param("s", $this->country_alias);
        $stmt->execute();
        $stmt->store_result();

        // If the alias is found in countries, now retrieve the country_id and then use it to insert into phones table
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($this->country_id);
            $stmt->fetch();

            // Prepare insert statement
            $stmt = $this->conn->prepare("INSERT INTO {$this->table} (country_id, number, service_status) VALUES (?, ?, ?)");
            if ($stmt === false) {
                die("Error preparing statement: " . $this-conn->error);
            }

            // Bind parameters
            $stmt->bind_param("isi", $this->country_id, $this->number, $this->service_status);

            // Then insert data
            if( $stmt->execute() ) {
                return true;
            }
        }


        return false;
    }


    // Set the status of a phone number active or inactive
    // Example usage:
    // $this->service_status == true      // status becomes active
    // $this->service_status == false;    // status becomes inactive
    public function updateServiceStatus() {
        // Prepare update statement
        $stmt = $this->conn->prepare("
            UPDATE {$this->table}
            SET service_status = ?
            WHERE number = ?
        ");

        // Bind parameters (i=integer, s=string)
        $stmt->bind_param("is", $this->service_status, $this->number);

        // Execute and check results
        if ( $stmt->execute() ) {
            if ( $stmt->affected_rows > 0 ) {
                return true;
            }
        }
        return false;
    }



    // Get phones by country ID
    public function getByCountryId() {
        $query = "SELECT * FROM {$this->table}
                  WHERE country_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('i', $this->country_id);
        $stmt->execute();
        return $stmt;
    }

    // Get related messages (requires Message model)
    public function getMessages() {
        $query = "SELECT * FROM messages
                  WHERE phone_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('i', $this->phone_id);
        $stmt->execute();
        return $stmt;
    }
}
?>
