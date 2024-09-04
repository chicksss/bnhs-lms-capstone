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
    if (isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $user_fullname = $_POST['user_fullname'];
    $user_LRN = $_POST['user_LRN'];
    $user_MiddleName = $_POST['user_MiddleName'];
    $user_LastName = $_POST['user_LastName'];
    $user_email = $_POST['user_email'];
    $user_address = $_POST['user_address'];
    $user_birth = $_POST['user_birth'];
    $user_contact = $_POST['user_contact'];
    $user_gender = $_POST['user_gender'];
    $user_grade = $_POST['user_grade'];
    $user_password = $_POST['user_password'];

    $user = $end_users->updateUserProfile($user_id, $user_LRN, $user_fullname, $user_MiddleName, $user_LastName, $user_email,$user_address,$user_birth,$user_contact,$user_gender,$user_grade);
    header ("Location: end_user_profile.php");
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
                    <li>
                        <a href="user_manual.php" class="text-gray-900 dark:text-dark hover:underline">
                            User Manual</a>
                    </li>
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
                        <a href="#" class="text-gray-900 dark:text-dark hover:underline">My Books</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="px-44 py-10">
        <div class="flex flex-cols-2 justify-between py-4">
            <h1 class="font-['Cedarville-Cursive'] text-3xl">Update Profile</h1> <br>

        </div>

        <div class="w-[1010px] py-[-2]" style="border-bottom:black 4px solid"></div>
    </div>

    <div>
        <div class="flex grid-cols-2 justify-start mx-44 gap-10">
            <div>
                <form action="end_user_updateProfile.php" method="POST">
                    <?php if(isset($user)) { ?>

                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <div class="mb-5">
                        <label for="text" class="block mb-2 text-sm font-medium  dark:text-black">Firstname:</label>
                        <input type="text" id="user_fullname" name="user_fullname"
                            value="<?php echo $user['user_fullname'] ?>"
                            class="border text-sm rounded-lg  block w-full p-2.5 dark:text-black"
                            placeholder="Firstname" />
                    </div>

                    <div class="mb-5">
                        <label for="email" class="block mb-2 text-sm font-medium dark:text-black">
                            Middlename:</label>
                        <input type="text" id="email" name="user_MiddleName"
                            value="<?php echo $user['user_MiddleName'] ?>"
                            class=" border text-sm rounded-lg  block w-full p-2.5  dark:text-black  "
                            placeholder="Middlename" />
                    </div>

                    <div class="mb-5">
                        <label for="email" class="block mb-2 text-sm font-medium  dark:text-black">Lastname
                        </label>
                        <input type="text" id="email" name="user_LastName" value="<?php echo $user['user_LastName'] ?>"
                            class=" border text-sm rounded-lg  block w-full p-2.5  dark:text-black  "
                            placeholder="Lastname" />
                    </div>


            </div>

            <div>

                <div class="mb-5">
                    <label for="email" class="block mb-2 text-sm font-medium dark:text-black">Email:</label>
                    <input type="email" id="email" name="user_email" value="<?php echo $user['user_email'] ?>"
                        class=" border text-sm rounded-lg  block w-full p-2.5 text-black" placeholder="Email" />
                </div>

                <div class="mb-5">
                    <label for="text" class="block mb-2 text-sm font-medium dark:text-black">
                        Address:</label>
                    <input type="text" id="email" name="user_address" value="<?php echo $user['user_address'] ?>"
                        class=" border text-sm rounded-lg  block w-full p-2.5 dark:text-black"
                        placeholder="Middlename" />
                </div>

                <div class="mb-5">
                    <label for="email" class="block mb-2 text-sm font-medium  dark:text-black">Birthday
                    </label>
                    <input type="date" id="email" name="user_birth" value="<?php echo $user['user_birth'] ?>"
                        class=" border text-sm rounded-lg  block w-full p-2.5  dark:text-black" placeholder="" />
                </div>

            </div>


            <div>

                <div class="mb-5">
                    <label for="email" class="block mb-2 text-sm font-medium dark:text-black">Contact:</label>
                    <input type="number" id="email" name="user_contact" value="<?php echo $user['user_contact'] ?>"
                        class=" border text-sm rounded-lg  block w-full p-2.5 text-black" placeholder="Contact" />
                </div>

                <div class="mb-5">
                    <label for="text" class="block mb-2 text-sm font-medium dark:text-black">
                        Gender:</label>
                    <select class="rounded-lg p-2 w-full" name="user_gender" aria-label="Default select example"
                        required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>

                    </select>
                </div>

                <div class="mb-5">
                    <label for="LRN" class="block mb-2 text-sm font-medium  dark:text-black">LRN:
                    </label>
                    <input type="number" id="email" name="user_LRN" value="<?php echo $user['user_LRN'] ?>"
                        class="border text-sm rounded-lg  block w-full p-2.5 dark:text-black" placeholder="LRN" />
                </div>

            </div>

            <div>

                <div class="mb-5">
                    <label for="email" class="block mb-2 text-sm font-medium dark:text-black">Grade Level:</label>
                    <input type="number" id="email" name="user_grade" value="<?php echo $user['user_grade'] ?>"
                        class=" border text-sm rounded-lg  block w-full p-2.5 text-black" placeholder="Grade Level" />
                </div>

                <div class="mb-5">
                    <label for="text" class="block mb-2 text-sm font-medium dark:text-black">
                        Password:</label>
                    <input type="password" id="email" name="user_password" value="<?php echo $user['user_password'] ?>"
                        class=" border text-sm rounded-lg  block w-full p-2.5 dark:text-black"
                        placeholder="Passoword" />
                </div>


            </div>


        </div>

        <div class="ml-44">
            <button type="submit" name="update" class="bg-[#d5bdaf] text-black p-2 rounded-lg">Update</button>
        </div>

        <?php } ?>
        </form>

    </div>


</body>

</html>