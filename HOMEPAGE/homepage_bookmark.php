<?php

require "../END_USER/end_user_db.php";
require "../END_USER/end_user_engine.php";

require "../DATABASE/book_catalog_db.php";
require "../BOOKS/book_catalog_engine.php";

require_once "../BOOKMARK/bookmark_engine.php";
require_once "../BOOKMARK/bookmark_db.php";


session_start();


$crud = new CRUD();

// $tables = [];
// $sql = "SHOW TABLES";
// $stmt = $pdo->query($sql);
// $book_table_name = $stmt->fetchAll(PDO::FETCH_COLUMN);
$book_table_name = $crud->bookListQuery();

$userbookmark = new BOOKMARK();



 $end_users = new END_USERS();
                    if(isset($_SESSION['user_id'])){
                        $user_id = $_SESSION['user_id'];
                        $user = $end_users->UserSessioninBook($user_id);
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
            <div class="flex items-center space-x-6 rtl:space-x-reverse">
                <a href="#" data-modal-target="default-modal" data-modal-toggle="default-modal"
                    class="text-sm text-black dark:text-blue-500 hover:underline">Log out</a>
            </div>
        </div>
    </nav>

    <nav class="bg-[#e6ccb2] shadow-lg mt-[58px]">
        <div class="max-w-screen-xl px-4 py-3 mx-auto">
            <div class="flex items-center">
                <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm md:ml-20 md:text-lg">
                    <li>
                        <a href="homepage_catalog.php" class="text-gray-900 dark:text-dark hover:underline"
                            aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="user_manual.php" class="text-gray-900 dark:text-dark hover:underline">
                            User Manual</a>
                    </li>
                    <li>
                        <a href="homepage_bookmark.php"
                            class="text-gray-900 dark:text-dark hover:underline">Bookmark</a>
                    </li>

                    <li>
                        <a href="../END_USER/end_user_profile.php"
                            class="text-gray-900 dark:text-dark hover:underline">Profile</a>
                    </li>

                    <li>
                        <a href="homepage_list_appointment.php" class="text-gray-900 dark:text-dark hover:underline">My
                            Books</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div>

        <div class="flex grid-cols-2 justify-between px-32 items-center py-10">
            <h1 class="text-3xl text-center md:text-3xl font-['Cedarville-Cursive']">
                Bookmark
            </h1>
        </div>

        <div class="flex flex-wrap justify-center gap-5 py-10 px-20  ">
            <?php 
            $bookmark = $userbookmark->getAllBookmark($user_id);
            ?>
            <?php  foreach($bookmark as $book){ ?>
            <div>

                <?php  
                        $book_table_name = $book['table_name'];
                        $book_id = $book['book_id'];
                        
                        
                        $bookCategory = $crud->getSelectedBook($book_table_name,$book_id);
                        if($bookCategory){
                        ?>
                <div class="relative flex-none">
                    <img src="../BOOKS/book/<?php echo $bookCategory['image']; ?>"
                        title="<?php echo $bookCategory['image']; ?>"
                        class="h-[300px] w-52 shadow-xl transition-transform duration-300 ease-in-out transform hover:scale-105"
                        style="">


                    <div
                        class="grid p-2 absolute inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 text-white opacity-0 transition-opacity duration-300 ease-in-out hover:opacity-100">

                        <button type="button">
                            <a href="../BOOKMARK/bookmark_delete.php?bookmark_id=<?php echo $book['bookmark_id']; ?>">
                                Delete</a>
                        </button>
                    </div>

                </div>
                <?php } ?>




            </div>
            <?php  } ?>




        </div>
    </div>





    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
</body>

</html>