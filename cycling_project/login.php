<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
</head>
<body>
    <?php
        
        include 'dbconnect.php';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                //get user's inputs. i am using $_SERVER() to check if inputs are empty
                if($_SERVER['REQUEST_METHOD']== 'POST')
                {
                      $username = $_POST['username'];//get user's input for username
                      $password = $_POST['password'];//get user's input for password
                      if(empty($username)||empty($password)){ //validate there will not be any empty inputs
                        echo "<script>
                      alert('Can't leave any empty inputs!');
                      window.location.href = 'index.html';
                      </script>";

                    }
                      $sql = $conn->prepare("SELECT * FROM user WHERE username = :username AND password = :password");//sql query to get user credentials from DB
                      $sql->bindParam(':username',$username); //binding paremeters for username
                      $sql->bindParam(':password', $password); //binding paremeters for password

                      if($sql-> execute()){//if sql query executes
                        if($sql->rowCount())//checking if there are available registers
                        $_SESSION['login'] = 1;//creating a login session

                        $row= $sql->fetch();//getting user's info from the query

                         //saving the id of the person logged in, to validate if he is the admin, he will be able to login into restricted are
                             $_SESSION['user_id'] = $row['id'];

                             if($row['id'] == 1){ //if id=admin's id land him to the admin menu page
                                echo "Hi " . $username;
                                header("Location: admin_menu.php");//redirecting admin to the admin page
                                exit;
                             }else{
                                echo "<script>
                      alert('Wrong credentials, try again!');
                      window.location.href = 'admin_login.html';
                      </script>";//display error message
                             }
                      }else{
                        echo "Error, please try again";
                      }
                }

                }
            catch(PDOException $e)
                {
                echo $e->getMessage(); //If we are not successful in connecting or running the query we will see an error
                }
        }
        else{
            echo "You're here by mistake" ;
        }
        $stmt = null;//clean memory
        ?>


</body>
</html>