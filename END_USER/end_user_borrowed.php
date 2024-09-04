<?php

require_once "end_user_db.php";
require_once "end_user_engine.php";

require_once "../database_user_appointment/user_appointment.php";
require_once "../database_user_appointment/appointment_engine.php";
$appointment = new CRUD_appoint();


session_start();
include "../dashdesign.php";
 
$end_users = new END_USERS();
 

// $getEndUsers = $end_users->getAllUser();


if(isset($_GET['user_id'])){
    $user_id = $_GET['user_id'];
    $getResult = $end_users->getUserBorrowedBooks($user_id);
}
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
            <h1 class="text-2xl font-bold px-3">STUDENT BOOKS</h1>
        </div>

        <div class="container card-body tbl"
            style="max-height: 100%;  border-radius: 15px; overflow-y: auto; background-color:white">
            <!-- <ul style="display: flex; gap: 20px; list-style: none; padding: 0; margin: 0;">

                <li>
                    <input type="text" class="form-control" id="idFilter" placeholder="Enter Account ID...">
                </li>

                <li>
                    <form class="form-inline" action="" method="post" enctype="multipart/form-data">
                        <input type="file" class="form-control-file" name="excel" required value="">
                        <button class="btn" type=""
                            style="background: #d4a373; padding: 10px; border-radius: 50%;">
                            <i class="fa-solid fa-file-arrow-up" style="font-size: 25px;"></i>
                        </button>
                    </form>
                </li>

            </ul> -->


            <script>
            // JavaScript function to filter table rows based on the selected status
            function filterStatus() {
                var selectBox = document.getElementById("statusFilter");
                var selectedValue = selectBox.value;
                var table = document.getElementById("bookTable");
                var tr = table.getElementsByTagName("tr");

                for (var i = 1; i < tr.length; i++) {
                    var td = tr[i].getElementsByTagName("td")[3];
                    if (td) {
                        var statusText = td.textContent || td.innerText;
                        if (selectedValue == "All" || statusText.indexOf(selectedValue) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
            </script>


            <div class="filter-container">
                <label for="statusFilter">Filter Status: </label>
                <select id="statusFilter" class="rounded-lg" onchange="filterStatus()">
                    <option value="All">All</option>
                    <option value="Hold">Hold</option>
                    <option value="Returned">Returned</option>
                    <option value="Borrowed">Borrowed</option>
                    <option value="Decline">Decline</option>
                    <option value="Penalty">Penalty</option>
                </select>
            </div>



            <ul class="flex justify-center gap-10 py-3">


                <?php foreach ($getResult as $user): ?>
                <li>
                    Name: <?php echo $user['user_fullname']; ?>
                </li>
                <!-- Add other information you want to display for each user -->
                <?php 
                    break;
                    endforeach; ?>


                <li style="margin-left: 380px;">

                    <?php
                        $totalPEnalites = $appointment->TotalPenalties($user_id);
                        echo '<span>Penalty:  </span>'.$totalPEnalites;
                    ?>

                </li>




            </ul>








            <?php
                    // $results_per_page = 10; 
                    // $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                    // $offset = ($current_page - 1) * $results_per_page;
                    // $user_id = isset($_GET['id']) ? $_GET['id'] : null;
                    // // Fetch total number of books for the user
                    // $total_books = count($end_users->getUserBorrowedBooks($user_id, $results_per_page, $offset));
                    // $total_pages = ceil($total_books / $results_per_page);
                    // // Fetch books for the current page
                    // $getResult = $end_users->SelectgetUserBorrowedBooks($user_id, $results_per_page, $offset);

                    $getResult = $end_users->getUserBorrowedBooks($user_id);
                    ?>
            <br>
            <style>
            .table {
                margin-top: 30px;
                font-size: 12px;
            }

            .tbl {
                height: 540px;
                width: 100%;
                overflow-y: scroll;
            }
            </style>

            <div class="relative overflow-y-auto h-[600px] shadow-md sm:rounded-lg">
                <table id="bookTable"
                    class="w-full text-lg px-5 py-2 text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                    <thead class="text-xs text-gray-700 uppercase bg-[#faedcd]">
                        <tr class="text-xs py-3">
                        <th scope="col" class="px-6 py-3 w-64 truncate">Book</th>
                            <th>Accession Number</th>
                            <th>Date Borrowed</th>
                            <th>Status</th>
                            <th>Penalties</th>
                        </tr>
                    </thead>
                    <tbody class=" ">
                        <?php foreach ($getResult as $u){ ?>
                        <tr class="text-lg py-3">
                        <td class="px-6 py-4"><?= $u['book_title'] ?></td>
                            <td><?= $u['book_call_number'] ?></td>
                            <td><?= $u['borrowing_date'] ?></td>
                            <td>
                                <p><?php 
                    if($u['status'] == 'Available'){
                        echo '<span style="color:gray; font-style: italic">Hold</span>';
                    } 
                    else if($u['status'] == 'Returned'){
                        echo '<span style="color:blue; font-style: italic">Returned</span>';
                    }
                    else if($u['status'] == 'Borrowed'){
                        echo '<span style="color:green; font-style: italic">Borrowed</span>';
                    }else if($u['status'] == 'Decline'){
                        echo '<span style="color:orange; font-style: italic">Decline</span>';
                    }
                    else{
                        echo '<span style="color:red; font-style: italic">Penalty</span>';
                    }
                ?></p>
                            </td>
                            <td>
                                <?php if($u['status'] == 'Penalty'){ ?>
                                <?= $u['penaltyCount'] ?>
                                <?php } ?>
                            </td>

                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>



        </div>
    </div>




    <main class="home-section">








        <script>
        const idFilterInput = document.getElementById("idFilter");
        const tableRows = document.querySelectorAll("table tbody tr");

        idFilterInput.addEventListener("input", function() {
            const filterValue = idFilterInput.value.toLowerCase();

            tableRows.forEach(function(row) {
                const idCell = row.querySelector("td:first-child");
                if (idCell) {
                    const idText = idCell.textContent;
                    row.style.display = idText.toLowerCase().includes(filterValue) ? "" : "none";
                }
            });
        });
        </script>






        <script>
        const idFilterInput = document.getElementById("idFilter");
        const tableRows = document.querySelectorAll("table tbody tr");

        idFilterInput.addEventListener("input", function() {
            const filterValue = idFilterInput.value.toLowerCase();

            tableRows.forEach(function(row) {
                const idCell = row.querySelector("td:first-child");
                if (idCell) {
                    const idText = idCell.textContent;
                    row.style.display = idText.toLowerCase().includes(filterValue) ? "" : "none";
                }
            });
        });
        </script>




    </main>
</body>
<script>
let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e) => {
        let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
        arrowParent.classList.toggle("showMenu");
    });
}
let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".bx-menu");
console.log(sidebarBtn);
sidebarBtn.addEventListener("click", () => {
    sidebar.classList.toggle("close");
});
</script>


</html>