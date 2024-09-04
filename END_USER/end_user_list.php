<?php

require_once "end_user_db.php";
require_once "end_user_engine.php";
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
            $user_MiddleName = $row[4];
            $user_LastName = $row[5];
            $user_address = $row[6];
            $user_birth = $row[7];
            $user_contact = $row[8];
            $user_gender = $row[9];
            $user_status = $row[10];
            $user_grade = $row[11];
                
            try {
                $user_LRN = $row[0];
                $checkLRN = $end_users->checkLRnUser($user_LRN); 
      
                if($user_LRN == $checkLRN){  
                    echo "<script>
                alert('The LRN is existed');
                location.replace('../END_USER/end_user_list.php')
                </script>";
        
            }  else {
                $getEndUsers = $end_users->EndUserRegister($user_LRN, $user_email, $user_password, $user_fullname,$user_MiddleName, $user_LastName, $user_address, $user_birth, $user_contact, $user_gender, $user_status, $user_grade);
                if ($getEndUsers->rowCount() > 0) {
                    echo "<script> alert('Successfully Registered'); location.replace('end_user_list.php') </script>";
                } else {
                    echo "There is an error in Log in please try again";
                }
            } 
        }catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}



if(isset($_POST['signup'])){
    $user_LRN = $_POST['user_LRN'];

      $checkLRN = $end_users->checkLRnUser($user_LRN); 
        if($user_LRN == $checkLRN){  
            echo "<script>
        alert('The LRN is existed');
        location.replace('../END_USER/end_user_list.php')
        </script>";
        }  else{

        $user_LRN = $_POST['user_LRN'];
        $user_password = $_POST['user_password'];
        $user_fullname = $_POST['user_fullname'];
        $user_MiddleName = $_POST['user_MiddleName'];
        $user_LastName = $_POST['user_LastName'];
        $user_address = $_POST['user_address'];
        $user_birth = $_POST['user_birth'];
        $user_contact = $_POST['user_contact'];
        $user_email = $_POST['user_email'];
        $user_gender = $_POST['user_gender'];
        $user_status = $_POST['user_status'];
        $user_grade = $_POST['user_grade'];

$end_users->EndUserRegister($user_LRN, $user_email, $user_password, $user_fullname,$user_MiddleName, $user_LastName,
$user_address, $user_birth, $user_contact, $user_gender, $user_status, $user_grade);
        }



echo "<script>
alert('Succesfully Registered');
location.replace('../END_USER/end_user_list.php')
</script>";

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
            <h1 class="text-2xl font-bold px-3">STUDENT LIST</h1>
        </div>

        <div class="flex justify-between gap-10  py-2 px-2">
            <div class="w-full">

                <input type="text" class="rounded-lg p-1 w-full " id="idFilter" placeholder="Search LRN...">
            </div>
            <div class="w-full">

                <div class="flex gap-10">
                    <!-- Modal toggle -->

                    <form class="" action="" method="post" enctype="multipart/form-data">
                        <input type="file" class="rounded-lg w-full border" name=" excel" required value="">
                        <button class="p-0 rounded-lg " type="submit" name="import">
                            <i class="fa-solid fa-file-arrow-up"></i>
                        </button>
                    </form>
                    <button data-modal-target="static-modal" data-modal-toggle="static-modal"
                        class="bg-[#d5bdaf] px-2 rounded-lg border" type="button">
                        Add Manually
                    </button>

                </div>


            </div>





            <!-- Main modal -->
            <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Add new Student Account
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="static-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->


                        <form class="form-group" style="padding:30px" action="end_user_list.php" method="POST">
                            <div class="flex grid-cols-2 justify-center">
                                <div class="px-10">
                                    <p class="text-xs mb-[-3px]">LRN:</p>
                                    <input type="number" id="inputField" maxlength="12" class="rounded-lg p-1 my-2 w-75"
                                        name="user_LRN" placeholder="LRN" id="">
                                    <script>
                                    document.getElementById("inputField").addEventListener("input", function() {
                                        var maxLength = parseInt(this.getAttribute("maxlength"));
                                        if (this.value.length > maxLength) {
                                            this.value = this.value.slice(0, maxLength);
                                        }
                                    });
                                    </script>

                                    <p class="text-xs mb-[-3px]">Firstname:</p>
                                    <input type="text" class="rounded-lg p-1 my-2 w-75" name="user_fullname"
                                        placeholder="Fullname" id="">

                                    <p class="text-xs mb-[-3px]">Middlename:</p>
                                    <input type="text" class="rounded-lg p-1 my-2 w-75" name="user_MiddleName"
                                        placeholder="Middle Name" id="">

                                    <p class="text-xs mb-[-3px]">Lastname:</p>
                                    <input type="text" class="rounded-lg p-1 my-2 w-75" name="user_LastName"
                                        placeholder="Last Name" id="">

                                    <p class="text-xs mb-[-3px]">Address:</p>
                                    <input type="text" class="rounded-lg p-1 my-2 w-75" name="user_address"
                                        placeholder="Address" id="">

                                    <p class="text-xs mb-[-3px]">Date of Birth:</p>
                                    <input type="date" class="rounded-lg p-1 my-2 w-75" name="user_birth" placeholder=""
                                        id="">
                                </div>

                                <div class="px-10">
                                    <p class="text-xs mb-[-3px]">Contact:</p>
                                    <input type="number" maxlength="11" class="rounded-lg p-1 my-2 w-75"
                                        name="user_contact" placeholder="Contact" id="inputcontact">


                                    <script>
                                    document.getElementById("inputcontact").addEventListener("input", function() {
                                        var maxLength = parseInt(this.getAttribute("maxlength"));
                                        if (this.value.length > maxLength) {
                                            this.value = this.value.slice(0, maxLength);
                                        }
                                    });
                                    </script>

                                    <input type="hidden" class="rounded-lg p-1 my-2 w-75" name="user_status"
                                        placeholder="" value="0">

                                    <p class="text-xs mb-[-3px]">Gender:</p>
                                    <select class="rounded-lg p-1 my-2 w-75" name="user_gender" id="">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>

                                    <p class="text-xs mb-[-3px]">Grade Level:</p>

                                    <select class="rounded-lg p-1 my-2 w-75" name="user_grade" id="">
                                        <option value="">Select Grade</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>

                                    <br>
                                    <p class="text-xs mb-[-3px]">Email:</p>
                                    <input type="email" class="rounded-lg p-1 my-2 w-75" name="user_email"
                                        placeholder="Email" id="">
                                    <p class="text-xs mb-[-3px]">Password:</p>
                                    <input type="password" class="rounded-lg p-1 my-2 w-75" name="user_password"
                                        placeholder="Password" id="">
                                </div>



                            </div>
                            <div>


                            </div>


                            <!-- Modal footer -->
                            <div
                                class="flex items-center md:px-10 py-3 border-t border-gray-200 rounded-b dark:border-gray-600">
                                <button type="submit" style="background-color: #DDA15E"
                                    class="rounded-lg p-2 bg-[#DDA15E] w-25" name="signup">Register</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>



        </div>

        <?php

            $result_per_page = 10; 
            $current_pages = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($current_pages - 1) * $result_per_page;
            $total_books = count($end_users->getAllUser());
            $total_pages = ceil($total_books / $result_per_page);
            $getEndUsers  = $end_users -> selectAllStudentsinAccount($result_per_page, $offset);
            ?>

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 py-10">
            <thead class="text-xs text-gray-700 uppercase bg-[#e6ccb2]  dark:text-black">
                <tr class="">
                    <th class="px-6 py-3">LRN</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Penalty</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3" style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($getEndUsers as $u) : ?>
                <tr class="hover:bg-[#f5ebe0]">
                    <td class="text-black px-6 py-4"><?= $u['user_LRN'] ?></td>
                    <td class="text-black px-6 py-4"><?= $u['user_email'] ?></td>
                    <td class="text-black px-6 py-4"><?= $u['user_fullname'] ?></td>

                    <!-- <td>
                            <?php if ($u['AllpenaltyCount'] >= 1) : ?>
                            <p class="text-danger"><?= $u['AllpenaltyCount'] ?></p>
                            <?php endif; ?>
                        </td> -->

                    <!-- <td>
                            <?php if($u['status'] == "Penalty"){ ?>
                            <?php echo $u['AllpenaltyCount']; ?>
                            <?php } ?>
                        </td> -->

                    <td class="text-black px-6 py-4">


                        <?php echo $u['AllpenaltyCount']; ?>


                    </td>



                    <td class="text-black px-6 py-4">
                        <?php if ($u['user_status'] > 0) : ?>
                        <p style="color:red">Banned</p>
                        <?php else : ?>
                        <p style="color:green">Active</p>
                        <?php endif; ?>
                    </td>
                    <td class="text-black px-6 py-4 flex gap-5 justify-center" style="width:250px">
                        <button type="submit" class="btn iconforbroow">
                            <a href="end_user_See_profile.php?user_id=<?= $u['user_id'] ?>">
                                <!-- <i class="fas fa-eye "></i> -->

                                <!-- <i class="bi bi-person-fill" style="font-size:20px;color:green"></i> -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                    <path fill-rule="evenodd"
                                        d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                        clip-rule="evenodd" />
                                </svg>

                            </a>
                        </button>
                        <button type="submit" class="btn">
                            <a href="end_user_borrowed.php?user_id=<?= $u['user_id'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path
                                        d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                                </svg>

                            </a>
                        </button>
                        <button type="submit" class="btn">
                            <a href="end_user_update.php?user_id=<?= $u['user_id'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path fill-rule="evenodd"
                                        d="m6.72 5.66 11.62 11.62A8.25 8.25 0 0 0 6.72 5.66Zm10.56 12.68L5.66 6.72a8.25 8.25 0 0 0 11.62 11.62ZM5.105 5.106c3.807-3.808 9.98-3.808 13.788 0 3.808 3.807 3.808 9.98 0 13.788-3.807 3.808-9.98 3.808-13.788 0-3.808-3.807-3.808-9.98 0-13.788Z"
                                        clip-rule="evenodd" />
                                </svg>

                            </a>
                        </button>
                        <button type="submit" class="btn">
                            <a href="end_user_delete.php?user_id=<?= $u['user_id'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path fill-rule="evenodd"
                                        d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                        clip-rule="evenodd" />
                                </svg>

                            </a>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation example" class="flex justify-center">
            <ul class="inline-flex -space-x-px text-sm">
                <?php if ($current_pages > 1): ?>
                <li>
                    <a href="?page=<?php echo $current_pages - 1; ?>"
                        class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        Previous
                    </a>
                </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($i == $current_pages) echo 'active'; ?>">
                    <a class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white <?php if ($i == $current_pages) echo 'bg-gray-200 text-gray-800'; ?>"
                        href="?page=<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
                <?php endfor; ?>

                <?php if ($current_pages < $total_pages): ?>
                <li>
                    <a href="?page=<?php echo $current_pages + 1; ?>"
                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        Next
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>


        <!-- <nav>
            <ul class="pagination">
                <?php if ($current_pages > 1): ?>
                <li class="page-item ">
                    <a class="page-link" href="?page=<?php echo $current_pages - 1; ?>">Previous</a>
                </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item  <?php if ($i == $current_pages) echo 'active'; ?>"><a class="page-link"
                        href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>

                <?php if ($current_pages < $total_pages): ?>
                <li class="page-item "><a class="page-link" href="?page=<?php echo $current_page + 1; ?>">Next</a>
                </li>
                <?php endif; ?>
            </ul>
        </nav> -->
    </div>


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
    </div>

</body>

</html>