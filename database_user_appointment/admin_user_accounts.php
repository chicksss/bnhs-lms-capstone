<?php
session_start();

require_once "user_appointment.php";
require_once "appointment_engine.php";
require_once "../BOOKS/book_catalog_db.php";
require_once "../BOOKS/book_catalog_engine.php";


require_once "../END_USER/end_user_db.php";
require_once "../END_USER/end_user_engine.php";
$end_users = new END_USERS();



// $bookCatalog = new CRUD();
// $bookCategory = $bookCatalog->getBookCategories();

$appointment = new CRUD_appoint();

if(isset($_GET['borrow_id'])){
    $borrow_id = $_GET['borrow_id'];    
    $resulUser = $appointment->get_one_user_borrowed($borrow_id);
}


if (isset($_POST['create'])) {
    $user_id = $_POST['user_id'];
    $user_status = $_POST['user_status'];
    $user = $end_users->bannedUser($user_id,$user_status);
    header ("Location: admin_appointment.php");
}
 

 





 


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADMIN APPOINTMENT LIST</title>

    <!--<title> Drop Down Sidebar Menu | CodingLab </title>-->
    <link rel="stylesheet" href="../CSS/new_side.css" />
    <!-- Boxiocns CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <!-- html icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/6122121193.js" crossorigin="anonymous"></script>
    <!-- bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

</head>

<style>
div.card {

    background-color: white;
    box-shadow: 12px 12px 16px 0 rgba(0, 0, 0, 0.25), -8px -8px 12px 0 rgba(255, 255, 255, 0.3);
    border-radius: 20px;

}

.home-content {
    width: 100%;
    padding-right: 100%;
    margin-top: -30px;
    font-size: 30px;
    position: fixed;
    z-index: 9;
    background: white;
    padding-top: 70px;
    color: black;
    padding-bottom: 50px
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
    box-shadow: 2px 2px 16px -4px rgba(0, 0, 0, 0.75);
    -webkit-box-shadow: 2px 2px 16px -4px rgba(0, 0, 0, 0.75);
    -moz-box-shadow: 2px 2px 16px -4px rgba(0, 0, 0, 0.75);


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

}

.logo img {
    height: 30px;
    width: 30px;
    margin-right: 20px;
}

.logo-name {
    font-size: 1.2rem;
    font-weight: bold;
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



/* appoitnmetn book category dropdown */

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
    padding: 12px 16px;
    z-index: 1;
}

.dropdown:hover .dropdown-content {
    display: block;
}

/* dropdown */

.dropdown {
    position: relative;
    display: inline-block;
}

.contents {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    margin-top: 50px;


}

.dropdown:hover .contents {
    display: block;
}
</style>

<body>

    <div class="sidebar close">

        <div class="logo-details" style="padding-left: 20px">
            <img src="../images/p_logo.png" style="height: 50px; width: 50px" />
            <span class="logo_name">&nbsp; PPL</span>
        </div>



        <ul class="nav-links">
            <li>
                <a href="../DASHBOARD/admin_index.php" class="nav-link align-middle px-0" style="color: white;  ">
                    <i class="fa fa-home" style="color: white"> </i>
                    <span class="link_name">Dashboard</span>
                </a>

            </li>

            <li>
                <a href="../ADMIN_LOGIN/admin_list.php" class="nav-link align-middle px-0" style="color: white;  ">
                    <i class="fa-solid fa-user" style="color: #ffffff;"></i>
                    <span class="link_name">Admin</span>
                </a>
            </li>


            <li>
                <a href="../END_USER/end_user_list.php" class="nav-link align-middle px-0" style="color: white">
                    <i class="fa-solid fa-user-tie" style="color: #ffffff;"></i>
                    <span class="link_name">User</span></a>
                </a>
            </li>

            <li>
                <a href="../BOOKS/admin_book_home.php" class="nav-link align-middle px-0" style="color: white">
                    <i class="fas fa-book" style="color: white"> </i>
                    <span class="link_name">Books</span></a>
            </li>

            <li>
                <a href="../database_user_appointment/admin_book_returned.php" class="nav-link align-middle px-0"
                    style="color: white">
                    <i class="bi bi-arrow-return-left" style="color: black"></i>
                    <span class="link_name" style="color: black">Returned</span></a>
            </li>






        </ul>
    </div>


    <main class="home-section">



        <nav class="navbar">
            <div class="logos">
                <i class="bx bx-menu icon" style="color: black; font-size:30px"></i>
                <span>USER ACCOUNTS</span>
            </div>
            <ul class="nav-link">
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


                        <div class="contents" style="margin-top:150px">
                            <?php if ($_SESSION['UserLogin']) {
                    ?>
                            <a href="../ADMIN_LOGIN/admin_profile.php?id=<?php echo $_SESSION['UserLogin']; ?>"
                                style="text-decoration:none; color:black; ">

                                <div class="card-body">
                                    <p>
                                        View Profile
                                    </p>
                                    <br>
                                    <p>
                                        <a href="../ADMIN_LOGIN/admin_logout.php" class="nav-link align-middle px-0"
                                            style="color: black">

                                            <span class="link_name">Logout</span></a>
                            </a>
                            </p>
                        </div>


                        </a>
                        <?php
                    }
                    ?>
                    </div>
                </div>
                </div>
            </ul>
        </nav>
        <br><br><br> <br><br>

        <div class="container" style="background-color:white">
            <form action="admin_user_accounts.php" method="POST">
                <?php if($resulUser) { ?>
                <input type="hidden" name="borrow_id" value="<?php echo $borrow_id; ?>">
                <div class="row">
                    <div class="col">
                        <label for=""> Account ID</label>
                        <input type="number" class="form-control" value="<?php echo $resulUser['borrow_user_id'] ?>"
                            placeholder="Account_ID" name="user_id" id="">
                    </div>
                    <div class="col">
                        <label for=""> Borrower Name</label>
                        <input type="text" class="form-control" value="<?php echo $resulUser['borrow_name'] ?>"
                            placeholder="Borrower Name" name="borrow_name" id="" disabled>
                    </div>

                    <?php } ?>
                    <div class="col">
                        <label for=""> Ban this user?</label>
                        <select class="form-select" name="user_status" aria-label="Default select example">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <br>
                <button type="submit" name="create" class="btn btn-primary">Submit</button>
            </form>

        </div>






    </main>
</body>
<script>
let arrow = document.querySelectorAll(" .arrow");
for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e) => {
        let arrowParent = e.target.parentElement.parentElement; //selecting main parent
        of arrow
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