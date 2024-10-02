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
    <title>Search</title>
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
                <li><a href="search.php">Search For a Book</a></li>
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
    <div class="Regcontainer">
    
        <div class="Regwrapper">
            <form method="get" novalidate>
                <div class="title"><span>Search</span></div>
	
                <label for="FirstName"><b>Search By Book Title</b></label>
                <input class="reg" type="text" placeholder="Search By Book Title" name="SearchName" id="SearchName">

                <label for="FirstName"><b>Search By Author</b></label>
                <input class="reg" type="text" placeholder="Search By Author" name="SearchAuthor" id="SearchAuthor">

                <label for="FirstName"><b>Search By Category: </b></label>
                <select class="reg" name="SearchCategory">
                    <option value="">Select Category</option>
                    <?php
                    $sql_category = "SELECT * FROM categories";
                    $sql_category_result = $conn->query($sql_category);

                    while ($categoryRow = $sql_category_result->fetch_assoc()) 
                    {
                        echo "<option value='" . htmlspecialchars($categoryRow["CategoryID"]) . "'>" . htmlspecialchars($categoryRow["CategoryDescription"]) . "</option>";
                    }
                ?>
                </select>
                <button type="submit" class="registerbtn">Search</button>
            </form>
        </div>
        <?php
        
            if(isset($_GET['SearchName']) && isset($_GET['SearchAuthor']) && isset($_GET['SearchCategory']))
            {
                $SearchName = htmlentities($_GET["SearchName"]);
                $SearchAuthor = htmlentities($_GET["SearchAuthor"]);
                $SearchCategory = htmlentities($_GET["SearchCategory"]);


                if (empty($SearchName) && empty($SearchAuthor) && empty($SearchCategory)) 
                {
                    echo'<div class="Regwrapper">
                    <p class="error-message">Error: please enter into at least 1 search field</p>
                    </div>';
                }
                else
                {
                    $sql = "SELECT books.*, categories.CategoryDescription
                    FROM books
                    LEFT JOIN reservations ON books.ISBN = reservations.ISBN
                    LEFT JOIN categories ON books.CategoryID = categories.CategoryID
                    WHERE ";                  
                    $sql_statements = [];

                    if(!empty($SearchName))
                    {
                        $sql_statements[] = "books.BookTitle LIKE '%" . $conn->real_escape_string($SearchName) . "%'";
                    }

                    if(!empty($SearchAuthor))
                    {
                        $sql_statements[] = "books.Author LIKE '%" . $conn->real_escape_string($SearchAuthor) . "%'";
                    }

                    if (!empty($SearchCategory)) 
                    {
                        $sql_statements[] = "books.CategoryID = '" . $conn->real_escape_string($SearchCategory) . "'";
                    }
                    
                    //implodes all sql statements in array with AND so that they are all linked when seraching
                    $sql .= implode(" AND ", $sql_statements);
                    
                    //Gets page, or set default to 1
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    //max no of rows
                    $PerPageResults = 5;

                    $result = $conn->query($sql);

                    //sees how many results there is
                    $totalRes = $result->num_rows;
                    $totalPages = ceil($totalRes / $PerPageResults);

                    $offset = ($page - 1) * $PerPageResults;

                    //Limits the offset in SQL
                    $sql .= " LIMIT $offset, $PerPageResults";

                    $result = $conn->query($sql);


                    if ($result->num_rows > 0) 
                    {
                        echo "<br> <br>";
                        for ($i = 1; $i <= $totalPages; $i++) {
                            echo "Page: ";
                            echo "<a href='search.php?page=$i&SearchName=$SearchName&SearchAuthor=$SearchAuthor&SearchCategory=$SearchCategory'>$i</a> ";
                        }               
                        echo "<table border='1'>";
                        echo "<tr>
                                <th>Book Title</th>
                                <th>Author</th>
                                <th>Edition</th>
                                <th>Year</th>
                                <th>Category</th>
                                <th>Reserve Status</th>
                            </tr>";
                        while ($row = $result->fetch_assoc()) 
                        {
                            echo "<tr>
                            <td>" . htmlspecialchars($row["BookTitle"]) . "</td>
                            <td>" . htmlspecialchars($row["Author"]) . "</td>
                            <td>" . htmlspecialchars($row["Edition"]) . "</td>
                            <td>" . htmlspecialchars($row["Year"]) . "</td>
                            <td>" . htmlspecialchars($row["CategoryDescription"]) . "</td>
                            <td>";
                            if ($row["Reserved"] === 'N') 
                            {
                                echo "<a href='reserve.php?id=" . htmlspecialchars($row["ISBN"]) . "'>Available</a>";
                            }
                            else if($row["Reserved"] === 'Y')
                            {
                                echo "Reserved";
                            }
                            echo "</td>
                            </tr>";
                        }
                        echo "</table>";
                    } 
                    else 
                    {
                        echo'<div class="Regwrapper">
                        <p class="error-message">No Search Results found</p>
                        </div>';
                    }
     
                }
                $conn->close();
                    
            }

        ?>
    </div>
    <footer>
        <h5>Website developed by Hemant Sundarrajan, 2023</h5>
    </footer>
    
</body>
</html>