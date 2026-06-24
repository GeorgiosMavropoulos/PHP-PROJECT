<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register your interest</title>
</head>
<body>


    <?php
    //including connection variables  
    include 'dbconnect.php';

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //if user does not come from register form and inputs aren't transfered by post method inside server, display error message else send the sql queries
                    if ($_SERVER['REQUEST_METHOD'] != 'POST') { //added !='POST' to display error message if someone just type on browser register.php
    echo "<script>
        alert('You skipped the register form accidently');
        window.location.href = 'register_form.html';
    </script>";
    exit;
}else {
                //TODO INSERT - complete the functionality
                 //validate that form isn't empty
                       $firstname = $_POST['firstname']; //get user's input for 1stname
                       $surname = $_POST['surname']; //get user's input for lastname
                       $email = $_POST['email']; //get user's input for email
                       $terms = isset($_POST['terms']) ? 1 : 0; //get terms acceptance and change yes into 1 and no into 0, because database accept integer and not characters
                             
                       if(empty($username)||empty($surname)||empty($email)||empty($terms)){ //validate there will not be any empty inputs
                        echo "<script>
                      alert('Can't leave any empty inputs!');
                      window.location.href = 'register_form.html';
                      </script>";
  
                    }
                    
                       //validating user hasn't  been already registered
                       $stmt = $conn->prepare("SELECT COUNT(*) FROM interest WHERE firstname = :firstname AND surname = :surname");
                       $stmt->bindParam(':firstname',$firstname);
                       $stmt->bindParam(':surname',$surname);
                        $stmt->execute();
                       if($stmt->fetchColumn() > 0){
                        echo "<script>
                      alert('Cycler is already registered!');
                      window.location.href = 'register_form.html';
                      </script>";
                     exit;
                    }

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //validating that user will enter a valid email
                      echo "<script>
                          alert('Invalid email format!');
                          window.location.href = 'register_form.html';
                      </script>";
                      exit;
                  }

                    //insert in DB
                     $stmt = $conn->prepare("INSERT INTO interest (firstname,surname,email,terms)VALUES (:firstname, :surname, :email, :terms)");
                     //biding parameteres
                     $stmt->bindParam(':firstname' , $firstname);
                     $stmt->bindParam(':surname', $surname);
                     $stmt->bindParam(':email', $email);
                     $stmt->bindParam(':terms', $terms);

                     if($stmt->execute()){
                        //Js to redirect you to the view_partipants page
                     echo "<script>
                      alert('Registered with success!');
                      window.location.href = 'register_form.html';
                      </script>";
                     }else{
                      
                        echo "<script>
                         alert('Error occured');
                       window.location.href = 'index.php';
                      </script>";
                     }
      }
                  }               
                
            catch(PDOException $e)
                {
                echo $e->getMessage(); //If we are not successful we will see an error

                }
                
              //made you look
              $stmt=null;//manually closing connection to DB
        
        ?>


</body>
</html>