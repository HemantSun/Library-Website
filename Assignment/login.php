<?php
//starts session, which tracks our users session throughout websites, if there is or isnt one
session_start();

//this uses our databases php, to utilise code reuse, so we dont have to  manually write the connection to the database
require_once 'databases.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/c13e82a8d6" crossorigin="anonymous"></script>
    <title>Login</title>
</head>
<body>
    <header>
        <nav>
            <input type="checkbox" id="check">
            <label for="check">
                <i class="fas fa-bars" id="btn"></i>
                <i class="fas fa-times" id="cancel"></i>
            </label>
            <img class="imgcl1" src="logo1.png" alt="">
            <ul class= "bar">
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>
    </header>
    
    <div class="Regcontainer">
        <form method="post" novalidate>
            <div class="Regwrapper">
                <?php
                //uses sql injection for protection, and checks with database to see if username and password exists ana is correct
                if (isset($_POST["Username"]) && isset($_POST["Password"])) 
                {
                    $username = htmlentities($_POST["Username"]);
                    $password = htmlentities($_POST["Password"]);
                    
                    //makes sure the fields arent empty
                    if (!empty($username) && !empty($password)) 
                    {
                        $query = "SELECT * FROM users WHERE Username = ? AND Password = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("ss", $username, $password);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        //redirects user to Home page
                        if ($result->num_rows === 1) 
                        {
                            $_SESSION["Username"] = $username;
                            header('Location: index.php');
                            exit();
                        } else {
                            $_SESSION["error"] = "Incorrect username or password.";

                        }
                    } 
                    else 
                    {
                        $_SESSION["error"] = "Missing Required Information";
                    }

                }
                    $conn->close();

                ?>
                <!-- Login form to Login to website-->
                <div class="title"><span>Login</span></div>

                <label for="Username"><b>Username</b></label>
                <input class="reg" type="text" placeholder="Enter Username" name="Username" id="Username" required>

                <label for="Password"><b>Password</b></label>
                <input class="reg" type="password" placeholder="Enter Password" name="Password" id="Password" required>

                <?php
                if (isset($_SESSION["error"])) {
                    echo '<p class="error-message">' . $_SESSION["error"] . '</p>';
                    unset($_SESSION["error"]);
                }
                ?>

                <hr>
                
                <button type="submit" class="registerbtn">Login</button>
                <p>Don't have an account? <a href="register.php">Register here.</a></p>
            </div>
        </form>
    </div>
    <footer>
        <h5>Website developed by Hemant Sundarrajan, 2023</h5>
    </footer>
</body>
</html>