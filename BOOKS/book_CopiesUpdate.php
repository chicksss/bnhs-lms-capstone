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
if (isset($_POST['updateCopies'])) {
    $id = $_POST['id'];
    $statusPerCopy = $_POST['statusPerCopy'];
    $book_call_number = $_POST['book_call_number'];
    $crud->UpdatecopiesBooks($id,$statusPerCopy,$book_call_number);
 
    header("Location: admin_AddCopies_Book.php");

    exit; 
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
            <h1 class="text-2xl font-bold px-3">BOOK COPIES UPDATE</h1>
        </div>
        <div class="flex justify-start gap-10">

            <?php if($result){ ?>
            <div>
                <div class="p-2 rounded-lg bg-[#d5bdaf] ">
                    <p class="w-[200px] truncate hover:text-clip">Book: <?php echo $result['title']?></p>
                </div>

                <img src="../BOOKS/book/<?php echo $result['image']; ?>" title="<?php echo $result['image']; ?>"
                    class="h-[450px] w-[350px] rounded-lg shadow-lg py-2">
            </div>

            <div>
                <div class="p-2 rounded-lg bg-[#d5bdaf]">
                    <b>Update Copies:</b>
                </div>

                <form method="POST" action="book_CopiesUpdate.php">
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                    <div class="grid py-2">
                        <!-- <input type="hidden" class="form-control" placeholder="Enter Book Copies" name="no_of_copies"
                            id="copies" value="1" required> -->
                        <label for="Status" style="color:black">Accession Number</label>
                        <input type="text" class="p-2 rounded-lg py-2" placeholder="Enter Book Copies"
                            name="book_call_number" id="copies" value="<?php echo $result['book_call_number'] ?>"
                            required>
                        <label for="Status" style="color:black">Status</label>
                        <select class="p-2 py-2 rounded-lg" name="statusPerCopy" id="">
                            <option value="Available">Available</option>
                            <option value="Not Available">Not Available</option>
                        </select>
                    </div>
                    <button type="submit" class="py-2 p-2 rounded-lg" style="background-color: #DDA15E"
                        name="updateCopies" value="Update">Update </button>
                </form>
            </div>

            <?php  }?>
        </div>

    </div>

</body>

</html>