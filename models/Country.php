<?php
// Dont directly access this file
//die;


class Country {
    // Database connection and table name
    private $conn;
    private $table = 'countries';

    // Object properties
    public $country_id;
    public $name;
    public $alias;
    public $active_number_count;

    private $maxPhoneNumbers = 30;  // max phone numbers to be displayed on countries page


    // Constructor with dependency(DB connection) injection
    public function __construct($db) {
        $this->conn = $db;
    }


    // Get all countries method
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY country_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $payload = [];

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $payload[] = $row;
            }
        }

        return json_encode([
            'status' => 'success',
            'data' => $payload
        ]);
    }


    // Get single country by ID method
    public function getById() {
        $query = "SELECT * FROM " . $this->table . "
                  WHERE country_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('i', $this->country_id);
        $stmt->execute();
        return $stmt;
    }


    // Create new country
    public function create() {
        // Prepare insert statement
        $stmt = $this->conn->prepare("INSERT INTO countries (name, alias) VALUES (?, ?)");
        if ($stmt === false) {
            die("Error preparing statement: " . $this->conn->error);
        }

        // Bind parameters. "ssi" means types are string, string, integer
        $stmt->bind_param("ss", $this->name, $this->alias);

        // Then insert data
        if( $stmt->execute() ) {
            return true;
        }
        return false;
    }


    // Increment or decrement the active_number_count value
    // Example usage:
    // updateActiveNumberCount(1);   // Increment by 1
    // updateActiveNumberCount(-1);  // Decrement by 1
    public function updateActiveNumberCount($change) {
        // Prepare update statement
        $stmt = $this->conn->prepare("
            UPDATE countries
            SET active_number_count = active_number_count + ?
            WHERE alias = ?
        ");

        // Bind parameters (i=integer, s=string)
        $stmt->bind_param("is", $change, $this->alias);

        // Execute and check results
        if ( $stmt->execute() ) {
            if ( $stmt->affected_rows > 0 ) {
                return true;
            }
        }
        return false;
    }


    public function getAllCountryBySender($country_alias) {
        // Get country information
        $stmt = $this->conn->prepare("SELECT country_id, name, alias, active_number_count
                              FROM countries
                              WHERE alias = ?");
        $stmt->bind_param("s", $country_alias);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            // Store country data
            $country_data = $result->fetch_assoc();

            $payload['country_id'] = $country_data['country_id'];
            $payload['name'] = $country_data['name'];
            $payload['alias'] = $country_data['alias'];
            $payload['active_number_count'] = $country_data['active_number_count'];
            $payload['phones'] = [];

            // Get phones for this country
            $phone_stmt = $this->conn->prepare("SELECT phone_id, number, service_status
                                        FROM phones
                                        WHERE country_id = ?
                                        ORDER BY phone_id DESC
                                        LIMIT " . $this->maxPhoneNumbers);
            $phone_stmt->bind_param("i", $country_data['country_id']);
            $phone_stmt->execute();
            $phone_result = $phone_stmt->get_result();

            if ($phone_result->num_rows > 0) {
                while($row = $phone_result->fetch_assoc()) {
                    $payload['phones'][] = [
                        'phone_id' => $row['phone_id'],
                        'number' => $row['number'],
                        'service_status' => (bool)$row['service_status']
                    ];
                }
            }

            // Close connections
            $phone_stmt->close();
            $stmt->close();
            $this->conn->close();

            return json_encode([
                'status' => 'success',
                'data' => $payload
            ]);
        }

        die(json_encode([
            'status' => 'error',
            'message' => 'Connection failed: ' . $this->conn->connect_error
        ]));
    }



    // Update country
    public function update() { /* Similar structure to create() */ }

    // Delete country
    public function delete() { /* Implementation */ }
}
?>
