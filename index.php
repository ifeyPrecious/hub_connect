<?php
include('./server/connection.php');
session_start();


$user_id =  $_SESSION['user_id'];
$username = $_SESSION['user_name'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post'])) {
    // Handle file upload
    $upload_folder = './assets/images/';
    $file_name = $_FILES['image']['name'];
    $file_tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($file_tmp, $upload_folder . $file_name);
    $image_path = $upload_folder . $file_name;

    // Get post content from the form
    $post_content = $_POST['post_content'];

    // Insert post data into the posts table
    $stmt = $conn->prepare("INSERT INTO posts (user_id, content, image) VALUES (?, ?, ?)");
    $stmt->bind_param('iss', $user_id, $post_content, $image_path);

    if ($stmt->execute()) {
        // Redirect to avoid form re-submission on refresh
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

//TO FETCH ALL
$stmt_select = $conn->prepare("SELECT * FROM posts WHERE user_id = ?");
$stmt_select->bind_param('i', $user_id);
$stmt_select->execute();
$result = $stmt_select->get_result();
$posts = $result->fetch_all(MYSQLI_ASSOC);


 


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width= , initial-scale=1.0" />
    <title>hubConnect</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css" />
    <link rel="stylesheet" href="./styles.css" />
</head>

<body>
    <nav>
        <div class="container">
            <h2 class="logo">HubConnect</h2>

            <!-- Button to send friend request -->

        </div>
    </nav>

    <main>
        <div class="container">
            <div class="left">
                <a class="profile">
                    <div class="profile-pic">
                        <img src="./images/profile-8.jpg">
                    </div>
                    <div class="handle">
                        <h4>HubConnect</h4>
                        <p class="text-muted">HubConnect</p>
                    </div>
                </a>
                <div class="sidebar">
                    <a class="menu-item active">
                        <span><i class="uil uil-home"></i></span>
                        <h3>Home</h3>
                    </a>
                    <a class="menu-item ">
                        <span><i class="uil uil-compass"></i></span>
                        <h3>Explore</h3>
                    </a>
                    <a class="menu-item" id="notifications">
                        <span><i class="uil uil-bell"><small class="notification-count">9+</small></i></span>
                        <h3>Notifications</h3>
                        <div class="notifications-popup">
                            <div>
                                <div class="profile-pic">
                                    <img src="./images/profile-10.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Abigail Willey</b> accepted your friend request
                                    <small class="text-muted">2 DAYS AGO</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-pic">
                                    <img src="./images/profile-11.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Varun Nair</b> commented on your post
                                    <small class="text-muted">1 HOUR AGO</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-pic">
                                    <img src="./images/profile-12.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Marry Opmong</b> and 210 other liked your post
                                    <small class="text-muted">4 MINUTES AGO</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-pic">
                                    <img src="./images/profile-13.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Wilson Fisk</b> started following you
                                    <small class="text-muted"> 11 HOURS AGO</small>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a class="menu-item" id="messages-notifications">
                        <i class="uil uil-envelope"><small class="notification-count">6</small></i></span>
                        <h3>Messages</h3>
                    </a>
                    <a class="menu-item ">
                        <span><i class="uil uil-bookmark"></i></span>
                        <h3>Bookmarks</h3>
                    </a>
                    <a class="menu-item ">
                        <span><i class="uil uil-analytics"></i></span>
                        <h3>Analytics</h3>
                    </a>
                    <a class="menu-item ">
                        <span><i class="uil uil-palette"></i></span>
                        <h3>Theme</h3>
                    </a>
                    <a class="menu-item ">
                        <span><i class="uil uil-setting"></i></span>
                        <h3>Settings</h3>
                    </a>

                    <label class="btn btn-primary" for="create-post">Create Post</label>
                </div>
            </div>



            <div class="middle">
                <div class="stories">
                    <div class="story">
                        <div class="profile-pic">
                            <img src="./images/profile-8.jpg" alt="">
                        </div>
                        <p class="name">Your Story</p>
                    </div>
                    <div class="story">
                        <div class="profile-pic">
                            <img src="./images/profile-9.jpg" alt="">
                        </div>
                        <p class="name">Lilla James</p>
                    </div>
                    <div class="story">
                        <div class="profile-pic">
                            <img src="./images/profile-2.jpg" alt="">
                        </div>
                        <p class="name">Jasmine Singh</p>
                    </div>
                    <div class="story">
                        <div class="profile-pic">
                            <img src="./images/profile-3.jpg" alt="">
                        </div>
                        <p class="name">Celina Fernandes</p>
                    </div>
                    <div class="story">
                        <div class="profile-pic">
                            <img src="./images/profile-4.jpg" alt="">
                        </div>
                        <p class="name">Mia Addams</p>
                    </div>
                    <div class="story">
                        <div class="profile-pic">
                            <img src="./images/profile-5.jpg" alt="">
                        </div>
                        <p class="name">Christy Kahea</p>
                    </div>
                </div>



                <form class="create-post" method="POST" action="" enctype="multipart/form-data">
                    <div class="profile-pic">
                        <img src="images/profile-8.jpg" alt="">
                    </div>
                    <input type="text" placeholder="What's on your mind <?php echo $username ?> " name="post_content" id="create-post">
                    <input type="file" name="image" accept="image/*">
                    <input type="submit" value="Post" name="post" class="btn btn-primary">

                </form>



                <div class="feeds">


                    <?php if (!empty($posts)) { ?>
                        <?php foreach ($posts as $post) { ?>

                            <div class="feed">
                                <div class="head">
                                    <p><?php echo $post['content']; ?></p>
                                </div>
                                <div class="user">
                                    <?php if (!empty($post['image'])) { ?>
                                        <div class="profile-pic">
                                            <img src="<?php echo $post['image']; ?>" class="img_size" alt="image">
                                        </div>
                                    <?php } ?>
                                    <div class="info">
                                        <h3><?php echo $username ?></h3>
                                        <small><?php ?></small>
                                    </div>
                                    <SPAN class="edit"><i class="uil uil-ellipsis-h"></i></SPAN>
                                </div>

                                <div class="photo">   

                                        <img src="<?php echo $post['image']; 
                                                    ?>" width="10" alt="Post Image">
                                </div>
                                <div class="action-button">
                                    <div class="interaction-button">
                                        <span><i class="uil uil-thumbs-up"></i></span>
                                 <span><i class="uil uil-comment"></i></span>
                                 <span><i class="uil uil-share"></i></span>
                                    </div>
                                    <div class="bookmark">
                                        <!--<span><i class="uil uil-bookmark"></i></span>  -->
                                    </div>
                                </div>

                                <div class="liked-by">
                                    <span><img src="images/profile-15.jpg"></span>
                             <span><img src="images/profile-16.jpg"></span>
                             <span><img src="images/profile-17.jpg"></span>
                             ,<p>Liked by <b>Enrest Achiever</b>snd <b>220 others</b></p>
                                </div>

                                <div class="caption">

                                    <span class="hash-tag">#lifestyle</span></p>
                                </div>
                                <div class="comments text-muted"> <!-- View all 130 comments    --></div>
                            </div>


                        <?php } ?>
                    <?php } ?>

 
                </div>
            </div>

<div class="right">
<div class="friend-requests">

<p class="text-center"><?php if (isset($_GET['request'])) {  ?></p>
                <p class="text-center text-danger"><?php echo $_GET['request']; ?></p>
                <?php } ?>
            
<h4>Requests</h4>

<?php

$user_id = $_SESSION['user_id'];

 

$stmt_select = $conn->prepare("SELECT * FROM users WHERE id != ?");
$stmt_select->bind_param("s", $user_id);
$stmt_select->execute();
$result = $stmt_select->get_result();

// Loop through the users
while ($user = $result->fetch_assoc()) {
    ?>
    <div class="request offset-3">
        <div class="info">
            <div class="profile-pic">
                <img src="<?php echo $user['user_image']; ?>" alt="Profile Picture">
            </div>
            <div>
                <h5><?php echo $user['username']; ?></h5>
            </div>
        </div>

        <?php
        // Check if a friend request exists between the current user and the user in the loop
        $stmt_check_request = $conn->prepare("SELECT * FROM friend_requests WHERE (sender_id = ? AND receiver_id = ?) OR (receiver_id = ? AND sender_id = ?)");
        $stmt_check_request->bind_param("ssss", $user_id, $user['id'], $user['id'], $user_id);
        $stmt_check_request->execute();
        $result_check_request = $stmt_check_request->get_result();

        if ($result_check_request->num_rows > 0) {
            // Friend request exists
            $request = $result_check_request->fetch_assoc();
            if ($request['status'] == 'pending') {
                ?>
                <button><a class="btn btn-primary py-5" href="friendRequest.php?friendid=<?php echo $user['id']; ?>">Cancel request</a></button>
                <?php
            } elseif ($request['status'] == 'requested') {
                ?> 
                <button type="submit" class="btn btn-info" disabled>Friend</button>
                <?php
            } elseif ($request['status'] == 'accepted') {
                ?>
                <button type="submit" class="btn btn-success" disabled>Friends</button>
                <?php
            }
        } else {
            // No friend request exists
            ?>
            <button><a class="btn btn-primary py-5" href="friendRequest.php?username=<?php echo $user['username']; ?>&friendid=<?php echo $user['id']; ?>">send request</a></button>
            <?php
        }
        

        $stmt_check_request->close();
        ?>
    </div>
<?php
}
?>

<p class="text-center">
    <?php if (isset($_GET['accept'])) { ?>
        <p class="text-center text-danger"><?php echo $_GET['accept']; ?></p>
    <?php } ?>
</p>

<?php
// Select all friend requests where the receiver is the current user
$stmt_select_requests = $conn->prepare("
    SELECT friend_requests.*, users.username AS sender_username, users.user_image AS sender_user_image
    FROM friend_requests
    INNER JOIN users ON friend_requests.sender_id = users.id
    WHERE friend_requests.receiver_id = ?
");
$stmt_select_requests->bind_param('s', $user_id);
$stmt_select_requests->execute();
$result_requests = $stmt_select_requests->get_result();

// Process the result (e.g., fetch and display the friend requests)
while ($request_row = $result_requests->fetch_assoc()) {
    ?>
    <div class="request">
        <div class="info">
            <div class="profile-pic">
                <img src="<?php echo $request_row['sender_user_image']; ?>" alt="Profile Picture">
            </div>
            <div>
                <h5><?php echo $request_row['sender_username']; ?></h5>
                <p class="text-muted">8 mutual friends</p>
            </div>
        </div>
        <div class="action">
        <?php
// Assume $request_row is the row representing the friend request
if ($request_row['status'] == 'pending') {
    ?>
    <button><a class="btn btn-primary py-5" href="acceptRequest.php?friendid=<?php echo $request_row['sender_id']; ?>&username=<?php echo urlencode($request_row['sender_username']); ?>">Accept</a></button>
    <button><a href="declineRequest.php?decline=true&requestid=<?php echo $request_row['id']; ?>">Decline</a></button>
        </div>
    <?php
} elseif ($request_row['status'] == 'requested') {
    ?>
    <button type="submit" class="btn btn-info" disabled>Friends</button>
    <button class="btn">Decline</button>
    <?php
} elseif ($request_row['status'] == 'accepted') {
    ?>
    <button type="submit" class="btn btn-success" disabled>Friends</button>
    <?php
}
?>

</div>

        </div>
    </div>
    <?php
}
$stmt_select_requests->close();
?>

 
</div>

</div>

        </div>

        </div>
        </div>
    </main>

    <script src="index.js"></script>
</body>

</html>