<?php
 
// require_once "../BOOKS/foradd/BOOK_ADD_AUTHORS.php/DATABASE/book_catalog_db.php";
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


    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<body>

    <div class="ml-52 p-2">
        <div class="absolute mt-[-50px]">
            <h1 class="text-2xl font-bold px-3">ADD AUTHORS</h1>
        </div>

        <?php
$id = isset($_GET['id']) ? $_GET['id'] : null; // Handle the case when 'id' is not set

if ($id !== null) {
    $result = $myAuthors->selectBooksByAuthorId($id);
    
    if (!empty($result)) {
        ?>

        <?php } else { ?>
        <p>No books found for the selected category.</p>
        <?php } ?>
        <?php } else { ?>

        <div class="flex items-center gap-5">
            <div>
                <div class="py-3">
                    <?php   $result = $crud->getLastBook();
                           if ($result) {  ?>
                    <div class="flex justify-start items-center">
                        <b clas="text-xs">Add Authors in this book:&nbsp;&nbsp;&nbsp; </b>
                        <input type="text" class="rounded-lg w-[200px]" id="myInputs" onkeyup="myFunctiongetSpebook()"
                            placeholder="Search for books.." value="<?php echo htmlspecialchars($result['title']); ?>"
                            title="Type Author">

                    </div>

                    <?php    } else { ?>
                    <p>No book found</p>
                    <?php   } ?>
                </div>

            </div>
            <div>
                <?php $result = $crud->getAllBooksInCat(); ?>

                <?php foreach ($result as $book) : ?>
                <?php  if ($book) {  ?>

                <button class="bg-[#d4a373] px-4 py-2 rounded-lg">
                    <a href="BOOK_ADD_AUTHORS.php?id=<?php echo $book['id']; ?>">
                        <p>Add</p>
                    </a>

                </button>

                <?php } ?>
                <?php endforeach; ?>
            </div>
        </div>







        <?php } ?>
    </div>
</body>

</html>