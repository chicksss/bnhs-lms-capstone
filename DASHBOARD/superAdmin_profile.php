<?php

require_once "../ADMIN_LOGIN/admin_login_engine.php";
require_once "../ADMIN_LOGIN/admin_login_db.php";
$crud = new CRUD();

session_start();

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


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-/Erl5r5RnInmGakjth6Qf1hqY0+JvXn6j3U6fJL+oQQm3v0Tq+3qyJRHAK0KpOX+/LX9Wx+8ZQd1sugFj/bH4Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"
        integrity="sha512-0gdIjKtPLS1F1CvT16KLwq3J36tKEnjUsiRboSCXzWibxn2sBdMfudKoRJInw6KjQUB1on+kE91fRo6U0h6q3A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <title>Admin Detials</title>
</head>
<style>
body {

    background: #ddf0ff;
}

.main-container {
    margin: 1%;
}

.col {
    text-align: center;
}

.card {
    background-color: white;

    padding: 10px;
    width: 100%;

}

.container {
    margin: auto;

}


/* Dashboard Navbar */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: black;
    position: fixed;
    background: white;
    width: 100%;
    z-index: 10;
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);

}

.logo-name {
    font-size: 1.2rem;

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


.nav-link {
    list-style: none;
    display: flex;
    margin-right: 70px;
}

.img {
    border-radius: 50rem;
    width: 50px;
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

.card {
    background-color: white;
    /* box-shadow: 12px 12px 16px 0 rgba(0, 0, 0, 0.25), -8px -8px 12px 0 rgba(255, 255, 255, 0.3); */
    border-radius: 15px;
    text-align: center;
    padding: 20px;

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
                <a href="../database_calendar/admin_events.php" class="nav-link align-middle px-0" style="color: white">
                    <i class="fas fa-calendar-check" style="color: white"> </i>
                    <span class="link_name">Events</span></a>
                </a>
            </li>
            <li>
                <a href="../database_faq/faq.php" class="nav-link align-middle px-0" style="color: white">
                    <i class="fa-solid fa-circle-question" style="color: #ffffff;"></i>
                    <span class="link_name">Faq</span></a>
                </a>
            </li> -->




        </ul>
    </div>
    <main class="home-section">

        <nav class="navbar d-flex">


            <div class="logos">
                <!-- <i class="bx bx-menu icon" style="color: black; font-size:30px"></i> -->
                <span>PROFILE</span>
            </div>




            <ul class="nav-links" style="margin-right:250px">
                <div class="dropdown">
                    <div class="logo" style="margin-right: auto; float: right;">
                        <span> <?php if (isset($_SESSION['UserLogin']) && isset($_SESSION['image'])): ?>
                            <img src="../admin_profiles/<?php echo $_SESSION['image']; ?>" class="img">
                            <span class="logo-name"
                                style="font-size: 15px; color:black"><?php echo $_SESSION['UserLogin']; ?></span>
                        </span>
                        <?php else: ?>
                        <span class="logo-name">Welcome Guest</span>
                        <?php endif; ?>
                        <div class="dropdown-content" style="margin-top:500px">
                            <!-- <?php if ($_SESSION['UserLogin']): ?>
                            <a href="../ADMIN_LOGIN/admin_profile.php?id=<?php echo $_SESSION['UserLogin']; ?>"
                                style="text-decoration:none; color:black;">
                                <div class="card-body">
                                    <p>View Profile</p>
                                    <br>
                                    <p>
                                        <a href="../ADMIN_LOGIN/admin_logout.php" class="nav-link align-middle px-0"
                                            style="color: black">
                                            <span class="link_name">Logout</span>
                                        </a>
                                    </p>
                                </div>
                            </a>
                            <?php endif; ?> -->

                            <?php if($_SESSION['UserLogin']):?>
                            <div class="card" style="width:20rem;height:100%">


                                <?php if (isset($_SESSION['admin_Id'])): ?>

                                <span>
                                    <img src=" ../admin_profiles/<?php echo $_SESSION['image']; ?>" class="imgs"
                                        style=" border-radius: 50rem; width: 100px; height: 100px;">
                                </span>


                                <span class="logo-name" style="font-size: 15px; color:black; font-weight:bold">
                                    <?php echo $_SESSION['fullname_admin']; ?>
                                </span>



                                <br>

                                <div class="row">
                                    <div class="col">
                                        <?php if (isset($_SESSION['admin_Id'])): ?>
                                        <a href="superAdmin_updateOnly.php?<?php echo $_SESSION['admin_Id']; ?>"
                                            style="text-decoration:none; color:black">
                                            <div class="card"
                                                style="background-color:#00457c; color:white;padding:18px"> <i
                                                    class="fa-solid fa-pen-to-square"
                                                    style="font-size:20px; color:white"></i>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col">
                                    <a href="superAdmin_profile.php?id=<?php echo $_SESSION['UserLogin']; ?>"
                                        style="text-decoration:none; color:black; ">
                                        <div class="card" style="background-color:#00457c; color:white;padding:18px">
                                            <i class="fa-solid fa-eye" style="color: #ffffff;font-size:20px;"></i>
                                        </div>

                                    </a>
                                </div>
                            </div>

                            <br>


                            <p style="font-size:15px; font-weight:light"><?php echo $_SESSION['admin_role']; ?> <i
                                    class="fa-solid fa-circle-check" style="color: black; font-size:15px"></i></p>


                            <div style="  background-color: #52525256; height:5px; width:100%; border-radius:50rem">
                            </div>
                            <br>

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
                                    <i class="fa-solid fa-envelope" style="margin-right: 5px;"></i>
                                    <?php echo $_SESSION['email_admin']; ?>
                                </span>

                            </div>

                            <?php endif; ?>
                            <br><br><br>
                            <a href="../ADMIN_LOGIN/admin_logout.php" class="align-middle px-0"
                                style="color: black; text-decoration:none">
                                <div class="card" style="background-color:#00457c; color:white">
                                    Log out
                                </div>
                            </a>

                            <?php endif; ?>


                            <br>






                        </div>
                    </div>
                </div>
                </div>
            </ul>



        </nav>


        <br><br><br>
        <div class="main-container">


            <?php        
                   
                if (isset($_SESSION['admin_Id'])) {
                $admin_Id = $_SESSION['admin_Id'];

               
                $user = $crud->adminProfile($admin_Id);

                ?>
            <?php
            $password = $user['password'];
            $maskedPassword = str_repeat('*', strlen($password));
            if ($user) {  ?>

            <section>



                <div class="container">
                    <div class="row justify-content-center">

                        <div class="card">
                            <div class="row justify-content-center">
                                <div class="col-sm-4">
                                    <img src="../admin_profiles/<?php echo $user['image']; ?>" width="300" height="300"
                                        title="<?php echo $user['image']; ?>">
                                </div>
                                <div class="col-sm-2">

                                    <b>Name:</b>
                                    <input class="form-control" type="text" placeholder="Readonly input here…"
                                        value="<?php echo $user['fullname_admin']; ?>" readonly> <br />

                                    <b>Email:</b><br />
                                    <input class="form-control" type="text" placeholder="Readonly input here…"
                                        value="<?php echo $user['email_admin']; ?>" readonly> <br />

                                    <b>Address:</b><br />
                                    <input class="form-control" type="text" placeholder="Readonly input here…"
                                        value="<?php echo $user['address_admin']; ?>" readonly><br />

                                </div>

                                <div class="col-sm-3">
                                    <b>Contact:</b>
                                    <input class="form-control" type="text" placeholder="Readonly input here…"
                                        value="<?php echo $user['contact_admin']; ?>" readonly><br />

                                    <b>Username:</b>
                                    <input class="form-control" type="text" placeholder="Readonly input here…"
                                        value="<?php echo $user['username']; ?>" readonly><br />


                                    <b>Password:</b>
                                    <input class="form-control" type="text" placeholder="Readonly input here…"
                                        value="<?php echo $maskedPassword; ?>" readonly><br />

                                </div>
                            </div>
                        </div>
                    </div>
                </div>





                <?php }?>

                <?php   } ?>

            </section>

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