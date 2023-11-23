<?php 
include('./server/connection.php');
session_start();


//=======================ACCEPT FRIEND FRIEND REQUEST==============================

// $user_id = $_SESSION['user_id']; 

// if ($_SERVER["REQUEST_METHOD"] == "GET") {
//     $sender_id = $_GET['friendid'];
//     $username = $_GET['username'];

//     $stmt_accept_request = $conn->prepare("INSERT INTO friends (user_id, friend_id, username) VALUES (?, ?, ?)");
//     $stmt_accept_request->bind_param('sss', $user_id, $sender_id, $username);
//     $stmt_accept_request->execute();
//     $stmt_accept_request->close();

//     header("location:index.php?accept=friend with {$username}");
// } else {
//     header('location:index.php?error=something went wrong');
// }



$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sender_id = $_GET['friendid'];
    $username = $_GET['username'];
    // $initial_status = 'pending';  

    // Insert into friends table
    $stmt_accept_request = $conn->prepare("INSERT INTO friends (user_id, friend_id, username, status) VALUES (?,? ,?)");
    $stmt_accept_request->bind_param('sss', $user_id, $sender_id, $username );
    $stmt_accept_request->execute();
    $stmt_accept_request->close();

// Update status in friend_requests table to 'rejected'
$updated_status = 'rejected';
$stmt_update_status = $conn->prepare("UPDATE friend_requests SET status = ? WHERE sender_id = ? AND receiver_id = ?");
$stmt_update_status->bind_param('sss', $updated_status, $sender_id, $user_id);
$stmt_update_status->execute();

if ($stmt_update_status->error) {
    echo "Error updating status: " . $stmt_update_status->error;
} else {
    echo "Status updated successfully!";
}

$stmt_update_status->close();
}