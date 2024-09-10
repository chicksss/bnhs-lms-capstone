    <?php
 
require_once "../END_USER/end_user_db.php";
require_once "../END_USER/end_user_engine.php";


  $end_user = new END_USERS();


    require_once "../DATABASE/book_catalog_db.php";
    require_once "../BOOKS/book_catalog_engine.php";

                                    
  $crud = new CRUD();


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
        $_SESSION['user_LRN'] = $LoginSuccess['user_LRN'];
        $_SESSION['user_fullname'] = $LoginSuccess['user_fullname'];
        $_SESSION['user_contact'] = $LoginSuccess['user_contact'];
        $_SESSION['user_address'] = $LoginSuccess['user_address'];
        $_SESSION['user_id'] = $LoginSuccess['user_id'];
        echo "<script>alert('Successfully Login'); location.replace('homepage_catalog.php')</script>";
        exit();
    }
  
    else {
        echo "<script>alert('Login Error. Please try again.'); location.replace('homepage_books.php')</script>";   
    }
}
}


    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="../src/output.css" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>

        <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
        <title>Document</title>
    </head>

    <body class="bg-[#f5ebe0]">
        <nav class="border-gray-200 bg-[#edede9] w-full fixed z-20 top-0 start-0 shadow-lg px-24">
            <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
                <a href="https://flowbite.com" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <span class="self-center text-1xl font-semibold whitespace-nowrap dark:text-black md:ml-20">BAUTISTA
                        NHS</span>
                </a>
                <div class="flex items-center space-x-6 rtl:space-x-reverse mr-20">
                    <a href="#" data-modal-target="default-modal" data-modal-toggle="default-modal"
                        class="text-sm text-black dark:text-blue-500 hover:underline">Sign in</a>
                </div>
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
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>


                    <form class="max-w-sm mx-auto p-5" method="POST" action="index.php">

                        <div class="mb-5">

                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Your
                                email</label>
                            <input type="email" id="email" name="user_email"
                                class="shadow-sm text-black border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  "
                                placeholder="Email" required />
                        </div>
                        <div class="mb-5">
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Your
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

        <nav class="bg-[#e6ccb2] shadow-lg mt-[58px] px-24">
            <div class="max-w-screen-xl px-4 py-3 mx-auto">
                <div class="flex items-center">
                    <ul
                        class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm md:ml-20 md:text-lg">
                        <li>
                            <a href="index.php" class="text-gray-900 dark:text-dark hover:underline"
                                aria-current="page">Home</a>
                        </li>
                        <li>
                            <a href="homepage_books.php" class="text-gray-900 dark:text-dark hover:underline">Browse
                                Books</a>
                        </li>
                        <!-- <li>
                            <a href="#about" class="text-gray-900 dark:text-dark hover:underline">About</a>
                        </li> -->
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-10">
            <div>
                <h1 class="text-3xl text-center md:mt-20 md:text-6xl" style="font-family: Cedarville Cursive">
                    Bautista National High School
                </h1>
                <div class="text-center border-y-2 border-gray-900 mx-auto w-[calc(100%-20rem)] ml-40 mr-40"></div>
            </div>

            <div class="flex grid-cols-2 justify-between px-[200px] py-10">
                <p class="" style="font-weight:bold; font-family: 'Cedarville Cursive'; font-size:30px">
                    Newly Acquired
                    Books</p>
                <div class="">
                    <input type="text"
                        class="block w-full p-2  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        id="searchInput" placeholder="Title/Author/ISBN/DDC..." oninput="filterBooks()">
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
                        var callnum = flipCard.querySelector('.book_call_number').innerText.toLowerCase();
                        var author = flipCard.querySelector('.author-name').innerText.toLowerCase();
                        var isbn = flipCard.querySelector('.book_isbn').innerText.toLowerCase();
                        var publisher = flipCard.querySelector('.publisher').innerText.toLowerCase();

                        // Check if the title, author, ISBN, or publisher contains the search query
                        if (title.includes(query) || author.includes(query) || isbn.includes(query) ||
                            publisher.includes(query) || callnum.includes(query)) {
                            flipCard.style.display = ''; // Show the flip-card
                        } else {
                            flipCard.style.display = 'none'; // Hide the flip-card
                        }
                    });
                }
                </script>
            </div>



            <div class="flex flex-wrap  gap-10 py-10 justify-center">
                <?php 
                        $allResults = $crud->NewAcquiredBooks(); 
                        foreach ($allResults as $res):
                        ?>
                <div class="myUL relative flex-none">

                    <img src="../BOOKS/book/<?php echo $res['image']; ?>" title="<?php echo $res['image']; ?>"
                        class="h-[300px] w-52 shadow-xl transition-transform duration-300 ease-in-out transform hover:scale-105"
                        style="">
                    <div
                        class="grid p-2 absolute inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 text-white opacity-0 transition-opacity duration-300 ease-in-out hover:opacity-100">
                        <b
                            class="title_book"><?= substr($res['title'], 0, 30); ?><?= strlen($res['title']) > 30 ? '...' : ''; ?></b>

                        <p class="author-name text-1xl"> by
                            &nbsp;<?=  $res['author_name'];  ?> </p>

                        <p class="book_isbn text-1xl"> ISBN
                            &nbsp;<?=  $res['book_isbn'];  ?> </p>

                        <p class="publisher text-1xl">
                            Publisher
                            &nbsp;<?=  $res['publisher'];  ?> </p>

                        <p class="book_call_number text-1xl">
                            Accession:
                            &nbsp;<?=  $res['book_call_number'];  ?> </p>

                        <button class="btn" style="background-color: #d4a373; "><a
                                style="text-decoration:none; color:black"
                                href="bookOverview.php?id=<?php echo $res['id'] ?>">Overview</a></button>

                    </div>
                </div>

                <?php endforeach; ?>

            </div>




            <div class="text-center border-y-2 border-gray-900 mt-2 mx-auto w-[calc(100%-20rem)] ml-40 mr-40"></div>

            <div class="flex grid-cols-2 justify-between px-[200px] py-10">
                <p class="" style="font-weight:bold; font-family: 'Cedarville Cursive'; font-size:30px">
                    Available Books</p>
                <div class="">

                    <!-- <input type="search"
                        class="block w-full p-2  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        id="searchInputss" placeholder="Search: Title/Author/ISBN..." oninput="filterBookss()"> -->
                </div>

                <script>
                function filterBookss() {
                    // Get the input value and convert it to lowercase
                    var query = document.getElementById('searchInputss').value.toLowerCase();

                    // Get all elements with the class 'myULs' (updated to use class)
                    var flipCards = document.querySelectorAll('.myULss');

                    // Loop through each flip-card
                    flipCards.forEach(function(flipCard) {
                        // Get the title and details of the book (adjust the classes based on your structure)
                        var title = flipCard.querySelector('.title_books').innerText.toLowerCase();
                        var callnum = flipCard.querySelector('.book_call_numbers').innerText.toLowerCase();
                        var author = flipCard.querySelector('.author-names').innerText.toLowerCase();
                        var isbn = flipCard.querySelector('.book_isbns').innerText.toLowerCase();
                        var publisher = flipCard.querySelector('.publishers').innerText.toLowerCase();

                        // Check if the title, author, ISBN, or publisher contains the search query
                        if (title.includes(query) || author.includes(query) || isbn.includes(query) ||
                            publisher.includes(query) || callnum.includes(query)) {
                            flipCard.style.display = ''; // Show the flip-card
                        } else {
                            flipCard.style.display = 'none'; // Hide the flip-card
                        }
                    });
                }
                </script>
            </div>

            <div class="flex flex-wrap gap-10 py-10 justify-center">
                <?php 
                        $allResults = $crud->availableBooks(); 
                        foreach ($allResults as $res):
                        ?>
                <div class="myULss relative flex-none">

                    <img src="../BOOKS/book/<?php echo $res['image']; ?>" title="<?php echo $res['image']; ?>"
                        class="h-[300px] w-52 shadow-xl transition-transform duration-300 ease-in-out transform hover:scale-105"
                        style="">
                    <div
                    class="grid p-2 absolute inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 text-white opacity-0 transition-opacity duration-300 ease-in-out hover:opacity-100">
                        <b
                            class="title_book"><?= substr($res['title'], 0, 30); ?><?= strlen($res['title']) > 30 ? '...' : ''; ?></b>

                        <p class="author-names text-1xl"> by
                            &nbsp;<?=  $res['author_name'];  ?> </p>

                        <p class="book_isbns text-1xl"> ISBN
                            &nbsp;<?=  $res['book_isbn'];  ?> </p>

                        <p class="publishers text-1xl">
                            Publisher
                            &nbsp;<?=  $res['publisher'];  ?> </p>

                        <!-- <p class="book_call_numbers text-1xl">
                            Accession:
                            &nbsp;<?=  $res['book_call_number'];  ?> </p> -->

                        <button class="btn" style="background-color: #d4a373; "><a
                                style="text-decoration:none; color:black"
                                href="bookOverview.php?id=<?php echo $res['id'] ?>">Overview</a></button>

                    </div>
                </div>

                <?php endforeach; ?>

            </div>


            <div class="px-10">
                <h1 class="font-['Cedarville-Cursive'] text-3xl ml-[160px] py-3  font-bold">Featured Book</h1>

                <div class="flex grid-cols-2 justify-center gap-10 px-[150px]">

                    <?php 
                        $allResults = $crud->featuredBook(); 
                        foreach ($allResults as $res) {
                            ?>
                    
                        <img src="../BOOKS/book/<?php echo $res['image']; ?>" title="<?php echo $res['image']; ?>"
                            class="h-96 w-96" >

                     

                    <div class="">
                        <h3 class="font-bold text-2xl py-2">
                            <?php echo $res['title'] ?></h3>
                        <p class="text-1xl py-2">by: <?php echo $res['author_name'] ?></p>

                        <p class="textAll text-1xl py-3" id="synopsis"
                            style="color: black; text-align: justify; text-justify: inter-word; width: 100%; overflow: hidden; max-height: 200px;">

                            &nbsp;<?= $res['synopsis']; ?></p>
                        <p id="seeMore" style="color: blue; cursor: pointer; display: none;">See more...</p>
                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var synopsis = document.getElementById('synopsis');
                            var seeMore = document.getElementById('seeMore');

                            // Check if the synopsis height is greater than the maximum height (100px in this example)
                            if (synopsis.scrollHeight > synopsis.clientHeight) {
                                seeMore.style.display = 'block';

                                seeMore.addEventListener('click', function() {
                                    synopsis.style.maxHeight = 'none';
                                    seeMore.style.display = 'none';
                                });
                            }
                        });
                        </script>


                        <b>This edition</b>

                        <div class="flex gap-10 py-5">
                            <div>
                                <b>ISBN:</b> <br>
                                <b>Publisher:</b> <br>
                                <b>Date Published:</b> <br>
                                <b>Total Borrowed:</b> <br>
                            </div>

                            <div>
                                <?php echo $res['book_isbn'] ?><br>
                                <?php echo $res['publisher'] ?><br>
                                <?php echo $res['book_date_published'] ?><br>
                                <?php echo $res['borrow_count'] ?> <br>
                            </div>
                        </div>

                    </div>
                    <?php } ?>
                </div>
            </div>


            <!-- <div class="px-[150px] py-5" id="about">
                <footer class="bg-white rounded-lg shadow m-4 dark:bg-gray-800">
                    <div class="mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-center">
                        <ul
                            class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                            <li>
                                <a href="#" class="hover:underline me-4 md:me-6">About</a>
                            </li>
                            <li>
                                <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="#" class="hover:underline me-4 md:me-6">Licensing</a>
                            </li>
                            <li>
                                <a href="#" class="hover:underline">Contact</a>
                            </li>
                        </ul>
                    </div>
                </footer>
            </div> -->


        </main>
        <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
    </body>

    </html>