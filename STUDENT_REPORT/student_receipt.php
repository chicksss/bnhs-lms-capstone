<?php
require '../DATABASE/book_catalog_db.php';
require_once "../database_user_appointment/appointment_engine.php";
require_once "../database_user_appointment/user_appointment.php";
require '../BOOKS/book_catalog_engine.php';
require 'tcpdf/tcpdf.php';

session_start();
$end_users = new END_USERS();

// Fetch data for the specific book
$result = $end_users->getAllUser();

// Create PDF
$pdf = new TCPDF();
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();

$html = "
    <!DOCTYPE html>
    <html lang=\"en\">
    <head>
        <!-- <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN\" crossorigin=\"anonymous\"> -->
        <style>
            .field {
                /* Add your styling for the field class here */
            }
            .header {
                text-align: center;
                font-weight: bold;
            }
            .address {
                text-align: center;    
            }
        </style>
    </head>
    <body>
        <div class=\"row\">
            <p class=\"header\">BAUTISTA NATIONAL HIGH SCHOOL</p>
            <p class=\"address\">Poblacion East, Bautista, Philippines</p>
            
            <p class=\"header\">Students Report</p>
            <p> <b>Librarian:</b> "  . $_SESSION['fullname_admin'] . "</p>
            <p> <b>Date of Report:</b>" . date("Y/m/d") . "</p>
        </div>";

// Fetch the total number of borrowed books
$borrowTtotal = $end_users->CountgetAllUser();
$html .= "<p> <b>Total Students:</b> " . $borrowTtotal['TOTALuser'] . "</p>";

$html .= "<table border=\"1\" style=\"border-collapse: collapse; width: 100%;\">
    
    <thead class=\"field\" style=\"font-weight:bold;\">
        <tr>
            <th>LRN</th>
            <th>Name</th>
            <th>Email</th>
            <th>Penalty</th>
           
        </tr>
    </thead>
    <tbody>";

foreach ($result as $j) {
    $html .= '<tr>';
    $html .= '<td>' . $j['user_LRN'] . '</td>';
    $html .= '<td>' . $j['user_fullname'] . '</td>';
    $html .= '<td>' . $j['user_email'] . '</td>';
     $html .= '<td>' . $j['AllpenaltyCount'] . '</td>';
    
  
   

    // Add additional columns if needed
    $html .= '</tr>';
}

$html .= "
    </tbody>
</table>
</body>
</html>";

$pdf->writeHTML($html);

// Output the PDF as a download
$pdf->Output('book_receipt.pdf', 'D');
?>