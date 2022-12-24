<?php
header('Content-Type: text/javascript');

// Connect to the database
$db = new mysqli('localhost', 'root', '', 'messages');

// Check if the displayed messages cookie is set
if (isset($_COOKIE['displayedMessages'])) {
    // If it is set, decode the cookie value and assign it to the $displayedMessages array
    $displayedMessages = json_decode($_COOKIE['displayedMessages'], true);
} else {
    // If it is not set, initialize the $displayedMessages array
    $displayedMessages = array();
}

// Select the messages from the database
$query = "SELECT * FROM messages";
$result = $db->query($query);

// Output the messages as an HTML list
while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $sender = (string)$row['sender'];
    $senderName = getUserName($sender);
    $time = $row['time'];
    $message = str_replace("'", "\'", "{$row['message']}");

    // Check if the message has been displayed before
    if (!in_array((int)$id, $displayedMessages)) {
        // Add the message to the list
        echo "document.getElementById('message-container').insertAdjacentHTML('beforeend', '<div class=\'message\'><b>$senderName: <br> $time </b><br> $message</div>');";
        // Add the message ID to the array of displayed messages
        $displayedMessages[] = (int)$id;
        setcookie('displayedMessages', json_encode($displayedMessages), 0, "/");
    }
}

// Update the displayed messages cookie with the new array

// Get the name of a user with the given ID
function getUserName($id) {
    $db = new mysqli('localhost', 'root', '', 'users');
    $query = "SELECT name FROM users WHERE id = '$id'";
    $result = $db->query($query);
    $row = $result->fetch_assoc();
    error_reporting(E_ERROR | E_PARSE);
    return (string) $row['name'];
}
