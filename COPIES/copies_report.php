<?php
 
require_once "../DATABASE/book_catalog_db.php";
require_once "../BOOKS/book_catalog_engine.php";

$tables = [];

session_start();

 include "../dashdesign.php";
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
            <h1 class="text-2xl font-bold px-3">REPORT (Copies)</h1>
        </div>

        <div class="flex justify-start py-5 px-12 gap-5">
            <div>
                <button id="dropdownUsersButton" data-dropdown-toggle="dropdownUsers" data-dropdown-placement="bottom"
                    class="text-black bg-[#d5bdaf]  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center  dark:focus:ring-blue-800">Category
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>

                <div id="dropdownUsers" class="z-10 hidden bg-white rounded-lg shadow w-60">
                    <ul class="h-48 py-2  overflow-y-auto text-gray-700 dark:text-gray-200 p-2"
                        aria-labelledby="dropdownUsersButton">
                        <li>
                            <?php 
                    $tables = $crud->selectAllCategory(); ?>

                            <?php   foreach ($tables as $table): ?>

                        <li class="p-1 hover:bg-[#e6ccb2]">
                            <a class="text-start no-underline " style="color:black"
                                href="?id=<?php echo $table['id']; ?>">
                                <p class="title_book"> <?php echo $table['category']; ?> </p>
                            </a>

                        </li>
                        <?php endforeach; ?>
                        </li>

                    </ul>

                </div>
            </div>
            <div>
                <?php
                    $id = isset($_GET['id']) ? $_GET['id'] : null;

                    if ($id !== null) {
                        $result = $crud->selectedBooks($id);
                        ?>
                <button class="px-4 py-2 rounded-lg" style="background-color: #d5bdaf; color:black">

                    <a href="copies_receipt.php?id=<?php echo $id; ?>">Generate
                        report &nbsp; <i class="fi-rr-blog-pencil"></i></a>
                </button>
                <?php
                    }  
                    ?>
            </div>

        </div>

        <div>
            <?php
                $id = isset($_GET['id']) ? $_GET['id'] : null;

                if ($id !== null) {
                    $result = $crud->selectedBooks($id);
                    
                    ?>

            <!-- <button type="submit" class="btn"><a href="receipt.php?id=<?php echo $id; ?>">Generate
                                    report</a></button> -->
            <?php

                    if (!empty($result)) {
                        
                    ?>



            <?php if(isset($_GET['id'])){ ?>
            <?php 
                    $categoryId = $_GET['id'];
                    $bookTotal = $crud->getTotalBooks($categoryId); 
                    
                  ?>

            <?php } ?>
            <div>

                <?php if(isset($_GET['id'])){ ?>
                <?php 
                    $bookCat = $_GET['id'];
                    $getCategory = $crud->getCat($bookCat);
                  ?>
                <b>Category:&nbsp;&nbsp; <?php echo $getCategory; ?> </b>
                <?php } else {?>


                <?php
                    if (isset($_GET['id'])) {
                        $categoryId = $_GET['id'];
                        $books = $crud->selectedBooks($categoryId);

                        // Initialize total copies
                        $totalCPS = 0;

                        foreach ($books as $book) {
                            // Add the total copies for each book to the overall total
                            $totalCPS += $book['totalCPS'];
                        }
                    }
                ?>

                <label for="">
                    Total Copies: <b> <?php echo $totalCPS; ?> </b>
                </label>

            </div>






            <?php   }?>



            <table class="w-full text-sm text-left ">
                <thead class="bg-[#d5bdaf] text-xs p-1 ">
                    <tr>
                        <th class="px-6 py-2">Title</th>

                        <th>Copies</th>

                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($result as $j): ?>
                    <tr class="hover:bg-[#e3d5ca]">
                        <td class="px-2 py-2 ">
                            <p class="title_book"> <?php echo $j['title']; ?> </p>
                        </td>
                        <!-- <td><?php echo $j['totalCPS']; ?></td> -->

                        <td><?php echo $j['totalCPS']; ?></td>


                        <!-- <td>
                        <a href="book_AddCopies.php?id=<?php echo $j['id']; ?>"><i class="fa-solid fa-plus" style="color: #2d75f0;"></i></a>
                    </td> -->
                        <td></td> <!-- Add any additional columns if needed -->
                    </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
            <!-- <?php if(isset($_GET['id'])){ ?>
            <?php 
                    $categoryId = $_GET['id'];
                    $bookTotal = $crud->getTotalBooks($categoryId); 
                   
                  ?>
            <label for="">
                Total book in <b> <?php echo $getCategory ?> </b> : <?php  echo $bookTotal; ?>
            </label>
            <?php } ?> -->










            <?php

                            
            
                        } else {
                            echo "<p>No books found for the selected category.</p>";
                        }
                    } else {
                        echo "<p>Select category</p>";
                    }
                    ?>

        </div>



    </div>

</body>

</html>