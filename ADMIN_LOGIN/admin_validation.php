<?php

 ob_start();

session_start();
include "../dashdesign.php";
require_once "admin_login_engine.php";
require_once "admin_login_db.php";


$crud = new CRUDADMIN();


// error_reporting(0);        // Turn off all error reporting
// ini_set('display_errors', 0);



 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $admin_Id = $_POST['admin_Id'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $fullname_admin = $_POST['fullname_admin'];
                $contact_admin = $_POST['contact_admin'];
                $address_admin = $_POST['address_admin'];
                $email_admin = $_POST['email_admin'];
                $admin_role = $_POST['admin_role'];
                $admin_status = $_POST['admin_status'];
                               
                $updateProfile = $crud->SuperupdateProfile($admin_Id,$username,$password,$fullname_admin,$contact_admin,$address_admin,$email_admin,$admin_role,$admin_status);
                if($updateProfile){
                    echo header ("Location: ../DASHBOARD/superAdmin_list.php");
                }
 }

if (isset($_POST['updateIMg'])) {
    $targetDirectory = "../admin_profiles/";
    $image = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $imagePath = $targetDirectory . $image;

    if (move_uploaded_file($imageTmp, $imagePath)) {
        try {
            // Retrieve user ID from session
            $admin_Id = $_SESSION['admin_Id'];

            // Update the image for the specific user
            $updatedImage = $crud->SuperupdatedImage($admin_Id, $image);

            if ($updatedImage) {
                header("Location: ../DASHBOARD/superAdmin_list.php");
                exit();
            } else {
                echo "Error updating image.";
            }
        } catch (PDOException $e) {
            echo "Error updating data in the database: " . $e->getMessage();
        }
    }
}

ob_end_flush();

 
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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


</head>


<body>


    <div class="ml-52">


        <div class="flex justify-evenly  py-10">

            <div>
                <div class="card bg-[#f5ebe0] flex justify-center px-5 py-5">


                    <?php
                            if (isset($_GET['id'])) {
                            $admin_Id = $_GET['id'];
                            $user = $crud->adminManage($admin_Id);
                            }
                               ?>
                    <?php if ($user) { ?>

                    <form action="" class="grid justify-center" method="POST" enctype="multipart/form-data">


                        <?php
                        if ($user) {
                            echo '<img src="../admin_profiles/' . $user['image'] . '" title="' . $user['image'] . '" class="w-full">';
                        }
                        ?>

                        <h5 class="text-center py-3"><?php echo $user['fullname_admin']; ?></h5>
                        <input type="file" class="rounded-lg" name="image" id="image" accept=".jpg, .jpeg, .png"
                            value="<?php echo $user['image'] ?>">
                            <br>
                            
                        <button type="submit" class="rounded-lg px-6 py-2" name="updateIMg"
                            style="background: #dda15e; color:black" class="btn">
                            Update </button>

                </div>
                <br>



            </div>

            <?php } ?>


            <div class="bg-[#f5ebe0] px-4 py-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <?php
                    if (isset($_GET['id'])) {
                    $admin_Id = $_GET['id'];
                    $user = $crud->adminManage($admin_Id);
                    }
                
                        if ($user) {  ?>

                        <form method="POST" action="" enctype="multipart/form-data">
                            <input type="hidden" name="admin_Id" value="<?php echo $user['admin_Id'] ?>">

                            <div class="flex justify-evenly gap-5">
                                <div class="grid">
                                    <div class="text-start">
                                        <label for="">Fullname:</label>
                                        <p class="text-muted mb-0"> <input type="text" class="rounded-lg"
                                                name="fullname_admin" value="<?php echo $user['fullname_admin'] ?>">
                                        </p>
                                    </div>

                                    <div class="text-start">
                                        <label for="">Email:</label>
                                        <p class="text-muted mb-0"> <input type="text" class="rounded-lg"
                                                name="email_admin" value="<?php echo $user['email_admin'] ?>">
                                        </p>
                                    </div>
                                    <div class="">
                                        <label for="">Phone:</label>
                                        <p class="text-muted mb-0"> <input type="number" class="rounded-lg"
                                                name="contact_admin" value="<?php echo $user['contact_admin'] ?>">
                                        </p>
                                    </div>
                                    <div class="">
                                        <label for="">Username:</label>
                                        <p class="text-muted mb-0"> <input type="text" class="rounded-lg"
                                                name="username" value="<?php echo $user['username'] ?>">
                                        </p>
                                    </div>

                                </div>


                                <div class="grid justify-items-start">
                                    <div class="">

                                        <label for="">Role</label>
                                        <p class="text-muted mb-0"> <input type="text" class="rounded-lg"
                                                name="admin_role" value="<?php echo $user['admin_role'] ?>">
                                        </p>

                                    </div>
                                    <label for="">Status:</label>
                                    <select name="admin_status" class="rounded-lg" id="">
                                        <option value="active">Active</option>
                                        <option value="deact">Deact</option>
                                    </select>




                                    <label for="">Address:</label>
                                    <p class="text-muted mb-0"> <input type="text" class="rounded-lg"
                                            name="address_admin" value="<?php echo $user['address_admin'] ?>">
                                    </p>


                                    <label for="">Password:</label>
                                    <p class="text-muted mb-0"> <input type="text" class="rounded-lg" name="password"
                                            value="<?php echo $user['password'] ?>">
                                    </p>




                                </div>

                                <div>

                                </div>

                            </div>










                    </div>
                    <br>
                    <button type="submit" class="rounded-lg px-6 py-2" style="background: #dda15e; color:black"> Update
                    </button>
                    <?php } ?>
                </div>

            </div>


        </div>
    </div>



</body>



</html>