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
            <h1 class="text-2xl font-bold px-3">PENALTY</h1>
        </div>




        <div class="absolute mt-[-50px] ml-[800px]">
            <input type="text" id="idFilter" class="rounded-lg p-2 w-[300px]"
                placeholder="Search: LRN/Book/Name/Accession number...">
        </div>

        <div>
            <?php

                                    
                                    $appointment = new CRUD_appoint();
                                    $bookResult = $appointment->appointmentResultPenalty();   
                   ?>


            <table class="w-full text-sm text-left">
                <thead class="bg-[#d5bdaf] text-xs p-1">
                    <tr>
                        <th class="px-6 py-2">LRN</th>

                        <th>Name</th>
                        <!-- <th>Date</th>
                        <th>Contact</th> -->

                        <th style="width:150px">Book</th>
                        <!-- <th>Book Status</th> -->
                        <th>Accession Number</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Penalties</th>


                        <th>Return</th>
                        <!-- <th>Borrowed</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php 
                
                foreach($bookResult as $t){ 
                    
                    ?>
                    <tr class="hover:bg-[#e3d5ca]">
                        <td class="px-2 py-2 ">
                            <p><?php echo $t['user_LRN']; ?> </p>
                        </td>

                        <td>
                            <p><?php echo $t['user_fullname']; ?> </p>
                        </td>

                        <td class="px-6 py-2 w-[300px]">
                            <p class="title-book"><?php echo $t['title']; ?> </p>
                        </td>

                        <td>
                            <p class="title-book"><?php echo $t['book_call_number']; ?> </p>
                        </td>

                        <td>
                            <p><?php 
                                        if($t['status'] == 'Available'){
                                             echo '<span style="color:gray; font-style: italic">Hold</span>';
                                        } 
                                        else if($t['status'] == 'Returned'){
                                            echo '<span style="color:blue; font-style: italic">Returned</span>';
                                        }
                                        else if($t['status'] == 'Borrowed'){
                                            echo '<span style="color:green; font-style: italic">Borrowed</span>';
                                            
                                        }else if($t['status'] == 'Decline'){
                                            echo '<span style="color:orange; font-style: italic">Decline</span>';
                                        }
                                        else{
                                             echo '<span style="color:red; font-style: italic">Penalty</span>';
                                        }
                                    ?></p>
                        </td>

                        <td><?php echo $t['appointmentDate'] ?></td>



                        <!-- <td>
                            <?php
                                if ($t['status'] == 'Available') {
                                    echo '<span style="color:gray; font-style: italic">Pending</span>';
                                } else if ($t['status'] == 'Borrowed') {
                                    $currentDate = date('Y-m-d');
                                    $appointDate = $t['appointmentDate'];

                                    if ($appointDate >= $currentDate) {
                                        // Calculate the number of days left until the appointment date
                                        $daysUntilAppoint = ceil((strtotime($appointDate) - strtotime($currentDate)) / (60 * 60 * 24));
                                        echo $daysUntilAppoint, " Day(s) Left";
                                    } else {
                                        echo '<span style="color:red; font-style: italic">Penalty</span>';
                                        $appointmentId = $t['appointment_Id'];

                                        // Check if the status is not already 'Penalty' before updating
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
                        </td> -->

                        <td>
                            <?php
//                               if ($t['status'] == 'Available') {
//                                     echo '<span style="color:gray; font-style: italic">Pending</span>';
//                                 } else if ($t['status'] == 'Borrowed') {
//                                     $currentDate = date('Y-m-d');
//                                     $appointDate = $t['appointmentDate'];

//                                     if ($appointDate >= $currentDate) {
//                                         // Calculate the number of days left until the appointment date
//                                         $daysUntilAppoint = ceil((strtotime($appointDate) - strtotime($currentDate)) / (60 * 60 * 24));
//                                         echo $daysUntilAppoint, " Day(s) Left";
//                                     } else {
//                                         echo '<span style="color:red; font-style: italic">Penalty</span>';
//                                         $appointmentId = $t['appointment_Id'];

//                                         // Check if the status is not already 'Penalty' before updating
//                                         if ($t['status'] != 'Penalty') {
//                                             $update = $appointment->UpdatetoPenalty($appointmentId);
//                                         }
//                                     }
//                                 } else {
//                                     if ($t['status'] == 'Penalty') {
//                                         echo "<p style='color:red'></p>";
//                                     }
//                                 }

 

 
    $appointmentId = $t['appointment_Id'];
    $DeadlineBorrow = new DateTime($t['appointmentDate']);
    $today = new DateTime('now');
    
        // Calculate the difference in days
        $interval = $today->diff($DeadlineBorrow);
        $daysPastDeadline = $interval->days;

        // Check if the current date is past the deadline
        if ($today > $DeadlineBorrow) {
            // If today is past the deadline, add 1 penalty per day
            $newPenaltyCount = $daysPastDeadline;
            $update = $appointment->UpdatetoPenaltyCount($appointmentId,$newPenaltyCount);
            //    echo "<p style='color:red'>" . $t['penaltyCount'] . "</p>";
                 if ($update) {
        echo "<p style='color:red'>" . htmlspecialchars($newPenaltyCount) . "</p>";
            } else {
                // Handle the error accordingly if the update fails
                echo "<p style='color:red'>Error updating penalty count</p>";
            }
        } else {
            // If today is on or before the deadline, no penalty
            $penalty = 0;
        }

   
 
 

?>





                        </td>



                        <td>
                            <?php
                        $currentDate = date('Y-m-d');
                        $appointDate = $t['appointmentDate'];
                        $daysUntilAppoint = max(0, ceil((strtotime($appointDate) - strtotime($currentDate)) / (60 * 60 * 24)));
                      
                        if ($appointDate >= $currentDate) {
                            //   echo $daysUntilAppoint, " Day Left";
                            echo '<button type="submit" class="btn" style="background-color: rgba(0, 0, 0, 0);"><a href="admin_user_list_delete.php?appointment_Id=' . $t['appointment_Id'] . '&book_Id=' . $t['book_Id'] . '&user_id=' . $t['user_id'] . '"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
</svg>
</a></button>';

                        } else{
                            echo '<button type="submit" class="btn" style="background-color: rgba(0, 0, 0, 0);"><a href="admin_user_list_delete.php?appointment_Id=' . $t['appointment_Id'] . '&book_Id=' . $t['book_Id'] . '&user_id=' . $t['user_id'] . '"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
</svg>
</a></button>';

                        }
                        ?>
                        </td>


                        <!-- <td>

                            <?php
                                $currentDate = date('Y-m-d');
                                $appointDate = $t['appointmentDate'];
                                $daysUntilAppoint = max(0, ceil((strtotime($appointDate) - strtotime($currentDate)) / (60 * 60 * 24)));
                            
                                if ($appointDate >= $currentDate) {
                                
                                        echo '<button type="submit" class="btn"
                                                        style="margin-right:20px; background-color: rgba(0, 0, 0, 0);"> <a style="text-decoration:none"
                                                            href="../BOOKS/addCopies.php?table=' . $seletedCategory . '&id=' . $t['id'] . '">
                                                            <i class="fa-solid fa-plus" style="color: blue;"></i>
                                                            <div class="hide-update"></div>
                                                        </a></button>';
                                } else {
                                    
                                    
                                    echo '<button type="submit" class="btn"
                                                        style="margin-right:20px; background-color: rgba(0, 0, 0, 0);"> <a style="text-decoration:none"
                                                            href="../database_book_catalog/addCopies.php?table=' . $seletedCategory . '&id=' . $t['id'] . '">
                                                            <i class="fa-solid fa-plus" style="color: blue;"></i>
                                                            <div class="hide-update"></div>
                                                        </a></button>';

                                }
                        ?>
                        </td> -->
                        <!-- <td>
                            <?php  echo '<button type="submit" class="btn" style=" background-color: rgba(0, 0, 0, 0);"><a
                                    href="../END_USER/end_user_update.php?user_id=' . $t['user_id'] . '"> <i class="fa-solid fa-ban" style="color: #ff0000;"></i></a></button>'; ?>

                        </td>

                        <td>

                            <?php
                          echo '<button type="submit" class="btn" style="background-color: rgba(0, 0, 0, 0);"><a href="admin_borrower_Accept.php?appointment_Id=' . $t['appointment_Id']. '"> <i class="fa-solid fa-circle-check" style="color: #4287ff;"></i></a></button>';

                        ?>
                        </td>

                        <td>

                            <?php
                     echo '<button type="submit" class="btn" style="background-color: rgba(0, 0, 0, 0);"><a href="admin_borrower_Decline.php?appointment_Id=' . $t['appointment_Id'] . '&book_Id=' . $t['book_Id'] . '">  <i class="fa-solid fa-circle-xmark" style="color: red;"></i></a></button>';

                        ?>
                        </td> -->


                    </tr>
                    <?php  ?>
                </tbody>
                <?php }   ?>
            </table>

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
        // function myFunction() {
        //     var input, filter, table, tr, td, i, txtValue;
        //     input = document.getElementById("myInput");
        //     filter = input.value.toUpperCase();
        //     table = document.getElementsByTagName("table")[0];
        //     tr = table.getElementsByTagName("tr");

        //     for (i = 0; i < tr.length; i++) {
        //         td = tr[i].getElementsByTagName("td")[
        //             0]; // Assuming you want to filter based on the first column (title)
        //         if (td) {
        //             txtValue = td.textContent || td.innerText;
        //             if (txtValue.toUpperCase().indexOf(filter) > -1) {
        //                 tr[i].style.display = "";
        //             } else {
        //                 tr[i].style.display = "none";
        //             }
        //         }
        //     }
        // }


        // const sidFilterInput = document.getElementById("myInput");
        // const tableRows = document.querySelectorAll("table tbody tr");

        // sidFilterInput.addEventListener("input", function() {
        //     const filterValue = sidFilterInput.value.toLowerCase();

        //     tableRows.forEach(function(row) {
        //         const idCell = row.querySelector("td:nth-child(3)");
        //         if (idCell) {
        //             const idText = idCell.textContent;
        //             row.style.display = idText.toLowerCase().includes(filterValue) ? "" : "none";
        //         }
        //     });
        // });





        //ID FILTER
        </script>


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