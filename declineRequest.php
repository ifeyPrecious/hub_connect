
<?php  
session_start();
include('./server/connection.php');

// ======================= DECLINE FRIEND REQUEST ==============================
// Check if a friend request has been declined
// if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['decline'])) {
//     $request_id = $_GET['requestid'];  

//     // Perform the deletion
//     $stmt_delete_request = $conn->prepare("DELETE FROM friend_requests WHERE id = ?");
//     $stmt_delete_request->bind_param('i', $request_id);
//     $stmt_delete_request->execute();
//     $stmt_delete_request->close();
    

// }

 

// ======================= DECLINE FRIEND REQUEST ==============================
 

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['decline'])) {
    $request_id = $_GET['requestid'];  

  
    $stmt_delete_request = $conn->prepare("DELETE FROM friend_requests WHERE id = ?");
    $stmt_delete_request->bind_param('i', $request_id);
    $stmt_delete_request->execute();

   
    if ($stmt_delete_request->error) {
        echo "Error executing deletion: " . $stmt_delete_request->error;
    } else {
         
        header("location: index.php");
        exit(); 
    }

    
    $stmt_delete_request->close();
}



?>