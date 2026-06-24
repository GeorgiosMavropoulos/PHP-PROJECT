
<?php 
//session destroy log's y out
    session_start();
    if  (!isset($_SESSION['login']) || $_SESSION['login'] != 1 || $_SESSION['user_id'] != 1){ //validate that user is the admin with id=1
       echo "<script>
                alert('Please login first');
                window.location.href = 'admin_login.html';
            </script>"; //redirect him to admin login area if someone tries to come here who isn't the admin  
            exit();
    }
session_destroy();
header("Location: index.html");//redirect admin into login page when he logs out


?>