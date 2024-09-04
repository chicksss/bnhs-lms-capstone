<?php
   ob_start();
require_once "../DATABASE/book_catalog_db.php";
require_once "book_catalog_engine.php";
$tables = [];

session_start();
 include "../dashdesign.php";
$crud = new CRUD();

$archive = $crud->InnerJoinBookArchive();
 


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
            <h1 class="text-2xl font-bold px-3">ARCHIVE</h1>
        </div>





        <br>
        <?php
// Assuming $archive contains all records
$totalRecords = count($archive);
$recordsPerPage = 10; // Set the number of records per page
$totalPages = ceil($totalRecords / $recordsPerPage);

// Get the current page or set a default
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = (int) $_GET['page'];
} else {
    $currentPage = 1;
}

// If current page is greater than total pages
if ($currentPage > $totalPages) {
    $currentPage = $totalPages;
}

// If current page is less than first page
if ($currentPage < 1) {
    $currentPage = 1;
}

// Calculate the offset for the query
$offset = ($currentPage - 1) * $recordsPerPage;

// Retrieve the current page records
$currentRecords = array_slice($archive, $offset, $recordsPerPage);
?>


<div class="py-3">
<input type="text" class="rounded-lg p-1" id="myInput" onkeyup="myFunction()"
placeholder="Search for books.." title="Type Author">
</div>

<script>
            function myFunction() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementsByTagName("table")[0];
                tr = table.getElementsByTagName("tr");

                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[
                        0]; // Assuming you want to filter based on the first column (title)
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
            </script>

        <!-- Display the table with paginated results -->
        <table class="w-full text-left px-10">
            <thead class="bg-[#d5bdaf]">
                <tr>
                    <th class="px-6 py-2">Title</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($currentRecords as $a): ?>
                <tr class="hover:bg-[#e3d5ca]">
                    <td class="px-6 py-2"><?php echo htmlspecialchars($a['archive_book_title']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    
        <div class="flex justify-center py-10">
                <!-- Pagination controls -->
        <nav aria-label="Page navigation example">
            <ul class="inline-flex -space-x-px text-sm">
                <?php if ($currentPage > 1): ?>
                <li>
                    <a href="?page=<?php echo $currentPage - 1; ?>"
                        class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li>
                    <a href="?page=<?php echo $i; ?>"
                        class="flex items-center justify-center px-3 h-8 leading-tight <?php echo $i == $currentPage ? 'text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white' : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                <li>
                    <a href="?page=<?php echo $currentPage + 1; ?>"
                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        </div>









    </div>

</body>

</html>