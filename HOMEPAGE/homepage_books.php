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



  $end_users = new END_USERS();
if(isset($_POST['login'])){
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $LoginSuccess = $end_users->EndUserLogin($user_email, $user_password);
    if($LoginSuccess['user_status'] == 1){
        echo "<script>alert('Your are banned because of not returning a book'); location.replace('homepage_books.php')</script>";  
    } else{

    if($LoginSuccess){
        session_start();
        $_SESSION['userLogin'] = $user_email;
        $_SESSION['user_fullname'] = $LoginSuccess['user_fullname'];
        $_SESSION['user_contact'] = $LoginSuccess['user_contact'];
        $_SESSION['user_address'] = $LoginSuccess['user_address'];
        $_SESSION['user_email'] = $LoginSuccess['user_email'];
        $_SESSION['user_id'] = $LoginSuccess['user_id'];
        echo "<script>alert('Successfully Login'); location.replace('homepage_catalog.php')</script>";
        exit();
    }
  
    else {
        echo "<script>alert('Login Error. Please try again.'); location.replace('homepage_books.php')</script>";   
    }
}
}





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
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
            <a href="https://flowbite.com" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-1xl font-semibold whitespace-nowrap dark:text-black md:ml-20">BAUTISTA
                    NHS</span>
            </a>
            <div class="flex items-center space-x-6 rtl:space-x-reverse  mr-20">
                <a href="#" data-modal-target="default-modal" data-modal-toggle="default-modal"
                    class="text-sm text-black dark:text-blue-500 hover:underline">Sign in</a>
            </div>
        </div>
    </nav>

    <nav class="bg-[#e6ccb2] shadow-lg mt-[58px]">
    <div class="max-w-screen-xl px-4 py-3 mx-auto flex justify-between items-center h-[60px]"> <!-- Added flex, justify-between, items-center, and height -->
        <div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm md:ml-20 md:text-lg">
                <li>
                    <a href="index.php" class="text-gray-900 dark:text-dark hover:underline" aria-current="page">Home</a>
                </li>
                <li>
                    <a href="#" class="text-gray-900 dark:text-dark hover:underline underline">Browse Books</a>
                </li>
                <!-- <li>
                    <a href="#" class="text-gray-900 dark:text-dark hover:underline">About</a>
                </li> -->
            </ul>
        </div>
        <div class="flex items-center mr-20">
        <input type="search" class="p-1 rounded-full border-0 px-3 py-2" id="searchInput"
        placeholder="Search: Title/Author/..." oninput="filterBooks()">
        </div>
        <script>
                        function filterBooks() {
                            // Get the input value and convert it to lowercase
                            var query = document.getElementById('searchInput').value.toLowerCase();

                            // Get all elements with the class 'myULs' (updated to use class)
                            var flipCards = document.querySelectorAll('.myUL');

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
    </div>
</nav>


    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow text-black ">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-black">
                        Sign in
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>


                <form class="max-w-sm mx-auto p-5" method="POST" action="homepage_books.php">

                    <div class="mb-5">

                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Your
                            email</label>
                        <input type="email" id="email" name="user_email"
                            class="shadow-sm text-black border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  "
                            placeholder="Email" required />
                    </div>
                    <div class="mb-5">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Your
                            password</label>
                        <input type="password" id="password" name="user_password" placeholder="Password"
                            class="shadow-sm text-black border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  "
                            required />
                    </div>

                    <button type="submit" name="login"
                        class="text-black bg-[#e6ccb2] hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Sign
                        in</button>
                </form>

            </div>
        </div>
    </div>


    <div>

        <div class="flex grid-cols-2 justify-between px-32 items-center py-10">
            <h1 class="text-3xl text-center md:text-3xl font-['Cedarville-Cursive']">
                Browse Books
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
                        <a class="text-start no-underline" style="color:black" href="homepage_books.php">
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




        <div>

            <div class="flex flex-wrap justify-center gap-5 py-10 px-20  ">
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
                <div class="myUL relative flex-none">

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

                        <button class="btn" style="background-color: #d4a373; "><a
                                style="text-decoration:none; color:black"
                                href="bookOverview.php?id=<?php echo $row['id'] ?>">Overview</a></button>

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
                    <div class="myUL relative flex-none">

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

                            <button class="btn" style="background-color: #d4a373; "><a
                                    style="text-decoration:none; color:black"
                                    href="bookOverview.php?id=<?php echo $row['id'] ?>">Overview</a></button>

                        </div>

                    </div>
                    <?php  } ?>


                </div>
            </div>

            <?php } ?>

        </div>

    </div>
</body>

</html>