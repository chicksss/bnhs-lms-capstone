<?php
 
require_once "../DATABASE/book_catalog_db.php";
require_once "../BOOKS/book_catalog_engine.php";


$tables = [];

session_start();

 include "../dashdesign.php";


$crud = new CRUD();

$archive = $crud->InnerJoinBookArchive();
 

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
            <h1 class="text-2xl font-bold px-3">REPORT (Archive)</h1>
        </div>


        <div class="py-5">

            <button class="px-6 py-2" style="background-color: #dda15e; color: black"><a
                    href="book_archivedReceipt.php">Generate
                    Report &nbsp; <i class="fi-rr-blog-pencil"></i></a></button>
        </div>


        <div class="py-2">
            <table class="w-full text-sm text-left">
                <thead class="bg-[#d5bdaf] text-xs p-1 ">
                    <tr>

                        <th class="px-6 py-2">Title</th>

                    </tr>
                </thead>

                <tbody>
                    <?php   foreach ($archive as $a): ?>
                    <tr class="hover:bg-[#e3d5ca]">
                        <td class="px-2 py-2 "> <?php echo $a['archive_book_title']; ?></td>




                    </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

    </div>

</body>

</html>