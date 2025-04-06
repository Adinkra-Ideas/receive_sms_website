<?php

class UnsentSMS {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new unsent SMS
    public function create($sender, $sms) {
        $stmt = $this->conn->prepare("INSERT INTO unsent_sms (sender, sms) VALUES (?, ?)");

        // Validate sender format (basic check)
        $clean_sender = trim($sender);
        if (empty($clean_sender)) {
            return false;
        }

        // Validate SMS content
        $clean_sms = trim($sms);
        if (empty($clean_sms)) {
            return false;
        }

        $stmt->bind_param("ss", $clean_sender, $clean_sms);

        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return false;
    }

    // Get all unsent SMS (with optional limit)
    public function getAll($limit = 100) {
        $stmt = $this->conn->prepare("SELECT id, sender, sms FROM unsent_sms ORDER BY id ASC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();

        $result = $stmt->get_result();
        $messages = [];

        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }

        return $messages;
    }

    // Delete SMS by ID (after sending)
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM unsent_sms WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Mark SMS as sent (delete after processing)
    public function markAsSent($id) {
        return $this->delete($id);
    }

    // Get count of unsent messages
    public function getCount() {
        $result = $this->conn->query("SELECT COUNT(*) AS count FROM unsent_sms");
        $row = $result->fetch_assoc();
        return $row['count'];
    }
}


?>
