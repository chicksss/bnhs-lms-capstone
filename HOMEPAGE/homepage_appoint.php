<?php

require '../DATABASE/book_catalog_db.php';
require_once "../BOOKS/book_catalog_engine.php";


require_once "../database_user_appointment/user_appointment.php";
require_once "../database_user_appointment/appointment_engine.php";
require_once "../AUTHORS/author_db.php";
require_once "../AUTHORS/authors_engine.php";
 

$myAuthors = new authorsBook();


session_start();
$crud = new CRUD();
// $appoointment = new APPOINTMENT();

  if (isset($_GET['table']) && isset($_GET['id']) && isset($_GET['user_id'])) {
                $selectedTable = $_GET['table'];
                $bookId = $_GET['id'];
                $user_id = $_GET['user_id'];
                $result = $crud->appointmentGetBookId($selectedTable,$bookId,$user_id);
            }

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $aresult = $myAuthors->selectAddBoolAuthors($id);
 

}





if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $borrowingDate = $_POST['borrowing_date'];
    $maxDailyAppointments = 10000;
    $currentTime = time();  
    $startDay = strtotime('today', $currentTime);

    if ($currentTime >= $startDay) {
      
        $AppointmentCount = $crud->BorrowDate($borrowingDate);
        
        if ($AppointmentCount >= $maxDailyAppointments) {
            echo "<script> alert('Sorry, the daily appointment limit has been reached.'); location.replace('homepage_catalog.php') </script>";
        } 

        
        else {
            // Proceed with the code for handling the appointment booking
              // Calculate the target time for the appointment (3 days from the borrowing date)
          
            
            $generateId = $_POST['generateId'];
            $book_number = $_POST['id'];
            $status = $_POST['status'];
            $borrowerName = $_POST['borrower_name'];
            $borrowingDate = $_POST['borrowing_date'];
            $book_title = $_POST['book_title'];
            $book_author = $_POST['author_name'];
            $borrower_address = $_POST['borrower_address'];
            $borrower_contact = $_POST['borrower_contact'];
            $borrower_email = $_POST['borrower_email'];
            $user_id = $_POST['user_id'];
            $book_call_number = $_POST['book_call_number'];
            

            // $borrowingDateTimestamp = strtotime($borrowingDate);
            // $targetTime = strtotime('+3 days', $borrowingDateTimestamp);
            // $currentTime = time();

            // // Calculate the difference in seconds
            // $difference = $targetTime - $currentTime;

            // // Calculate days, hours, minutes, and seconds
            // $days = floor($difference / (24 * 3600));
           

            // echo "<h3>Appointment Details:</h3>";
            // echo "Appointment Date: " . date('Y-m-d', $borrowingDateTimestamp) . "<br>";
            // echo "Countdown to Appointment: $days days";

            
            // $val = 30;

            // $dateTime = new DateTime($borrowingDate);
            // $dateTime->modify("+" . ($val) . " days");
            // $days = $dateTime->format('Y-m-d');

            // // Calculate the difference in days and divide by 2
            // $diffInDays = max(0, floor((strtotime($days) + strtotime($borrowingDate)) / (60 * 60 * 24)));


            $val = 30;

            $dateTime = new DateTime($borrowingDate);
            $dateTime->modify("+" . $val . " days");
            $dueDate = $dateTime->format('Y-m-d');

            // Calculate the difference in days
            $currentTimestamp = time(); // Current timestamp
            $dueTimestamp = $dateTime->getTimestamp(); // Timestamp of the due date
            $diffInDays = max(0, floor(($dueTimestamp + $currentTimestamp) / (60 * 60 * 24)));


echo '<style>
.card-book-titles {
    padding: 20px;
    background-color: #00457c;
    width: 100%;
    margin-top: 1px;
    z-index: 2;
    color: white;
}

.containers {
    text-align: center;
    font-family: "Arial";
}
.btn{
    background-color: #00457c;
    text-align: center;
}
</style>';

            // echo "Original Date: $borrowingDate<br>";
            // echo "Date after subtraction of half of $val days: $diffInDays";
        echo '<div class="containers card-book-titles">
             <h1>SUCCESSFULLY BORROWED </h1>
           
        </div>
        <div class="containers">
            <button class="btn btn-primary">
                <a style="text-decoration: none; color: white" href="homepage_catalog.php">Back</a>
            </button>
        </div>';
       


            
           
           

            // Increment the borrow count for the book
            // $stmt = $pdo->prepare("UPDATE $selectedTable SET total_borrow_count = total_borrow_count + 1 WHERE id = ?");
            // $stmt->execute([$bookId]);
            $stmt = $crud->CountOfBook($book_number, $selectedTable);


            $stmt = $crud->AddTotal_borrow_count($book_number, $total_borrow_count);

           // $stmt = $crud->deleteCallNumber($book_number,$selectedTable);

            // $stmt = $pdo->prepare("UPDATE $selectedTable SET status = ? WHERE id = ?");
            // $stmt->execute([$status, $bookId]);

          //  $stmt = $crud->BookStatusSet($status,$book_number);

            
           //$stmt = $crud->expirationAppointment($days);

            // Update the count in the borrowings table based on borrowing date
            // $stmt = $pdo->prepare("UPDATE appointments.borrowings SET count = count + 1 WHERE borrowing_date = ?");
            // $stmt->execute([$borrowingDate]);
            $stmt = $crud->UpdateCountBorrowings($borrowingDate);
          

            // Insert the borrowing record into the borrowings table
            // $stmt = $pdo->prepare("INSERT INTO appointments.borrowings (generateId, book_id, borrower_name, borrowing_date, book_title, book_author, borrower_address, borrower_contact, borrower_email, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            // $stmt->execute([$generateId, $bookId, $borrowerName, $borrowingDate, $book_title, $book_author, $borrower_address, $borrower_contact, $borrower_email, $status]);
            $stmt = $crud->InsertRecord($generateId, $book_number, $borrowerName, $borrowingDate, $book_title, $book_author, $borrower_address, $borrower_contact, $borrower_email, $status,$user_id,$dueDate,$book_call_number);

            
            // Redirect to the book catalog page
            //header("Location: homepage_appoinment_receipt.php?book_number=$book_number&borrower_name=$borrowerName&generateId=$generateId&borrowing_date=$borrowingDate&book_title=$book_title&book_author=$book_author&borrower_address=$borrower_address&borrower_contact=$borrower_contact&borrower_email=$borrower_email&status=$status&user_id=$user_id&appointmentDate=$days");
            echo "<script>
            window.location.href = 'homepage_appoinment_receipt.php?book_number=$book_number&borrower_name=$borrowerName&generateId=$generateId&borrowing_date=$borrowingDate&book_title=$book_title&book_author=$book_author&borrower_address=$borrower_address&borrower_contact=$borrower_contact&borrower_email=$borrower_email&status=$status&user_id=$user_id&appointmentDate=$dueDate&book_call_number=$book_call_number';
            window.close(); // This will close the current page
        </script>";
           exit();
        }
    }
}



    $randomNumber = rand(1,100);
    $generateId = bin2hex($randomNumber);

                
// Close the database connection
$pdo = null;
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
                <a href="../END_USER/end_user_logout.php" data-modal-target="default-modal"
                    data-modal-toggle="default-modal" class="text-sm text-black dark:text-blue-500 hover:underline">Log
                    out</a>
            </div>
        </div>
    </nav>

    <nav class="bg-[#e6ccb2] shadow-lg mt-[58px] fixed w-full">
        <div class="max-w-screen-xl px-4 py-3 mx-auto">
            <div class="flex items-center">
                <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm md:ml-20 md:text-lg">
                    <li>
                        <a href="index.php" class="text-gray-900 dark:text-dark hover:underline"
                            aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="homepage_books.php" class="text-gray-900 dark:text-dark hover:underline">
                            User Manual</a>
                    </li>
                    <li>
                        <a href="homepage_bookmark.php"
                            class="text-gray-900 dark:text-dark hover:underline">Bookmark</a>
                    </li>

                    <li>
                        <a href="#" class="text-gray-900 dark:text-dark hover:underline">Profile</a>
                    </li>

                    <li>
                        <a href="#" class="text-gray-900 dark:text-dark hover:underline">My Books</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="py-28">
        <aside class="fixed w-[450px] h-full" aria-label="Sidebar">

            <div class="ml-[120px] py-10">

                <?php if($result): ?>
                <img src="../BOOKS/book/<?= $result['image']; ?>" title="<?= $result['image']; ?>"
                    class="w-50 h-[300px] ml-5 shadow-lg rounded-lg">
                <?php endif; ?> <br> <br>

                <?php if (isset($_GET['id'])){ ?>
                <?php $bookDetails = $crud->getBookDetails($_GET['id']); ?>

                <?php foreach ($bookDetails as $book){ ?>

                <?php if($book['statusPerCopy'] == 'Available'){ ?>
                <button style="background-color: #DDA15E; border-radius: 24px;" class="ml-5 p-2 w-[200px]">
                    <a style="color: black; text-decoration:none; font-size:16px"
                        href="homepageBorrow.php?table=<?php echo $selectedTable; ?>&id=<?php echo $book['id']; ?>&user_id=<?php echo $user_id; ?>&book_ID=<?php echo $book['book_ID'];?>&copy_id=<?php echo $book['id'];?>">
                        Borrow
                    </a>
                </button>
                <?php } else { ?>
                <b class="text-black mt-5">Out of stock</b>

                <?php } ?>

                <?php } ?>

                <?php }   ?>
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

                        <b>Available Copies:</b> <br>
                    </div>
                    <div>

                        <?php echo $result['book_isbn'] ?><br>

                        <?php echo $result['publisher'] ?><br>
                        <?php echo $result['book_date_published'] ?><br>
                        <?php echo $result['borrow_count'] ?><br>

                    </div>

                </div>

            </div>

            <div>
                <p class="py-2">Accession Number:</p>
                <div class="flex justify-start gap-20">
                    <?php if (isset($_GET['id'])){ ?>
                    <?php $bookDetails = $crud->getBookDetails($_GET['id']); ?>

                    <?php foreach ($bookDetails as $book): ?>

                    <!-- <p style="color:green">Available</p> -->

                    <?php echo $book['book_call_number']; ?>

                    <?php 
                            endforeach; ?>
                    <?php 
                        $getAllAvailableCopies = $crud->getAlAvaialble($_GET['id']);
                            // echo $getAllAvailableCopies;
                            }
                            ?>

                    <p style="color: green">There are <?php echo $getAllAvailableCopies ?> Available Copies</p>
                </div>


            </div>

            <?php  } ?>
        </div>
    </div>

</body>

</html>