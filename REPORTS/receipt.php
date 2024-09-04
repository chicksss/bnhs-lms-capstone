<?php
require '../DATABASE/book_catalog_db.php';
require '../database_user_appointment/user_appointment.php';
require '../BOOKS/book_catalog_engine.php';
require 'tcpdf/tcpdf.php';

session_start();
$crud = new CRUD();

// Fetch data for the specific book
$result = $crud->getAllBookReport();

 

// Create PDF
$pdf = new TCPDF('L', 'mm', 'Legal', true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();

$html = "
    <!DOCTYPE html>
    <html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
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

            <p class=\"header\">Book Report</p>
            <p> <b>Librarian:</b>  " . $_SESSION['fullname_admin']. "</p>
            <p><b>Date of Report:</b>" . date("Y/m/d"). "</p>
       </div>";

$bookTotal = $crud->CountAllBookReport();
$html .= "<p><b>Total Books:</b>" . $bookTotal['TOTALId'] . "</p>";
 
$html .= "<table border=\"1\" style=\"border-collapse: collapse; width: 100%;\">
            <thead class=\"field\" style=\"font-weight:bold; background-color: gray; color:white;\">

                <tr>
                      
                    <th>Book</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>ISBN</th>
                    
                </tr>
            </thead>
            <tbody>";

foreach ($result as $book) {
    $html .= '<tr>';
    // $html .= '<td>' . $book['id'] . '</td>';
    $html .= '<td>' . $book['title'] . '</td>';
     $html .= '<td>' . $book['author_name'] . '</td>';
      $html .= '<td>' . $book['publisher'] . '</td>';
       $html .= '<td>' . $book['book_isbn'] . '</td>';
 
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