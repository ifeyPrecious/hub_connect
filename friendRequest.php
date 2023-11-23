<?php
include('./server/connection.php');
session_start();

// ======================= SEND FRIEND REQUEST ==============================
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['friendid'], $_GET['username'])) {
   $user_id = $_SESSION['user_id'];
   $receiver_id = $_GET['friendid'];
   $username = $_GET['username'];
   $initial_status = 'pending'; // Initial status in the friend_requests table

   // Insert into friend_requests table
   $stmt_insert_request = $conn->prepare("INSERT INTO friend_requests (sender_id, receiver_id, username, status) VALUES (?, ?, ?, ?)");
   $stmt_insert_request->bind_param('ssss', $user_id, $receiver_id, $username, $initial_status);
   $stmt_insert_request->execute();

   if ($stmt_insert_request->error) {
       echo "Error sending friend request: " . $stmt_insert_request->error;
   } else {
       header('location: index.php?request=friend request sent');
   }

   $stmt_insert_request->close();
} else {
   header('location: index.php?error=friend request not sent');
}


?>
