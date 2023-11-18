<?php 
// include('./server/connection.php');
// session_start();
// if (!isset($_SESSION['user_id'])) {
//     header('Location: login.php');
//     exit;
// }

// $user_id =  $_SESSION['user_id'];
// $username = $_SESSION['user_name'];



// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post'])) {
//     $post_content = $_POST['post_content'];
//     $stmt = $conn->prepare("INSERT INTO posts (user_id, content) VALUES (?, ?)");
//     $stmt->bind_param('ss', $user_id, $post_content);
//     $stmt->execute();
// }


 
include('./server/connection.php');
session_start();

// Check if the user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header('Location: login.php');
//     exit;
// }

// $user_id = $_SESSION['user_id'];
// $username = $_SESSION['user_name'];

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post'])) {
//     // Handle file upload
//     $upload_folder = './assets/images/';
//     $file_name = $_FILES['image']['name'];
//     $file_tmp = $_FILES['image']['tmp_name'];
//     move_uploaded_file($file_tmp, $upload_folder . $file_name);
//     $image_path = $upload_folder . $file_name;

//     // Get post content from the form
//     $post_content = $_POST['post_content'];

//     // Insert post data into the posts table
//     $stmt = $conn->prepare("INSERT INTO posts (user_id, content, image) VALUES (?, ?, ?)");
//     $stmt->bind_param('iss', $user_id, $post_content, $image_path);
//     $stmt->execute();
// }

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

// Fetch the latest posts
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
    <title>Chirag social</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css"
    />
    <link rel="stylesheet" href="./styles.css" />
  </head>
  <body>
      <nav>
            <div class="container">
                <h2 class="logo">HubConnect</h2>
                <div class="search-bar">
                    <i class="uil uil-search"></i>
                    <input
                    type="search"
                    placeholder="Search for creators, inspirations and projects"
                    />
                </div>
                <div class="create">
                    <label class="btn btn-primary" for="create-post">Create</label>
                    <div class="profile-pic">
                        <img src="images/profile-8.jpg" alt="pic 1" />
                    </div>
                </div>
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
                      <span><i class="uil uil-home"></i></span> <h3>Home</h3>
                    </a>
                    <a class="menu-item ">
                      <span><i class="uil uil-compass"></i></span> <h3>Explore</h3>
                    </a>
                    <a class="menu-item" id="notifications">
                      <span><i class="uil uil-bell"><small class="notification-count">9+</small></i></span> <h3>Notifications</h3>
                      <div class="notifications-popup">
                          <div>
                              <div class="profile-pic">
                                  <img src="./images/profile-10.jpg" >
                              </div>
                              <div class="notification-body">
                                  <b>Abigail Willey</b> accepted your friend request
                                  <small class="text-muted">2 DAYS AGO</small>
                              </div>
                          </div>
                          <div>
                              <div class="profile-pic">
                                  <img src="./images/profile-11.jpg" >
                              </div>
                              <div class="notification-body">
                                  <b>Varun Nair</b> commented on your post
                                  <small class="text-muted">1 HOUR AGO</small>
                              </div>
                          </div>
                          <div>
                              <div class="profile-pic">
                                  <img src="./images/profile-12.jpg" >
                              </div>
                              <div class="notification-body">
                                  <b>Marry Opmong</b> and 210 other liked your post
                                  <small class="text-muted">4 MINUTES AGO</small>
                              </div>
                          </div>
                          <div>
                              <div class="profile-pic">
                                  <img src="./images/profile-13.jpg" >
                              </div>
                              <div class="notification-body">
                                  <b>Wilson Fisk</b> started following you
                                  <small class="text-muted"> 11 HOURS AGO</small>
                              </div>
                          </div>
                      </div>
                    </a>
                    <a class="menu-item" id="messages-notifications">
                        <i class="uil uil-envelope"><small class="notification-count">6</small></i></span><h3>Messages</h3>
                    </a>
                    <a class="menu-item ">
                      <span><i class="uil uil-bookmark"></i></span> <h3>Bookmarks</h3>
                    </a>
                    <a class="menu-item ">
                      <span><i class="uil uil-analytics"></i></span> <h3>Analytics</h3>
                    </a>
                    <a class="menu-item ">
                      <span><i class="uil uil-palette"></i></span> <h3>Theme</h3>
                    </a>
                    <a class="menu-item ">
                      <span><i class="uil uil-setting"></i></span> <h3>Settings</h3>
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
                    <input type="text"  placeholder="What's on your mind <?php echo $username?> " name="post_content" id="create-post"> 
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
                                <img src="<?php echo $post['image']; ?>" class="img_size"  alt="image">
                            </div>
                            <?php } ?>
                            <div class="info">
                                <h3><?php echo $username ?></h3>
                                <small><?php ?></small>
                            </div>
                            <SPAN class="edit"><i class="uil uil-ellipsis-h"></i></SPAN>
                        </div>
                         
                                <div class="photo">   

                                        <img src="<?php echo $post['image']; ?>" width="10" alt="Post Image">
                                </div>
                         <div class="action-button">
                             <div class="interaction-button">
                                 <!-- <span><i class="uil uil-thumbs-up"></i></span>
                                 <span><i class="uil uil-comment"></i></span>
                                 <span><i class="uil uil-share"></i></span> -->
                             </div>
                             <div class="bookmark">
                                   <!--<span><i class="uil uil-bookmark"></i></span>  -->
                             </div>
                         </div>

                         <div class="liked-by">
                             <!-- <span><img src="images/profile-15.jpg"></span>
                             <span><img src="images/profile-16.jpg"></span>
                             <span><img src="images/profile-17.jpg"></span>
                             ,<p>Liked by <b>Enrest Achiever</b>snd <b>220 others</b></p> -->
                         </div>

                         <div class="caption">
                        
                            <span class="hash-tag">#lifestyle</span></p>
                         </div>
                         <div class="comments text-muted">  <!-- View all 130 comments    --></div>
                    </div>


                    <?php } ?>
<?php } ?>


   
                    <div class="feed">
                        <div class="head">
                            
                        </div>
                         <div class="user">
                             <div class="profile-pic">
                                 <img src="images/profile-19.jpg" alt="">
                             </div>
                             <div class="info">
                                 <h3>Karim Benzema</h3>
                                 <small>Mumbai, 30 MINUTES AGO</small>
                             </div >
                             <SPAN class="edit"><i class="uil uil-ellipsis-h"></i></SPAN>
                         </div>

                         <div class="photo">
                             <img src="images/feed-6.jpg" alt="">
                         </div>

                         <div class="action-button">
                             <div class="interaction-button">
                                 <span><i class="uil uil-thumbs-up"></i></span>
                                 <span><i class="uil uil-comment"></i></span>
                                 <span><i class="uil uil-share"></i></span>
                             </div>
                             <div class="bookmark">
                                 <span><i class="uil uil-bookmark"></i></span>
                             </div>
                         </div>

                         <div class="liked-by">
                             <span><img src="images/profile-15.jpg"></span>
                             <span><img src="images/profile-14.jpg"></span>
                             <span><img src="images/profile-17.jpg"></span>
                             ,<p>Liked by <b>Enrest Achiever</b>snd <b>150 others</b></p>
                         </div>

                         <div class="caption">
                             <p><b>Karim Benzema</b>Lorem ipsum dolor storiesquiquam eius.
                            <span class="hash-tag">#lifestyle</span></p>
                         </div>
                         <div class="comments text-muted">View all 30 comments</div>
                    </div>
                    <div class="feed">
                        <div class="head">
                            
                        </div>
                         <div class="user">
                             <div class="profile-pic">
                                 <img src="images/profile-20.jpg" alt="">
                             </div>
                             <div class="info">
                                 <h3>Srishti Tirkey</h3>
                                 <small>Bangalore, 11 HOURS AGO</small>
                             </div >
                             <SPAN class="edit"><i class="uil uil-ellipsis-h"></i></SPAN>
                         </div>

                         <div class="photo">
                             <img src="images/feed-7.jpg" alt="">
                         </div>

                         <div class="action-button">
                             <div class="interaction-button">
                                 <span><i class="uil uil-thumbs-up"></i></span>
                                 <span><i class="uil uil-comment"></i></span>
                                 <span><i class="uil uil-share"></i></span>
                             </div>
                             <div class="bookmark">
                                 <span><i class="uil uil-bookmark"></i></span>
                             </div>
                         </div>

                         <div class="liked-by">
                             <span><img src="images/profile-15.jpg"></span>
                             <span><img src="images/profile-13.jpg"></span>
                             <span><img src="images/profile-10.jpg"></span>
                             ,<p>Liked by <b>Enrest Achiever</b>snd <b>530 others</b></p>
                         </div>

                         <div class="caption">
                             <p><b>Srishti Tirkey</b>Lorem ipsum dolor storiesquiquam eius.
                            <span class="hash-tag">#lifestyle</span></p>
                         </div>
                         <div class="comments text-muted">View all 190 comments</div>
                    </div>
                </div>
              </div>
              
              <!-- <div class="right">
                  <div class="messages">
                    <div class="heading">
                        <h4>Messages</h4>
                        <span><i class="uil uil-edit"></i></span>
                    </div>
  
                    <div class="search-bar">
                        <span><i class="uil uil-search"></i></span>
                        <input type="search" placeholder="Search Messages" id="message-search">
                    </div>
  
                    <div class="category">
                        <h6 class="active">Primary</h6>
                        <h6>General</h6>
                        <h6 class="message-requests">Requests(7)</h6>
                    </div>
                    <div class="message">
                        <div class="profile-pic">
                            <img src="images/profile-17.jpg">
                            <div class="active"></div>
                        </div>
                        <div class="message-body">
                            <h5>Kareena Joshua</h5>
                            <p class="text-muted">Just woke up bruh..</p>
                        </div>
                    </div>                             
                    <div class="message">
                        <div class="profile-pic">
                            <img src="images/profile-18.jpg">
                            <div class="active"></div>
                        </div>
                        <div class="message-body">
                            <h5>Dan Smith</h5>
                            <p class="text-bold">2 New Messages</p>
                        </div>
                    </div>                             
                    <div class="message">
                        <div class="profile-pic">
                            <img src="images/profile-15.jpg">
                        </div>
                        <div class="message-body">
                            <h5>Chris Brown</h5>
                            <p class="text-muted">Lol u right</p>
                        </div>
                    </div>                             
                    <div class="message">
                        <div class="profile-pic">
                            <img src="images/profile-14.jpg">
                        </div>
                        <div class="message-body">
                            <h5>Lana Rose</h5>
                            <p class="text-bold">Birthday tomorrow!!</p>
                        </div>
                    </div>                             
                    <div class="message">
                        <div class="profile-pic">
                            <img src="images/profile-11.jpg">
                        </div>
                        <div class="message-body">
                            <h5>Varun Nair</h5>
                            <p class="text-muted">Ssup?</p>
                        </div>
                    </div>                             
                    <div class="message">
                        <div class="profile-pic">
                            <img src="images/profile-1.jpg">
                            <div class="active"></div>
                        </div>
                        <div class="message-body">
                            <h5>Jahnvi Doifode</h5>
                            <p class="text-bold">3 New Messages</p>
                        </div>
                    </div>                                                        
                </div> -->



                <!-- Button to send friend request -->
<form method="post" action="">
    <input type="hidden" name="friend_id" value="<?php echo $friendId; ?>">
    <button type="submit" name="send_request">Send Friend Request</button>
</form>

                <div class="friend-requests">
                    <h4>Requests</h4>
                    <div class="request">
                        <div class="info">
                            <div class="profile-pic">
                                <img src="images/profile-13.jpg">
                            </div>
                            <div>
                                <h5>Wilson Fisk</h5>
                                <p class="text-muted">8 mutual friends</p>
                                
                            </div>
                        </div>
                        <div class="action">
                            <button class="btn btn-primary">Accept</button>
                            <button class="btn">Decline</button>
                        </div>
                    </div>
                    <div class="request">
                        <div class="info">
                            <div class="profile-pic">
                                <img src="images/profile-20.jpg">
                            </div>
                            <div>
                                <h5>Srishti Tirkey</h5>
                                <p class="text-muted">2 mutual friends</p>
                                
                            </div>
                        </div>
                        <div class="action">
                            <button class="btn btn-primary">Accept</button>
                            <button class="btn">Decline</button>
                        </div>
                    </div>
                    <div class="request">
                        <div class="info">
                            <div class="profile-pic">
                                <img src="images/profile-5.jpg">
                            </div>
                            <div>
                                <h5>Christ Kahea</h5>
                                <p class="text-muted">1 mutual friend</p>
                                
                            </div>
                        </div>
                        <div class="action">
                            <button class="btn btn-primary">Accept</button>
                            <button class="btn">Decline</button>
                        </div>
                    </div>
            
              </div> 


               
              </div>
          </div>
      </main>

        <script src="index.js"></script>
  </body>
  
</html>
