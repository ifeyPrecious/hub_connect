<?php
session_start();
include('./server/connection.php');

// ======================= ACCEPT FRIEND REQUEST ==============================
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['friendid'], $_GET['username'])) {
    $user_id = $_SESSION['user_id'];
    $sender_id = $_GET['friendid'];
    $username = $_GET['username'];

    // Insert into friends table
    $stmt_accept_request = $conn->prepare("
        INSERT INTO friends (user_id, friend_id, username) 
        VALUES (?, ?, ?)
    ");
    $stmt_accept_request->bind_param('sss', $user_id, $sender_id, $username);
    $stmt_accept_request->execute();

    if ($stmt_accept_request->error) {
        echo "Error accepting friend request: " . $stmt_accept_request->error;
    } else {
        // Update status in friend_requests table to 'accepted'
        $updated_status = 'accepted';
        $stmt_update_status = $conn->prepare("
            UPDATE friend_requests 
            SET status = ? 
            WHERE sender_id = ? AND receiver_id = ?
        ");
        $stmt_update_status->bind_param('sss', $updated_status, $sender_id, $user_id);
        $stmt_update_status->execute();

        if ($stmt_update_status->error) {
            echo "Error updating status: " . $stmt_update_status->error;
        } else {
            // Redirect to index.php with the username as a parameter
            header("location: index.php?accept=" . urlencode("friend with {$username}"));
            exit(); // Important: Make sure to exit after sending the header
        }

        $stmt_update_status->close();
    }

    $stmt_accept_request->close();
} else {
    echo "Invalid request method or missing parameters.";
}
?>
