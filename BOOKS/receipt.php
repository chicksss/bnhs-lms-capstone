<?php
require '../DATABASE/book_catalog_db.php';
require '../database_user_appointment/user_appointment.php';
require '../BOOKS/book_catalog_engine.php';
require 'tcpdf/tcpdf.php';

session_start();
$crud = new CRUD();

// Get book ID from the URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id !== null) {
    // Fetch data for the specific book
    $result = $crud->selectedBooks($id);

    // Create PDF
    $pdf = new TCPDF();
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->AddPage();

    $html = "
    <!DOCTYPE html>
    <html lang=\"en\">
    <head>
        <style>
            .field {
                /* Add your styling for the field class here */
            }
            .header {
                text-align: center;
            }
           
        </style>
    </head>
    <body>
        <h1 class=\"header\">BAUTISTA NATIONAL HIGH SCHOOL</h1>
        <p class=\"header\">Poblacion East, Bautista, Philippines</p>
        <p class=\"header\">Book Report</p>

        <p>Librarian: " . $_SESSION['fullname_admin'] . "</p>
        <p>Date of report: " . date("Y/m/d") . "<br></p>";
        
    if (isset($_GET['id'])) {
        $bookCat = $_GET['id'];
        $getCategory = $crud->getCat($bookCat);
        $html .= "<p>Category: $getCategory</p>";
    }

    if (isset($_GET['id'])) {
        $categoryId = $_GET['id'];
        $bookTotal = $crud->getTotalBooks($categoryId);
        $html .= "<p>Total Books: $bookTotal</p>";
    }

    if (isset($_GET['id'])) {
        $categoryId = $_GET['id'];
        $bookTotals = $crud->getBookAvailable($categoryId);
        $html .= "<p>Total Available: $bookTotals</p>";
    }

    $html .= "<table border=\"1\">
                <thead class=\"field\" style=\"font-weight:bold;\">
                    <tr>
                        <th>No.</th>
                        <th>Title</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>";

    foreach ($result as $j) {
        $html .= '<tr>';
        $html .= '<td>' . $j['id'] . '</td>';
        $html .= '<td>' . $j['title'] . '</td>';
        $html .= '<td>' . $j['status_name'] . '</td>';
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
    $pdf->Output($id . '-receipt.pdf', 'D');
} else {
    // Handle the case where no book ID is provided
    echo "Invalid book ID";
}
?>