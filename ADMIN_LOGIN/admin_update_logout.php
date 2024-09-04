<?php

session_start();
unset($_SESSION['admin_Id']);
// echo header("Location: index.php");
echo "<script> alert('Account updated please Log in again'); location.replace('index.php') </script>";
?>