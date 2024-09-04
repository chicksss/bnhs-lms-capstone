<?php
session_start();
 include "../dashdesign.php";
   include "../tabs.php";
require_once "user_appointment.php";
require_once "appointment_engine.php";
require_once "../DATABASE/book_catalog_db.php";
require_once "../BOOKS/book_catalog_engine.php";
$bookCatalog = new CRUD();
$bookCategory = $bookCatalog->getBookCategories();
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
        <div class="absolute mt-[-110px]">
            <h1 class="text-2xl font-bold px-3">BORROWED</h1>
        </div>

        <div class="absolute mt-[-50px] ml-[800px]">
            <input type="text" id="idFilter" class="rounded-lg p-2 w-[300px]"
                placeholder="Search: LRN/Book/Name/Accession number...">
        </div>

        <div class="">

            <?php
// Initialize your class and get all records
$appointment = new CRUD_appoint();
$bookResult = $appointment->appointmentResultBorrowed();   

// Pagination variables
$totalRecords = count($bookResult);
$recordsPerPage = 10; // Set the number of records per page
$totalPages = ceil($totalRecords / $recordsPerPage);

// Get the current page or set a default
$currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Ensure current page is within valid range
if ($currentPage > $totalPages) {
    $currentPage = $totalPages;
} elseif ($currentPage < 1) {
    $currentPage = 1;
}

// Calculate the offset for the query
$offset = ($currentPage - 1) * $recordsPerPage;

// Retrieve the current page records
$currentRecords = array_slice($bookResult, $offset, $recordsPerPage);
?>

            <table class="w-full">
                <thead class="bg-[#d5bdaf] text-xs">
                    <tr>
                        <th class="px-6 py-2">LRN</th>
                        <th class="px-6 py-2">Name</th>
                        <th class="px-6 py-2" style="width:150px">Book</th>
                        <th class="px-6 py-2">Accession no.</th>
                        <th class="px-6 py-2">Status</th>
                        <th class="px-6 py-2">Date Borrowed</th>
                        <th class="px-6 py-2">Date Return</th>
                        <th class="px-6 py-2">Countdown</th>
                        <th class="px-6 py-2">Return</th>
                        <th class="px-6 py-2">Decline</th>
                    </tr>
                </thead>
                <tbody class="text-xs">
                    <?php foreach ($currentRecords as $t): ?>
                    <tr class="hover:bg-[#e3d5ca]">
                        <td class="px-6 py-2">
                            <p><?php echo htmlspecialchars($t['user_LRN']); ?></p>
                        </td>
                        <td class="px-6 py-2">
                            <p><?php echo htmlspecialchars($t['user_fullname']); ?></p>
                        </td>
                        <td class="px-6 py-2">
                            <p class="title-book"><?php echo htmlspecialchars($t['title']); ?></p>
                        </td>
                        <td class="px-6 py-2">
                            <p class="title-book"><?php echo htmlspecialchars($t['book_call_number']); ?></p>
                        </td>
                        <td class="px-6 py-2">
                            <p>
                                <?php 
                    switch ($t['status']) {
                        case 'Available':
                            echo '<span style="color:gray; font-style: italic">Hold</span>';
                            break;
                        case 'Returned':
                            echo '<span style="color:blue; font-style: italic">Returned</span>';
                            break;
                        case 'Borrowed':
                            echo '<span style="color:green; font-style: italic">Borrowed</span>';
                            break;
                        case 'Decline':
                            echo '<span style="color:orange; font-style: italic">Decline</span>';
                            break;
                        default:
                            echo '<span style="color:red; font-style: italic">Penalty</span>';
                            break;
                    }
                    ?>
                            </p>
                        </td>
                        <td class="px-6 py-2"><?php echo htmlspecialchars($t['borrowing_date']); ?></td>
                        <td class="px-6 py-2"><?php echo date('Y-m-d', strtotime($t['borrowing_date'] . ' +2 days')); ?>
                        </td>
                        <td class="px-6 py-2">
                            <?php
                if ($t['status'] == 'Available') {
                    echo '<span style="color:gray; font-style: italic">Pending</span>';
                } else if ($t['status'] == 'Borrowed') {
                    $currentDate = date('Y-m-d');
                    $appointDate = $t['appointmentDate'];

                    if ($appointDate >= $currentDate) {
                        $daysUntilAppoint = ceil((strtotime($appointDate) - strtotime($currentDate)) / (60 * 60 * 24));
                        echo $daysUntilAppoint . " Day(s) Left";
                    } else {
                        echo '<span style="color:red; font-style: italic">Penalty</span>';
                        $appointmentId = $t['appointment_Id'];
                        if ($t['status'] != 'Penalty') {
                            $update = $appointment->UpdatetoPenalty($appointmentId);
                        }
                    }
                } else {
                    if ($t['status'] == 'Penalty') {
                        echo "<p style='color:red'></p>";
                    }
                }
                ?>
                        </td>
                        <td class="px-6 py-2">
                            <?php
                $currentDate = date('Y-m-d');
                $appointDate = $t['appointmentDate'];
                $daysUntilAppoint = max(0, ceil((strtotime($appointDate) - strtotime($currentDate)) / (60 * 60 * 24)));
                
                if ($appointDate >= $currentDate) {
                    echo '<button type="submit" class="btn" style="background-color: rgba(0, 0, 0, 0);"><a href="admin_user_list_delete.php?appointment_Id=' . $t['appointment_Id'] . '&book_Id=' . $t['book_Id'] . '&user_id=' . $t['user_id'] . '"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
</svg>
</a></button>';
                } else {
                    echo '<button type="submit" class="btn" style="background-color: rgba(0, 0, 0, 0);"><a href="admin_user_list_delete.php?appointment_Id=' . $t['appointment_Id'] . '&book_Id=' . $t['book_Id'] . '&user_id=' . $t['user_id'] . '"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
</svg></a></button>';
                }
                ?>
                        </td>
                        <td class="px-6 py-2">
                            <?php
                echo '<button type="submit" class="btn" style="background-color: rgba(0, 0, 0, 0);"><a href="admin_borrower_Decline.php?appointment_Id=' . $t['appointment_Id'] . '&book_Id=' . $t['book_Id'] . '"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
</svg>
</a></button>';
                ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination controls -->
            <div class="flex justify-center">
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


            <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get the dropdown element
                var statusFilter = document.getElementById('statusFilter');

                // Add event listener to filter table on change
                statusFilter.addEventListener('change', function() {
                    var selectedStatus = statusFilter.value;
                    filterTableByStatus(selectedStatus);
                });

                // Function to filter the table by status
                function filterTableByStatus(status) {
                    var tableRows = document.querySelectorAll('.table tbody tr');

                    tableRows.forEach(function(row) {
                        var statusCell = row.querySelector('td:nth-child(5) p');
                        var rowStatus = statusCell.textContent.trim();


                        if (status === 'all' || rowStatus === status) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }
            });
            </script>
        </div>
        <?php   echo '</div>'; ?>





        <script>
        const idFilterInput = document.getElementById("idFilter");
        const tableRows = document.querySelectorAll("table tbody tr");

        idFilterInput.addEventListener("input", function() {
            const filterValue = idFilterInput.value.toLowerCase();

            tableRows.forEach(function(row) {
                let isRowVisible = false;

                // Loop through each cell in the row
                row.querySelectorAll("td").forEach(function(cell) {
                    const cellText = cell.textContent.toLowerCase();

                    // Check if the cell text contains the filter value
                    if (cellText.includes(filterValue)) {
                        isRowVisible = true;
                    }
                });

                // Set the display property based on whether any cell contains the filter value
                row.style.display = isRowVisible ? "" : "none";
            });
        });
        </script>

    </div>

    </div>


</body>

</html>