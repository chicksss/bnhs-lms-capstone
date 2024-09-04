<?php
require "author_db.php";
require "authors_engine.php";




 

session_start();
 

$myAuthors = new authorsBook();
 


if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = $myAuthors->SelectedUpdateAuthor($id);
}

 

if (isset($_POST['adbook'])) {
    $id = $_POST['id'];
    $myAuthors->deleteAuthor($id);
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADMIN APPOINTMENT LIST</title>

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
    <link href="../uicons-regular-rounded/css/uicons-regular-rounded.css" rel="stylesheet">


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

/* navbar dashboard */
ul {
    margin: 0;
    padding: 0;
}

.sidebar .nav-links li:hover {
    background: #faedcd;
    border-top-left-radius: 50rem;
    border-bottom-left-radius: 50rem;
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

<body style="background:white">

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
    <main class="home-section" style="background-color:white">

        <nav class="navbar d-flex">


            <div class="logos">
                <!-- <i class="bx bx-menu icon" style="color: black; font-size:30px"></i> -->
                <span>AUTHORS</span>
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
                        <div class="dropdown-content" style="margin-top:350px; height:450px">


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






        <style>
        .dropdown-contents {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            padding: 12px 16px;
            z-index: 4;
        }

        .dropdown:hover .dropdown-contents {
            display: block;
        }
        </style>

        <div class="card-body">


            <div class="row" style="background-color:white">


                <div class="row">





                    <?php if($result){ ?>
                    <h1>Delete Author?</h1>
                    <form method="POST" action="author_delete.php">
                        <input type="number" name="id" value="<?php echo $result['id'] ?>">
                        <input type="submit" class="btn" style="background: #dda15e" name="adbook" value="Delete">

                    </form>
                </div>
                <?php } ?>
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