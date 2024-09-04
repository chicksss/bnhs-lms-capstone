<?php

require_once "admin_login_engine.php";
require_once "admin_login_db.php";
$crud = new CRUDADMIN();
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
    width: 50%;
    padding: 2%;

}

.btn {
    background-color: #00457c;
    color: white;

}
</style>

<body>

    <div class="sidebar close">
        <div class="logo-details" style="padding-left:20px">
            <img src="../images/p_logo.png" style="height:50px;width:50px">
            <span class="logo_name">&nbsp; PPL</span>
        </div>



        <ul class="nav-links">
            <li>
                <a href="admin_index.php" class="nav-link align-middle px-0" style="color: white;  ">
                    <i class="fa fa-home" style="color: white"> </i>
                    <span class="link_name">Dashboard</span>
                </a>

            </li>
            <li>
                <a href="admin_book.php" class="nav-link align-middle px-0" style="color: white;  ">
                    <i class="fa fa-book" style="color: white"> </i>
                    <span class="link_name">Books</span>
                </a>

            </li>
            <li>
                <a href="admin_appointment.php" class="nav-link align-middle px-0" style="color: white">
                    <i class="fas fa-edit" style="color: white"> </i>
                    <span class="link_name">Appointment</span></a>
            </li>

            <li>

                <a href="admin_staff.php" class="nav-link align-middle px-0" style="color: white">
                    <i class="fas fa-sitemap" style="color: white"> </i>
                    <span class="link_name">Staff</span></a>

            </li>

            <li>
                <a href="admin_events.php" class="nav-link align-middle px-0" style="color: white">
                    <i class="fas fa-calendar-check" style="color: white"> </i>
                    <span class="link_name">Events</span></a>
                </a>
            </li>

            <li>
                <a href="../database_faq/faq.php" class="nav-link align-middle px-0" style="color: white">
                    <i class="fa-solid fa-circle-question" style="color: #ffffff;"></i>
                    <span class="link_name">Faq</span></a>
                </a>
            </li>





        </ul>
    </div>

    <main class="home-section">

        <div class="home-content" style="position:fixed">
            <i class="bx bx-menu"></i>
        </div>


        <br><br>
        <div class="container" style="margin: auto">
            <div class="card" style="background-color: #00457c;  padding:2%">
                <h3 style="font-family: Arial; color:white;font-weight:900;">MANAGE PROFILE</h3>
            </div>

            <div class="container" align="center">
                <div class="img-card">
                    <?php
                 if (isset($_SESSION['admin_Id'])) {
                $admin_Id = $_SESSION['admin_Id'];
                // Fetch the user's data from the database using the ID
                // $statement = $pdo->prepare("SELECT * FROM user WHERE id = :id");
                // $statement->bindParam(':id', $userId);
                // $statement->execute();
                // $user = $statement->fetch(PDO::FETCH_ASSOC); 


                $user = $crud->adminManage($admin_Id);

                 }
                
                        if ($user) {  ?>
                    <div class=" container">
                        <br><br>
                        <div class="container">
                            <div class="row">
                                <div class="col" style="text-align:center">
                                    <b>Profile: </b> <br><br>
                                    <b>Name: </b> <br><br>
                                    <b>Email: </b> <br><br>
                                    <b>Address: </b> <br><br>
                                    <b>Fullname: </b> <br><br>
                                    <b>Contact: </b> <br><br>
                                    <b>Password: </b> <br><br>
                                </div>

                                <div class="col" style="text-align:center">
                                    <form method="POST" action="admin_update.php" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $user['admin_Id'] ?>">
                                        <input type="file" name="image" value="<?php echo $user['image'] ?>" required>
                                        <br>
                                        <input type="text" name="username" value="<?php echo $user['username'] ?>"> <br>
                                        <br>
                                        <input type="email" name="email_admin"
                                            value="<?php echo $user['email_admin'] ?>">
                                        <br> <br>

                                        <input type="text" name="address_admin"
                                            value="<?php echo $user['address_admin'] ?>">
                                        <br> <br>

                                        <input type="text" name="fullname_admin"
                                            value="<?php echo $user['fullname_admin'] ?>">
                                        <br> <br>

                                        <input type="number" name="contact_admin"
                                            value="<?php echo $user['contact_admin'] ?>">
                                        <br> <br>

                                        <input type="password" name="password" value="<?php echo $user['password'] ?>">
                                        <br> <br>

                                        <button type="submit" class="btn"><a
                                                href="admin_update.php?id=<?php echo $user['id']; ?>">Update</a></button>
                                        <button class="btn"><a style="text-decoration:none; color:white;"
                                                href="../ADMIN_FOLDER/delete.php?id=<?php echo $user['id'] ?>">Delete</a></button>
                                    </form>



                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <?php }
    
                        ?>




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