<?php
 

$tables = [];

session_start();
 include "../dashdesign.php";
 
require_once "../DATABASE/book_catalog_db.php";
require_once "../BOOKS/book_catalog_engine.php";



$crud = new CRUD();

$join = $crud->InnerJoinBook();
 

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
        <div class="mt-[-50px]">
            <h1 class="text-2xl font-bold px-3">REPORT (Books)</h1>
        </div>

        <div class="py-5">

            <button class="px-6 py-2" style="background-color: #dda15e; color: black"><a href="receipt.php">Generate
                    Report &nbsp; <i class="fi-rr-blog-pencil"></i></a></button>


        </div>


        <div>
            <?php 
                $ttoal = $crud->CountAllBookReport();
                if ($ttoal){
                 ?>
            <b>Total Books: <?php echo $ttoal['TOTALId']; ?> </b>
            <?php } ?>
        </div>


        <div class="py-2">
            <table class="w-full text-sm text-left">
                <thead class="bg-[#d5bdaf] text-xs p-1">
                    <tr>
                        <th class="px-6 py-2">
                            Book
                        </th>

                        <th>
                            Author
                        </th>
                        <th>
                            Publisher
                        </th>
                        <th>
                            ISBN
                        </th>
                </thead>

                <tbody>
                    <?php
                    $books = $crud->getAllBookReport();
                     foreach($books as $b): ?>
                    <tr class="hover:bg-[#e3d5ca]">
                        <td class="px-2 py-2 ">
                            <?php echo $b['title'] ?>
                        </td>

                        <td>
                            <?php echo $b['author_name'] ?>
                        </td>

                        

                        <td>
                            <?php echo $b['publisher'] ?>
                        </td>

                        <td>
                            <?php echo $b['book_isbn'] ?>
                        </td>


                    </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>

        </div>

    </div>

</body>

</html>