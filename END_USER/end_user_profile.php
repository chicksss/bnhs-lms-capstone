<?php

require_once 'end_user_db.php';

 if(!isset($_SESSION)){
session_start();
} 
 
require_once "../DATABASE/book_catalog_db.php";
require_once "../BOOKS/book_catalog_engine.php";

require_once "../BOOKMARK/bookmark_engine.php";
require_once "../BOOKMARK/bookmark_db.php";

require_once "end_user_db.php";
require_once "end_user_engine.php";
 


 



$crud = new CRUD();

$userbookmark = new BOOKMARK();



$tables = $crud->bookListQuery();

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
        <div class="flex flex-wrap justify-between items-center mx-10 p-4 ">
            <a href="https://flowbite.com" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-1xl font-semibold whitespace-nowrap dark:text-black md:ml-20">BAUTISTA
                    NHS</span>
            </a>

            <a href="../END_USER/end_user_logout.php" class="text-sm text-black dark:text-blue-500 hover:underline ">Log
                out</a>


        </div>
    </nav>

    <nav class="bg-[#e6ccb2] shadow-lg mt-[58px]">
        <div class="max-w-screen-xl px-4 py-3 mx-auto">
            <div class="flex items-center">
                <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm md:ml-20 md:text-lg">
                    <li>
                        <a href="../HOMEPAGE/homepage_catalog.php" class="text-gray-900 dark:text-dark hover:underline"
                            aria-current="page">Home</a>
                    </li>
                    <!-- <li>
                        <a href="user_manual.php" class="text-gray-900 dark:text-dark hover:underline">
                            User Manual</a>
                    </li> -->
                    <li>
                        <a href="../HOMEPAGE/homepage_bookmark.php"
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
                        <a href="../HOMEPAGE/homepage_list_appointment.php"
                            class="text-gray-900 dark:text-dark hover:underline">My
                            Books</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="py-5">
        <div class="px-44 py-10">
            <div class="flex flex-cols-2 justify-between py-4">
                <h1 class="font-['Cedarville-Cursive'] text-3xl">Your Profile</h1> <br>
                <button class="w-25 rounded-lg p-2" style="background-color: #d5bdaf"><a
                        href="end_user_updateProfile.php?user_id=<?php echo $user['user_id']?>"
                        style="text-decoration:none; color:black;">Update
                        profile</a></button>
            </div>

            <div class="w-[1010px] py-[-2]" style="border-bottom:black 4px solid"></div>
        </div>


        <div class="flex grid-cols-2 justify-evenly">
            <div>
                <b>Firstname:</b>
                <p><?php echo $user['user_fullname']; ?></p>
                <br>
                <b>Middlename:</b>
                <p><?php echo $user['user_MiddleName']; ?></p>
                <br>
                <b>Lastname:</b>
                <p><?php echo $user['user_LastName']; ?></p>
            </div>

            <div>
                <b>Address:</b>
                <p><?php echo $user['user_address']; ?></p>
                <br>
                <b>Email:</b>
                <p><?php echo $user['user_email']; ?></p>
                <br>
                <b>Birthday:</b>
                <p><?php echo $user['user_birth']; ?></p>
            </div>

            <div>
                <b>Contact:</b>
                <p><?php echo $user['user_contact']; ?></p>
                <br>
                <b>LRN:</b>
                <p><?php echo $user['user_LRN']; ?></p>
                <br>
                <b>Grade:</b>
                <p><?php echo $user['user_grade']; ?></p>
            </div>

            <div>
                <b>Password:</b>
                <div id="password"><?php echo str_repeat('*', strlen($user['user_password'])); ?></div>

            </div>


        </div>
    </div>






</body>

</html>