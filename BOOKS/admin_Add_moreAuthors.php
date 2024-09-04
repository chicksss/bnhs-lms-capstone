<?php
ob_start();
require_once "../DATABASE/book_catalog_db.php";
require_once "book_catalog_engine.php";

require_once "../AUTHORS/author_db.php";
require_once "../AUTHORS/authors_engine.php";
$myAuthors = new authorsBook();
$tables = [];

session_start();
 include "../dashdesign.php";
$crud = new CRUD();

$join = $crud->InnerJoinBook();
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
            <h1 class="text-2xl font-bold px-3">BOOK AUTHORS</h1>
        </div>
        <div class="flex justify-between px-10 py-2">
            <div class="">
                <select class="rounded-lg px-5 p-1" name="category_id" onchange="window.location.href=this.value">
                    <option value="">Select a Category</option>
                    <option value="admin_Add_moreAuthors.php"> All Books </option>
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
            <!-- <div class="">
                <ul class="info-list">
                    <li style="margin-top:10px">


                        <br>
                        <?php if(isset($_GET['id'])){ ?>
                            <?php 
                    $categoryId = $_GET['id'];
                    $bookTotal = $crud->getTotalBooks($categoryId); 
                  ?>
                            Total Book: <?php echo $bookTotal; ?>
                            <?php } ?>
                    </li>




                </ul>
            </div> -->

            <div class="">
                <input type="text" class="rounded-lg px-5 p-1" id="myInput" onkeyup="myFunction()"
                    placeholder="Search for books.." title="Type Author">
            </div>






        </div>
        <div class="row"
            style="background-color:white; margin-top:10px; width: 68.7rem; padding:10px; margin-left:20px">


            <?php
                                $id = isset($_GET['id']) ? $_GET['id'] : null; // Handle the case when 'id' is not set
                                if ($id !== null) {
                                    $result = $myAuthors->selectBooksByAuthorId($id);      
                                    if (!empty($result)) {
                                        ?>
            <table class="p-2 text-left w-full" style="">
                <caption class="p-2 text-left">
                    Category: &nbsp; &nbsp; &nbsp; &nbsp;
                    <?php if(isset($_GET['id'])){ ?>
                    <?php 
                                                    $bookCat = $_GET['id'];
                                                    $getCategory = $crud->getCat($bookCat);
                                                ?>
                    <?php echo   $getCategory  ?>
                    <?php } else {?>


                    <?php   }?>

                </caption>
                <thead class="">
                    <tr class="bg-[#d5bdaf] ">
                        <th class="px-6 p-2">Title</th>
                        <th class="px-6 p-2">Add</th>
                    </tr>

                    <?php if (!empty($result)) : ?>
                    <?php foreach ($result as $book) : ?>
                <tbody class="hover:hover:bg-[#e3d5ca]">
                    <tr>
                        <td class="px-6 p-2"><?php echo htmlspecialchars($book['title']); ?></td>

                        <td class="px-6 p-2">
                            <a href="add_more_authors.php?id=<?php echo $book['id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>

                            </a>
                        </td>
                    </tr>
                </tbody>

                <?php endforeach; ?>
                <?php else : ?>
                <tr>
                    <td colspan="2">No books found for the selected category.</td>
                </tr>
                <?php endif; ?>
                </tbody>
            </table>
            <?php } else { ?>
            <p>No books found for the selected category.</p>
            <?php } ?>
            <?php } else { ?>

            <?php
                                
                                $results_per_page = 10; 
                                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                                $offset = ($current_page - 1) * $results_per_page;

                                $total_books = count($crud->SelectAllAuthors());
                                $total_pages = ceil($total_books / $results_per_page);

                                
                                $Allresult = $crud->SelectAllAuthorsWithLimit($results_per_page, $offset);

                                
                                ?>

            <table class="p-2 text-left w-full" style="">
                <caption class="p-2 text-left">All Books</caption>
                <thead class="bg-[#d5bdaf]">
                    <tr>
                        <th class="px-6 p-2">Title</th>
                        <th class="px-6 p-2">Add</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($Allresult as $book) : ?>
                    <tr class="hover:bg-[#e3d5ca]">
                        <td class="px-6 p-2"><?php echo htmlspecialchars($book['title']); ?></td>
                        <td class="px-6 p-2">
                            <a href="add_more_authors.php?id=<?php echo $book['id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                </i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>



        <div class="flex justify-center py-10">
        <nav aria-label="Page navigation example">
                <ul class="inline-flex -space-x-px text-sm">
                    <?php if ($current_page > 1): ?>
                    <li>
                        <a href="?page=<?php echo $current_page - 1; ?>"
                            class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                    </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li>
                        <a href="?page=<?php echo $i; ?>"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    <?php if ($current_page < $total_pages): ?>
                    <li>
                        <a href="?page=<?php echo $current_page + 1; ?>"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>









            <?php } ?>



            <script>
            function myFunction() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementsByTagName("table")[0];
                tr = table.getElementsByTagName("tr");

                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[0];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
                    }
                }
            }
            </script>




        </div>
    </div>

</body>

</html>