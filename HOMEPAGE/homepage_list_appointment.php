<?php

require "../END_USER/end_user_db.php";
require "../END_USER/end_user_engine.php";


require "../database_user_appointment/user_appointment.php";
require "../database_user_appointment/appointment_engine.php";
session_start();



$end_users = new END_USERS();
                    if(isset($_SESSION['user_id'])){
                        $user_id = $_SESSION['user_id'];
                        $user = $end_users->UserSessioninBook($user_id);
                    }


                    $currentTime = time();
                            $startDay = strtotime('today', $currentTime);

$appointment = new CRUD_appoint();

//  $appointmentsList = $appointment->getUserAppointments();
// if(isset($_SESSION['user_id'])){
//     $user_id = $_SESSION['user_id'];
    
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../src/output.css" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
    <title>Document</title>
</head>

<body class="bg-[#f5ebe0]">

    <nav class="border-gray-200 bg-[#edede9] w-full fixed z-20 top-0 start-0 shadow-lg">
        <div class="flex flex-wrap justify-between items-center mx-10 p-4 ">
            <a href="https://flowbite.com" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-1xl font-semibold whitespace-nowrap dark:text-black md:ml-20">BAUTISTA
                    NHS</span>
            </a>

            <a href="../END_USER/end_user_logout.php" class="text-sm text-black dark:text-blue-500 hover:underline ">Log
                out</a>


        </div>
    </nav>

    <nav class="bg-[#e6ccb2] shadow-lg mt-[58px]">
        <div class="max-w-screen-xl px-4 py-3 mx-auto">
            <div class="flex items-center">
                <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm md:ml-20 md:text-lg">
                    <li>
                        <a href="homepage_catalog.php" class="text-gray-900 dark:text-dark hover:underline"
                            aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="user_manual.php" class="text-gray-900 dark:text-dark hover:underline">
                            User Manual</a>
                    </li>
                    <li>
                        <a href="homepage_bookmark.php"
                            class="text-gray-900 dark:text-dark hover:underline">Bookmark</a>
                    </li>

                    <li>
                        <?php
                        if ($_SESSION['user_fullname']) { ?>
                        <a class="text-gray-900 dark:text-dark hover:underline"
                            href="../END_USER/end_user_profile.php?user_id=<?php echo $_SESSION['user_fullname']; ?>">Profile</a>
                        <?php } ?>

                    </li>

                    <li>
                        <a href="#" class="text-gray-900 dark:text-dark hover:underline">My Books</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="px-44 py-10">
        <div class="flex flex-cols-2 justify-between py-4">
            <h1 class="font-['Cedarville-Cursive'] text-3xl ">My Books</h1> <br>
            <div>
                <?php
                        $totalPEnalites = $appointment->TotalPenalties($user_id);
                        echo '<span>Total Penalty:  </span>'.$totalPEnalites;
                    ?>
            </div>

        </div>

        <div class="w-[1010px] py-[-2]" style="border-bottom:black 4px solid"></div>




    </div>

    <div class="ml-44">
        <table class="w-full text-center text-sm text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-[#e6ccb2] dark:text-black">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        LRN
                    </th>
                    <th class="w-44 py-3">
                        Name
                    </th>
                    <th scope="col" class="w-96  py-3">
                        Book
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Countdown
                    </th>
                </tr>
            </thead>
            <?php 
                    $appointmentsList = $appointment->getAllAppointmentList($user_id);
                    foreach($appointmentsList as $bokAppoint): 
                    ?>
            <tbody>

                <tr class="bg-[#f5ebe0]">
                    <td class="text-black px-6 py-4">
                        <?php echo $bokAppoint['generateId']; ?>
                    </td>
                    <td class="text-black w-75 py-4">
                        <?php echo $bokAppoint['borrower_name']; ?>
                    </td>
                    <td class="text-black px-6 py-4">
                        <?php echo $bokAppoint['book_title']; ?>
                    </td>
                    <td class="text-black px-6 py-4">
                        <?php echo $bokAppoint['borrowing_date']; ?>
                    </td>

                    <td class="text-black px-6 py-4">
                        <p><?php 
                    if($bokAppoint['status'] == 'Available'){
                        echo '<span style="color:gray; font-style: italic">Hold</span>';
                    } 
                    else if($bokAppoint['status'] == 'Returned'){
                        echo '<span style="color:blue; font-style: italic">Returned</span>';
                    }
                    else if($bokAppoint['status'] == 'Borrowed'){
                        echo '<span style="color:green; font-style: italic">Borrowed</span>';
                    }else if($bokAppoint['status'] == 'Decline'){
                        echo '<span style="color:orange; font-style: italic">Decline</span>';
                    }
                    else{
                        echo '<span style="color:red; font-style: italic">Penalty</span>';
                    }
                ?></p>
                    </td>

                    <td class="text-black px-6 py-4">
                        <?php
                             if($bokAppoint['status'] == 'Available'){
                                echo '<span style="color:gray; font-style: italic">Pending</span>';
                             
                            }
                            else if($bokAppoint['status'] == 'Borrowed'){
                                 $currentDate = date('Y-m-d');
                            $appointDate = $bokAppoint['appointmentDate'];

                            if ($appointDate >= $currentDate) {
                                // Calculate the number of days left until the borrowing_date
                                $daysUntilAppoint = ceil((strtotime($appointDate) - strtotime($currentDate)) / (60 * 60 * 24));
                                echo $daysUntilAppoint, " Day(s) Left";
                            } else { 
                                
                                 $appointmentId = $bokAppoint['appointment_Id'];
                                 $update = $appointment->UpdatetoPenalty($appointmentId);
                                   
                            }
                            } 
                            
                            ?>

                    </td>

                    <td class="text-black px-6 py-4" style="width:250px">
                        <button type="submit" class="btn iconforbroow">
                            <a href="end_user_See_profile.php?user_id=<?= $u['user_id'] ?>">
                                <!-- <i class="fas fa-eye "></i> -->

                                <i class="bi bi-person-fill" style="font-size:20px;color:green"></i>
                            </a>
                        </button>
                        <button type="submit" class="btn">
                            <a href="end_user_borrowed.php?user_id=<?= $u['user_id'] ?>">
                                <i class="bi bi-book iconforbroow" style="font-size:20px;color:blue"></i>
                            </a>
                        </button>
                        <button type="submit" class="btn">
                            <a href="end_user_update.php?user_id=<?= $u['user_id'] ?>">
                                <i class="bi bi-ban iconforbroow" style="font-size:20px;color:red"></i>
                            </a>
                        </button>
                        <button type="submit" class="btn">
                            <a href="end_user_delete.php?user_id=<?= $u['user_id'] ?>">
                                <i class="fas fa-trash iconforbroow" style="font-size:20px;color:red"></i>
                            </a>
                        </button>
                    </td>
                </tr>
            </tbody>
            <?php endforeach; ?>
        </table>
    </div>




</body>

</html>