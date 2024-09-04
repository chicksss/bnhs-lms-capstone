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
    $user_status = $_POST['user_status'];
    $user = $end_users->bannedUser($user_id,$user_status);
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
            <h1 class="text-2xl font-bold px-3">STUDENT STATUS</h1>
        </div>
        <div class="container" style="background-color:white; padding:30px">
            <form action="end_user_update.php" method="POST">
                <?php if(isset($user)) { ?>
                <!-- <input type="hidden" name="user_id" value="<?php echo $user_id; ?>"> -->
                <div class="flex justify-center gap-10">

                    <div class="col">

                        <input type="hidden" class="rounded-lg" value="<?php echo $user['user_id'] ?>"
                            placeholder="ID" name="user_id" id="">
                        <label for="">Name</label>
                        <input type="text"  class="rounded-lg font-medium" value="<?php echo $user['user_fullname'] ?>"
                            placeholder="Name" name="user_fullname" id="">
                    </div>

                    <div class="col">
                        <label for=""> Update status?</label>
                        <select c class="rounded-lg font-medium"  name="user_status" aria-label="Default select example">
                            <option value="0">Active</option>
                            <option value="1">Banned</option>

                        </select>
                    </div>

                    <?php } ?>

                </div>


                <br>


                <div class="flex justify-center">
                <button type="submit" name="update" class="rounded-lg px-3 py-2 " style="background: #dda15e">Ban</button>


                </div>
                


            </form>

        </div>

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