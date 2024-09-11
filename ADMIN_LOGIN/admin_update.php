<?php
 ob_start();
require_once "admin_login_engine.php";
require_once "admin_login_db.php";
$crud = new CRUDADMIN();

session_start();
  include "../dashdesign.php";
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $admin_Id = $_POST['admin_Id'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $fullname_admin = $_POST['fullname_admin'];
                $contact_admin = $_POST['contact_admin'];
                $address_admin = $_POST['address_admin'];
                $email_admin = $_POST['email_admin'];
                $admin_role = $_POST['admin_role'];
                               
                $updateProfile = $crud->updateProfile($admin_Id,$username,$password,$fullname_admin,$contact_admin,$address_admin,$email_admin,$admin_role);
                if($updateProfile){
                    echo header ("Location: ../DASHBOARD/admin_index.php");
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
            $updatedImage = $crud->updatedImage($admin_Id, $image);

            if ($updatedImage) {
                header("Location: ../DASHBOARD/admin_index.php");
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
        <div class="absolute mt-[-40px]">
            <h1 class="text-2xl font-bold px-3">UPDATE PROFILE</h1>
        </div>


        <div>
            <div class="flex justify-start">
                <div class="px-10 py-10">
                    <div class="card-body">
                        <?php
                                    if (isset($_SESSION['admin_Id'])) {
                                    $admin_Id = $_SESSION['admin_Id'];
                                    $user = $crud->adminManage($admin_Id);
                                    }
                                
                                        if ($user) {  ?>

                        <form method="POST" action="" enctype="multipart/form-data">
                            <input type="hidden" name="admin_Id" value="<?php echo $user['admin_Id'] ?>">
                            <div class="flex justify-evenly gap-10">

                                <div class="card bg-[#f5ebe0] p-3 rounded-lg">
                                    <div>
                                        <div class="">
                                            <div class="card-body text-center">

                                                <?php
                                        if (isset($_SESSION['admin_Id'])) {
                                        $admin_Id = $_SESSION['admin_Id'];
                                        $user = $crud->adminManage($admin_Id);
                                        }
                                            ?>
                                                <?php if ($user) { ?>
                                                <form action="" method="POST" enctype="multipart/form-data">
                                                    <?php
                                        if ($user) {
                                            echo '<img src="../admin_profiles/' . $user['image'] . '" title="' . $user['image'] . '" class=" py-2 rounded-lg w-[300px] h-60">';
                                        }
                                        ?>
                                                    <input type="file" class="form-control-sm" name="image" id="image"
                                                        accept=".jpg, .jpeg, .png" value="<?php echo $user['image'] ?>">
                                            </div>
                                            <div class="py-2">
                                                <button type="submit" name="updateIMg" class="rounded-lg p-2 px-10"
                                                    style="background: #d5bdaf; color:black">
                                                    Update </button>

                                                    
                                            </div>

                                        </div>

                                    </div>

                                    <?php } ?>
                                </div>

                                <div class="flex justify-evenly gap-10">
                                    <div>
                                        <div class="py-2">
                                            <label>Name:</label> <br>
                                            <input type="text" class="rounded-lg p-1" name="fullname_admin" id="title"
                                                value="<?php echo $user['fullname_admin'] ?>">


                                        </div>

                                        <div class="py-2">
                                            <label>Email:</label><br>
                                            <input type="text" class="rounded-lg p-1" name="email_admin"
                                                value="<?php echo $user['email_admin'] ?>">


                                        </div>


                                        <div class="py-2">
                                            <label>Username:</label><br>
                                            <input type="text" class="rounded-lg p-1" name="username"
                                                value="<?php echo $user['username'] ?>">

                                        </div>







                                        <div class="py-2">
                                            <button type="submit" class="rounded-lg p-2 px-2"
                                                style="background: #d5bdaf; color:black">
                                                Update
                                            </button>

                                            <button onclick="goBack()" class="btn-back bg-[#d5bdaf] p-2 rounded-lg px-10">Back</button>
                                            <script>
                                            function goBack() {
                                                window.history.back();
                                            }
                                    </script>
                                        </div>


                                    </div>
                                    <div>

                                        <div class="py-2">
                                            <label>Phone:</label><br>
                                            <input type="number" class="rounded-lg p-1" name="contact_admin"
                                                value="<?php echo $user['contact_admin'] ?>">

                                        </div>

                                        <div class="py-2">
                                            <label>Address:</label><br>
                                            <input type="text" class="rounded-lg p-1" name="address_admin"
                                                value="<?php echo $user['address_admin'] ?>">

                                        </div>

                                        <div class="py-2">
                                            <label>Password:</label><br>
                                            <input type="text" class="rounded-lg p-1" name="password"
                                                value="<?php echo $user['password'] ?>">

                                        </div>



                                    </div>
                                </div>

                            </div>




                    </div>

                    <?php } ?>
                </div>

            </div>
        </div>


    </div>

</body>

</html>