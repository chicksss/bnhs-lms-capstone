<?php
session_start();

require_once "user_appointment.php";
require_once "appointment_engine.php";
require_once "../BOOKS/book_catalog_db.php";
require_once "../BOOKS/book_catalog_engine.php";

// class CRUD_appoint extends Appointment_DB {
  
// }




// $bookCatalog = new CRUD();
// $bookCategory = $bookCatalog->getBookCategories();

$appointment = new CRUD_appoint();

if(isset($_GET['appointment_Id'])){
    $appointment_Id = $_GET['appointment_Id'];
    $resulUser = $appointment->user_get_id($appointment_Id);
}


if (isset($_POST['create'])) {
    $borrow_name = $_POST['borrow_name'];
    $borrow_book_title = $_POST['borrow_book_title'];
    
    $borrow_user_id = $_POST['borrow_user_id'];
    $borrow_date = $_POST['borrow_date'];
    $resulUser = $appointment->insert_user_borrow($borrow_name,$borrow_book_title,$borrow_user_id,$borrow_date);
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
    z-index: 1;
    margin-top: 750px;
    margin-left: -170px;

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

body {
    background-color: rgba(180, 180, 180, 0.37);
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



        </ul>
    </div>
    <main class="home-section">

        <nav class="navbar d-flex">


            <div class="logos">
                <!-- <i class="bx bx-menu icon" style="color: black; font-size:30px"></i> -->
                <span>LIST USER BORROWED</span>
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
                                        <a href="../ADMIN_LOGIN/admin_update.php?<?php echo $_SESSION['admin_Id']; ?>"
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
                                    <a href="../ADMIN_LOGIN/admin_profile.php?id=<?php echo $_SESSION['UserLogin']; ?>"
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
        <br><br><br> <br><br>




        <section>

            <div class=" container card-body" style="max-height: 490px; overflow-y: auto; background-color:white">
                <label style="font-weight:900" for="idFilter">Filter by ID:</label>
                <input type="text" style="width:50%" class="form-control" id="idFilter" placeholder="Enter ID...">
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Account_ID</th>
                            <th>Borrower Name</th>
                            <th>Book</th>
                            <th>Date Return</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php 
                        $res = $appointment->get_user_borrowed();
                       
                        foreach($res as $user_borrow){?>

                        <tr>
                            <td><?php echo $user_borrow['borrow_user_id'] ?></td>
                            <td><?php echo $user_borrow['borrow_name'] ?></td>
                            <td><?php echo $user_borrow['borrow_book_title'] ?></td>
                            <td><?php echo $user_borrow['borrow_date'] ?></td>
                            <td>
                                <?php  
                                $currentDate = date('Y-m-d');
                                  if($currentDate <  $user_borrow['borrow_date']){
                                             echo "<p style='color:blue'>Ongoing</p>";
                                        } 
                                        else{ ?>

                                <a href="admin_user_accounts.php?borrow_id=<?php echo $user_borrow['borrow_id']?>"
                                    style="text-decoration:none">
                                    <p style="color:red">Penalty</p>
                                </a>
                                <?php       }    }
                               ?>
                            </td>

                        </tr>

                    </tbody>
                </table>




        </section>

    </main>
</body>

<script>
const idFilterInput = document.getElementById("idFilter");
const tableRows = document.querySelectorAll("table tbody tr");

idFilterInput.addEventListener("input", function() {
    const filterValue = idFilterInput.value.toLowerCase();

    tableRows.forEach(function(row) {
        const idCell = row.querySelector("td:first-child");
        if (idCell) {
            const idText = idCell.textContent;
            row.style.display = idText.toLowerCase().includes(filterValue) ? "" : "none";
        }
    });
});
</script>
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