<?php
 ob_start();
require_once "../DATABASE/book_catalog_db.php";
require_once "book_catalog_engine.php";




$tables = [];

session_start();
include "../dashdesign.php";
$crud = new CRUD();

// if (isset($_POST['submit'])) {
//     $tableName = $_POST['table_name'];
//     $crud->createBookTable($tableName); 
// }

 

if (isset($_POST['create'])) {
    $title = $_POST['title'];
    $crud->createBook($title);
}


if(isset($_POST['addCategories'])){
    $category = $_POST['category'];
    $crud->categoriesBook($category);
}



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

    <title>Document</title>
</head>

<body>

    <div class="ml-52 p-2">

        <div class="absolute mt-[-50px]">
            <h1 class="text-2xl font-bold px-3">CATEGORY</h1>
        </div>
        <div class="flex justify-between">
            <div>
            <form method="POST" action="admin_book_home.php">

                <div class="flex justify-start gap-5 items-center">
                    <input type="text" class="rounded-lg w-50 p-1 px-3 py-1" placeholder="Add new Category" name="category"
                        id="category" required>
                    <button class="bg-[#e6ccb2] border rounded-lg px-3 py-1" type="submit" style="background: #f5ebe0" name="addCategories">Add
                    </button>
                </div>
                </form>
            </div>
      

        </div>
        

        <div class="py-5">
            <?php $category = $crud->selectAllCategory(); ?>

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-[#e6ccb2]  dark:text-black">

                    <tr>
                        <th class="px-6 py-3">Category</th>
                        <th class="px-6 py-3">Action</th>


                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($category as $j): ?>
                    <tr class="hover:bg-[#e3d5ca]">
                        <td class="text-black px-6 py-4">
                            <?php echo $j['category']; ?>
                        </td>
                        <td class="text-black px-6 py-4 flex">
                            <a href="updateCategory.php?id=<?php echo $j['id']; ?>" style="margin-right:20px"><svg
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path
                                        d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                                </svg>
                            </a>
                            <a href="deleteCategory.php?id=<?php echo $j['id']; ?>"><svg
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path fill-rule="evenodd"
                                        d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>

        </div>

    </div>

    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>


</body>

</html>