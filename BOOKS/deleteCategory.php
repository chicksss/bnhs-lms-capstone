<?php
ob_start();

 // require "../dashdesign.php";
require_once "../DATABASE/book_catalog_db.php";
require_once "book_catalog_engine.php";




$tables = [];
$crud = new CRUD(); 
include_once "../dashdesign.php";

 if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $result = $crud->selectCategory($id);
 }


if(isset($_POST['deleteCat'])){
    $id = intval($_POST['id']);
    $crud->deleteCategory($id);
    header("Location: admin_book_home.php");
    exit(); 
}

ob_end_flush(); // Flush the output buffer and turn off output buffering
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />


    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>

    <!-- font -->

    <title>Document</title>
</head>

<body>

    <div class="ml-52 p-2 px-5">
        <?php if($result){ ?>

        <form method="POST" action="deleteCategory.php">
            <h5 class="text-2xl text-center ">Delete Category?</h5>
            <div class="form-group flex grid-cols-1 justify-center py-2">
                <input type="hidden" name="id" value="<?= htmlspecialchars($result['id']); ?>">
                <button type="submit" class="p-2 rounded-lg bg-[#DDA15E]" style="background-color: #DDA15E"
                    name="deleteCat" value="Create Section">
                    Delete </button>
            </div>
        </form>

        <?php } ?>

    </div>

</body>

</html>