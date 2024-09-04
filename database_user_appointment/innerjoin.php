<?php
session_start();
require_once "user_appointment.php";
require_once "appointment_engines.php";
require_once "../BOOKS/book_catalog_db.php";
require_once "../BOOKS/book_catalog_engine.php";
$bookCatalog = new CRUD();
$bookCategory = $bookCatalog->getBookCategories();
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
/* div.card {

    background-color: white;
    box-shadow: 12px 12px 16px 0 rgba(0, 0, 0, 0.25), -8px -8px 12px 0 rgba(255, 255, 255, 0.3);
    border-radius: 20px;

} */

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


.title-book {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 200px;
    font-weight: 100;
}

body {
    background-color: rgba(180, 180, 180, 0.37);
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
                <a href="../database_book_catalog/admin_book.php" class="nav-link align-middle px-0"
                    style="color: white">
                    <i class="fas fa-book" style="color: white"> </i>
                    <span class="link_name">Books</span></a>
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

            <li>
                <a href="../database_user_appointment/admin_appointment.php" class="nav-link align-middle px-0"
                    style="color: white">
                    <i class="fas fa-edit" style="color: white"> </i>
                    <span class="link_name">Borrowers</span></a>
            </li>

            <!-- <li>
                <a href="../database_calendar/admin_events.php" class="nav-link align-middle px-0" style="color: white">
                    <i class="fas fa-calendar-check" style="color: white"> </i>
                    <span class="link_name">Events</span></a>
                </a>
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

        <nav class="navbar d-flex">


            <div class="logos">
                <!-- <i class="bx bx-menu icon" style="color: black; font-size:30px"></i> -->
                <span>BORROW</span>
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
        <br><br><br><br>






        <style>
        .dropdown-contents {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            padding: 12px 16px;
            z-index: 1;
        }

        .dropdown:hover .dropdown-contents {
            display: block;
        }
        </style>

        <div class="dropdown">
            <button class="btn btn-primary"> <span>Book Appointment Section</span></button>

            <div class="dropdown-contents">
                <?php 
                            
                            foreach($bookCategory as $book): ?>
                <ul>
                    <li>
                        <a style="text-decoration:none; color:black"
                            href="?table=<?php echo $book; ?>"><?php echo $book; ?></a>
                    </li>
                </ul>


                <?php endforeach; ?>
            </div>
        </div>



        <div class="container card-body" style="max-height: 490px; overflow-y: auto; background-color:white">
            <div class="row">
                <div class="col">
                    <div class="" style="text-align:left; margin-left:1px">
                        <!-- <button type="submit" name="create" class="btn btn-primary"><a
                                href="admin_list_users_borrowed.php" style="color:white; text-decoration:none">Borrowed
                                List</a></button> -->

                        <!-- <button type="submit" name="create" class="btn btn-primary"><a
                                href="admin_penalty_users_borrowed.php"
                                style="color:white; text-decoration:none">Penalty
                                List</a></button> -->

                        <input type="text" id="idFilter" class="form-control" placeholder="Enter Borrower ID...">
                    </div>
                </div>
                <div class="col" style="text-align:right; margin-right:65px">
                    <!-- <label for="idFilter">Filter by ID:</label>
                    <input type="text" id="idFilter" placeholder="Enter ID..."> -->


                </div>
            </div>

            <?php

                      if (isset($_GET['table'])) {
                        $seletedCategory = $_GET['table'];
                        $currentTime = time();
                        $startDay = strtotime('today', $currentTime);
                        $appointment = new CRUD_appoint();
                        $bookResult = $appointment->appointmentResult($seletedCategory);
                   ?>

            <?php if($bookResult > 0){  ?>

            <table class="table" style="font-size: 13px;">
                <thead style="font-size:15px">
                    <tr>
                        <th>Account ID</th>
                        <th>Borrower ID</th>

                        <th>Borrower</th>
                        <!-- <th>Date</th>
                        <th>Contact</th> -->

                        <th style="width:150px">Book</th>
                        <!-- <th>Book Status</th> -->
                        <th>Call Number</th>
                        <th>Status</th>
                        <th>Countdown</th>
                        <th>Delete</th>
                        <!-- <th>Borrowed</th> -->
                        <th>Add Copies</th>

                    </tr>
                </thead>
                <tbody>
                    <?php 
                
                foreach($bookResult as $t){ ?>
                    <tr>
                        <td>
                            <p><?php echo $t['user_id']; ?> </p>
                        </td>

                        <td>
                            <p><?php echo $t['generateId']; ?> </p>
                        </td>

                        <td>
                            <p><?php echo $t['borrower_name']; ?> </p>
                        </td>

                        <td>
                            <p class="title-book"><?php echo $t['title']; ?> </p>
                        </td>

                        <td>
                            <p class="title-book"><?php echo $t['book_call_number']; ?> </p>
                        </td>

                        <td>
                            <p><?php 
                                        if($t['status'] == 'Available'){
                                            echo "Borrowed";
                                        } 
                                        else{
                                            echo "Returned";
                                        }
                                    ?></p>
                        </td>



                        <td>
                            <?php

                         
                            $currentDate = date('Y-m-d');
                            $appointDate = $t['appointmentDate'];

                            if ($appointDate >= $currentDate) {
                                // Calculate the number of days left until the borrowing_date
                                $daysUntilAppoint = ceil((strtotime($appointDate) - strtotime($currentDate)) / (60 * 60 * 24));
                                echo $daysUntilAppoint, " Day(s) Left";
                            } else { 
                                echo " <p style='color:red'>Penalty</p>";
                                // Increment the count of book copies
                                // $bookCategory = $bookCatalog->IncrementCountOfBook($book_number, $selectedTable);
                                // echo '<button type="submit" class="btn btn-danger"><a href="admin_user_list_borrowed.php?appointment_Id=' . $t['appointment_Id'] . '"> <i class="fas fa-trash delete" style="font-size:20px;color:white"></i></a></button>';
                            }
                            ?>

                        </td>
                        <td>
                            <?php
                        $currentDate = date('Y-m-d');
                        $appointDate = $t['appointmentDate'];
                        $daysUntilAppoint = max(0, ceil((strtotime($appointDate) - strtotime($currentDate)) / (60 * 60 * 24)));
                      
                        if ($appointDate >= $currentDate) {
                            //   echo $daysUntilAppoint, " Day Left";
                             echo '<button type="submit" class="btn btn-danger"><a href="admin_user_list_delete.php?appointment_Id=' . $t['appointment_Id'] . '"> <i class="fas fa-trash delete" style="font-size:20px;color:white"></i></a></button>';

                        } else{
                             echo '<button type="submit" class="btn btn-danger"><a href="admin_user_list_delete.php?appointment_Id=' . $t['appointment_Id'] . '"> <i class="fas fa-trash delete" style="font-size:20px;color:white"></i></a></button>';

                        }
                        ?>
                        </td>


                        <td>

                            <?php
                        $currentDate = date('Y-m-d');
                        $appointDate = $t['appointmentDate'];
                        $daysUntilAppoint = max(0, ceil((strtotime($appointDate) - strtotime($currentDate)) / (60 * 60 * 24)));
                      
                        if ($appointDate >= $currentDate) {
                            //   echo $daysUntilAppoint, " Day Left";
                                echo '<button type="submit" class="btn btn-primary"
                                                style="margin-right:20px"> <a style="text-decoration:none"
                                                    href="../database_book_catalog/addCopies.php?table=' . $seletedCategory . '&id=' . $t['book_Id'] . '">
                                                    <i class="fas fa-edit update"
                                                        style="font-size:20px;color:white"></i>
                                                    <div class="hide-update"></div>
                                                </a></button>';
                        } else {
                             
                            // Increment the count of book copies
                            //$bookCategory = $bookCatalog->IncrementCountOfBook($book_number, $selectedTable);
                             echo '<button type="submit" class="btn btn-primary"><a href="../database_book_catalog/addCopies.php?id=' . $t['book_Id'] . '"> <i class="fa-solid fa-file-circle-plus" style="color: #ffffff;"></i></a></button>';


                        }
                        ?>
                        </td>

                    </tr>
                    <?php  ?>
                </tbody>
                <?php } }  ?>
            </table>
            <?php } ?>

        </div>

        <script>
        const idFilterInput = document.getElementById("idFilter");
        const tableRows = document.querySelectorAll("table tbody tr");

        idFilterInput.addEventListener("input", function() {
            const filterValue = idFilterInput.value.toLowerCase();

            tableRows.forEach(function(row) {
                const idCell = row.querySelector("td:nth-child(2)");
                if (idCell) {
                    const idText = idCell.textContent;
                    row.style.display = idText.toLowerCase().includes(filterValue) ? "" : "none";
                }
            });
        });
        </script>




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