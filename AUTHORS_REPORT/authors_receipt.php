<?php

require "../AUTHORS/author_db.php";
require "../AUTHORS/authors_engine.php";
require 'tcpdf/tcpdf.php';

session_start();

$myAuthors = new authorsBook();

// Fetch data for the specific book
$result = $myAuthors->getAllAuthors();

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
            
            <p class=\"header\">Authors Report</p>
            <p> <b>Librarian:</b>  " . $_SESSION['fullname_admin'] . "</p>
            <p> <b>Date of Report:</b> " . date("Y/m/d") . "</p>
        </div>";


$borrowTtotal = $myAuthors->CountgetAllAuthors();
$html .= "<p> <b>Total Authors:</b> " . $borrowTtotal['AuthorId'] . "</p>";

$html .= "<table border=\"1\" style=\"border-collapse: collapse; width: 100%;\">
    <thead class=\"field\" style=\"font-weight:bold;\">
        <tr>
            <th>No.</th>
            <th>Author</th>
           
           
        </tr>
    </thead>
    <tbody>";

foreach ($result as $j) {
    $html .= '<tr>';
    $html .= '<td>' . $j['id'] . '</td>';
    $html .= '<td>' . $j['author_name'] . '</td>';
    
    
  
   

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