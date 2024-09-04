<?php

session_start();
unset($_SESSION['user_fullname']);
echo header("Location: ../HOMEPAGE/index.php");

?>