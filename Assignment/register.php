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
    <title>Register</title>
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
        <ul class="bar">
            <li><a href="index.php">Home</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
    </nav>
    </header>
    <?php
        if ( isset($_POST['Username']) && isset($_POST['Password']) && isset($_POST['PasswordConf']) && isset($_POST['FirstName'])&& isset($_POST['Surname']) && isset($_POST['AddressLine1']) && isset($_POST['AddressLine2']) && isset($_POST['City']) && isset($_POST['Telephone']) && isset($_POST['Mobile'])) 
        {
            //assigns the entered values to variables
            $uname = htmlentities($_POST['Username']);
            $pw = htmlentities($_POST['Password']);
            $pwc = htmlentities($_POST['PasswordConf']);
            $fname = htmlentities($_POST['FirstName']);
            $lname = htmlentities($_POST['Surname']);
            $addr1 = htmlentities($_POST['AddressLine1']);
            $addr2 = htmlentities($_POST['AddressLine2']);
            $c = htmlentities($_POST['City']);
            $t = htmlentities($_POST['Telephone']);
            $m = htmlentities($_POST['Mobile']);

            //ensures fields arent empty
            if (!empty($uname) && !empty($pw) && !empty($pwc) && !empty($fname) && !empty($lname) && !empty($addr1) && !empty($addr2) && !empty($c) && !empty($t) && !empty($m)) 
            {
                $numberString = strval($t);
                $numberString2 = strval($m);
                
                //query used to check if a user already exists in the database
                $query = "SELECT * FROM users WHERE Username = '$uname'";
                $result = $conn->query($query);
                
                //ensure the requirements are met so a user can register
                if (strlen($pw) !== 6) 
                {
                    $_SESSION["error"] = "Password must be 6 characters long";
                }
                else if($pw !== $pwc)
                {
                    $_SESSION["error"] = "The Passwords do not match!";
                }
                else if (strlen($numberString) !== 10) 
                {
                    $_SESSION["error"] = "Your Telephone number is not 10 digits long!";
                }
                else if (strlen($numberString2) !== 10) 
                {
                    $_SESSION["error"] = "Your Mobile Phone number is not 10 digits long!";
                }
                else if ($result->num_rows === 1) 
                {
                    $_SESSION["error"] = "This Username is Already taken!";
                }
                else 
                {
                    //inserts user into database
                    $sql = "INSERT INTO users (Username, Password, FirstName, Surname, AddressLine1, AddressLine2, City, Telephone, Mobile) VALUES ('$uname', '$pw', '$fname', '$lname', '$addr1', '$addr2', '$c', '$t', '$m')";
                    
                    if ($conn->query($sql) === TRUE) 
                    {
                        header('Location: login.php');
                        return;
                    } 
                    else 
                    {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
            else
            {
                $_SESSION["error"] = "Missing Required Information";
                header('Location: register.php');
                return;
            }
            
        }
        $conn->close();
    ?>
    <div class="Regcontainer">

        <form method="post" novalidate>
            <div class="Regwrapper">
                <div class="title"><span>Register</span></div>
                <?php

                if (isset($_SESSION["error"])) 
                {
                    echo '<p class="error-messagereg">' . $_SESSION["error"] . '</p>';
                    unset($_SESSION["error"]);
                }
                ?>
                <!-- Registration form to Register into website-->
                <label for="Username"><b>Username</b></label>
                <input class="reg" type="text" placeholder="Enter Username" name="Username" id="Username" required>

                <label for="Password"><b>Password</b></label>
                <input class="reg" type="password" placeholder="Enter Password" name="Password" id="Password" required>

                <label for="PasswordConf"><b>Password Confirmation</b></label>
                <input class="reg" type="password" placeholder="Enter Password Confirmation" name="PasswordConf" id="PasswordConf" required>

                <label for="FirstName"><b>First Name</b></label>
                <input class="reg" type="text" placeholder="Enter First Name" name="FirstName" id="FirstName" required>

                <label for="Surname"><b>Surname</b></label>
                <input class="reg" type="text" placeholder="Enter Surname" name="Surname" id="Surname" required>

                <label for="AddressLine1"><b>Address Line 1</b></label>
                <input class="reg" type="text" placeholder="Enter AddressLine1" name="AddressLine1" id="AddressLine1" required>

                <label for="AddressLine2"><b>Address Line 2</b></label>
                <input class="reg" type="text" placeholder="Enter AddressLine2" name="AddressLine2" id="AddressLine2" required>

                <label for="City"><b>City</b></label>
                <input class="reg" type="text" placeholder="Enter City" name="City" id="City" required>

                <label for="Telephone"><b>Telephone</b></label>
                <input class="reg" type="tel" placeholder="Enter Tel no" name="Telephone" id="Telephone" required>

                <label for="Mobile"><b>Mobile</b></label>
                <input class="reg" type="tel" placeholder="Enter Mobile no" name="Mobile" id="Mobile" required>

                <hr>

                <button type="submit" class="registerbtn">Register</button>
                <p>Already have an account? <a href="login.php">Log in here</a>.</p>
            </div>
        </form>  
    </div>
    <footer>
        <h5>Website developed by Hemant Sundarrajan, 2023</h5>
    </footer>
</body>
</html>