<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
         body,html{
               
                  font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                  background: rgb(121,50,9);
                  background: linear-gradient(90deg, rgba(121,50,9,1) 0%, rgba(36,24,0,1) 8%, rgba(78,128,138,1) 30%);
                /*overflow: hidden;*/
        }
                      /*
                  using media queries to make it mobile-friendly
                  */
                  @media (max-width: 767px) {
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table th, .table td {
        white-space: nowrap; 
        padding: 4px; 
    }

    .table {
        font-size: 11px; 
    }
}
    </style>
    
    <title>Search results</title>
    <!----Adding bootstrap cdn links----->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
     
     <!-- Font Awesome cdn link -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    </head>
<body>
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
    <h1 class="text-center h2 m-0 flex-grow-1 fs-3 text-info">E-Cycling</h1>
     <!---adding a logout button with form to execute php script------>
     <form action="logout.php" method="post"><!----using logout.php script to execute logout session-->
     <button class="btn bg-danger" type="submit" onclick="return confirm('Are you sure you want to log out?')">Logout</button>
    </form>
</div>
</header>
<?php

include 'dbconnect.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //validate form getting a post request
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //searching for participant
        if (isset($_POST['participant']) && $_POST['participant'] == "1") {
            $firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';  
            if(empty($firstname)){
                echo "<script>
                      alert('Can't leave any empty inputs!');
                      window.location.href = 'index.html';
                      </script>";
                      exit;
            }
            echo '<p class="text-dark text-center fs-5">Searching participant for name: ' . htmlspecialchars($firstname) . '</p>';

            $stmt = $conn->prepare("SELECT * FROM participant WHERE firstname LIKE :firstname OR surname LIKE :firstname"); //prepare statenmebt to get from DB the data
            $searchParam = '%' . $firstname . '%';
            $stmt->bindParam(':firstname', $searchParam, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //if statement executes displaying results in a table form
            if ($results) {
                echo '<div class="table-responsive">';
                echo '<table class="table table-bordered table-striped table-hover table-sm custom-table">';
                echo '<thead><tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Power Output</th>
                        <th>Distance</th>
                        <th>Club ID</th>
                      </tr></thead><tbody>';
                      //using htmlspecialchars to  prevent Cross-Site Scripting (XSS) attacks by sanitizing user input
                foreach ($results as $row) {
                    echo '<tr>';
                      echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                     echo '<td>' . htmlspecialchars($row['firstname']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['surname']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['power_output']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['distance']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['club_id']) . '</td>';
                    echo '</tr>';
                }

                echo '</tbody></table></div>';
            } else {
                echo "<div class='alert alert-warning'>Can't find participant</div>"; //error
            }
        }

       //searching for a club
        elseif (isset($_POST['club'])) {
            $club = trim($_POST['club']);
          
            if(empty($club)){
                echo "<script>
                      alert('Can't leave any empty inputs!');
                      window.location.href = 'index.html';
                      </script>";
                      exit;
            }
            echo '<p class="text-dark text-center fs-5">Searching for club: ' . htmlspecialchars($club) . '</p>';

            $stmt = $conn->prepare("SELECT * FROM club WHERE name LIKE :name"); //statement to get from DB the data
            $searchParam = '%' . $club . '%';
              $stmt->bindParam(':name', $searchParam, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
         //display data in table form if there are results
            if ($results) {
                echo '<div class="table-responsive">';
                echo '<table class="table table-bordered text-center table-striped table-hover table-sm custom-table">';
                echo '<thead><tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Location</th>
                      </tr></thead><tbody>';
                    
                foreach ($results as $row) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['location']) . '</td>';
                    echo '</tr>';
                }

                echo '</tbody></table></div>';
                $clubId = $results[0]['id'];
            } else {
                echo "<div class='alert alert-warning'>Couldn't find club</div>";
            }
        

        //creating 2nd statement
        $stmt2 = $conn->prepare("SELECT * FROM participant WHERE club_id = :club_id");
        $stmt2->bindParam(':club_id',$clubId, PDO::PARAM_INT);
        $stmt2->execute(); //executing statement
        $participants = $stmt2->fetchAll(PDO::FETCH_ASSOC);//creating a participants object

        if($participants){
            $distance = 0;
            $power = 0;
            $count = count($participants);
        
            foreach($participants as $players){
                $distance += $players['distance'];
                $power += $players['power_output'];
            }
            //calculating average distance and power
            $avg_distance = $count > 0 ? $distance / $count : 0;  
             $avg_power = $count > 0 ?  $power / $count : 0;

             //display statics
             echo "<div class='mt-2 mb-3 table-responsive'>";
             echo "<table class='table table-bordered table-sm'>";
             echo "<thead><tr><th colspan='2' class='text-center'>Club Statistics</th></tr></thead>";
             echo "<tbody>";
             echo "<tr><td><strong>Total Distance</strong></td><td>" . round($distance, 2) . " km</td></tr>";
                      echo "<tr><td><strong>Total Power</strong></td><td>" . round($power, 2) . " W</td></tr>";
             echo "<tr><td><strong>Average Distance</strong></td><td>" . round($avg_distance, 2) . " km</td></tr>";
             echo "<tr><td><strong>Average Power</strong></td><td>" . round($avg_power, 2) . " W</td></tr>";
             echo "</tbody>";
             echo "</table>";
             echo "</div>";
             //displaying players
             echo "<div class='mt-2 mb-3 table-responsive'>";
  
                   echo "<table class='table table-sm table-bordered'>";
    echo "<thead><tr><th colspan='5' class='text-center text-bold'>Club's Players</th></tr>";
    echo "<thead><tr>
    
            <th>First Name</th>
                  <th>Surname</th>
                          <th>Email</th>
            <th>Power Output</th>
            <th>Distance</th>
          </tr></thead><tbody>";

    foreach ($participants as $players) {
        echo "<tr>";
                 echo "<td>" . htmlspecialchars($players['firstname']) . "</td>";
        echo "<td>" . htmlspecialchars($players['surname']) . "</td>";
               echo "<td>" . htmlspecialchars($players['email']) . "</td>";
                echo "<td>" . htmlspecialchars($players['power_output']) . " W</td>";
        echo "<td>" . htmlspecialchars($players['distance']) . " km</td>";
                  echo "</tr>";
    }

    echo "</tbody></table></div>";
    echo "</td></tr>";
}
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage(); // error
}
$stmt=null;//manually closing connection to DB
?>


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