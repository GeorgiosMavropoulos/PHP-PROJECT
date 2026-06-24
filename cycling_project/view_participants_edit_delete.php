<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View participants</title>
    <style>
         body,html{             
                  font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                  background: rgb(121,50,9);
                  background: linear-gradient(90deg, rgba(121,50,9,1) 0%, rgba(36,24,0,1) 8%, rgba(78,128,138,1) 30%);
        }

        /* applying css on the table*/
        .costume-table{
         width: 60%;
         margin: 30px auto;
        text-align: center;
        font-size: 12px;
        }

           
    .custom-table th, .custom-table td {
        font-size: 16px; /* decrease font-size */
        padding: 5px;    /*deacreasing padding */
        text-align: center; /* centering text */
    }

   
    .custom-table td {
        height: 25px; /* decreasing line td height*/
        width: 20px;
        margin: 5px;
    }

    /*using media queries to make it responsive for mobile*/
    @media (max-width: 768px) {
  .custom-table td, .custom-table th {
    font-size: 9px;
    padding: 1px;
  }
  .text-info{
    font-size: 5px;
  }
 
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
         <!-- creating a container to style with bootstrap the header -->
         <div class="container-fluid bg-success round-5 d-flex align-items-center p-1">
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
    <h1 class="text-center h2 m-0 flex-grow-1 fs-3 text-info">View participants for edit or delete</h1>
     <!---adding a logout button with form to execute php script------>
     <form action="logout.php" method="post"><!----using logout.php script to execute logout session-->
     <button class="btn bg-danger" type="submit" onclick="return confirm('Are you sure you want to log out?')">Logout</button>
    </form>
</div>
</header>
    <?php
        
    //including connection variables - remember to update these if you are using XAMPP    
    include 'dbconnect.php';
        
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //TODO SELECT - view the participants with links to edit or delete them. 
            $sql = "SELECT * FROM participant ORDER BY id"; // sql query to display all participants
            echo '<div class="table-responsive">'; // <-- making table responsive
               echo '<table class="table table-bordered table-striped table-hover table-sm custom-table">';
               echo '<thead>';
               echo '<tr>';
               echo '<th>ID</th>';
               echo '<th>First Name</th>';
               echo '<th>Surname</th>';
               echo '<th>Email</th>';
               echo '<th>Power Output</th>';
               echo '<th>Distance</th>';
               echo '<th>Club ID</th>';
               echo '<th colspan="2">Actions</th>'; 
               echo '</tr>';
               echo '</thead>';
               echo '<tbody>';
            //for each loop to diplay all participants and each echo will diplay results in a table form
            foreach($conn->query($sql, PDO::FETCH_ASSOC) as $row) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['firstname'] . '</td>';
                echo '<td>' . $row['surname'] . '</td>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td>' . $row['power_output'] . '</td>';
                echo '<td>' . $row['distance'] . '</td>';
                echo '<td>' . $row['club_id'] . '</td>';
                echo '<td><a href="edit_participant_form.php?id=' . $row['id'] . '" class="btn btn-sm btn-warning">Edit</a></td>';
                echo '<td><a href="delete.php?id=' . $row['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete?\')">Delete</a></td>';
                echo '</tr>';
            }
            echo '</tbody>';
          echo '</table>';
            echo '</div>';
            }
        catch(PDOException $e)
            {
            echo $e->getMessage(); //If we are not successful we will see an error
            }
            $stmt=null;//manually closing connection to DB
        ?>

< <!-----footer-->
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
            <div>
        </div>
    </div>
</footer>
<!----end--> 
</body>
</html>