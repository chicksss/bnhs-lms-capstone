<?php
 
 if(!isset($_SESSION)){
session_start();
} 
 
require_once "../DATABASE/book_catalog_db.php";
require_once "../BOOKS/book_catalog_engine.php";

require_once "../BOOKMARK/bookmark_engine.php";
require_once "../BOOKMARK/bookmark_db.php";

require_once "../END_USER/end_user_db.php";
require_once "../END_USER/end_user_engine.php";
  

$crud = new CRUD();

$userbookmark = new BOOKMARK();




if(isset($_POST['login'])){
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $LoginSuccess = $end_user->EndUserLogin($user_email, $user_password);
    if($LoginSuccess['user_status'] == 1){
        echo "<script>alert('Your are banned because of not returning a book'); location.replace('homepage_books.php')</script>";  
    } else{

    if($LoginSuccess){
        session_start();
        $_SESSION['userLogin'] = $user_email;
        $_SESSION['user_fullname'] = $LoginSuccess['user_fullname'];
        $_SESSION['user_contact'] = $LoginSuccess['user_contact'];
        $_SESSION['user_address'] = $LoginSuccess['user_address'];

        $_SESSION['user_LRN'] = $LoginSuccess['user_LRN'];
        

    
        $_SESSION['user_id'] = $LoginSuccess['user_id'];
        echo "<script>alert('Successfully Login'); location.replace('homepage_catalog.php')</script>";
        exit();
    }
  
    else {
        echo "<script>alert('Login Error. Please try again.'); location.replace('homepage_books.php')</script>";   
    }
}
}





  $end_users = new END_USERS();
    if(isset($_SESSION['user_id'])){
         $user_id = $_SESSION['user_id'];
         $user = $end_users->UserSessioninBook($user_id);
    }
 

if (isset($_GET['table']) && isset($_GET['id'])&& isset($_GET['user_id'])) {
    $selectedTable = $_GET['table'];
    $bookId = $_GET['id'];
    $user_id = $_GET['user_id'];
    $result = $crud->ViewBook($selectedTable,$bookId,$user_id);
      if ($result) {
        // Set the response content type to PDF
        header('Content-Type: application/pdf');
        // Output the PDF content directly
        echo $result['book_pdf'];
        exit; // Exit to prevent the rest of the HTML from being sent
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <link href="../src/output.css" rel="stylesheet" /> -->

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
    <title>Document</title>
</head>


<body class="bg-[#f5ebe0]">

    <nav class="border-gray-200 bg-[#edede9] w-full fixed z-20 top-0 start-0 shadow-lg">
        <div class="flex flex-wrap justify-between items-center mx-10 p-4 ">
            <a href="https://flowbite.com" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-1xl font-semibold whitespace-nowrap dark:text-black md:ml-20">BAUTISTA
                    NHS</span>
            </a>

            <a href="../END_USER/end_user_logout.php" class="text-sm text-black dark:text-blue-500 hover:underline mr-20">Log
                out</a>


        </div>
    </nav>

    <nav class="bg-[#e6ccb2] shadow-lg mt-[58px]">
        <div class="max-w-screen-xl px-4 py-3 mx-auto">
            <div class="flex items-center">
                <ul class="flex flex-row items-center font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm md:ml-20 md:text-lg">
                    <li>
                        <a href="homepage_catalog.php" class="text-gray-900 dark:text-dark hover:underline"
                            aria-current="page">Home</a>
                    </li>
                    <!-- <li>
                        <a href="user_manual.php" class="text-gray-900 dark:text-dark hover:underline">
                            User Manual</a>
                    </li> -->
                    <li>
                        <a href="homepage_bookmark.php"
                            class="text-gray-900 dark:text-dark hover:underline">Bookmark</a>
                    </li>

                    <li>
                        <?php
                        if ($_SESSION['user_fullname']) { ?>
                        <a class="text-gray-900 dark:text-dark hover:underline"
                            href="../END_USER/end_user_profile.php?user_id=<?php echo $_SESSION['user_fullname']; ?>">Profile</a>
                        <?php } ?>

                    </li>

                    <li>
                        <a href="homepage_list_appointment.php" class="text-gray-900 dark:text-dark hover:underline">My
                            Books</a>
                    </li>

                    <li>
                        <div class="ml-96">
                            <input type="search" class="p-1 rounded-full border-0 px-3 py-2" id="searchInput"
                                placeholder="Search: Title/Author/..." oninput="filterBooks()">
                        </div>
                        <script>
                        function filterBooks() {
                            // Get the input value and convert it to lowercase
                            var query = document.getElementById('searchInput').value.toLowerCase();

                            // Get all elements with the class 'myULs' (updated to use class)
                            var flipCards = document.querySelectorAll('.myulsss');

                            // Loop through each flip-card
                            flipCards.forEach(function(flipCard) {
                                // Get the title and details of the book (adjust the classes based on your structure)
                                var title = flipCard.querySelector('.title_book').innerText.toLowerCase();
                                // var callnum = flipCard.querySelector('.book_call_number').innerText
                                //     .toLowerCase();
                                var author = flipCard.querySelector('.author-name').innerText.toLowerCase();
                                var isbn = flipCard.querySelector('.book_isbn').innerText.toLowerCase();
                                var publisher = flipCard.querySelector('.publisher').innerText
                                    .toLowerCase();

                                // Check if the title, author, ISBN, or publisher contains the search query
                                if (title.includes(query) || author.includes(query) || isbn.includes(
                                        query) ||
                                    publisher.includes(query)) {
                                    flipCard.style.display = ''; // Show the flip-card
                                } else {
                                    flipCard.style.display = 'none'; // Hide the flip-card
                                }
                            });
                        }
                        </script>

                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div>

        <div class="flex grid-cols-2 justify-between px-32 items-center py-10">
            <h1 class="text-3xl text-center md:text-3xl font-['Cedarville-Cursive']">
                All Books
            </h1>

            <button id="dropdownUsersButton" data-dropdown-toggle="dropdownUsers" data-dropdown-placement="bottom"
                class="text-black bg-[#e6ccb2]  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center  dark:focus:ring-blue-800"
                type="button">Category <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>

            <div id="dropdownUsers" class="z-10 hidden bg-white rounded-lg shadow w-60">
                <ul class="h-48 py-2 overflow-y-auto text-gray-700 dark:text-gray-200 p-2"
                    aria-labelledby="dropdownUsersButton">
                    <li>
                        <?php 
                    $tables = $crud->selectAllCategory(); ?>
                    <li class="p-1">
                        <a class="text-start no-underline" style="color:black" href="homepage_catalog.php">
                            <p class="text-1xl "> All Books </p>
                        </a>

                    </li>
                    <?php   foreach ($tables as $table): ?>

                    <li class="p-1 hover:bg-[#e6ccb2]">
                        <a class="text-start no-underline " style="color:black"
                            href="?table=<?php echo $table['id']; ?>">
                            <p class="title_book"> <?php echo $table['category']; ?> </p>
                        </a>

                    </li>
                    <?php endforeach; ?>
                    </li>

                </ul>

            </div>
        </div>



        <?php
            if (isset($_GET['table'])) {
                $selectedTable = $_GET['table'];
                 $getCategory = $crud->getCat($selectedTable);
              ?>

        <h1 class="text-3xl text-center">
            <?php echo $getCategory ?>
        </h1>




        <div class="">

            <div class=" flex flex-wrap justify-center gap-5 py-10 px-20  ">
                <?php
                        if (isset($_GET['submit'])) {
                            $searchBook = $_GET['search'];
                            $result = $crud->getFilteredBook($selectedTable, $searchBook);
                        } else {
                            $result = $crud->selectedBook($selectedTable);
                        }

                        if (count($result) > 0) {
                           

                            foreach ($result as $row) {
                                ?>
                <div class="myulsss relative flex-none">

                    <img src="../BOOKS/book/<?php echo $row['image']; ?>" title="<?php echo $row['image']; ?>"
                        class="h-[300px] w-52 shadow-xl transition-transform duration-300 ease-in-out transform hover:scale-105"
                        style="">
                    <div
                        class="grid p-2 absolute inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 text-white opacity-0 transition-opacity duration-300 ease-in-out hover:opacity-100">
                        <b
                            class="title_book"><?= substr($row['title'], 0, 30); ?><?= strlen($row['title']) > 30 ? '...' : ''; ?></b>

                        <p class="author-name text-1xl"> by
                            &nbsp;<?=  $row['author_name'];  ?> </p>

                        <p class="book_isbn text-1xl"> ISBN
                            &nbsp;<?=  $row['book_isbn'];  ?> </p>

                        <p class="publisher text-1xl">
                            Publisher
                            &nbsp;<?=  $row['publisher'];  ?> </p>

                        <p class="book_call_number text-1xl">
                            Accession:
                            &nbsp;<?=  $row['book_call_number'];  ?> </p>

                        <?php
                                        if ($row['status_name'] == 'Available') {
                                            if (isset($_SESSION['user_id'])) {
                                                $user_id = $_SESSION['user_id'];
                                                echo '<a href="homepage_appoint.php?table=' . $selectedTable . '&id=' . $row['id'] . '&user_id=' . $user_id.' "><button class="btn" style="background-color: #d4a373; width:100%">Borrow</button></a>';
                                            echo '<br>';
                                            echo '<br>';
                                                if (isset($_SESSION['user_id'])) {
                                                    $user_id = $_SESSION['user_id'];
                                                    $title = $row['title'];
                                                    $book_id = $row['id'];
                                                    $is_bookmarked = $userbookmark->checkBookmarked($user_id, $selectedTable, $book_id);

                                                    if ($is_bookmarked) {
                                                        echo '<button class="btn" style="background-color: #dda15e; width:100%">Bookmarked</button>';
                                                    } else {
                                                    echo '<a class="addBookmark" href="../BOOKMARK/bookmark_handler.php?table=' . $selectedTable . '&book_id=' . $book_id . '&id=' . $row['id'] . '&title=' . urlencode($title) . '"><button class="btn" style="background-color: #dda15e; width:100%">Bookmark</button></a>';
                                                    }
                                                }
                                            }
                                        }  
                                                                                
                                         else if($row['status_name'] == 'Not_Available') {
                                           $result = $crud->udpdateStatusInBookCopies($selectedTable, $row['id']);
                                            if (isset($_SESSION['user_id'])) {
                                                $user_id = $_SESSION['user_id'];
                                                $title = $row['title'];
                                                $book_id = $row['id'];
                                                $is_bookmarked = $userbookmark->checkBookmarked($user_id, $selectedTable, $book_id);

                                                if ($is_bookmarked) {
                                                    echo '<button class="btn-borrow" disabled>Bookmarked</button>';
                                                } else {
                                                    echo '<a class="addBookmark" href="../BOOKMARK/bookmark_handler.php?table=' . $selectedTable . '&book_id=' . $book_id . '&id=' . $row['id'] . '&title=' . urlencode($title) . '"><button class="btn" style="background-color: #dda15e;width:100%">Bookmark</button></a>';
                                                }
                                            }
                                        }
                                        ?>

                    </div>

                </div>

                <?php }
                        } else { ?>
                <div>
                    <h1>There are no books in this category</h1>
                </div>
                <?php       
                } } else {

                     
              ?>


                <div class="flex flex-wrap justify-center gap-5 py-10 px-20  ">
                    <?php
                $result = $crud->selectedBookAll();
                foreach ($result as $row) {
                ?>
                    <div class="myulsss relative flex-none">

                        <img src="../BOOKS/book/<?php echo $row['image']; ?>" title="<?php echo $row['image']; ?>"
                            class="h-[300px] w-52 shadow-xl transition-transform duration-300 ease-in-out transform hover:scale-105"
                            style="">
                        <div
                            class="grid p-2 absolute inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 text-white opacity-0 transition-opacity duration-300 ease-in-out hover:opacity-100">
                            <b
                                class="title_book"><?= substr($row['title'], 0, 30); ?><?= strlen($row['title']) > 30 ? '...' : ''; ?></b>

                            <p class="author-name text-1xl"> by
                                &nbsp;<?=  $row['author_name'];  ?> </p>

                            <p class="book_isbn text-1xl"> ISBN
                                &nbsp;<?=  $row['book_isbn'];  ?> </p>

                            <p class="publisher text-1xl">
                                Publisher
                                &nbsp;<?=  $row['publisher'];  ?> </p>

                            <p class="book_call_number text-1xl">
                                Accession:
                                &nbsp;<?=  $row['book_call_number'];  ?> </p>

                            <?php if ($row['status_name'] == 'Available') {
                                             
                                        if (isset($_SESSION['user_id'])) {
                                            $user_id = $_SESSION['user_id'];
                                           $selectedTable = $row['id'];
                                            echo '<a href="homepage_appoint.php?table=' . $selectedTable . '&id=' . $row['id'] . '&user_id=' . $user_id.' "><button class="btn" style="background-color: #d4a373; width:100%">Borrow</button></a>';
                                           // echo '<a href="homepage_appoint.php?table=' . '&id=' . $row['id'] . '&user_id=' . $user_id.' "><button class="btn" style="background-color: #d4a373; width:100%">Borrow</button></a><br><br>';
                                            if (isset($_SESSION['user_id'])) {
                                                $user_id = $_SESSION['user_id'];
                                                $title = $row['title'];
                                                $book_id = $row['id'];
                                                $is_bookmarked = $userbookmark->checkBookmarkedAll($user_id, $book_id);
                                                if ($is_bookmarked) {
                                                    echo '<button class="btn" disabled style="background-color: #dda15e; width:100%">Bookmarked</button>';
                                                } else {
                                                    echo '<a class="addBookmark" href="../BOOKMARK/bookmark_handler.php?book_id=' . $book_id . '&id=' . $row['id'] . '&title=' . urlencode($title) . '"><button class="btn" style="background-color: #dda15e; width:100%">Bookmark</button></a>';
                                                }
                                            }
                                        }
                                    } else if ($row['status_name'] == 'Not_Available') {
                                        $result = $crud->udpdateStatusInBookCopiesAll($row['id']);
                                        if (isset($_SESSION['user_id'])) {
                                            $user_id = $_SESSION['user_id'];
                                            $title = $row['title'];
                                            $book_id = $row['id'];
                                            $is_bookmarked = $userbookmark->checkBookmarkedAll($user_id, $book_id);
                                            if ($is_bookmarked) {
                                                echo '<button class="btn" disabled style="background-color: #dda15e; width:100%">Bookmarked</button>';
                                            } else {
                                                echo '<a class="addBookmark" href="../BOOKMARK/bookmark_handler.php?book_id=' . $book_id . '&id=' . $row['id'] . '&title=' . urlencode($title) . '"><button class="btn" style="background-color: #dda15e; width:100%">Bookmark</button></a>';
                                            }
                                        }
                                    } ?>

                        </div>

                    </div>
                    <?php  } ?>


                </div>
            </div>

            <?php 
        }
         ?>

        </div>
    </div>

</body>

</html>