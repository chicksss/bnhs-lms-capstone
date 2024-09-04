<?php
require '../DATABASE/book_catalog_db.php';
require '../database_user_appointment/user_appointment.php';
require '../BOOKS/book_catalog_engine.php';
require('tcpdf/tcpdf.php');

session_start();
$crud = new CRUD();

if (isset($_GET['table']) && isset($_GET['id'])) {
    $selectedTable = $_GET['table'];
    $bookId = $_GET['id'];
    $result = $crud->appointmentGetBookId($selectedTable, $bookId);
}

// Assuming $_GET['generateId'] should be echoed
$generateId = isset($_GET['generateId']) ? $_GET['generateId'] : '';
$borrower_name = isset($_GET['borrower_name']) ? $_GET['borrower_name'] : '';
$appointmentDate = isset($_GET['appointmentDate']) ? $_GET['appointmentDate'] : '';
$borrower_address = isset($_GET['borrower_address']) ? $_GET['borrower_address'] : '';
 
$borrower_email = isset($_GET['borrower_email']) ? $_GET['borrower_email'] : '';
$borrowing_date = isset($_GET['borrowing_date']) ? $_GET['borrowing_date'] : '';
$book_title = isset($_GET['book_title']) ? $_GET['book_title'] : '';
 
$dueDate = isset($_GET['appointmentDate']) ? $_GET['appointmentDate'] : '';



$status = isset($_GET['status']) ? $_GET['status'] : '';
$book_call_number = isset($_GET['book_call_number']) ? $_GET['book_call_number'] : '';



// Define the path to your background image
$backgroundImagePath = '../images/lis.jpg';

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', true);
$pdf->SetTitle('Borrower Slip');
$pdf->AddPage();

// Set the background image as a watermark
$pdf->Image($backgroundImagePath, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);


$pdf->SetFont('helvetica', '', 12);

$html = "
<!DOCTYPE html>
<html lang=\"en\">
  <head>
    <meta charset=\"UTF-8\" />
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\" />
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />
    
    <link
      href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css\"
      rel=\"stylesheet\"
      integrity=\"sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC\"
      crossorigin=\"anonymous\"
    />
    <title>Document</title>
  </head>
  <style>
    .title {
      text-align: center;
    }
    .line {
      margin-top: -2px;
      width:100%;
    }
    .info {
      margin: auto;
      width: 70%;
    }
    .header {
      background-color: gray;
      color: white;
      padding: 10px;
    }
  </style>
  <body>
    <div class=\"container\">
      <div class=\"title\">
        
        <b>BAUTISTA NATIONAL HIGH SCHOOL</b>
        <p>Poblacion East , Bautista, Philippines</p>
      </div>
      <div class=\"info\">
        <b>BORROWER ID </b> $generateId
        <div class=\"row\">
          <div class=\"col\">
            <div class=\"header\">
              <b>Personal Information</b>
            </div>
            <label for=\"\">Fullname</label> <br />
            <b>$borrower_name</b>
            <hr class=\"line\" size=\"5\" width=\"100%\" color=\"black\" />
            
             <label for=\"\">Address</label> <br />
            <b>$borrower_address</b>
            <hr class=\"line\" size=\"5\" width=\"100%\" color=\"black\" />

            

             <label for=\"\">Email</label> <br />
            <b>$borrower_email</b>
            <hr class=\"line\" size=\"5\" width=\"100%\" color=\"black\" />

              <label for=\"\">Date</label> <br />
            <b>$borrowing_date</b>
            <hr class=\"line\" size=\"5\" width=\"100%\" color=\"black\" />

              <label for=\"\">Date Return</label> <br />
            <b>$dueDate</b>
            <hr class=\"line\" size=\"5\" width=\"100%\" color=\"black\" />

          
          </div>
       

          <div class=\"col\">
            <div class=\"header\">
              <b>Book you borrowed</b>
            </div>
             <label for=\"\">Book Title</label> <br />
            <b>$book_title</b>
            <hr class=\"line\" size=\"5\" width=\"100%\" color=\"black\" />
              <label for=\"\">Accession Number</label> <br />
            <b>$book_call_number</b>
            <hr class=\"line\" size=\"5\" width=\"100%\" color=\"black\" />

             <label for=\"\">Book Status</label> <br />
            <b>Borrowed</b>
            <hr class=\"line\" size=\"5\" width=\"100%\" color=\"black\" />
        </div>
      </div>
    </div>
  </body>
</html>
";

$pdf->writeHTML($html);

// Output the PDF as a download
$pdf->Output($generateId . $borrowing_date . $borrower_address. $borrower_email . $borrower_name .$book_call_number .  '-receipt.pdf', 'D');