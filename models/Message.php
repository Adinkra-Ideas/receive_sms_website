<?php
// Dont directly access this file
//die;

class Message {
    // Database connection and table name
    private $conn;
    private $table = 'messages';

    // Object properties
    public $message_id;
    public $phone_id;
    public $sender;
    public $sms;
    public $send_time;

    //
    private $maxMessages = 42;          /* if a phone number has more than this, the excess will be deleted */


    // Constructor with dependency(DB connection) injection
    public function __construct($db) {
        $this->conn = $db;
    }


    // Create new message
    public function create($receiver) {
        // So, since this messages table has a key named phone_id that is a child of another key
        // in phones also named phone_id, the proper insert approach would be to first ensure
        // the receiver number we have received exists in the phones table in number column. If yes,
        // Then pick the phone_id from the phones table and use it to insert into the messages table.
        // The database remains clean as a result of this relationship.

        // Prepare the search and retrieve statement
        $stmt = $this->conn->prepare("SELECT phone_id FROM phones WHERE number = ?");
        $stmt->bind_param("s", $receiver);
        $stmt->execute();
        $stmt->store_result();

        // If the phone_id exists in phones, now retrieve the phone_id and then use it to insert into messages table
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($this->phone_id);
            $stmt->fetch();

            // retrieve current time for lagos nigeria
            date_default_timezone_set('Africa/Lagos');
            $this->send_time = date('Y-m-d H:i:s');

            // Prepare insert statement
            $query = "INSERT INTO {$this->table} (phone_id, sender, sms, send_time) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            if ($stmt === false) {
                die("Error preparing statement: " . $this->conn->error);
            }

            // Bind parameters
            $stmt->bind_param("isss", $this->phone_id, $this->sender, $this->sms, $this->send_time);

            // Then insert data
            if( $stmt->execute() ) {
                // echo "statement execd ";
                // Now after we've added a number, if the message count for this number
                // exceeds $this->maxMessages, we trim it down to $this->maxMessages count
                $this->trimMessagesToSpecifiedMaxCount($this->phone_id);

                return true;
            }
        }
        return false;
    }


    // for trimming messages of a specific number to max 42
    public function trimMessagesToSpecifiedMaxCount($thePhoneId) {
        // 1. Check current message count
        $countStmt = $this->conn->prepare("SELECT COUNT(*) AS count FROM messages WHERE phone_id = ?");
        $countStmt->bind_param("i", $thePhoneId);
        $countStmt->execute();
        $result = $countStmt->get_result();
        $row = $result->fetch_assoc();
        $currentCount = $row['count'];
        $countStmt->close();

        if ($currentCount > $this->maxMessages) {
            // 2. Find the cutoff time for the 42nd newest message
            $cutoffStmt = $this->conn->prepare("
                SELECT message_id
                FROM messages
                WHERE phone_id = ?
                ORDER BY message_id DESC
                LIMIT 1 OFFSET ?
            ");
            $offset = $this->maxMessages - 1;
            $cutoffStmt->bind_param("ii", $thePhoneId, $offset);
            $cutoffStmt->execute();
            $cutoffResult = $cutoffStmt->get_result();

            if ($cutoffResult->num_rows > 0) {
                $cutoffRow = $cutoffResult->fetch_assoc();
                $trimOffFromId = $cutoffRow['message_id'];
                $cutoffStmt->close();

                // 3. Delete older messages
                $deleteStmt = $this->conn->prepare("
                    DELETE FROM messages
                    WHERE phone_id = ?
                    AND message_id < ?
                ");
                $deleteStmt->bind_param("ii", $thePhoneId, $trimOffFromId);
                $deleteStmt->execute();

                $deletedCount = $deleteStmt->affected_rows;
                $deleteStmt->close();
            }
        }
    }


    // get all messages for a phone number
    public function getAllMessageBySender($theReceiver) {
        // First retrieve the phone_id from phones table
        // where number == $theReceiver
        // Prepare the search and retrieve statement
        $stmt = $this->conn->prepare("SELECT service_status, country_id, phone_id FROM phones WHERE number = ?");
        $stmt->bind_param("s", $theReceiver);
        $stmt->execute();
        $stmt->store_result();

        // If phone_id of the receiving sms number is found in phones table
        // we collect the phone_id and use it to select all the associated
        // messages from messages table
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($serviceStatus, $countryId, $this->phone_id);
            $stmt->fetch();

            // Prepare and execute query
            $stmt = $this->conn->prepare("SELECT * FROM messages WHERE phone_id = ? ORDER BY message_id DESC");
            $stmt->bind_param("i", $this->phone_id);
            $stmt->execute();

            // Get result
            $result = $stmt->get_result();
            $theMessages = [];

            // Fetch all matching messages
            while ($row = $result->fetch_assoc()) {
                // add the full row to theMessages array
                $theMessages[] = $row;
            }

            // now we need to read the country and country_alias of this
            // $theReceiver phone number from countries table using the
            // $countryId we retrieved as key
            // Prepare and execute query
            $stmt = $this->conn->prepare("SELECT name, alias FROM countries WHERE country_id = ?");
            $stmt->bind_param("i", $countryId);
            $stmt->execute();
            $stmt->store_result();

            // Check if any results found
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($theCountry, $theCountryAlias);
                $stmt->fetch();
                // now we have the $theCountry and $theCountryAlias variables

                // Add service_status, country and country_alias to the payload
                // first add this number to the payload
                $thePayload['number'] = $theReceiver;
                $thePayload['service_status'] = ($serviceStatus ? true : false);
                $thePayload['country'] = $theCountry;
                $thePayload['country_alias'] = $theCountryAlias;
                $thePayload['messages'] = $theMessages;

                // Output JSON
                // ensuring that it returns the correct JSON structure,
                // whether there's data or not in our theMessages array
                if (count($theMessages) > 0) {
                    return json_encode([
                        'status' => 'success',
                        'count' => count($theMessages),
                        'data' => $thePayload
                    ]);
                } else {
                    return json_encode([
                        'status' => 'success',
                        'count' => 0,
                        'data' => $thePayload,
                        'message' => 'No messages found from sender '
                    ]);
                }
            }
        }

        die(json_encode([
            'status' => 'error',
            'message' => 'Connection failed: ' . $this->conn->connect_error
        ]));
    }


}
?>
