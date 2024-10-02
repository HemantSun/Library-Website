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
    <title>Remove Reservation</title>
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
                <li><a href="search.php">Search for a Book</a></li>
                <li><a href="view.php">View Reserved Books</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <?php
        //checks if user is logged in, if not forces them to, to access library services
        if (!isset($_SESSION["Username"])) {
            echo
            ' <br> <p>Please Log in to access all of our libraries features! Use the Navbar to Login, or <a href="login.php">Log in here</a></p>
            <p>If you dont have an accout, please register and ceate one. You can <a href="register.php">Register here</a></p>
            <p>Osprey Library is your one stop shop for E learning and E books in an online Library!</p>';
            exit();
        }
    ?>
    <div class="Regcontainer2">
        <?php
            if ( isset($_POST['remove']) && isset($_POST['id']))
            {
                //Removes reservation, so that book is now reservable again, and no longer reserved by user
                $id = $conn -> real_escape_string($_POST['id']);
                $sql = "UPDATE books SET Reserved = 'N' WHERE ISBN = '$id'";
                $sql2 = "DELETE FROM reservations WHERE ISBN = '$id'";
                $conn->query($sql2);
                $conn->query($sql);
                echo '<h2>Reservation was Removed Successfully!</h2>';
                echo '<br> <br>';
                echo '<h4>Click here to view your Updated Reserved Books - <a href="view.php">Reserved Books</a></h4>';
                echo '<br> <br>';
                echo '<h4>Click here to Search for New Books to reserve - <a href="search.php">Search</a><h4>';
                echo '<footer>
                    <h5>Website developed by Hemant Sundarrajan, 2023</h5>
                </footer>';
                return;
            }
            //Removal confirmation, so user doesnt accidnetally remove reservation
            $id = $conn -> real_escape_string($_GET['id']);
            $sql = "SELECT * FROM books WHERE ISBN='$id'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            echo "<h3>Confirm The Reservation Removal of: ". $row["BookTitle"] ."</h3>\n";
            echo('<form method ="post"><input type="hidden" ');
            echo('name="id" value="'.htmlentities($row["ISBN"]).'">'."\n");
            echo('<input type="submit" value="Remove" name="remove">');
            echo('<a href="view.php"> Cancel</a>');
            echo("\n</form>\n");

            $conn->close();
        ?>
    </div>
    <footer>
        <h5>Website developed by Hemant Sundarrajan, 2023</h5>
    </footer>
    
</body>
</html>