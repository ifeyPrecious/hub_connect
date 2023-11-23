<?php 
include('./server/connection.php');
session_start();


// ======================= ACCEPT/REJECT FRIEND REQUEST ==============================
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['accept'])) {
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
            header("location: index.php?accept=friend with {$username}");
        }

        $stmt_update_status->close();
    }

    $stmt_accept_request->close();
}