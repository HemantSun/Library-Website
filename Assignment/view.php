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
    <title>View Reserved Books</title>
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
        if (!isset($_SESSION["Username"])) 
        {
            echo
            ' <br> <p>Please Log in to access all of our libraries features! Use the Navbar to Login, or <a href="login.php">Log in here</a></p>
            <p>If you dont have an accout, please register and ceate one. You can <a href="register.php">Register here</a></p>
            <p>Osprey Library is your one stop shop for E learning and E books in an online Library!</p>';
            exit();
        }
    ?>
    <div class="Regcontainer2">
        <?php

            $loggedInUsername = $_SESSION['Username'];

            $sql = "SELECT
            books.ISBN,
            books.BookTitle,
            books.Author,
            books.Edition,
            books.Year,
            reservations.ReservedDate
            FROM
                reservations
            JOIN
                books ON reservations.ISBN = books.ISBN
            WHERE
                reservations.Username = '$loggedInUsername' AND books.Reserved = 'Y'";
            
            $page = isset($_GET['page']) ? $_GET['page'] : 1; // Get the current page or default to 1
            $PerPageResults = 5; // Number of results per page

            $result = $conn->query($sql);

            $totalRes = $result->num_rows;
            $totalPages = ceil($totalRes / $PerPageResults);

            $offset = ($page - 1) * $PerPageResults;

            $sql .= " LIMIT $offset, $PerPageResults";

            $result = $conn->query($sql);
            
            //if books exits, in a table the books are shown
            if ($result->num_rows > 0) 
            {
                echo "<h3>Hey there $loggedInUsername!, These are the books you have reserved:</h3>";
                echo "<br> <br>";
                echo "<table border='1'>";
                echo "<tr>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>Edition</th>
                        <th>Year</th>
                        <th>Date of Reservation</th>
                        <th>Remove Reservation</th>
                    </tr>";
                while ($row = $result->fetch_assoc()) 
                {
                    echo "<tr>
                    <td>" . htmlspecialchars($row["BookTitle"]) . "</td>
                    <td>" . htmlspecialchars($row["Author"]) . "</td>
                    <td>" . htmlspecialchars($row["Edition"]) . "</td>
                    <td>" . htmlspecialchars($row["Year"]) . "</td>
                    <td>" . htmlspecialchars($row["ReservedDate"]) . "</td>
                    <td>
                    <a href='remove.php?id=" . htmlspecialchars($row["ISBN"]) . "'>Remove</a>
                    </td>
                    </tr>";

                }
            } 
            else 
            {
                echo "<h1>Hey there $loggedInUsername!, You currently have no reserved books.";
            }
            //shows pages, which increments depending on the rows (pagination)
            for ($i = 1; $i <= $totalPages; $i++) 
            {
                echo "Page: ";
                echo "<a href='view.php?page=$i'>$i</a> ";
            }
            
            $conn->close();
        ?>
    </div>
    <footer>
        <h5>Website developed by Hemant Sundarrajan, 2023</h5>
    </footer>
    
</body>
</html>