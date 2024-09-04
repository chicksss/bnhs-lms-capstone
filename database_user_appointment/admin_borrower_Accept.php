<?php

 ob_start();
session_start();

include "../dashdesign.php";
 
require_once "user_appointment.php";
require_once "appointment_engine.php";
require_once "../DATABASE/book_catalog_db.php";
require_once "../BOOKS/book_catalog_engine.php";
 

$bookCatalog = new CRUD();
$bookCategory = $bookCatalog->getBookCategories();


  $appointment = new CRUD_appoint();
  
if(isset($_GET['appointment_Id'])){
    $appointment_Id = $_GET['appointment_Id'];
    $getUser = $appointment->user_get_id($appointment_Id);
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $appointment_Id = $_POST['appointment_Id'];
    $status = $_POST['status'];
    $book_id = $_POST['id'];
    $borrowing_date = $_POST['borrowing_date'];

            $val = 2;

            $dateTime = new DateTime($borrowing_date);
            $dateTime->modify("+" . $val . " days");
            $dueDate = $dateTime->format('Y-m-d');

            // Calculate the difference in days
            $currentTimestamp = time(); // Current timestamp
            $dueTimestamp = $dateTime->getTimestamp(); // Timestamp of the due date
            $diffInDays = max(0, floor(($dueTimestamp + $currentTimestamp) / (60 * 60 * 24)));

            
    $deleteAppointmentUser = $appointment->AcceptRequestBook($appointment_Id, $status, $borrowing_date, $dueDate,$book_id); 
    header ("Location: admin_appointment.php");
}

 ob_end_flush();
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

    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<body>

    <div class="ml-52 p-2">
        <div class="absolute mt-[-50px]">
            <h1 class="text-2xl font-bold px-3">ACCEPT BORROWER</h1>
        </div>

        <div class="px-10 grid justify-center">
            <?php if($getUser) { ?>
            <form action="admin_borrower_Accept.php" method="POST">
                <input type="hidden" name="appointment_Id" value="<?php echo $getUser['appointment_Id'] ?>">
                <input type="hidden" name="id" value="<?php echo $getUser['book_number'] ?>">

                <div class="flex gap-10 justify-center">
                    <div class="flex gap-10 justify-center">
                        <div>

                            <div class="flex justify-between py-10 gap-10">
                                <div>
                                    <label for=""> Borrower: </label><br>
                                    <label for=""> Title: </label><br>
                                    <label for=""> Accession Number: </label><br>
                                </div>
                                <div>
                                    <?php echo $getUser['borrower_name'] ?>
                                    <br>
                                    <?php echo $getUser['book_title'] ?>
                                    <br>
                                    <?php echo $getUser['book_call_number'] ?>
                                </div>
                            </div>


                            <select class="form-control" name="status" style="display:none">
                                <option value="Borrowed">Borrowed</option>
                                <option value="Returned">Returned</option>

                            </select>

                            <button type="submit" style="background: #dda15e" class="rounded-lg p-2">Accept</button>

                        </div>
                        <div>
                            <br>


                        </div>

                    </div>

                    <div>
                        <?php 
                                            $t = time();
                                             ?>
                        <div class="input-group">
                            <input class="form-control form-control-sm" type="hidden" name="borrowing_date"
                                placeholder="Date" value="<?php echo(date("Y-m-d",$t)); ?>" />

                        </div>



                        <div class="grid justify-center">
                            <img src="../BOOKS/book/<?php echo $getUser['image']; ?>"
                                title="<?php echo $getUser['image']; ?>"
                                class="h-[450px] w-[350px] rounded-lg shadow-lg py-2">

                        </div>
                    </div>
                </div>




            </form>
            <?php } ?>
        </div>
    </div>


</body>

</html>