<?php
 session_start();
require '../DATABASE/book_catalog_db.php';
require_once "../BOOKS/book_catalog_engine.php";


require_once "../database_user_appointment/user_appointment.php";
require_once "../database_user_appointment/appointment_engine.php";



$crud = new CRUD();
// $appoointment = new APPOINTMENT();


if (isset($_GET['table']) && isset($_GET['id']) && isset($_GET['user_id'])&& isset($_GET['id'])) {
    $selectedTable = $_GET['table'];
    $bookId = $_GET['id'];
    $user_id = $_GET['user_id'];
    $copy_id = $_GET['id'];
    $result = $crud->getBorrowId($bookId,$user_id,$selectedTable,$copy_id);
}


 


// if (isset($_GET['table']) && isset($_GET['id']) && isset($_GET['user_id'])) {
//     $selectedTable = $_GET['table'];
//     $bookId = $_GET['id'];
//     $user_id = $_GET['user_id'];

//     $result = $crud->appointmentGetBookId($selectedTable,$bookId,$user_id);
// }



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $borrowingDate = $_POST['borrowing_date'];
    $maxDailyAppointments = 1000;
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
            $book_number = $_POST['book_id'];
            $book_Id = $_POST['book_Id'];
            
            $status = $_POST['status'];
            $borrowerName = $_POST['borrower_name'];
            $borrowingDate = $_POST['borrowing_date'];
            $book_title = $_POST['book_title'];
            $book_author = $_POST['author_name'];
            $borrower_address = $_POST['borrower_address'];
            
            $borrower_email = $_POST['borrower_email'];
            $user_id = $_POST['user_id'];
            $book_call_number = $_POST['book_call_number'];

            $category_id = $_POST['category_id'];

            $copy_id = $_POST['copy_id'];
            
 
            $val = 1;

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
    background-color: #dda15e;
    width: 100%;
    margin-top: 1px;
    z-index: 2;
    color: black;
}

.containers {
    text-align: center;
    font-family: "Arial";
}
.btn{
    background-color: #dda15e;
    text-align: center;
}
</style>';

            // echo "Original Date: $borrowingDate<br>";
            // echo "Date after subtraction of half of $val days: $diffInDays";
        echo '<div class="containers card-book-titles">
             <h1>SUCCESSFULLY BORROWED </h1>
           
        </div>
        <div class="containers">
            <button class="btn btn-primary" style="padding:10px; ">
                <a style="text-decoration: none;  color: black" href="homepage_catalog.php">Back</a>
            </button>
        </div>';
       


            
           
           

            // Increment the borrow count for the book
            // $stmt = $pdo->prepare("UPDATE $selectedTable SET total_borrow_count = total_borrow_count + 1 WHERE id = ?");
            // $stmt->execute([$bookId]);
            $stmt = $crud->CountOfBook($book_number,$selectedTable);

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
            $stmt = $crud->InsertRecord($generateId, $book_number, $borrowerName, $borrowingDate, $book_title, $book_author, $borrower_address, $borrower_email, $status,$user_id,$dueDate,$book_call_number, $category_id,$book_Id,$copy_id);

            
            // Redirect to the book catalog page
            //header("Location: homepage_appoinment_receipt.php?book_number=$book_number&borrower_name=$borrowerName&generateId=$generateId&borrowing_date=$borrowingDate&book_title=$book_title&book_author=$book_author&borrower_address=$borrower_address&borrower_contact=$borrower_contact&borrower_email=$borrower_email&status=$status&user_id=$user_id&appointmentDate=$days");
            echo "<script>
            window.location.href = 'homepage_appoinment_receipt.php?book_number=$book_number&borrower_name=$borrowerName&generateId=$generateId&borrowing_date=$borrowingDate&book_title=$book_title&book_author=$book_author&borrower_address=$borrower_address&borrower_email=$borrower_email&status=$status&user_id=$user_id&appointmentDate=$dueDate&book_call_number=$book_call_number&category_id=$category_id&book_Id=$book_Id&copy_id=$copy_id';
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- font -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="../NAVIGATION/my.css" />


    <!-- html icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <!-- font awesome -->

    <script src="https://kit.fontawesome.com/6122121193.js" crossorigin="anonymous"></script>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />



    <!-- MODAL -->

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <title>BORROW</title>
</head>

<style>
.card-book-title {
    padding: 20px;
    background-color: #00457c;
    width: 100%;
    margin-top: 1px;
    z-index: 2;
}


.card-book-titles {
    padding: 20px;
    background-color: #00457c;
    width: 100%;
    margin-top: 1px;
    z-index: 2;
    color: white;
}



.card {
    width: 100%;
    border: none;
    border-radius: 20px;
    font-weight: 100px;
}

label.radio {
    cursor: pointer;
    width: 100%;
}

label.radio input {
    position: absolute;
    top: 0;
    left: 0;
    visibility: hidden;
    pointer-events: none;
}

label.radio span {
    padding: 7px 14px;
    border: 2px solid #eee;
    display: inline-block;
    color: #039be5;
    border-radius: 10px;
    width: 100%;
    height: 48px;
    line-height: 27px;
}

label.radio input:checked+span {
    border-color: #039be5;
    background-color: #81d4fa;
    color: #fff;
    border-radius: 9px;
    height: 48px;
    line-height: 27px;
}

.form-control {
    margin-top: 10px;
    height: 48px;
    border: 2px solid #eee;
    border-radius: 10px;
}

.form-control:focus {
    box-shadow: none;
    border: 2px solid #039be5;
}

.agree-text {
    font-size: 12px;
}

.terms {
    font-size: 12px;
    text-decoration: none;
    color: #039be5;
}

.confirm-button {
    height: 50px;
    border-radius: 10px;
}

.menubtn {
    z-index: 10;
}

.row {
    margin-bottom: 10px;
}

label {
    font-weight: bold;
}


/* dropdodwn in user */

.dropbtn {
    background-color: #00447c00;
    color: white;


    border: none;
    cursor: pointer;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: white;
    min-width: 200px;

    z-index: 1;
    margin-top: -30px;
    margin-left: -80px;

}

.dropdown-content a {
    color: black;
    margin-top: -1px;
    text-decoration: none;

}

.dropdown:hover .dropdown-content {
    display: block;
}

.dropdown:hover .dropbtn {
    background-color: #00447c00;
}

body {
    background-color: rgba(180, 180, 180, 0.37);
}

.img-book {
    height: 300px;
    width: 200px;


}
</style>

<body class="bg-[#f5ebe0]">







    <br><br>
    <div class="w3-container">

        <div class="col">
            <br>
            <br>
            <?php if ($result) { ?>
            <form action="?table=<?php echo $selectedTable; ?>&id=<?php echo $bookId; ?>&user_id=<?php echo $user_id ?>"
                method="POST">

                <input type="hidden" name="book_Id" value="<?php echo $result['id'] ?>">
                <input type="hidden" name="book_id" value="<?php echo $bookId ?>">

                <input type="hidden" name="copy_id" value="<?php echo $copy_id; ?>">

                <input class="form-control form-control-sm" type="hidden" name="user_id" placeholder="ID"
                    value="<?php echo $user_id ?>" />

                <div class="container" style=" text-align: center; margin:auto">

                    <img src="../BOOKS/book/<?= $result['image']; ?>" title="<?= $result['image']; ?>" class="img-book">
                    <h5>Borrow this book?</h5>
                    <input type="hidden" name="category_id" value="<?php echo $selectedTable; ?>" id="">
                    <!-- <input class="form-control form-control-sm" type="hidden" name="generateId" id="generateId"
                        value="<?php echo $_SESSION['user_LRN']; ?>" /> -->
                    <input type="hidden" name="generateId" id="generateId"
                        value="<?php echo isset($_SESSION['user_LRN']) ? $_SESSION['user_LRN'] : ''; ?>" />

                    <input class="form-control form-control-sm" type="hidden" placeholder="Name" name="borrower_name"
                        value="<?php echo $_SESSION['user_fullname']; ?>" />
                    <input class="form-control form-control-sm" type="hidden" name="borrower_email"
                        placeholder="johndoe@example.com" value="<?php echo $_SESSION['userLogin'];?>" />


                    <input class="form-control form-control-sm" type="hidden" name="borrower_address"
                        placeholder="Address" value="<?php echo $_SESSION['user_address']; ?>" />





                    <?php 
                                            $t = time();
                                             ?>

                    <input class="form-control form-control-sm" type="hidden" name="borrowing_date" placeholder="Date"
                        value="<?php echo(date("Y-m-d",$t)); ?>" />


                    <input class="form-control form-control-sm" type="hidden" placeholder="Book" name="book_title"
                        value="<?php echo htmlspecialchars($result['title'], ENT_QUOTES, 'UTF-8'); ?>" />




                    <input class="form-control form-control-sm" type="hidden" placeholder="Book" name="author_name"
                        value="<?php echo $result['author_name'] ?>" />


                    <input class="form-control form-control-sm" type="hidden" placeholder="Book" name="book_call_number"
                        value="<?php echo $result['book_call_number'] ?>" />



                    <input type="hidden" name="status" value="Available">






                    <button type="submit" class="btn" style="background-color:#dda15e; color:black; border-radius: 5%">
                        Borrow
                    </button>
                </div>









            </form>
            <?php  } ?>
        </div>
    </div>








</body>


</html>