<?php
require_once "admin_login_engine.php";
require_once "admin_login_db.php";

   


$crud = new CRUDADMIN(); 

/* admin page */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $total = $crud->adminLog($username, $password);

    if ($total) {
        session_start();

        $_SESSION['UserLogin'] = $username;
        $_SESSION['image'] = $total['image'];
        $_SESSION['admin_Id'] = $total['admin_Id'];
        $_SESSION['fullname_admin'] = $total['fullname_admin'];
        $_SESSION['contact_admin'] = $total['contact_admin'];
        $_SESSION['address_admin'] = $total['address_admin'];
        $_SESSION['email_admin'] = $total['email_admin'];
        $_SESSION['admin_role'] = $total['admin_role'];
        $_SESSION['admin_status'] = $total['admin_status'];

        if ($total['admin_status'] == "active") {
            if ($total['admin_role'] == "super admin") {
                echo "<script>alert('Welcome to Bautista National High School Dashboard'); location.replace('../DASHBOARD/superAdmin_dashboard.php')</script>";
            } else {
                echo "<script>alert('Welcome to Bautista National High School Dashboard'); location.replace('../DASHBOARD/admin_index.php')</script>";
            }
            
            // Ensure that after the redirects, the script exits to prevent further execution
            exit();
        } else {
            echo "<script>alert('Your account is not active. Please contact an administrator.'); location.replace('index.php')</script>";
        }
    } else {
        echo "<script>alert('Login Error Please try again'); location.replace('index.php')</script>";
    }
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../src/output.css" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
    <title>Document</title>
</head>

<body class="bg-[url('../images/bautista.jpg')] bg-cover bg-no-repeat">

    <div class="flex justify-center py-20">
        <div class="card rounded-lg p-2 shadow-lg w-[35%] bg-white opacity-[90%]">
            <h1 class="text-center text-3xl py-3">Admin Login Page</h1>
            <form class="max-w-sm mx-auto py-20" method="post" action="index.php">

                <div class="mb-5 py-2">
                    <input type="text" id="email" name="username"
                        class="shadow-sm rounded-xl text-black p-2 w-full bg-white" placeholder="username" required />
                </div>
                <div class="mb-5 py-2">
                    <input type="password" name="password" id="password" placeholder="password"
                        class="shadow-sm rounded-xl text-black p-2 w-full" required />
                </div>



                <div class="flex items-center justify-center">
                    <div class="flex flex-col items-center">
                        <button type="submit" class="bg-[#d5bdaf] p-2 text-black rounded-lg w-20">
                            Log in</button>
                        <br>
                        <a href="admin_forgot.php">Forgot password?</a>
                    </div>

                </div>



            </form>

        </div>
    </div>

</body>

</html>