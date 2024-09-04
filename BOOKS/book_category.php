<?php

 
require_once "../DATABASE/book_catalog_db.php";
require_once "book_catalog_engine.php";

 session_start();

  include "../dashdesign.php";
 $crud = new CRUD();
 
 $bookList = $crud->bookCateory();


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
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


</head>

<body>

    <div class="ml-52">
        <div class="absolute mt-[-40px]">
            <h1 class="text-2xl font-bold px-3">MOST AND LEAST BORROWED BOOK</h1>
        </div>

        <div class="px-10">
            <select class="rounded-lg p-1" style="width:550px; margin-top: 9px" name="category_id"
                onchange="window.location.href=this.value">
                <option value="">Select a Category</option>
                <?php 
                                $tables = $crud->selectAllCategory();
                                foreach ($tables as $table): 
                            ?>
                <option value="?id=<?php echo $table['id']; ?>">
                    <?php echo $table['category']; ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <?php
 
                if (isset($_GET['id'])) {
                    $selectedBook = $_GET['id'];
            $checkbook = $crud->selectedBookCategory($selectedBook);

            if (count($checkbook) > 0) {
                    ?>
        <?php
                    $book = $crud->selectedBookCategory($selectedBook);
                    if (count($book) > 0) {
                    ?>
        <?php foreach ($book as $row) { ?>
        <div class="px-10 py-5">
            <h1>Most Borrowed Books</h1>
            <div class="flex justify-items-stretch gap-10 py-5">
                <div>
                    <img src="../BOOKS/book/<?= $row['image']; ?>" title="<?= $row['image']; ?>" class="w-60">
                </div>
                <div>
                    <div class="grid">
                        <h5 class="font-bold text-2xl py-2">
                            <?php echo $row['title'] ?></h5>
                        <p class="text-justify w-[780px] py-2">
                            <?php echo $row['synopsis'] ?>
                        </p>
                        <b class="py-2">This Edition:</b>
                        <div class="flex justify-start gap-10">
                            <div>
                                <p>ISBN: </p>
                                <p>Publisher:</p>
                                <p>Date Published:</p>
                            </div>
                            <div>
                                <p><?php echo $row['book_isbn'] ?> </p>
                                <p> <?php echo $row['publisher'] ?></p>
                                <p> <?php echo $row['book_date_published'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php }
                } else { ?>
        <span> There are no most borrowed books.</span>
        <?php    }  }   ?>


        <div class="px-10">
            <h1>Least Borrowed Books</h1>
            <?php if(isset($_GET['id'])){ 
                      $selectedBook = $_GET['id'];
                ?>
            <?php 
                $book = $crud->leastBorrowedBook($selectedBook); ?>
            <?php
                    if(count($book)>0){ ?>
            <?php array_shift($book); ?>

            <div class="flex flex-wrap py-2 gap-10">
                <?php foreach ($book as $row) { ?>
                <div>
                    <img src="../BOOKS/book/<?= $row['image']; ?>" title="<?= $row['image']; ?>" class="w-24">
                </div>
                <?php } ?>
            </div>


            <?php }else{ ?>

            <span> There are no least borrowed books.</span>
            <?php } 
                }?>
        </div>

    </div>


</body>

</html>