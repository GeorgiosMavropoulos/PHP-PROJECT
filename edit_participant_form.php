<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update participant scores</title>
    <style>
         body,html{
                  overflow: hidden;
                  font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                  background: rgb(121,50,9);
                  background: linear-gradient(90deg, rgba(121,50,9,1) 0%, rgba(36,24,0,1) 8%, rgba(78,128,138,1) 30%);
        }
    </style>
        <!----Adding bootstrap cdn links----->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Font Awesome cdn link -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
    <!----PHP script to allow only admin when is logged in to access this page---->
    <?php 
    session_start();
    if  (!isset($_SESSION['login']) || $_SESSION['login'] != 1 || $_SESSION['user_id'] != 1){ //validate that user is the admin with id=1
       echo "<script>
                alert('Please login first');
                window.location.href = 'admin_login.html';
            </script>"; //redirect him to admin login area if someone tries to come here who isn't the admin
      
    }
    ?>
<body>
    <header>
    <header>
         <!-- creating a container to style with bootstrap the header -->
        <div class="container-fluid bg-success  d-flex align-items-center p-1 justify-content-between">    
        <div class="d-flex flex-column">
        <a href="." onclick="return confirmLogout()" class="text-warning">Back to index</a>
        <!------If you admin choose to get back to index i have to logg him out 'cause i can't change the file admin_login.html to .php  so i can check if there's a session or not! 
        so i created a JS script to log him out------>
        <script>
            function confirmLogout(){
                var confirmLogout = confirm('You will be logged out if you get back to index page. Do you agree?');
                if (confirmLogout){
                    window.location.href = 'logout.php'
                    return false; //return false stops the normal transistion of the link!
                }
                else{
                    return false;
                }
            }
        </script> 
    <a href="admin_menu.php" class="text-warning">Admin Menu</a>
</div>   
    <h1 class="flex-grow-1 text-center  h4 m-0 text-info">Edit Participant Form</h1>
     <!---adding a logout button with form to execute php script------>
     <form action="logout.php" method="post"><!----using logout.php script to execute logout session-->
     <button class="btn bg-danger" type="submit" onclick="return confirm('Are you sure you want to log out?')">Logout</button>
    </form>
    </div>
</header>
    </header>
     <!-- creating a container to style with bootstrap the header -->
     <div class="container-fluid mt-5  bg-success round-5 d-flex align-items-center p-1">
     <div class="col-sm-12 w-100 d-flex justify-content-center">
        <?php
        //including connection variables    
    include 'dbconnect.php';
try {
    // connect with pdo
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //get participant's id 
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
 

        $stmt = $conn->prepare("SELECT * FROM participant WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $firstname = $row['firstname'];
        $surname = $row['surname'];
        $power_output = $row['power_output'];
        $distance_travelled = $row['distance'];
    } else {
        echo "Participant does't found";
        exit;
    }
}
catch(Exception $e){
    echo "Error: ". $e->getMessage();
    exit;
    $stmt = null;//clean memory
}     
               
        ?>
    <form action="edit_participant.php" class="form-control  w-md-50 d-flex mx-auto flex-column justify-content-center align-items-center bg-warning bg-gradient p-3" method="POST">
        Particpant Firstname<br>
        <input type="text" class="form-control mb-2" name="firstname" value="<?php echo $firstname; ?>" disabled> <br>
        Particpant Surname <br>
        <input type="text" class="form-control mb-2" name="surname"  value="<?php echo $surname; ?>" disabled> <br>
        Power output in watts<br>
        <input type="text" class="form-control mb-2" name="power_output" value="<?php echo $power_output; ?>" required> <br>
        Distance in KM<br>
        <input type="text" class="form-control mb-2" name="distance_travelled" value="<?php echo $distance_travelled ?>" required> <br>
        <input type="hidden" class="form-control mb-2" name ="id" value="<?php echo $id; ?>">

        <input type="submit" class="btn btn-success w-50" value="Update this rider">         
        
    </form>
    </div>
    </div>
        <!-----footer-->
<footer class="bg-dark text-white fixed-bottom">
    <div class="container-fluid">
        <div class="row d-flex justify-content-between align-items-center">
            <!---copyright--->
            <div class="col-sm-4 text-center text-sm-center">
                &copy; 2025 E-Cycling
            </div>
            <div class="col-sm-4 d-flex justify-content-center">
                <p class="mt-3 text-info">Cycle With us</p>
            </div>
            <!---Social Media--->
            <div class="col-sm-4 d-flex justify-content-center">
                <!---FB--->
                <a href="https://www.facebook.com" target="_blank" class="me-3">
                    <i class="fab fa-facebook-square" style="font-size: 30px; color: #3b5998;"></i>
                </a>
                <!---Insta--->
                <a href="https://www.instagram.com" target="_blank" class="me-3">
                    <i class="fab fa-instagram" style="font-size: 30px; color: #E4405F;"></i>
                </a>
                <!---twitter--->
                <a href="https://twitter.com" target="_blank">
                    <i class="fab fa-twitter" style="font-size: 30px; color: #1DA1F2;"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
<!----end-->
</body>
</html>