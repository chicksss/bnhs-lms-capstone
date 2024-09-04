<?php
 
require_once "../DATABASE/book_catalog_db.php";
require_once "book_catalog_engine.php";




$tables = [];

session_start();
include "../dashdesign.php";
$crud = new CRUD();

$join = $crud->InnerJoinBook();

// if (isset($_POST['submit'])) {
//     $tableName = $_POST['table_name'];
//     $crud->createBookTable($tableName); 
// }

  


//search books

// if (isset($_GET['search'])) {
//     $search = $_GET['search'];
//     $selectedTable = $_GET['table_name'];

//     // Modify your SQL query to include the search filter
//     // $queryFoods = "SELECT * FROM ppl_book WHERE title LIKE '%$search%'";
//     // $result = mysqli_query($conn, $queryFoods);

//     $result = $crud->getFilteredBook($selectedTable,$search);
    
// }



 






?>



<!DOCTYPE html>
<html lang="en" dir="ltr">

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


<body style="background:white">


    <div class="ml-52 p-2">
    <div class="absolute mt-[-55px]">
            <h1 class="text-2xl font-bold px-3">ADD COPIES</h1>
        </div>
        <div class="row"
            style="background-color:white; margin-top:10px; width: 68.7rem; padding:10px; margin-left:20px">
 
            <!-- 

        <?php


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $crud->selectedBook($id);
    
    if (($result)) {
        ?>
        <table class="table" style="">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Action</th>

                </tr>
            </thead>



            <tbody>
                <?php foreach ($result as $j): ?>
                <tr>
                    <td class="title-book"><?php echo $j['title']; ?></td>
                    <td><?php echo $j['author_name']; ?></td>
                    <td style="gap:30px; display: flex">
                        <a href="update_Books.php?id=<?php echo $j['id']; ?>"><i class="bi bi-pencil-fill"></i></a>
                        <a href="book_archive.php?id=<?php echo $j['id']; ?>"><i class="bi bi-trash-fill"></i></a>
                        <a href="book_AddCopies.php?id=<?php echo $j['id']; ?>"><i class="fa-solid fa-plus"
                                style="color: #2d75f0;"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php } else { ?>
        <p>No books found for the selected category.</p>
        <?php } ?>
        <?php } else { ?>
        <p>No category ID specified.</p>
        <?php } ?> -->


            <?php
// Get the category ID from the query string
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Get the current page number from the query string, default is 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Number of records to show per page
$offset = ($page - 1) * $limit;

if ($id !== null) {
    // Get the total number of books for pagination
    $totalBooks = $crud->countBooksInCategory($id);
    $totalPages = ceil($totalBooks / $limit);

    // Fetch the selected books with limit and offset for pagination
    $result = $crud->selectedBooktoAddCopie($id, $limit, $offset);

    if (!empty($result)) {
        ?>
             <table class="w-full text-xl px-5 text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr class="text-lg py-3">
                    <th class="px-6 py-3">Title</th>
                    <th class="px-6 py-3">Add Copies</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $result = $crud->getAllBooksInCat(); ?>

                    <?php foreach ($result as $j): ?>
                    <?php  if ($j) {  ?>
                    <tr>
                        <td><?= substr($j['title'], 0, 80); ?><?= strlen($j['title']) > 30 ? '...' : ''; ?></td>
                        <td>
                            <a href="book_AddCopies.php?id=<?= $j['id']; ?>"><i class="fa-solid fa-plus"
                                    style="color: #2d75f0;"></i></a>
                        </td>
                    </tr>
                    <?php 
                }
                endforeach; ?>
                </tbody>
            </table>

            <nav>
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                    <li class="page-item"><a class="page-link"
                            href="?id=<?= $id; ?>&page=<?= $page - 1; ?>">Previous</a></li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : ''; ?>"><a class="page-link"
                            href="?id=<?= $id; ?>&page=<?= $i; ?>"><?= $i; ?></a></li>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                    <li class="page-item"><a class="page-link" href="?id=<?= $id; ?>&page=<?= $page + 1; ?>">Next</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <?php 
    } else { 
        ?>
            <p>No books found for the selected category.</p>
            <?php 
    } 
} else { 
    ?>
                <table class="w-full text-xl px-5 text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr class="text-lg py-3">
                    <th class="px-6 py-3">Title</th>
                    <th class="px-6 py-3">Add Copies</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $result = $crud->getAllBooksInCat(); ?>

                    <?php foreach ($result as $j): ?>
                    <?php  if ($j) {  ?>
                    <tr>
                        <td><?= substr($j['title'], 0, 80); ?><?= strlen($j['title']) > 30 ? '...' : ''; ?></td>
                        <td>
                            <a href="book_AddCopiesAFTERADDINGAUTHOR.php?id=<?= $j['id']; ?>"><svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12  10.5v6m3-3H9m4.06-7.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    <?php 
                }
                endforeach; ?>
                </tbody>
            </table>
            <?php 
} 
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
    </div>





</body>






</html>