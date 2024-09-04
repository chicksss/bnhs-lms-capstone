<?php

session_start();
unset($_SESSION['UserLogin']);
echo header("Location: index.php");

?>