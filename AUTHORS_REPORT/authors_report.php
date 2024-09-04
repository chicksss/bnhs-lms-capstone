<?php
session_start();
 
 include "../dashdesign.php";
 
require "../AUTHORS/author_db.php";
require "../AUTHORS/authors_engine.php";
 

$myAuthors = new authorsBook();

  
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
            <h1 class="text-2xl font-bold px-3">REPORT (Authors)</h1>
        </div>

        <div class="py-5">

            <button class="px-6 py-2" style="background-color: #dda15e; color: black"><a href="authors_receipt.php">Generate
                    Report &nbsp; <i class="fi-rr-blog-pencil"></i></a></button>


        </div>
        <div>
            <caption>
                Total Authors:
                <?php $resAuthor = $myAuthors->GetAllAuthorsCount();?>
                <?php if($resAuthor){ ?>
                <?php  echo $resAuthor['totalAuthorsnumber']; ?>
                <?php  } ?>
            </caption>
        </div>
        <div class="py-2 overflow-y-auto h-[500px]">
            <table class="w-full text-sm text-left ">
                <thead class="bg-[#d5bdaf] text-xs p-1 ">
                    <tr>
                        <th class="px-6 py-2">
                            Authors
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                   
                    $authors = $myAuthors->getAllAuthors();
                    foreach($authors as $a): ?>
                    <tr class="hover:bg-[#e3d5ca]">
                        <td class="px-2 py-2 ">
                            <?php echo $a['author_name']; ?>
                        </td>

                    </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>