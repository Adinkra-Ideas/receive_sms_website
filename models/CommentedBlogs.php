<?php


class CommentedBlogs {
    // Database connection and table name
    private $conn;
    private $table = 'phones';

    // Object properties
    public $url_id;
    public $domainn;
    public $comment_time;


    // Constructor with dependency(DB connection) injection
    public function __construct($db) {
        $this->conn = $db;
    }


    // Create add new commented blog
    public function create($url) {
        $domain = strtolower($url);

        // Validate domain length
        if (strlen($domain) > 64) {
            return ['status' => 'error', 'message' => 'Domain exceeds maximum length of 64 characters'];
        }

        // retrieve current time for lagos nigeria
        date_default_timezone_set('Africa/Lagos');
        $the_timezone = date('Y-m-d H:i:s');

        // Attempt to insert new record
        $stmt = $this->conn->prepare("
            INSERT INTO commented_blogs (domainn, comment_time)
            VALUES (?, ?)
        ");
        if (!$stmt) {
            return ['status' => 'error', 'message' => 'Prepare failed: ' . $this->conn->error];
        }

        $stmt->bind_param('ss', $domain, $the_timezone);
        $insertResult = $stmt->execute();
        $stmt->close();

        if ($insertResult) {
           return ['status' => 'success', 'message' => 'success'];
        }
        // Handle duplicate entry
        else {
            $stmt = $this->conn->prepare("
                SELECT comment_time
                FROM commented_blogs
                WHERE domainn = ?
            ");

            if (!$stmt) {
                return ['status' => 'error', 'message' => 'Prepare failed: ' . $this->conn->error];
            }

            $stmt->bind_param('s', $domain);
            $stmt->execute();
            $result = $stmt->get_result();
            $existing = $result->fetch_assoc();
            $stmt->close();

            if ($existing) {
                return [
                    'status' => 'error',
                    'message' => $domain . ' domain existing already since ' . $existing['comment_time']
                ];
            }
            return ['status' => 'error', 'message' => 'Duplicate entry not found'];
        }
    }
}
?>
