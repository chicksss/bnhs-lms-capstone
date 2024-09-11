<?php

 session_start();
 include "../dashdesign.php";
require "../AUTHORS/author_db.php";
require "../AUTHORS/authors_engine.php";

$myAuthors = new authorsBook();

if(isset($_POST['addAuthor'])){
   $author_name = $_POST['author_name'];
   $add = $myAuthors->AddNewAuthors($author_name);
   header("Location: ../BOOKS/admin_authors.php");
} 
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
            <h1 class="text-2xl font-bold px-3">AUTHORS</h1>
        </div>

        <div class="flex justify-between px-10">

            <div>
                <form action="admin_authors.php" method="POST">
                    <input type="text" class="rounded-lg p-1" name="author_name" placeholder="New Author">
                    <button type="submit" class="px-3 p-1 rounded-lg" style="background: #dda15e; color:black"
                        name="addAuthor">Add</button>
                </form>
            </div>
            <div>

                <input type="text" class="rounded-lg p-1" id="myInput" onkeyup="myFunction()"
                    placeholder="Search for Authors.." title="Type Author">

            </div>
        </div>

        <div class="px-10">

            <?php
                    // Pagination Parameters
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $limit = 10; // Number of authors per page
                    $start = ($page - 1) * $limit;

                    // Fetch authors for the current page
                    $authors = $myAuthors->getAuthorsWithLimit($start, $limit); // Modify this function according to your implementation

                    // Total number of authors
                    $totalAuthors = $myAuthors->getTotalAuthors(); // Modify this function according to your implementation

                    // Calculate total pages
                    $totalPages = ceil($totalAuthors / $limit);
                    ?>


            <div class=" py-2">
                <table class="w-full">
                    <thead class="bg-[#d5bdaf] text-left">
                        <tr class="p-2">
                            <th class="px-6 py-2">Authors</th>
                            <th class="px-6 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($authors as $a): ?>
                        <tr class="hover:bg-[#e3d5ca]">
                            <td class="px-6 py-2"><?php echo $a['author_name']; ?></td>
                            <td class="flex">
                                <a href="../AUTHORS/update_authors.php?id=<?php echo $a['id']; ?>"
                                    style="margin-right:20px">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                    </svg>

                                </a>
                                <!-- <a href="../AUTHORS/author_delete.php?id=<?php echo $a['id']; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>

                                </a> -->
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="grid justify-center">
                <nav aria-label="Page navigation example">
                    <ul class="inline-flex -space-x-px text-sm">
                        <li>
                            <a href="?page=<?php echo ($page > 1) ? $page - 1 : 1; ?>"
                                class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white <?php echo ($page <= 1) ? 'opacity-50 cursor-not-allowed' : ''; ?>"
                                aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li>
                            <a href="?page=<?php echo $i; ?>"
                                class="flex items-center justify-center px-3 h-8 leading-tight <?php echo ($i == $page) ? 'text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white' : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                        <?php endfor; ?>

                        <li>
                            <a href="?page=<?php echo ($page < $totalPages) ? $page + 1 : $totalPages; ?>"
                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white <?php echo ($page >= $totalPages) ? 'opacity-50 cursor-not-allowed' : ''; ?>"
                                aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>




            <!-- <nav>
                <ul class="pagination ">
                    <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>">Previous</a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>"
                        <?php if ($i == $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?>
                    <a href="?page=<?php echo $page + 1; ?>">Next</a>
                    <?php endif; ?>
                </ul>
            </nav> -->







        </div>




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