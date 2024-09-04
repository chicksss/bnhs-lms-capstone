<?php

require_once "../END_USER/end_user_db.php";
require_once "../END_USER/end_user_engine.php";
session_start();
 include "../dashdesign.php";

 
$end_users = new END_USERS();
 

$getEndUsers = $end_users->getAllUser();

if (isset($_POST["import"])) {
    $fileName = $_FILES["excel"]["name"];
    $fileExtension = explode('.', $fileName);
    $fileExtension = strtolower(end($fileExtension));
    $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;
    $targetDirectory = "uploads/" . $newFileName;
    move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

    error_reporting(0);
    ini_set('display_errors', 0);

    require 'excelReader/excel_reader2.php';
    require 'excelReader/SpreadsheetReader.php';

    // Assuming $end_users is your database connection
    try {
     
        $reader = new SpreadsheetReader($targetDirectory);

        foreach ($reader as $key => $row) {
            $user_LRN = $row[0];
            $user_email = $row[1];
            $user_password = $row[2];
            $user_fullname = $row[3];
            $user_address = $row[4];
            $user_birth = $row[5];
            $user_contact = $row[6];
            $user_gender = $row[7];
            $user_status = $row[8];
            $user_grade = $row[9];
                
            try {
                $getEndUsers = $end_users->EndUserRegister($user_LRN, $user_email, $user_password, $user_fullname, $user_address, $user_birth, $user_contact, $user_gender, $user_status, $user_grade);

                if ($getEndUsers->rowCount() > 0) {
                    echo "<script> alert('Successfully Registered'); location.replace('end_user_list.php') </script>";
                } else {
                    echo "There is an error in Log in please try again";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
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
            <h1 class="text-2xl font-bold px-3">REPORT (Student)</h1>
        </div>

        <div>
            <button class="px-6 py-2 " style="background-color: #dda15e; color: black"><a
                    href="student_receipt.php">Generate
                    Report &nbsp; <i class="fi-rr-blog-pencil"></i></a></button>

        </div>

        <div class="py-2">
            <table class="w-full text-sm text-left">
                <thead class="bg-[#d5bdaf] text-xs p-1">
                    <tr>
                        <th class="px-6 py-2">LRN</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Penalty</th>



                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($getEndUsers as $u) : ?>
                    <tr class="hover:bg-[#e3d5ca]">
                        <td class="px-2 py-2 "><?= $u['user_LRN'] ?></td>
                        <td><?= $u['user_email'] ?></td>
                        <td><?= $u['user_fullname'] ?></td>
                        <td><?= $u['AllpenaltyCount'] ?></td>
                       



                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>


        </div>
    </div>

</body>

</html>