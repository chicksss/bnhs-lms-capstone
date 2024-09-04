<?php
 ob_start();
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
    $getResult = $end_users->SeegetUser($user_id);
}



   if (isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $user_fullname = $_POST['user_fullname'];
    $user_MiddleName = $_POST['user_MiddleName'];
    $user_LastName = $_POST['user_LastName'];
    $user_LRN = $_POST['user_LRN'];
    $user_email = $_POST['user_email'];
    $user_address = $_POST['user_address'];
    $user_birth = $_POST['user_birth'];
    $user_contact = $_POST['user_contact'];
    $user_gender = $_POST['user_gender'];
    $user_grade = $_POST['user_grade'];
    

    $user = $end_users->updateUserProfile($user_id, $user_LRN, $user_fullname, $user_MiddleName, $user_LastName, $user_email,$user_address,$user_birth,$user_contact,$user_gender,$user_grade);
    header("Location: end_user_See_profile.php?user_id=" . $user_id);

}


 

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
            <h1 class="text-2xl font-bold px-3">STUDENT PROFILE</h1>
        </div>
        <div class="py-5 px-10" style="background-color:#f5ebe0">
            <form action="end_user_See_profile.php" method="POST">
                <?php if(isset($getResult)) { ?>
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <div class="grid justify-start gap-5">

                    <div class="flex justify-start gap-10">
                        <div class="grid">
                            <label for="">First Name:</label> <br>
                            <input type="text" class="rounded-lg p-1" value="<?php echo $getResult['user_fullname'] ?>"
                                placeholder="Name" name="user_fullname" id="">
                        </div>

                        <div class="grid">
                            <label for="">Middle Name:</label><br>
                            <input type="text" class="rounded-lg p-1"
                                value="<?php echo $getResult['user_MiddleName'] ?>" placeholder="Middle Name"
                                name="user_MiddleName" id="">
                        </div>
                        <div class="grid">
                            <label for="">Last Name:</label><br>
                            <input type="text" class="rounded-lg p-1" value="<?php echo $getResult['user_LastName'] ?>"
                                placeholder="Last Name" name="user_LastName" id="">

                            <hr>
                        </div>

                    </div>


                    <div class="flex justify-start gap-10">
                        <div class="grid">
                            <label for="">Email</label>
                            <input type="email" class="rounded-lg p-1" value="<?php echo $getResult['user_email'] ?>"
                                placeholder="Name" name="user_email" id="">
                        </div>

                        <div class="grid">
                            <label for="">Address</label>
                            <input type="text" class="rounded-lg p-1" value="<?php echo $getResult['user_address'] ?>"
                                placeholder="Name" name="user_address" id="">
                        </div>
                        <div class="grid">
                            <label for="">Birthday</label>
                            <input type="date" class="rounded-lg p-1" value="<?php echo $getResult['user_birth'] ?>"
                                placeholder="Name" name="user_birth" id="">

                            <hr>
                        </div>

                    </div>

                    <div class="flex justify-start gap-10">
                        <div class="grid">
                            <label for="">Contact</label>
                            <input type="number" class="rounded-lg p-1" value="<?php echo $getResult['user_contact'] ?>"
                                placeholder="contact" name="user_contact" id="">
                        </div>

                        <div class="grid">
                            <label for="">Gender</label>
                            <select class="rounded-lg p-1" name="user_gender" aria-label="Default select example"
                                required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="grid">
                            <label for="">LRN</label>
                            <input type="text" class="rounded-lg p-1" value="<?php echo $getResult['user_LRN'] ?>"
                                placeholder="Grade" name="user_LRN" id="">
                            <hr>
                        </div>

                    </div>


                    <div class="flex justify-start gap-10">
                        <div class="grid">

                            <label for="">Grade</label>
                            <input type="number" class="rounded-lg p-1" value="<?php echo $getResult['user_grade'] ?>"
                                placeholder="Grade" name="user_grade" id="">

                        </div>

                        <div class="grid">
                            <label for="">Password</label>
                            <input type="password" class="rounded-lg p-1"
                                value="<?php echo $getResult['user_password'] ?>" placeholder="contact"
                                name="user_password" id="" disabled>
                        </div>


                    </div>







                </div>

                <div class="flex justify-start" style="margin-top:20px">
                    <button type="submit" style="background-color:#d5bdaf; color:black" name="update"
                        class="rounded-lg px-6 py-2">Update</button>

                </div>


                <?php } ?>


            </form>

        </div>
    </div>



</body>

</html>