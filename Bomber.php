<?php

require_once dirname(__FILE__, 1) . '/models/Message.php';
require_once dirname(__FILE__, 1) . '/models/UnsentSMS.php';

// 2. Include your database connection file
require_once dirname(__FILE__, 1) . '/config/Database.php';

// 3. Obtain a database connection
$database = new Database();
$conn = $database->getConnection();

// Instantiate required models
$message = new Message($conn);
$unsent_sms = new UnsentSMS($conn);


// Get all active phone numbers
$phone_query = "SELECT number FROM phones WHERE service_status = 1";
$phone_result = $conn->query($phone_query);

if ($phone_result->num_rows > 0) {

    while($phone_row = $phone_result->fetch_assoc()) {
        $number = $phone_row['number'];

        // Generate random 0 or 1
        $random_choice = mt_rand(0, 1);
        if ($random_choice === 1) {
            // Start transaction
            $conn->begin_transaction();
            try {
                // Get and lock oldest unsent SMS
                $sms_stmt = $conn->prepare(
                    "SELECT id, sender, sms
                    FROM unsent_sms
                    ORDER BY id ASC
                    LIMIT 1
                    FOR UPDATE"
                );
                $sms_stmt->execute();
                $sms_result = $sms_stmt->get_result();

                if ($sms_result->num_rows > 0) {
                    $sms_row = $sms_result->fetch_assoc();

                    // Delete the retrieved SMS
                    $delete_stmt = $conn->prepare(
                        "DELETE FROM unsent_sms
                        WHERE id = ?"
                    );
                    $delete_stmt->bind_param("i", $sms_row['id']);
                    $delete_stmt->execute();

                    // Commit transaction
                    $conn->commit();

                    // Send the sms to this active number on website
                    $message->sender = $sms_row['sender'];
                    $message->sms = $sms_row['sms'];
                    $message->create($number);

                    // re-insert sms back to unsent_sms table,
                    // but this time, as the newest sms
                    $unsent_sms->create($sms_row['sender'], $sms_row['sms']);
                } else {
                    // No SMS to process
                    $conn->rollback();
                }
            } catch (Exception $e) {
                $conn->rollback();
            }
        }
    }
}

?>


