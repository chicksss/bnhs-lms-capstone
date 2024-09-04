<?php
  ob_start();
require_once "../DATABASE/book_catalog_db.php";
require_once "book_catalog_engine.php";
 
session_start();
 include "../dashdesign.php";
$crud = new CRUD();

 


if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = $crud->SelectBooktoArchive($id);
}

if (isset($_POST['archive'])) {
    $bookId = $_POST['id'];
    $archive_book_title = $_POST['archive_book_title'];
    $archive = $crud->DeleteBook($bookId);
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
            <h1 class="text-2xl font-bold px-3">MOVE TO ARCHIVE</h1>
        </div>

        <div class="flex justify-start gap-10 px-10">
            <div>
                <div class="grid justify-center">
                    <h1 class="font-bold">Move this book in archive?</h1>
                    <?php if ($result){ ?>

                    <p><?php echo $result['title'] ?></p>
                    <form action="book_archive.php" method="post">
                        <!-- <input type="hidden" name="id" value="<?php echo $result['id']; ?>"> -->
                        <!-- <label style="font-weight: 900" for="status">Book ID</label> -->
                        <input type="hidden" name="id" value="<?php echo $result['id'] ?>" id="">
                        <input type="hidden" name="archive_book_title" value=" <?php echo $result['title']; ?>">

                        <!-- <input type="submit" name="archive" value="Add to archive"> -->
                        <br>
                        <button type="submit" class="rounded-lg px-5 p-1 " style="background:#dda15e" name="archive">
                            Yes</button>


                    </form>
                    <?php } ?>
                </div>
            </div>
            <?php if ($result){ ?>
            <div>
                <b></b>
            </div>
            <img src="../BOOKS/book/<?php echo $result['image']; ?>" title="<?php echo $result['image']; ?>"
                class="h-[450px] w-[350px] rounded-lg shadow-lg py-2">
            <?php } ?>
            <div>

            </div>
        </div>

    </div>
</body>

</html>