 <!DOCTYPE html>
 <html lang="en">

 <head>

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
     <link href="../uicons-regular-rounded/css/uicons-regular-rounded.css" rel="stylesheet">
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


 <body>


     <!-- 
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
     </div> -->




 </body>
 <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
 <script>
feather.replace()
 </script>







 </html>