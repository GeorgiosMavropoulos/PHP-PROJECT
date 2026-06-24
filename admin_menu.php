<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin menu</title>
    <style>
          /* css for body to change font-family and remove over flow on right n left*/
          body,html{
                  overflow: hidden;
                  font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                  background: rgb(121,50,9);
                  background: linear-gradient(90deg, rgba(121,50,9,1) 0%, rgba(36,24,0,1) 8%, rgba(78,128,138,1) 30%);
        }
            /* added hover to make size larger when mouse is over links*/
            a.hover-effect:hover {
    font-size: 20px;
}

        /* aligning container with links in the middle of the page*/
        .border-primary{
                         margin-top: 100px;
                        
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
    <h1 class="text-center h2 m-0 flex-grow-1 text-info">Cit-E Cycling web portal</h1>
    <!---adding a logout button with form to execute php script------>
    <form action="logout.php" method="post"><!----using logout.php script to execute logout session-->
     <button class="btn bg-danger" type="submit" onclick="return confirm('Are you sure you want to log out?')">Logout</button>
    </form>
</div>
</header>
    <ul class="list-unstyled">
        <!-- styling with bootstrap the links -->
        <div class="container border w-30 bg-success rounded-3 border-2 border-primary p-3">
    <div class="row">
        <div class="col-sm-12 text-center">
        <li><a class="text-decoration-none text-warning hover-effect" href="search_form.php">Search for clubs or participants</a></li>
        <li><a class="text-decoration-none text-warning hover-effect" href="view_participants_edit_delete.php">View all participants to either edit or delete</a></li>
</div>
</div>
</div>
    </ul> 

    <!-------Img banner--------->
    <div class="container bg-light p-4 rounded">
    <div class="row align-items-center">
        <div class="col-md-6 text-center mb-3 mb-md-0">
            <img style="width: 100%; border-radius: 10px; max-width: 600px;" alt="cycling-contest" class="round-5" src="img/cycling2.jpg">
        </div>
        <div class="col-md-6 d-flex align-items-center">
            <p class="color-dark text-center fs-4 text-success">Behind every great race stands a silent sentinel — the keeper of the path, the guardian of tradition.
                 Through code and chaos, updates and storms, the admin holds the reins with steady hands. With the heart of a knight and the mind of a strategist,
                 they ensure that each rider’s journey begins with purpose and ends with pride. To the unseen herald of Sunderland’s noble quest — we salute you</p>
        </div>
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