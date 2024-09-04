<?php

 ob_start();
session_start();

include "../dashdesign.php";
require_once "user_appointment.php";
require_once "appointment_engine.php";
require_once "../DATABASE/book_catalog_db.php";
require_once "../BOOKS/book_catalog_engine.php";

$bookCatalog = new CRUD();
$crud = new CRUD();
$bookCategory = $bookCatalog->getBookCategories();
$appointment = new CRUD_appoint();
        
if(isset($_GET['appointment_Id'])){
    $appointment_Id = $_GET['appointment_Id'];
    $getUser = $appointment->user_get_id($appointment_Id);
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $appointment_Id = $_POST['appointment_Id'];
    $book_id = $_POST['id'];
    $status = $_POST['status'];
    $deleteAppointmentUser = $appointment->DeclineRequestBook($appointment_Id,$book_id); 
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
            <h1 class="text-2xl font-bold px-3">BORROWER (Decline)</h1>
        </div>

        <div class="grid justify-center text-center">
            <h1 class="text-1xl font-bold">Decline Borrower?</h1>
            <?php if($getUser) { ?>
            <form action="admin_borrower_Decline.php" method="POST">
                <input type="hidden" name="appointment_Id" value="<?php echo $getUser['appointment_Id'] ?>">
                <input type="hidden" name="id" value="<?php echo $getUser['book_number'] ?>">

                <!-- <label for="Status" style="color:black">Status</label> -->
                <select class="form-control" name="status" style="display:none">
                    <option value="Decline">Decline</option>
                </select>
                <br>


                <button type="submit" style="background: #dda15e" class="rounded-lg p-2">Decline</button>
            </form>


            <?php } ?>

        </div>


    </div>

</body>

</html>