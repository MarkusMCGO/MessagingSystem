<?php
// send-message.php
// Connect to the database
$db = new mysqli('localhost', 'root', '', 'messages');

date_default_timezone_set('America/Vancouver');

// Check if the form has been submitted
    if(isset($_POST['message']) && isset($_POST['sender'])) {
        // Escape the message to prevent SQL injection
        $message = htmlspecialchars($db->real_escape_string($_POST['message']));
        $time = date("l, jS F Y g:i A");
        $sender = $db->real_escape_string($_POST['sender']);

        // Insert the message into the database
        $query = "INSERT INTO messages (sender, message, time) VALUES ($sender, '$message', '$time')";
        $result = $db->query($query);
        $id = mysqli_insert_id($db);

        if ($result) {
            // Return a success message
            echo json_encode(['status' => 'success', 'message' => 'Good.']);
        } else {
            // Return an error message
            echo json_encode(['status' => 'error', 'message' => $db->error]);
        }
    }

