<?php
include('./server/connection.php');
session_start();

//=======================SEND FRIEND FRIEND REQUEST==============================
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $receiver_id = $_GET['friendid'];
    $username = $_GET['username'];
    $initial_status = 'pending';  // Initial status in the friend_requests table

    $stmt_insert_request = $conn->prepare("INSERT INTO friend_requests (sender_id, receiver_id, username, status) VALUES  (?, ?, ?, ?)");
    $stmt_insert_request->bind_param('ssss', $user_id, $receiver_id, $username, $initial_status);
    $stmt_insert_request->execute();
    $stmt_insert_request->close();

    // Now, update the status to 'requested'
   //  $updated_status = 'requested';
   //  $stmt_update_status = $conn->prepare("UPDATE friend_requests SET status = ? WHERE sender_id = ? AND receiver_id = ?");
   //  $stmt_update_status->bind_param('sss', $updated_status, $user_id, $receiver_id);
   //  $stmt_update_status->execute();
   //  $stmt_update_status->close();

    header('location:index.php?request=friend request sent');
} else {
    header('location:index.php?error=friend not request sent');
}

  

// if ($_SERVER["REQUEST_METHOD"] == "GET") {
//    $friend_id = $_GET['friendid'];
//    $username = $_GET['username'];
//    $unique_id = $_GET['uniqueid'];
   
//    $stmt_insert_request = $conn->prepare("INSERT INTO friend_requests (sender_id, receiver_id, username, unique_id) VALUES (?, ?, ?, ?)");
//    $stmt_insert_request->bind_param('ssss', $_SESSION['user_id'], $friend_id, $username, $unique_id);
//    $stmt_insert_request->execute();
//    $stmt_insert_request->close();

 
//    header('location:index.php?request=friend request sent');
// } else {
//    header('location:index.php?error=something went wrong');
// }


// friendRequest.php

// Assuming you have a database connection established (e.g., $conn)

// if ($_SERVER["REQUEST_METHOD"] == "GET") {
//    $friend_id = $_GET['friendid'];
//    $username = $_GET['username'];
//    $unique_id = $_GET['uniqueid'];

 
//    $stmt_insert_request = $conn->prepare("INSERT INTO friend_requests (sender_id, receiver_id, username, unique_id) VALUES (?, ?, ?, ?)");
//    $stmt_insert_request->bind_param('ssss', $_SESSION['user_id'], $friend_id, $username, $unique_id);
//    $stmt_insert_request->execute();
//    $stmt_insert_request->close();

  
   $stmt_select_requests = $conn->prepare("SELECT * FROM friend_requests WHERE sender_id = ?");
    $stmt_select_requests->bind_param('s', $_SESSION['user_id']);
    $stmt_select_requests->execute();
    $result_requests = $stmt_select_requests->get_result();

   
//    while ($row = $result_requests->fetch_assoc()) {
//       $sender_id = $row['sender_id'];
//       $receiver_id = $row['receiver_id'];
//       $username = $row['username'];
//       // $unique_id = $row['unique_id'];
   
//       echo "Sender ID: $sender_id, Receiver ID: $receiver_id, Username: $username, Unique ID: $unique_id<br>";
   
//   }
  

//    $stmt_select_requests->close();
 
//    header('location:index.php?request=friend request sent');
// } else {
//    header('location:index.php?error=something went wrong');
// }


?>
