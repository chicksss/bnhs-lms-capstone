<?php



require_once "../ADMIN_LOGIN/admin_login_engine.php";
require_once "../ADMIN_LOGIN/admin_login_db.php";
$crud = new CRUD();

session_start();


// if (isset($_GET['admin_Id'])) {
//     $admin_Id = $_GET['admin_Id'];
//     $user = $crud->selectAdminUpdate($admin_Id);
// } 







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


 

 



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--<title> Drop Down Sidebar Menu | CodingLab </title>-->
    <link rel="stylesheet" href="../CSS/new_side.css" />
    <!-- Boxiocns CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <!-- html icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/6122121193.js" crossorigin="anonymous"></script>




    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <title>Admin Details</title>
</head>
<style>
body {

    background: #ddf0ff;
}



.col {
    text-align: center;
}

.img-card {
    background-color: white;
    box-shadow: 12px 12px 16px 0 rgba(0, 0, 0, 0.25), -8px -8px 12px 0 rgba(255, 255, 255, 0.3);
    border-radius: 20px;
    width: 90%;
    padding: 2%;

}

.btn {
    background-color: #00457c;
    color: white;

}
</style>

<body>

    <div class="sidebar">
        <div class="logo-details" style="padding-left: 20px">

            <span class="logo_name">&nbsp; BNHS</span>


        </div>




        <ul class="nav-links">

            <li>
                <a href="superAdmin_dashboard.php" class="nav-link align-middle px-0" style="color: white;  ">
                    <i class="fa fa-home" style="color: white"> </i>
                    <span class="link_name">Dashboard</span>
                </a>

            </li>

            <li>
                <a href="superAdmin_list.php" class="nav-link align-middle px-0" style="color: white;  ">
                    <i class="fa-solid fa-user" style="color: #ffffff;"></i>
                    <span class="link_name">Admin</span>
                </a>
            </li>





            <!-- <li>
                <a href="../database_user_appointment/admin_appointment.php" class="nav-link align-middle px-0"
                    style="color: white">
                    <i class="fas fa-edit" style="color: white"> </i>
                    <span class="link_name">Appointment</span></a>
            </li>


            <li>

                <a href="../database_staff/admin_staff.php" class="nav-link align-middle px-0" style="color: white">
                    <i class="fas fa-sitemap" style="color: white"> </i>
                    <span class="link_name">Staff</span></a>

            </li> -->


            <!-- <li>
                <a href="../database_faq/faq.php" class="nav-link align-middle px-0" style="color: white">
                    <i class="fa-solid fa-circle-question" style="color: #ffffff;"></i>
                    <span class="link_name">Faq</span></a>
                </a>
            </li> -->




        </ul>
    </div>
    <main class="home-section">





        <br>
        <div class="container" style="background-color:white">

            <!--  <a href="admin_update_logout.php"><i
                                class="fa-solid fa-arrow-left" style="color: #ffffff; margin-right:20px"></i> </a> -->
            <div class="row">
                <div class="card" style="background-color: #00457c; width:100%; padding:2%">
                    <h5 style="font-family: Poppins; color:white;font-weight:900;"> <a
                            href="superAdmin_dashboard.php"><i class="fa-solid fa-arrow-left"
                                style="color: #ffffff; margin-right:20px"></i> </a>
                        UPDATE
                        PROFILE</h5>
                </div>

                <div class="col">
                    <?php
                            if (isset($_SESSION['admin_Id'])) {
                            $admin_Id = $_SESSION['admin_Id'];
                            $user = $crud->adminManage($admin_Id);
                            }
                
                        if ($user) {  ?>

                    <form method="POST" action="" enctype="multipart/form-data">
                        <input type="hidden" name="admin_Id" value="<?php echo $user['admin_Id'] ?>">

                        <div class="form-group">

                            <label for="username"><b>Profile: </b></label>
                            <input type="text" class="form-control" name="username"
                                value="<?php echo $user['username'] ?>">

                            <label for=""><b>Email: </b></label>
                            <input type="email" class="form-control" name="email_admin"
                                value="<?php echo $user['email_admin'] ?>">

                            <label for=""><b>Address: </b></label>
                            <input type="text" class="form-control" name="address_admin"
                                value="<?php echo $user['address_admin'] ?>">

                            <label for=""><b>Fullname: </b></label>
                            <input type="text" class="form-control" name="fullname_admin"
                                value="<?php echo $user['fullname_admin'] ?>">

                            <label for=""><b>Contact: </b></label>
                            <input type="number" class="form-control" name="contact_admin"
                                value="<?php echo $user['contact_admin'] ?>">

                            <label for=""><b>Password: </b></label>
                            <input type="password" class="form-control" name="password"
                                value="<?php echo $user['password'] ?>">


                            <label for=""><b>Role: </b></label>
                            <input type="text" class="form-control" name="admin_role"
                                value="<?php echo $user['admin_role'] ?>">
                        </div>





                        <!-- <button type="submit" class="btn"><a style="color:white"
                                    href="admin_update.php?id=<?php echo $user['id']; ?>">Update</a></button> -->
                        <button type="submit" class="btn"> Update </button>
                        <!-- <button class="btn"><a style="text-decoration:none; color:white;"
                                    href="../ADMIN_FOLDER/delete.php?id=<?php echo $user['id'] ?>">Delete</a></button> -->
                    </form>

                    <?php }
    
                        ?>



                </div>
                <div class="col">

                    <?php if ($user) { ?>

                    <form action="" method="POST" enctype="multipart/form-data">


                        <?php
                            if ($user) {
                                echo '<img src="../admin_profiles/' . $user['image'] . '" title="' . $user['image'] . '" style="height:360px; width:400px">';
                            }
                            ?>


                        <input type="file" class="form-control" name="image" id="image" accept=".jpg, .jpeg, .png"
                            value="<?php echo $user['image'] ?>">
                        <!-- <input type="submit" class="btn-primary" name="updateIMg" value="Update"> -->
                        <button type="submit" name="updateIMg" class="btn"> Update </button>
                    </form>
                    <?php }
    
                        ?>

                </div>










            </div>
        </div>









    </main>






</body>


<script>
let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e) => {
        let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
        arrowParent.classList.toggle("showMenu");
    });
}
let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".bx-menu");
console.log(sidebarBtn);
sidebarBtn.addEventListener("click", () => {
    sidebar.classList.toggle("close");
});
</script>





</html>