<?php
 ob_start();
session_start();

require_once "user_appointment.php";
 include "../dashdesign.php";
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
    $borrowing_date = $_POST['borrowing_date'];
    $status = $_POST['status'];
    $book_id = $_POST['id'];
    $b_id = $_POST['b_id'];
    $return_date = $_POST['return_date'];
    $u_id = $_POST['u_id'];
    $UpdateAppointmentUser = $appointment->UpdatetoReturnBook($appointment_Id, $borrowing_date,$status,$book_id, $b_id, $return_date, $u_id); 
    header ("Location: admin_appointment_penalty.php");
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
            <h1 class="text-2xl font-bold px-3">BORROWERS (Return Book)</h1>
        </div>


        <div>
            <div class="grid justify-start">

                <?php if($getUser) { ?>
                <form action="admin_user_list_delete.php" method="POST">
                    <input type="hidden" name="appointment_Id" value="<?php echo $getUser['appointment_Id'] ?>">
                    <input type="hidden" name="generateId" value="<?php echo $getUser['generateId'] ?>">
                    <input type="hidden" name="id" value="<?php echo $getUser['book_number'] ?>">


                    <div class="flex justify-start gap-10">

                        <div>
                            <img src="../BOOKS/book/<?php echo $getUser['image']; ?>"
                                title="<?php echo $getUser['image']; ?>"
                                class="h-[450px] w-[350px] rounded-lg shadow-lg py-2">
                        </div>

                        <div>
                            <div class="flex justify-between gap-5">
                                <div class="grid">
                                    <b class="font-bold py-1"> Borrower: </b><br>
                                    <b class="font-bold py-1"> Title: </b> <br>
                                    <b class="font-bold py-1"> Book Author: </b> <br>
                                    <b class="font-bold py-1"> Accession Number: </b>

                                </div>

                                <div class="grid">
                                    <p class="py-1"><?php echo $getUser['borrower_name'] ?></p>
                                    <p class="py-1"> <?php echo $getUser['book_title'] ?></p>
                                    <p class="py-1"><?php echo $getUser['author_name'] ?></p>
                                    <p class="py-1"> <?php echo $getUser['book_call_number'] ?></p>
                                    <br>
                                    <input type="hidden" name="status" value="Returned">
                                    <input type="hidden" class="form-control" name="borrowing_date"
                                        value="<?php echo $getUser['borrowing_date'] ?>" required>
                                    <input type="hidden" name="b_id" value="<?php echo $getUser['book_number'] ?>">
                                    <input type="hidden" name="u_id" value="<?php echo $getUser['user_id'] ?>">
                                    <input type="hidden" class="form-control" name="return_date"
                                        value="<?php echo $getUser['borrowing_date'] ?>" required>
                                    <br>
                                </div>

                            </div>
                        </div>


                    </div>
                    <div class="py-3">
                        <button type="submit" class="rounded-lg p-2" style="background: #dda15e">Return</button>
                    </div>



                </form>
                <?php } ?>
            </div>

        </div>

    </div>

</body>

</html>