<?php
 
require_once "../BOOKS/book_catalog_db.php";
require_once "../BOOKS/book_catalog_engine.php";




$tables = [];

session_start();
$crud = new CRUD();

// if (isset($_POST['submit'])) {
//     $tableName = $_POST['table_name'];
//     $crud->createBookTable($tableName); 
// }


if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = $crud->selectUpdateBookCopy($id);
   

}

 

if (isset($_POST['updateCopies'])) {
    $id = $_POST['id'];
    $statusPerCopy = $_POST['statusPerCopy'];
    $crud->UpdatecopiesBooks($id,$statusPerCopy);
 header("Location: admin_appointment.php");

}


// if (isset($_POST['updateCopies'])) {
//     $id = $_POST['id'];
//     $statusPerCopy = $_POST['statusPerCopy'];
//     $crud->UpdatecopiesBooks($id,$statusPerCopy);
//     header("Location: admin_AddCopies_Book.php");

// }



//search books

// if (isset($_GET['search'])) {
//     $search = $_GET['search'];
//     $selectedTable = $_GET['table_name'];

//     // Modify your SQL query to include the search filter
//     // $queryFoods = "SELECT * FROM ppl_book WHERE title LIKE '%$search%'";
//     // $result = mysqli_query($conn, $queryFoods);

//     $result = $crud->getFilteredBook($selectedTable,$search);
    
// }



 






?>



<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />

    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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
    <link href="../uicons-regular-rounded/css/uicons-regular-rounded.css" rel="stylesheet">

    <!-- bootstrap icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<style>
.sidebar .nav-links li:hover {
    background: #faedcd;
    border-top-left-radius: 50rem;
    border-bottom-left-radius: 50rem;
}

body {
    font-family: 'Poppins';
}

div.card {

    background-color: white;
    /* box-shadow: 12px 12px 16px 0 rgba(0, 0, 0, 0.25), -8px -8px 12px 0 rgba(255, 255, 255, 0.3); */
    border-radius: 20px;
    border: none;

}

.row {
    padding: 2px;
}

.hide-delete {
    display: none;
}

.delete:hover+.hide-delete {
    display: block;
    color: red;
}




.hide-update {
    display: none;
}

.update:hover+.hide-update {
    display: block;
    color: blue;
}







.create {
    background: #00457c;
    color: white;
}

.card-book-sec button {
    background: #00457c;
    color: white;
    padding: 10px;
    width: 70%;
    border-radius: 10px;
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
    background: white;
    width: 100%;
    z-index: 10;



}

body {
    background-color: rgba(180, 180, 180, 0.37);
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


/* modal content to book category and list */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin-left: 15%;
    padding: 20px;
    margin-top: 2%;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
}


.form-group {
    margin-top: 20px;
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
    margin-top: 50px;
}

.dropdown:hover .dropdown-content {
    display: block;
}

.section-content {
    background-color: white;
}

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

/* dropdown */

.dropdown {
    position: relative;
    display: inline-block;

}

.dropdown-contents {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    margin-top: 750px;
    margin-left: -170px;

}

.dropdown:hover .dropdown-contents {
    display: block;
}

.section-content {
    background-color: white;
}

#overflowTest {

    color: white;
    padding: 15px;
    width: 100%;
    height: 300px;
    overflow: scroll;
    border: 1px solid #ccc;
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


        <nav class="navbar d-flex">


            <div class="logos">
                <!-- <i class="bx bx-menu icon" style="color: black; font-size:30px"></i> -->
                <span>UPDATE COPY</span>
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
                        <div class="dropdown-contents" style="margin-top:350px">
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
                                                style="background-color:#dda15e; color:black;padding:18px"> <i
                                                    class="fa-solid fa-pen-to-square"
                                                    style="font-size:20px; color:black"></i>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col">
                                    <a href="../ADMIN_LOGIN/admin_profile.php?id=<?php echo $_SESSION['UserLogin']; ?>"
                                        style="text-decoration:none; color:black; ">
                                        <div class="card" style="background-color:#dda15e; color:black;padding:18px">
                                            <i class="fa-solid fa-eye" style="color: #white;font-size:20px;"></i>
                                        </div>

                                    </a>
                                </div>
                            </div>

                            <br>


                            <p style="font-size:15px; font-weight:light"><?php echo $_SESSION['admin_role']; ?> <i
                                    class="fa-solid fa-circle-check" style="color: black; font-size:15px"></i></p>


                            <div style="background-color: #52525256; height:5px; width:100%; border-radius:50rem">
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
                                <div class="card" style="background-color:#dda15e; color:black">
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




        <br><br>





        <div class="card-body" style="background-color:white;margin-top:20px">





            <div class="row" style="background-color:white">






                <?php if($result){ ?>
                <form method="POST" action="admin_copies_update.php">


                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>">

                    <div class="form-group">

                        <!-- <input type="hidden" class="form-control" placeholder="Enter Book Copies" name="no_of_copies"
                            id="copies" value="1" required> -->
                        <label for="Status" style="color:black">Update Status</label>
                        <select class="form-control" name="statusPerCopy" id="">
                            <option value="Available">Available</option>
                        </select>





                    </div>
                    <button type="submit" class="btn" style="background-color: #DDA15E" name="updateCopies"
                        value="Update">Update </button>
                </form>

                <?php  }?>

            </div>

        </div>








        </div>




    </main>




</body>




<script>
const openModalBtn = document.getElementById('btnCategory');
const closeModalBtn = document.getElementById('closeModalBtn');
const modal = document.getElementById('categoryModal');

const openBookModalBtn = document.getElementById('btnBookList');
const closeBookModalBtn = document.getElementById('closeModalBookList');
const modalBook = document.getElementById('bookModal');


const openBookCategoryModalBtn = document.getElementById('btnBooksDelete');
const closeBookCategoryModalBtn = document.getElementById('closeBookCategoryModalBtn');
const modalBookDelete = document.getElementById('modalCategories');

openBookCategoryModalBtn.addEventListener('click', () => {
    modalBookDelete.style.display = 'block';
});

closeBookCategoryModalBtn.addEventListener('click', () => {
    modalBookDelete.style.display = 'none';
});



openModalBtn.addEventListener('click', () => {
    modal.style.display = 'block';
});

closeModalBtn.addEventListener('click', () => {
    modal.style.display = 'none';
});

openBookModalBtn.addEventListener('click', () => {
    modalBook.style.display = 'block';
});

closeBookModalBtn.addEventListener('click', () => {
    modalBook.style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
    if (event.target === modalBook) {
        modalBook.style.display = 'none';
    }

    if (event.target === modalBookDelete) {
        modalBookDelete.style.display = 'none';
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