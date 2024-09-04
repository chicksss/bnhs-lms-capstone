<?php
 ob_start();
require_once "../DATABASE/book_catalog_db.php";
require_once "book_catalog_engine.php";
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
            <h1 class="text-2xl font-bold px-3">COPIES</h1>
        </div>

        <div class="flex justify-between px-10 py-2">
            <div>
                <select class="rounded-lg p-1" style="width:550px; margin-top: 9px" name="category_id"
                    onchange="window.location.href=this.value">
                    <option value="">Select a Category</option>

                    <option value="admin_AddCopies_Book.php">All Books</option>
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
            <div>
                <input type="text" class="rounded-lg p-1" id="myInput" onkeyup="myFunction()"
                    placeholder="Search for books.." title="Type Author">
            </div>
        </div>


        <div class="px-10">

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
            <table class="table caption-top w-full" style="">
                <caption class="bg-white p-2 font-bold text-left">
                    Category: &nbsp; &nbsp; &nbsp; &nbsp;
                    <?php 
                if (isset($_GET['id'])) { 
                    $bookCat = $_GET['id'];
                    $getCategory = $crud->getCat($bookCat);
                    echo $getCategory;
                } 
                ?>
                </caption>
                <thead class="bg-[#d5bdaf] p-2">
                    <tr class="text-left p-2">
                        <th class="text-left p-2">Title</th>
                        <th class="text-left p-2">Add Copies</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $j): ?>
                    <tr>
                        <td class="text-left p-2">
                            <?= substr($j['title'], 0, 80); ?><?= strlen($j['title']) > 30 ? '...' : ''; ?></td>
                        <td class="text-left p-2">
                            <a href="book_AddCopies.php?id=<?= $j['id']; ?>"><svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 10.5v6m3-3H9m4.06-7.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                                </svg></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- <nav>
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
            </nav> -->

          <div class="flex justify-center">
          <nav aria-label="Page navigation example">
                <ul class="inline-flex -space-x-px text-sm">
                    <?php if ($page > 1): ?>
                    <li>
                        <a href="?id=<?= $id; ?>&page=<?= $page - 1; ?>"
                            class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                    </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li>
                        <a href="?id=<?= $id; ?>&page=<?= $i; ?>"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                    </li>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                    <li>
                        <a href="?id=<?= $id; ?>&page=<?= $page + 1; ?>"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
          </div>


            <?php 
    } else { 
        ?>
            <p>No books found for the selected category.</p>
            <?php 
    } 
} else { 
    ?>

<div class="overflow-y-auto h-[500px]">
<table class="table-auto w-full">
            

                <thead class="bg-[#d5bdaf]">
                    <tr class="text-left p-2">
                        <th class="p-2 px-6">Title</th>
                        <th class="p-2 px-6">Add Copies</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $Allresult = $crud->AllCpsINBooks();
                    foreach ($Allresult as $j): ?>
                    <tr class="text-left p-2 hover:bg-[#e3d5ca]">
                        <td class="p-2 px-6 hover:bg-[#e3d5ca]">
                            <?= substr($j['title'], 0, 80); ?><?= strlen($j['title']) > 30 ? '...' : ''; ?></td>
                        <td class="p-2 px-6">
                            <a href="book_AddCopies.php?id=<?= $j['id']; ?>"><svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 10.5v6m3-3H9m4.06-7.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
                    </div>

            <?php 
} 
?>

        </div>


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


</body>

</html>