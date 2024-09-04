<?php
require_once "admin_login_engine.php";
require_once "admin_login_db.php";
$crud = new CRUDADMIN();
session_start();

 



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
                    echo header ("Location: ../DASHBOARD/superAdmin_dashboard.php");
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
                header("Location: ../DASHBOARD/superAdmin_dashboard.php");
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



    <link href="../uicons-regular-rounded/css/uicons-regular-rounded.css" rel="stylesheet">


    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">



    <!--<title> Drop Down Sidebar Menu | CodingLab </title>-->
    <link rel="stylesheet" href="../CSS/new_side.css" />


    <!-- line graph -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <!-- bar graph -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>





    <!-- Boxiocns CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <!-- html icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/6122121193.js" crossorigin="anonymous"></script>
    <!-- bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />




    <link rel="stylesheet" href="../BOOKS/side.css">




    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous">
    </script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
    </script>












</head>
<style>
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


.card {
    background: #f5ebe0;
    padding: 20px;

}

/* navbar dashboard */
ul {
    margin: 0;
    padding: 0;
}

/* Dashboard Navbar */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: black;
    position: fixed;
    background: #f5ebe0;
    width: 100%;
    z-index: 10;


}

.logo {
    display: flex;
    align-items: center;
    margin-left: auto;
}

.logos {
    display: flex;
    align-items: left;
    margin-right: auto;
    font-size: 30px;
    margin-left: 20px;
}

.logo img {
    height: 30px;
    width: 30px;
    margin-right: 20px;
}

.logo-name {
    font-size: 1.2rem;

}

.nav-link {
    list-style: none;
    display: flex;
    margin-right: 70px;
}



.img {
    border-radius: 50rem;
    width: 100px;

}

.icon {
    display: flex;
    align-items: center;
    padding-left: 20px;
}

/* dropdown */

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    margin-top: 750px;
    margin-left: -170px;

}

.dropdown:hover .dropdown-content {
    display: block;
}
</style>

<body>

    <div class="sidebar" style="background-color:#d5bdaf;">

        <nav id="sidebar">
            <div class="logo-details" style="padding-left: 20px">

                <span class="logo_name" style="color: black">&nbsp; BAUTISTA</span>
            </div>

            <ul class="list-unstyled components">

                <li>
                    <a href=" ../DASHBOARD/admin_index.php" style="color: white; ">
                        <i class="fi-rr-home" style="color: black;"></i>
                        <span class="link_name" style="color: black"> &nbsp; Dashboard</span>
                    </a>
                </li>



                <li>
                    <a href="#userSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle "> <i
                            class="fi-rr-users" style="color: black"> </i> &nbsp; User</a>
                    <ul class="collapse list-unstyled" id="userSubmenu">
                        <li>
                            <a href="../ADMIN_LOGIN/admin_list.php" style="color: white;  ">
                                <i class="fa-solid fa-user" style="color: black;"></i>
                                <span class="link_name" style="color: black"> &nbsp; Admin</span>
                            </a>
                        </li>
                        <li>
                            <a href="../END_USER/end_user_list.php" style="color: white">
                                <i class="fa-solid fa-user-tie" style="color: black;"></i>
                                <span class="link_name" style="color: black"> &nbsp; Students</span>
                            </a>
                        </li>

                    </ul>
                </li>
                <li>

                    <a href="../BOOKS/admin_book_home.php"> <i class="fi fi-rr-apps"></i> &nbsp; Category</a>
                </li>

                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle "> <i
                            class="fi-rr-book-alt" style="color: black"> </i> &nbsp; Books</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="../BOOKS/admin_add_book.php">Add Books </a>
                        </li>

                        <li>
                            <a href="../BOOKS/admin_Add_moreAuthors.php">Book authors </a>
                        </li>


                        <li>
                            <a href="../BOOKS/admin_AddCopies_Book.php">Copies</a>
                        </li>

                        <li>
                            <a href="../BOOKS/admin_bookList.php">List of books</a>
                        </li>


                        <li>
                            <a href="../BOOKS/admin_book_archive.php">Archive</a>
                        </li>

                    </ul>
                </li>



                <li>
                    <a href="../BOOKS/admin_authors.php" style="color: white">
                        <i class="fi-rr-book-open-reader" style="color: black"></i>
                        <span class="link_name" style="color: black"> &nbsp; Authors</span>
                    </a>
                </li>

                <li>
                    <a href="../database_user_appointment/admin_appointment.php" style="color: white">
                        <i class=" fi-rr-books" style="color: black"> </i>
                        <span class="link_name" style="color: black"> &nbsp; Borrowers</span>
                    </a>
                </li>

                <li>
                    <a href="../database_user_appointment/admin_book_returned.php" style="color: white">
                        <i class=" fi-rr-arrow-alt-from-right" style="color: black"></i>
                        <span class="link_name" style="color: black"> &nbsp;Returned</span>
                    </a>
                </li>

                <li>
                    <a href="../BOOKS/BOOK_REPORT.php" style="color: white">
                        <i class="fi-rr-newspaper-open" style="color: black"></i>
                        <span class="link_name" style="color: black"> &nbsp;Reports</span>
                    </a>
                </li>



            </ul>


        </nav>
    </div>
    <main class="home-section">

        <nav class="navbar">
            <div class="container-fluid d-flex">
                <a style="color:black" class="navbar-brand ms-4">UPDATE ADMIN</a>



                <ul class="nav-links ms-4" style="margin-right:230px">
                    <div class="dropdown">
                        <div class="logo" style="margin-right: auto; float: right;">
                            <span>
                                <?php if (isset($_SESSION['UserLogin']) && isset($_SESSION['image'])): ?>
                                <img src="../admin_profiles/<?php echo $_SESSION['image']; ?>" class="img">
                                <span class="logo-name"
                                    style="font-size: 15px; color:black"><?php echo $_SESSION['UserLogin']; ?></span>
                            </span>
                            <?php else: ?>
                            <span class="logo-name">
                                <?php
                       
                            echo '<script>alert("Redirecting to ../ADMIN_LOGIN/index.php"); window.location.href="../ADMIN_LOGIN/index.php";</script>';
                          
                        
                        ?>

                            </span>
                            <?php endif; ?>


                            <div class="dropdown-content t-10" style="margin-top:380px; margin-left:-180px">

                                <?php if($_SESSION['UserLogin']):?>
                                <div class="card text-center" style="width:100%;height:100%;background: #f5ebe0">
                                    <?php if (isset($_SESSION['admin_Id'])): ?>
                                    <img src=" ../admin_profiles/<?php echo $_SESSION['image']; ?>" class="m-auto"
                                        style="width: 100%; height: 50%; border-radius: 10%">

                                    <div class="card-body">
                                        <span class="logo-name" style="font-size: 15px; color:black; font-weight:bold;">
                                            <?php echo $_SESSION['fullname_admin']; ?>
                                        </span>


                                        <h5 class="card-title">
                                            <p style="font-size:15px; font-weight:light">
                                                <?php echo $_SESSION['admin_role']; ?>
                                                <i class="fa-solid fa-circle-check"
                                                    style="color: black; font-size:15px"></i>
                                            </p>
                                        </h5>

                                        <div class="container">
                                            <span class="logo-name"
                                                style="font-size: 15px; color:black; display: flex; align-items: center;">
                                                <i class="fa-solid fa-phone" style="margin-right: 5px;"></i>
                                                <?php echo $_SESSION['contact_admin']; ?>
                                            </span>



                                            <span class="logo-name"
                                                style="font-size: 15px; color:black; display: flex; align-items: center;">
                                                <i class="fa-solid fa-location-dot" style="margin-right: 5px;"></i>
                                                <?php echo $_SESSION['address_admin']; ?>
                                            </span>

                                            <span class="logo-name"
                                                style="font-size: 15px; color:black; display: flex; align-items: center;">
                                                <i class="fa-solid fa-envelope"
                                                    style="margin-right: 5px; color:black"></i>
                                                <?php echo $_SESSION['email_admin']; ?>
                                            </span>

                                        </div>







                                    </div>

                                    <div class="col d-flex justify-content-evenly">

                                        <?php if (isset($_SESSION['admin_Id'])): ?>
                                        <a href="../ADMIN_LOGIN/admin_update.php?<?php echo $_SESSION['admin_Id']; ?>"
                                            style="text-decoration:none; color:black">
                                            <div class="card"
                                                style="background-color:#d4a373; color:black;padding:10px">Edit profile
                                            </div>
                                        </a>



                                        <a href="../ADMIN_LOGIN/admin_profile.php?id=<?php echo $_SESSION['UserLogin']; ?>"
                                            style="text-decoration:none; color:black; ">
                                            <div class="card"
                                                style="background-color:#d4a373; color:black;padding:10px">
                                                View profile
                                            </div>

                                        </a>

                                        <?php endif; ?>

                                    </div>

                                    <?php endif; ?>
                                    <div class="">

                                        <a href="../ADMIN_LOGIN/admin_logout.php" class="align-middle px-0"
                                            style="color: black; text-decoration:none">
                                            <div class="card"
                                                style="background-color:#d4a373; color:black; padding:10px;margin-top:10px">
                                                Log out
                                            </div>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                </ul>
            </div>
        </nav><br>



        <section>


            <!-- <?php if($res){ ?>

            <form action="admin_validation.php" method="POST">
                <input type="text" name="username" value="<?php echo $res['username'] ?>">
                <input type="password" name="password" value="<?php echo $res['password'] ?>">

                <button type="submit" class="btn" style="background: #dda15e"> Update</button>

            </form>

            <?php  } ?> -->

            <div class="container py-5">


                <div class="row">

                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">

                                <?php
                            if (isset($_GET['id'])) {
                            $admin_Id = $_GET['id'];
                            $user = $crud->adminManage($admin_Id);
                            }
                 ?>
                                <?php if ($user) { ?>

                                <form action="" method="POST" enctype="multipart/form-data">


                                    <?php
                                        if ($user) {
                                            echo '<img src="../admin_profiles/' . $user['image'] . '" title="' . $user['image'] . '" style="height:200px; width:200px">';
                                        }
                                        ?>




                                    <h5 class="my-3"><?php echo $user['fullname_admin']; ?></h5>
                                    <input type="file" class="form-control-sm" name="image" id="image"
                                        accept=".jpg, .jpeg, .png" value="<?php echo $user['image'] ?>">

                            </div>
                            <button type="submit" name="updateIMg" style="background: #dda15e; color:black" class="btn">
                                Update </button>
                        </div>

                    </div>

                    <?php } ?>


                    <div class="col-lg-8">
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

                                    <div class="container p-3">
                                        <div class="row">
                                            <div class="col text-start">
                                                <label for="">Fullname:</label>
                                                <p class="text-muted mb-0"> <input type="text" class="form-control-sm"
                                                        name="fullname_admin"
                                                        value="<?php echo $user['fullname_admin'] ?>">
                                                </p>
                                            </div>

                                            <div class="col text-start">
                                                <label for="">Email:</label>
                                                <p class="text-muted mb-0"> <input type="text" class="form-control-sm"
                                                        name="email_admin" value="<?php echo $user['email_admin'] ?>">
                                                </p>
                                            </div>
                                        </div>
                                        <br>


                                        <div class="row">

                                            <div class="col text-start">
                                                <label for="">Phone:</label>
                                                <p class="text-muted mb-0"> <input type="number" class="form-control-sm"
                                                        name="contact_admin"
                                                        value="<?php echo $user['contact_admin'] ?>">
                                                </p>
                                            </div>

                                            <div class="col text-start">
                                                <label for="">Username:</label>
                                                <p class="text-muted mb-0"> <input type="text" class="form-control-sm"
                                                        name="username" value="<?php echo $user['username'] ?>">
                                                </p>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">

                                            <div class="col text-start">

                                                <label for="">Address:</label>
                                                <p class="text-muted mb-0"> <input type="text" class="form-control-sm"
                                                        name="address_admin"
                                                        value="<?php echo $user['address_admin'] ?>">
                                                </p>

                                            </div>

                                            <div class="col text-start">
                                                <label for="">Password:</label>
                                                <p class="text-muted mb-0"> <input type="text" class="form-control-sm"
                                                        name="password" value="<?php echo $user['password'] ?>">
                                                </p>



                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">

                                            <div class="col text-start">

                                                <label for="">Role</label>
                                                <p class="text-muted mb-0"> <input type="text" class="form-control-sm"
                                                        name="admin_role" value="<?php echo $user['admin_role'] ?>">
                                                </p>

                                            </div>

                                            <div class="col text-start">

                                                <label for="">Status:</label>
                                                <select name="admin_status" class="form-control" id="">
                                                    <option value="active">Active</option>
                                                    <option value="deact">Deact</option>
                                                </select>

                                            </div>
                                        </div>

                                    </div>








                            </div>
                            <button type="submit" class="btn" style="background: #dda15e; color:black"> Update
                            </button>
                            <?php } ?>
                        </div>

                    </div>


                </div>
            </div>


        </section>




    </main>

</body>






<!-- modal for add new admin -->

<script>
const openModalBtn = document.getElementById('openModalBtn');
const closeModalBtn = document.getElementById('closeModalBtn');
const modal = document.getElementById('modal');

openModalBtn.addEventListener('click', () => {
    modal.style.display = 'block';
});

closeModalBtn.addEventListener('click', () => {
    modal.style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});
</script>



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