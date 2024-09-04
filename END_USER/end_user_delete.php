<?php

ob_start();
session_start();
require_once "end_user_db.php";
require_once "end_user_engine.php";
include "../dashdesign.php";


 
$end_users = new END_USERS();
 

 
if(isset($_GET['user_id'])){
    $user_id = $_GET['user_id'];    
    $user = $end_users->getEndUser_Id($user_id);
}


if (isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $user = $end_users->deleteUser($user_id);
    header ("Location: end_user_list.php");
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
            <h1 class="text-2xl font-bold px-3">STUDENT DELETE</h1>
        </div>

        <div class="grid justify-center mt-24">
            <h1>Delete student account?</h1>

            <form action="end_user_delete.php" method="POST" style="text-align:center">
                <?php if(isset($user)) { ?>
                <!-- <input type="hidden" name="user_id" value="<?php echo $user_id; ?>"> -->
                <input type="hidden" class="form-control" value="<?php echo $user['user_id'] ?>" placeholder="ID"
                    name="user_id" id="">

                <?php } ?>
                <button type="submit" name="update" class="rounded-lg px-3 py-2 "
                    style="background: #dda15e">Delete</button>
            </form>
        </div>











    </div>
</body>


</html>