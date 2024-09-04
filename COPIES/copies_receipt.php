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

    // Initialize total copies
    $totalCPS = 0;

    // Calculate total copies
    if (isset($_GET['id'])) {
        $categoryId = $_GET['id'];
        $books = $crud->selectedBooks($categoryId);

        foreach ($books as $book) {
            // Add the total copies for each book to the overall total
            $totalCPS += $book['totalCPS'];
        }
    }
   

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
        <div class=\"row\">
            <h1 class=\"header\">BAUTISTA NATIONAL HIGH SCHOOL</h1>
            <p class=\"header\">Copies Report</p>
            <p><b>Librarian:</b> " . $_SESSION['fullname_admin']. "</p>
            <p><b>Date of Report:</b> " . date("Y/m/d") . "</p>";

    if (isset($_GET['id'])) {
        $bookCat = $_GET['id'];
        $getCategory = $crud->getCat($bookCat);
        $html .= "<p><b>Category:</b> $getCategory</p>";
    }

     if (isset($_GET['id'])) {
        $categoryId = $_GET['id'];
        $books = $crud->selectedBooks($categoryId);
         $totalCPS = 0;
        foreach ($books as $book) {
            // Add the total copies for each book to the overall total
            $totalCPS += $book['totalCPS'];
        }
         $html .= "<p><b>Total Copies:</b> $totalCPS</p>";
    }
   

    $html .= "<table border=\"1\" style=\"border-collapse: collapse; width: 100%;\">
                <thead class=\"field\" style=\"font-weight:bold;\">
                    <tr>
                      
                        <th>Title</th>
                        <th>Copies</th>
                    </tr>
                </thead>
                <tbody>";

    foreach ($result as $j) {
        $html .= '<tr>';
   
        $html .= '<td>' . $j['title'] . '</td>';
        $html .= '<td>' . $j['totalCPS'] . '</td>';
        // Add additional columns if needed
        $html .= '</tr>';
    }

    $html .= "
                </tbody>
            </table>";

   "
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