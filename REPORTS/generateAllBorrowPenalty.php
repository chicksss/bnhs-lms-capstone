<?php
 
require_once "../DATABASE/book_catalog_db.php";
require_once "../BOOKS/book_catalog_engine.php";

require_once "../database_user_appointment/appointment_engine.php";
require_once "../database_user_appointment/user_appointment.php";

$tables = [];

session_start();
 include "../dashdesign.php";
  include "../tabsr.php";
$crud = new CRUD();
$appointment = new CRUD_appoint();
$join = $crud->InnerJoinBook();

 
 
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
            <h1 class="text-2xl font-bold px-3"> REPORT(Penalty)</h1>
        </div>

        <div class="absolute ml-[900px] mt-[-50px]">
            <button class="px-6 py-2" style="background-color: #dda15e; color: black"><a
                    href="Returned_receipt.php">Generate
                    Report &nbsp; <i class="fi-rr-blog-pencil"></i></a></button>
        </div>

        <div>
            <table class="w-full  ">
                <thead class="bg-[#d5bdaf]  text-left">
                    <th class="px-6 py-2">
                        LRN
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        Title
                    </th>
                    <th>
                        Accession number
                    </th>
                    <th>
                        Date
                    </th>
                </thead>

                <tbody class="text-left">
                    <?php
                    $books = $appointment->appointmentResultPenalty();
                     foreach($books as $b): ?>
                    <tr class="hover:bg-[#e3d5ca] text-left">

                        <th class="px-6 py-2">
                            <?php echo $b['user_LRN'] ?>
                            </td>
                        <td>
                            <?php echo $b['user_fullname'] ?>
                        </td>
                        <td>
                            <?php echo $b['title'] ?>
                        </td>

                        <td>
                            <?php echo $b['book_call_number'] ?>
                        </td>
                        <td>
                            <?php echo $b['borrowing_date'] ?>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>