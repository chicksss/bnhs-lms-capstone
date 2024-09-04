<?php
 
require_once "../DATABASE/book_catalog_db.php";
require_once "book_catalog_engine.php";

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

    <div class="ml-52 p-2 ">
        <div class="absolute mt-[-50px]">
            <h1 class="text-2xl font-bold px-3">LIST OF BOOKS</h1>
        </div>
        <div class="flex justify-between px-10 py-2">
            <div> <select class="rounded-lg p-1" name="category_id" onchange="window.location.href=this.value">
                    <option value="">Select a Category</option>
                    <option value="admin_bookList.php">All Books</option>
                    <?php 
                                $tables = $crud->selectAllCategory();
                                foreach ($tables as $table): 
                            ?>
                    <option value="?id=<?php echo $table['id']; ?>">
                        <?php echo $table['category']; ?>
                    </option>
                    <?php endforeach; ?>
                </select></div>
            <div>
                <input type="text" class="rounded-lg p-1" id="myInput" onkeyup="myFunction()"
                    placeholder="Search for books.." title="Type Author">
            </div>
        </div>


        <div class="px-10">
            <?php
 
                $recordsPerPage = 7;
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $recordsPerPage; 
                $id = isset($_GET['id']) ? $_GET['id'] : null;
                if ($id !== null) {
                    $totalRecords = $crud->countBooks($id);  
                    $totalPages = ceil($totalRecords / $recordsPerPage);
                    $result = $crud->selectedBooksS($id, $offset, $recordsPerPage); // Modify your selectedBooks method to accept offset and limit
                ?>
            <!-- <button type="submit" class="btn"><a href="receipt.php?id=<?php echo $id; ?>">Generate report</a></button> -->

            <?php if (!empty($result)) { ?>

            <table class="w-full">
                <caption class="p-2 text-left">
                    Category: &nbsp; &nbsp; &nbsp; &nbsp;
                    <?php if (isset($_GET['id'])) { ?>
                    <?php 
                $bookCat = $_GET['id'];
                $getCategory = $crud->getCat($bookCat);
                echo $getCategory;
                ?>
                    <?php } ?>
                </caption>
                <thead class="bg-[#d5bdaf] p-2 text-left">
                    <tr>
                        <th class="px-6 py-2">Title</th>
                        <th class="px-6 py-2">Copies</th>
                        <th class="px-6 py-2">Total</th>
                        <th class="px-6 py-2">Status</th>
                        <th class="px-6 py-2">Action</th>

                    </tr>
                </thead>
            
               
                <tbody>
                    <?php foreach ($result as $j): ?>
                    <tr class="hover:bg-[#e3d5ca] ">
                        <td class="px-6 py-2">
                            <p class="title_book"><?php echo $j['title']; ?></p>
                        </td class="px-6 py-2">
                        <td class="px-6 py-2"><?php echo $j['totalAvailableCPS']; ?> </td>

                        <td class="px-6 py-2"><?php echo $j['totalCPS']; ?> </td>

                        <td class="px-6 py-2">
                            <?php if($j['totalAvailableCPS'] > 0){ ?>
                            <p>Available</p>

                        </td>

                        <?php  } else{ ?>
                        <p>Not Available</p>
                        <?php } ?>
                        <td class="flex px-2 py-2">
                            <a href="update_Books.php?id=<?php echo $j['id']; ?>" style="margin-right:20px"><svg
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg>
                            </a>
                            <a href="book_archive.php?id=<?php echo $j['id']; ?>"><svg
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </a>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
                        
            </table>

            <!-- Pagination controls -->

       <div class="flex justify-center py-10">
       <nav aria-label="Page navigation example">
                <ul class="inline-flex -space-x-px text-sm">
                    <?php if ($page > 1): ?>
                    <li>
                        <a href="?id=<?php echo $id; ?>&page=<?php echo $page - 1; ?>"
                            class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                    </li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li>
                        <a href="?id=<?php echo $id; ?>&page=<?php echo $i; ?>"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                    <li>
                        <a href="?id=<?php echo $id; ?>&page=<?php echo $page + 1; ?>"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                    </li>
                    <?php endif; ?>
                </ul>

            </nav>
       </div>


            <?php
    } else {
        echo "<p>No books found for the selected category.</p>";
    }
} else { ?>
            <div class="overflow-y-auto h-[500px]">
            <table class="table-auto w-full">
                <caption class="p-2 text-left">
                    All Books
                </caption>
                <thead class="bg-[#d5bdaf] p-2 text-left">
                    <tr>
                        <th class="px-6 py-2">Title</th>
                        <th class="px-6 py-2">Copies</th>
                        <th class="px-6 py-2">Total</th>
                        <th class="px-6 py-2">Status</th>
                        <th class="px-6 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $Allresult = $crud->Alllistofthebook();
                    foreach ($Allresult as $j): ?>
                    
                    <tr class="hover:bg-[#e3d5ca]">
                        <td class="px-6 py-2">
                            <p class="title_book"><?php echo $j['title']; ?></p>
                        </td>
                        <td class="px-6 py-2"><?php echo $j['totalAvailableCPS']; ?> </td>

                        <td class="px-6 py-2"><?php echo $j['totalCPS']; ?> </td>

                        <td class="px-6 py-2">
                            <?php if($j['totalAvailableCPS'] > 0){ ?>
                            <p>Available</p>

                        </td>

                        <?php  } else{ ?>
                        <p>Not Available</p>
                        <?php } ?>
                        <td class="px-6 py-2 flex">
                            <a href="update_Books.php?id=<?php echo $j['id']; ?>" style="margin-right:20px">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg></a>
                            <a href="book_archive.php?id=<?php echo $j['id']; ?>">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>


                            </a>
                        </td>
                    </tr>
                 
                  
                    <?php endforeach; ?>
                </tbody>
            </table>
                        </div>
            <?php }
?>






            <script>
            function myFunction() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementsByTagName("table")[0];
                tr = table.getElementsByTagName("tr");

                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[
                        0]; // Assuming you want to filter based on the first column (title)
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
            </script>


        </div>


    </div>

</body>

</html>