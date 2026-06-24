<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete participant</title>
</head>
<body>
    <?php 
    session_start();
    if  (!isset($_SESSION['login']) || $_SESSION['login'] != 1 || $_SESSION['user_id'] != 1){ //validate that user is the admin with id=1
       echo "<script>
                alert('Please login first');
                window.location.href = 'admin_login.html';
            </script>"; //redirect him to admin login area if someone tries to come here who isn't the admin  
    }
  
    ?>

    <?php
       
    include 'dbconnect.php';

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                //TODO DELETE - complete the functionality
                  if(isset($_GET['id'])){ //getting user's id
                    $id = $_GET['id'];  
                }
                $sql = $conn->prepare("DELETE FROM participant WHERE id = ?");//deleting participant with correct id!
                $sql->bindParam(1,$id);
                if($sql->execute()){//if sql execute display deleted window
                    echo "<script>
    alert('Deleted!');
    window.location.href = 'view_participants_edit_delete.php';
</script>";
                }else{
                    echo "<script
    alert('Error');
    window.location.href = 'view_participants_edit_delete.php';
</script>";
                }
                }
            catch(PDOException $e)
                {
                    echo "Error: ". $e->getMessage(); // if we are not successfull an error message will pop up
                }
                $stmt=null;//manually closing connection to DB
        
        
        ?>


</body>
</html>