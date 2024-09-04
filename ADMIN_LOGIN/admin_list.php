<?php
require_once "admin_login_engine.php";
require_once "admin_login_db.php";

session_start();
 include "../dashdesign.php";
 
$crud = new CRUDADMIN();


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fullname_admin = $_POST['fullname_admin'];
    $contact_admin = $_POST['contact_admin'];
    $address_admin = $_POST['address_admin'];
    $email_admin = $_POST['email_admin'];

    $stmt = $crud->AddNewAdmin($username,$password,$fullname_admin,$contact_admin,$address_admin,$email_admin);
}

 


 
if (isset($_SESSION['admin_role']) && $_SESSION['admin_role'] == 'super admin') {
    echo "<script>alert('Admin'); location.replace('../DASHBOARD/superAdmin_list.php')</script>";
} else {
    
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

    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<body>



    <div class="ml-52 p-2">
        <div class="absolute mt-[-50px]">
            <h1 class="text-2xl font-bold px-3">ADMIN LIST</h1>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-[#e6ccb2]  dark:text-black">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Role
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php   
                        $users = $crud->adminList();
                        array_shift($users);
                        foreach ($users as $user){ ?>
                <tr class="bg-[#f5ebe0]">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-black">
                        <?php echo $user['fullname_admin']; ?>
                    </th>
                    <td class="text-black px-6 py-4">
                        <?php echo $user['admin_role']; ?>
                    </td>

                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>


</body>

</html>