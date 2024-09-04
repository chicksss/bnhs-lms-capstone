<?php
ob_start();
require_once "../DATABASE/book_catalog_db.php";
require_once "book_catalog_engine.php";
$tables = [];

session_start();
include "../dashdesign.php";
$crud = new CRUD();

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = $crud->selectUpdateBookCopy($id);
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $crud->DeletecopiesBooks($id);
    header("Location: admin_AddCopies_Book.php");
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

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

</head>

<body>

    <div class="ml-52 p-2">
    <div class="absolute mt-[-55px]">
            <h1 class="text-2xl font-bold px-3">BOOK COPIES DELETE</h1>
        </div>
        <div class="grid justify-center text-center">
            <?php if($result){ ?>
            <h6 class="text-2xl ">DELETE THIS COPY?</h6>
            <form method="POST" action="book_CopiesDelete.php">
                <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                <button type="submit" class="rounded-lg px-5 py-2" style="background-color: #DDA15E" name="delete"
                    value="Update">Delete</button>
            </form>

            <?php  }?>
        </div>
    </div>

</body>

</html>