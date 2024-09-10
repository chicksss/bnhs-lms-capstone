<?php

require '../DATABASE/book_catalog_db.php';
require_once "../BOOKS/book_catalog_engine.php";


require_once "../database_user_appointment/user_appointment.php";
require_once "../database_user_appointment/appointment_engine.php";

require_once '../END_USER/end_user_db.php';
require_once '../END_USER/end_user_engine.php';


require_once "../AUTHORS/author_db.php";
require_once "../AUTHORS/authors_engine.php";
 

$myAuthors = new authorsBook();




$crud = new CRUD();
$end_user = new END_USERS();

// $appoointment = new APPOINTMENT();

  if (isset($_GET['id'])) {
                $bookId = $_GET['id'];  
                $result = $crud->getBookOverview($bookId);
            }

// if (isset($_GET['table']) && isset($_GET['id']) && isset($_GET['user_id'])) {
//     $selectedTable = $_GET['table'];
//     $bookId = $_GET['id'];
//     $user_id = $_GET['user_id'];

//     $result = $crud->appointmentGetBookId($selectedTable,$bookId,$user_id);
// }


            //USER SIGN UP
if(isset($_POST['signup'])){
    $user_password = $_POST['user_password'];
    $user_fullname = $_POST['user_fullname'];
    $user_address = $_POST['user_address'];
    $user_birth = $_POST['user_birth'];
    $user_contact = $_POST['user_contact'];
    $user_email = $_POST['user_email'];
    $user_gender = $_POST['user_gender'];
    $stmt = $end_user->EndUserRegister($user_password,$user_fullname,$user_address,$user_birth,$user_contact,$user_email,$user_gender);
    if($stmt-> rowCount()>0){
       
        echo "<script> alert('Succesfully Registered'); location.replace('homepage_books.php') </script>";
        // echo"<script>alert('Succesfully Registered')</script>";
    }
    else{
        echo "There is an error in Log in please try again";
    }
    

}


if(isset($_GET['id'])){
    $id = $_GET['id'];
    $aresult = $myAuthors->selectAddBoolAuthors($id);
 

}



//user log in 

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
        // $_SESSION['user_email'] = $LoginSuccess['user_email'];
        $_SESSION['user_id'] = $LoginSuccess['user_id'];
        echo "<script>alert('Successfully Login'); location.replace('homepage_catalog.php')</script>";

       
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
                    class="text-sm text-black dark:text-blue-500 hover:underline">Sign in</a>
            </div>
        </div>
    </nav>

    <nav class="bg-[#e6ccb2] shadow-lg  mt-[58px] w-full fixed">
        <div class="max-w-screen-xl px-4 py-3 mx-auto">
            <div class="flex items-center">
                <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm md:ml-20 md:text-lg">
                    <li>
                        <a href="index.php" class="text-gray-900 dark:text-dark hover:underline"
                            aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="homepage_books.php" class="text-gray-900 dark:text-dark hover:underline">Browse
                            Books</a>
                    </li>
                     
                </ul>
            </div>
        </div>
    </nav>

    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 w-96  z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
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


                <form class="max-w-sm mx-auto  p-5" method="POST" action="homepage_books.php">

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





    <div class="py-28">
        <aside class="fixed w-[450px] h-full" aria-label="Sidebar">

            <div class="ml-[120px] py-10">
                <?php if($result): ?>
                <img src="../BOOKS/book/<?= $result['image']; ?>" title="<?= $result['image']; ?>"
                    class="w-50 h-[300px] ml-5 shadow-lg rounded-lg">
                <?php endif; ?> <br> <br>

                <!-- Button trigger modal -->
                <button type="button" style="background-color: #DDA15E; border-radius: 24px;" class="ml-5 p-2 w-[200px]"
                    data-modal-target="default-modal-to-signin" data-modal-toggle="default-modal-to-signin">
                    Borrow
                </button>
            </div>

        </aside>

        <div id="default-modal-to-signin" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

            <div class="relative p-4 w-50 max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow text-black ">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-black">
                            Sign in
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="default-modal-to-signin">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
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

        <div class="ml-[300px] z-[-1] px-20">
            <?php if($result) {?>
            <div class="py-10">
                <p><?php  echo $result['category'];  ?></p>
                <h1 class="text-3xl font-bold py-2"><?php  echo $result['title'];  ?></h1>
                <?php if ($aresult) : ?>

                <ul class="flex flex-wrap">
                    <p style="">by &nbsp;</p>
                    <?php
                    $aresult = $myAuthors->getBookAuthors($id);
                    foreach ($aresult as $book_A) : ?>
                    <li style="color: blue" class="px-1"><?php echo $book_A['author_name']; ?>,</li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>

                <p class="py-2 text-justify"><?php  echo $result['synopsis'];  ?> </p>
            </div>

            <div>
                <p>This Edition:</p>
                <div class="flex justify-start gap-10 py-3">
                    <div>
                        <b>ISBN:</b> <br>
                        <b>Publisher:</b> <br>
                        <b>Date Published:</b> <br>
                        <b>Total Borrowed:</b> <br>
                    </div>
                    <div>

                        <?php echo $result['book_isbn'] ?><br>

                        <?php echo $result['publisher'] ?><br>
                        <?php echo $result['book_date_published'] ?><br>
                        <?php echo $result['borrow_count'] ?><br>
                    </div>
                </div>
            </div>

            <?php  } ?>
        </div>
    </div>




</body>

</html>