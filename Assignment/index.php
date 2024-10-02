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
    <title>Home</title>
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
            <?php
            //checks if user is logged in, if not the navbar shows less options as user isnt logged in
            if (!isset($_SESSION["Username"]))
            {
                echo '<ul class="bar">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="login.php">Login</a>
                    </li>
                    <li>
                        <a href="register.php">Register</a>
                    </li>
                </ul>';
                echo '<div class="container">
                    <div class="left">
                        <p>Please Log in to access all of our libraries features! Use the Navbar to Login, or <a href="login.php">Log in here</a></p>
                        <p>If you dont have an accout, please register and ceate one. You can <a href="register.php">Register here</a></p>
                        <p>Osprey Library is your one stop shop for E learning and E books in an online Library!</p>

                        <br>
                        <br>

                        <h2>Please Login to Avail of these great services!</h2>
                        <p>Our library is more than just a repository of books; its a hub for learning and collaboration. Take advantage of our library services, including reference assistance, interlibrary loans, and research support. Our dedicated staff is here to help you navigate the world of information and make the most of your library experience.</p>

                        <br>
                        <br>

                        <h2>Membership and Accessibilty</h2>
                        <p>Membership and Accessibility:
                        Becoming a member of our library opens the door to a world of knowledge and resources. Discover the benefits of membership, including borrowing privileges, exclusive events, and personalized services. We are committed to ensuring accessibility for all, so explore our accessible services and facilities designed to cater to diverse needs.</p>

                        <br>
                        <br>

                        <h2>Events and Programs:</h2>
                        <p>Stay tuned for our exciting events and programs designed to engage and enrich our community. From book clubs and author talks to workshops and lectures, theres always something happening at the library. Here at Osprey Library, we strive to ensure that you, the user has a great experience on this website!.</p>

                    </div>
                    <div class="right">
                        <div class="fourbyfour">
                            <img src="book1.jpg">
                            <img src="book2.jpg">
                            <img src="book3.jpg">
                            <img src="book4.jpg">
                        </div>
                    </div>
                </div>';
            }
            else
            {
                $loggedInUsername = $_SESSION['Username'];
                echo '<ul class="bar">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                    <a href="search.php">Search For a Book</a>
                    </li>
                    <li>
                        <a href="view.php">View Reserved Books</a>
                    </li>
                    <li>
                        <a href="logout.php">Logout</a>
                    </li>
                </ul>';

                echo '<div class="container">
                    <div class="left">';
                        echo "<h1>Welcome back to OSPREY LIBRARY $loggedInUsername !</h1>
                        <p>Now that you are logged in, you can finally avail of our services again!</p>
                        <p>We have upgraded our online services to a great level, hopefully you can avail of them today!</p>

                        <br>
                        <br>";

                        echo '<h2>Nice to see you again!</h2>
                        <p>Our library is more than just a repository of books; its a hub for learning and collaboration. Take advantage of our library services, including reference assistance, interlibrary loans, and research support. Our dedicated staff is here to help you navigate the world of information and make the most of your library experience.</p>

                        <br>
                        <br>

                        <h2>Membership and Accessibilty</h2>
                        <p>Membership and Accessibility:
                        Becoming a member of our library opens the door to a world of knowledge and resources. Discover the benefits of membership, including borrowing privileges, exclusive events, and personalized services. We are committed to ensuring accessibility for all, so explore our accessible services and facilities designed to cater to diverse needs.</p>

                        <br>
                        <br>

                        <h2>Events and Programs:</h2>
                        <p>Stay tuned for our exciting events and programs designed to engage and enrich our community. From book clubs and author talks to workshops and lectures, theres always something happening at the library. Here at Osprey Library, we strive to ensure that you, the user has a great experience on this website!.</p>

                    </div>
                    <div class="right">
                        <div class="fourbyfour">
                            <img src="book1.jpg">
                            <img src="book2.jpg">
                            <img src="book3.jpg">
                            <img src="book4.jpg">
                        </div>
                    </div>
                </div>';

            }
            $conn->close();
            ?>
        </nav>
    </header>
    <footer>
        <h5>Website developed by Hemant Sundarrajan, 2023</h5>
    </footer>
</body>
</html>