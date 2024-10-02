<?php
//logout page which destroys session, and logs current user out, then sends user back to Home
session_start();
session_destroy();
header("Location: index.php")
?>