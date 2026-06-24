<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update participants score</title>
</head>
<body>
<a href=".">Back to index</a>

    <?php
        session_start();
        if (!isset($_SESSION['user_id'])) {//don't leave logged out users to enter this page
            echo "<script>
                alert('Please login first');
                window.location.href = 'admin_login.html';
            </script>";
            exit();
        }
        //including connection variables   
        include 'dbconnect.php';

        try {
            if($_SERVER['REQUEST_METHOD'] == 'POST') //has the user submitted the form and edited the participant
            {
                //TODO - UPDATE section
                
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // fetching data
       $id = $_POST['id'];
       if(empty($power_output)||empty($distance_travelled)){ //validate there will not be any empty inputs
        echo "<script>
      alert('Can't leave any empty inputs!');
      window.location.href = 'edit_participant.php';
      </script>";
    }
       $power_output = $_POST['power_output'];
       $distance_travelled = $_POST['distance_travelled'];
  
          //sql query
          $sql = $conn->prepare("UPDATE participant SET power_output = :power_output, distance = :distance WHERE id = :id");
             $sql->bindParam(':distance', $distance_travelled);
             $sql->bindParam(':power_output', $power_output);
                $sql->bindParam(':id', $id);
          if($sql->execute()){//if statement executed display success msg
        //Js to redirect you to the view_partipants page
            echo "<script>
            alert('Update!');
            window.location.href = 'view_participants_edit_delete.php';
        </script>";
          }else{
            echo "<script>
        alert('Error');
        window.location.href = 'edit_participant.php';
    </script>";
          }

            }
            else{
                //TODO - SELECT section

                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                if (isset($_GET['id'])){
                    $id = $_GET['id']; // getting the id from the participant on the form

                    $stmt = $conn->prepare("SELECT * FROM participant WHERE id = ?");
                    $stmt->execute();
                     $row = $stmt->fetch(PDO::FETCH_ASSOC);
                     if($row){//filling the form with user's data!
                        $firstname = $row['firstname'];
                        $power_output = $row['power_output'];
                           $distance_travelled = $row['distance'];
                     }else{
                        echo "Can't find user";
                     }

                }
                include "edit_participant_form.php";
            }
        }
        catch(PDOException $e)
            {
                echo "Error : " . $e->getMessage();
            }
            $stmt=null;//manually closing connection to DB
         /**
            * For the brave souls who get this far: You are the chosen ones,
            * the valiant knights of programming who toil away, without rest,
            * fixing our most awful code. To you, true saviors, kings of men,
            * I say this: never gonna give you up, never gonna let you down,
            * never gonna run around and desert you. Never gonna make you cry,
            * never gonna say goodbye. Never gonna tell a lie and hurt you.
            */
        ?>


</body>
</html>