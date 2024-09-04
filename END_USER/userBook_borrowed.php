<?php

require_once "end_user_db.php";
require_once "end_user_engine.php";
require "../database_user_appointment/user_appointment.php";
require "../database_user_appointment/appointment_engine.php";
session_start();

 
$end_users = new END_USERS();
 
$appointment = new CRUD_appoint();
$getEndUsers = $end_users->getAllUser();



$end_users = new END_USERS();
                    if(isset($_SESSION['user_id'])){
                        $user_id = $_SESSION['user_id'];
                        $user = $end_users->UserSessioninBook($user_id);
                    }


                    $currentTime = time();
                            $startDay = strtotime('today', $currentTime);

                            
if (isset($_POST["import"])) {
    $fileName = $_FILES["excel"]["name"];
    $fileExtension = explode('.', $fileName);
    $fileExtension = strtolower(end($fileExtension));
    $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

    $targetDirectory = "uploads/" . $newFileName;
    move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

    error_reporting(0);
    ini_set('display_errors', 0);

    require 'excelReader/excel_reader2.php';
    require 'excelReader/SpreadsheetReader.php';

    $reader = new SpreadsheetReader($targetDirectory);

    foreach ($reader as $key => $row) {
        // Extracting data from the form
        $user_email = $row[0];
        $user_password = $row[1];
        
        // Insert user data into the database with error handling
        try {
            $getEndUsers = $end_users->EndUserRegister($user_email, $user_password);

            if ($getEndUsers->rowCount() > 0) {
                echo "<script> alert('Successfully Registered'); location.replace('homepage_books.php') </script>";
            } else {
                echo "There is an error in Log in please try again";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
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
    <title>END USER LIST</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">



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


body {
    background-color: rgba(180, 180, 180, 0.37);
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: black;
    position: fixed;
    background: #dad7cd;
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
    background: #dad7cd;
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



.dropdown:hover .dropdown-content {
    display: block;

}

/* dropdown */

/* .dropdown {
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


} */

/* .dropdown:hover .contents {
    display: block;
} */

ul {
    margin: 0;
    padding: 0;
}


.card {
    background-color: white;
    /* box-shadow: 12px 12px 16px 0 rgba(0, 0, 0, 0.25), -8px -8px 12px 0 rgba(255, 255, 255, 0.3); */
    border-radius: 15px;
    text-align: center;
    padding: 20px;

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
</style>

<body>

    <div class="sidebar" style="background-color:#d5bdaf;">
        <div class="logo-details" style="padding-left: 20px">

            <span class="logo_name" style="color: black">&nbsp; BNHS</span>
        </div>


        <ul class="nav-links">

            <li>
                <a href="../DASHBOARD/admin_index.php" class="nav-link align-middle px-0" style="color: white; ">
                    <i class="fa fa-home" style="color: black"> </i>
                    <span class="link_name" style="color: black">Dashboard</span>
                </a>

            </li>

            <li>
                <a href="../ADMIN_LOGIN/admin_list.php" class="nav-link align-middle px-0" style="color: white;  ">
                    <i class="fa-solid fa-user" style="color: black;"></i>
                    <span class="link_name" style="color: black">Admin</span>
                </a>
            </li>


            <li>
                <a href="../END_USER/end_user_list.php" class="nav-link align-middle px-0" style="color: white">
                    <i class="fa-solid fa-user-tie" style="color: black;"></i>
                    <span class="link_name" style="color: black">User</span></a>
                </a>
            </li>



            <li>
                <a href="../BOOKS/admin_book_home.php" class="nav-link align-middle px-0" style="color: white">
                    <i class="fas fa-book" style="color: black"> </i>
                    <span class="link_name" style="color: black">Books</span></a>
            </li>

            <li>
                <a href="../database_user_appointment/admin_appointment.php" class="nav-link align-middle px-0"
                    style="color: white">
                    <i class="fas fa-edit" style="color: black"> </i>
                    <span class="link_name" style="color: black">Borrowers</span></a>
            </li>




            <!-- <li>

                <a href="../database_staff/admin_staff.php" class="nav-link align-middle px-0" style="color: white">
                    <i class="fas fa-sitemap" style="color: white"> </i>
                    <span class="link_name">Staff</span></a>

            </li> -->

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

            <li>
                <a href="../database_user_appointment/admin_book_returned.php" class="nav-link align-middle px-0"
                    style="color: white">
                    <i class="bi bi-arrow-return-left" style="color: black"></i>
                    <span class="link_name" style="color: black">Returned</span></a>
            </li>




        </ul>
    </div>


    <main class="home-section">

        <nav class="navbar d-flex">


            <div class="logos">
                <!-- <i class="bx bx-menu icon" style="color: black; font-size:30px"></i> -->
                <span>USER</span>
            </div>




            <ul class="nav-links" style="margin-right:250px">
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
                        <div class="dropdown-content" style="margin-top:350px; height:450px; margin-left:-160px">


                            <?php if($_SESSION['UserLogin']):?>
                            <div class="card" style="width:20rem;height:100%; background:#f5ebe0">


                                <?php if (isset($_SESSION['admin_Id'])): ?>

                                <span>
                                    <img src=" ../admin_profiles/<?php echo $_SESSION['image']; ?>" class="imgs"
                                        style="width: 100%; height: 100%;">
                                </span>



                                <span class="logo-name" style="font-size: 15px; color:black; font-weight:bold;">
                                    <?php echo $_SESSION['fullname_admin']; ?>
                                </span>



                                <br>

                                <div class="row">
                                    <div class="col">
                                        <?php if (isset($_SESSION['admin_Id'])): ?>
                                        <a href="../ADMIN_LOGIN/admin_update.php?<?php echo $_SESSION['admin_Id']; ?>"
                                            style="text-decoration:none; color:black">
                                            <div class="card"
                                                style="background-color:#d4a373; color:black;padding:10px"> <i
                                                    class="fa-solid fa-pen-to-square"
                                                    style="font-size:20px; color:black"></i>
                                        </a>

                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col">
                                    <a href="../ADMIN_LOGIN/admin_profile.php?id=<?php echo $_SESSION['UserLogin']; ?>"
                                        style="text-decoration:none; color:black; ">
                                        <div class="card" style="background-color:#d4a373; color:black;padding:10px">
                                            <i class="fa-solid fa-eye" style="color: black;font-size:20px;"></i>
                                        </div>

                                    </a>
                                </div>
                            </div>

                            <br>


                            <p style="font-size:15px; font-weight:light"><?php echo $_SESSION['admin_role']; ?> <i
                                    class="fa-solid fa-circle-check" style="color: black; font-size:15px"></i></p>
                            <div style="background-color: black; height:5px; width:100%; border-radius:50rem">
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
                                    <i class="fa-solid fa-envelope" style="margin-right: 5px; color:black"></i>
                                    <?php echo $_SESSION['email_admin']; ?>
                                </span>

                            </div>

                            <?php endif; ?>
                            <br><br><br>
                            <a href="../ADMIN_LOGIN/admin_logout.php" class="align-middle px-0"
                                style="color: black; text-decoration:none">
                                <div class="card" style="background-color:#d4a373; color:black; padding:10px">
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

        <section>
            <div class="container">
                <div class="row container" style="text-align: center; color: black; margin:auto">
                    <div class="col" style="text-align:left">
                        <h1 style="font-family: 'Cedarville Cursive';">Books</h1>
                    </div>
                    <div class="col">

                        <?php
                        $totalPEnalites = $appointment->TotalPenalties($user_id);
                        echo '<span>Total Penalty:  </span>'.$totalPEnalites;
                    ?>
                    </div>

                </div>



            </div>
            <div class="" style="border-bottom:black 4px solid; width:76rem; text-align:center; margin:auto"></div>

            <div class="container card-body" style="max-height: 550px; overflow-y: auto; ">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Account ID</th>
                            <th>Name</th>
                            <th>Book</th>
                            <th>Date</th>
                            <th>Status</th>
                            <!-- <th>Status</th> -->
                            <th>Countdown</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                    $appointmentsList = $appointment->getAllAppointmentList($user_id);
                    foreach($appointmentsList as $bokAppoint): 
                    ?>
                        <tr>
                            <td><?php echo $bokAppoint['user_id']; ?></td>
                            <td><?php echo $bokAppoint['borrower_name']; ?></td>
                            <td><?php echo $bokAppoint['book_title']; ?></td>
                            <td><?php echo $bokAppoint['borrowing_date']; ?></td>
                            <td>
                                <?php
                             if($bokAppoint['status'] == 'Available'){
                                echo '<span style="color:green; font-style: italic">Reserved</span>';
                             
                            }
                            else if($bokAppoint['status'] == 'Borrowed'){
                                 $currentDate = date('Y-m-d');
                            $appointDate = $bokAppoint['appointmentDate'];

                            if ($appointDate >= $currentDate) {
                                // Calculate the number of days left until the borrowing_date
                                $daysUntilAppoint = ceil((strtotime($appointDate) - strtotime($currentDate)) / (60 * 60 * 24));
                                 echo " <p style='color:blue'>Accepted</p>";
                            } else { 
                                echo " <p style='color:red'>Penalty</p>";
                                // Increment the count of book copies
                                // $bookCategory = $bookCatalog->IncrementCountOfBook($book_number, $selectedTable);
                                // echo '<button type="submit" class="btn btn-danger"><a href="admin_user_list_borrowed.php?appointment_Id=' . $t['appointment_Id'] . '"> <i class="fas fa-trash delete" style="font-size:20px;color:white"></i></a></button>';
                            }
                            }
                            else{
                           
                        }
                            ?>

                            </td>

                            <td>
                                <?php
                             if($bokAppoint['status'] == 'Available'){
                                echo '<span style="color:red; font-style: italic">Pending</span>';
                             
                            }
                            else if($bokAppoint['status'] == 'Borrowed'){
                                 $currentDate = date('Y-m-d');
                            $appointDate = $bokAppoint['appointmentDate'];

                            if ($appointDate >= $currentDate) {
                                // Calculate the number of days left until the borrowing_date
                                $daysUntilAppoint = ceil((strtotime($appointDate) - strtotime($currentDate)) / (60 * 60 * 24));
                                echo $daysUntilAppoint, " Day(s) Left";
                            } else { 
                                
                                 
                                 $appointmentId = $bokAppoint['appointment_Id'];
                                 $update = $appointment->UpdatetoPenalty($appointmentId);
                                   
                            }
                            }
                            
                            ?>

                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>







            </div>
            </div>

        </section>




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