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



if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = $myAuthors->selectAddBoolAuthors($id);
    }
    


if(isset($_POST['addAuthor'])){
    $b_id = $_POST['b_id'];
    $author_name = $_POST['author_name'];
    $add = $myAuthors->AddNewAuthors($author_name);
    header("Location: add_more_authors.php?id=".$b_id);
        }

    
if (isset($_POST['adbook'])) {
$b_id = $_POST['b_id'];
$selected_authors = isset($_POST['selected_authors']) ? $_POST['selected_authors'] : [];

foreach ($selected_authors as $a_id) {
$myAuthors->addAuthorsinBook($b_id, $a_id);
}

header("Location: add_more_authors.php?id=" . $b_id);
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
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <title>Document</title>

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

</head>

<body class="font-['Quicksand']">

    <div class="ml-52 p-2">
        <div class="absolute mt-[-55px]">
            <h1 class="text-2xl font-bold px-3">BOOK AUTHORS</h1>
        </div>


        <!-- <i class=" flex justify-center">If you want to add copies you can proceed to <a href="admin_AddCopies_BookAfterAddAuthor.php" class="underline"> "Add copies"</a></i> -->

        <!-- Main modal -->
        <div id="default-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Add new author
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="default-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <?php if ($result): ?>
                        <div class="col">
                            <label for="">Add New Author</label>
                            <form action="add_more_authors.php" method="POST">
                                <input type="hidden" name="b_id" value="<?php echo $result['id']; ?>">
                                <input type="text" class="form-control" name="author_name" placeholder="Enter Author">

                        </div>
                        <!-- Modal footer -->
                        <div
                            class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit" class="p-1 rounded-lg px-5" style="background: #dda15e; color:black"
                                name="addAuthor">Add</button>
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

<div class="flex justify-end mr-20">
<button onclick="goBack()" class="btn-back bg-[#dda15e] p-2 rounded-lg px-10">Back</button>
        <script>
        function goBack() {
            window.history.back("");
        }
</script>
</div>

        <div class="flex justify-evenly px-10 gap-2 py-3">
            <div class="card rounded-lg p-0 ">
                <div class="bg-[#d5bdaf] px-[-20px] p-2">
                    <label for="author" class="py-2" style="font-weight: 900; color: black">Select Author
                    </label>
                </div>
                <div class="flex justify-start py-2">
                    <div>
                        <input type="text" class="rounded-lg p-2" id="myInput" onkeyup="myFunction()"
                            placeholder="Search for Authors.." title="Type Author">
                    </div>
                    <div>
                        <button data-modal-target="default-modal" data-modal-toggle="default-modal"
                            class="block  text-black bg-[#dda15e] p-2 border rounded-lg mx-3 px-4 "
                            style="background: #DDA15E" type="button">
                            New
                        </button>
                    </div>
                </div>
                <?php if ($result): ?>
                <form method="POST" action="add_more_authors.php">
                    <br>
                    <input type="hidden" name="b_id" value="<?php echo $result['id']; ?>">
                    <input type="hidden" name="a_id" class="rounded-lg p-1" id="authorInput"
                        placeholder="Search for Authors.." title="Type Author">

                    <div class="overflow-y-auto h-80" id="overflowTests">
                        <div class="w-full text-sm text-left rtl:text-right text-black py-2" id="myDIV">
                            <?php
                                $listA = $crud->GetAllAuthors();
                                 foreach ($listA as $author): ?>
                            <div class="author-row flex justify-between mx-2">
                                <div class="author-name p-2">
                                    <p class="text-xl text-left"><?php echo $author['author_name']; ?></p>
                                </div>
                                <div class="author-id  p-2" data-id="<?php echo $author['id']; ?>">
                                    <input type="checkbox" name="selected_authors[]"
                                        class="author-id w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        value="<?php echo $author['id']; ?>">
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var tableCells = document.querySelectorAll(".author-id");

                            tableCells.forEach(function(cell) {
                                cell.addEventListener("click", function() {
                                    var authorId = cell.getAttribute("data-id");
                                    var input = document.getElementById("authorInput");

                                    // Set the input value to the clicked author's ID
                                    input.value = authorId;
                                });
                            });

                            // Add a filter for the authors
                            document.getElementById("authorInput").addEventListener("input", function() {
                                var filter = this.value.toUpperCase();
                                var tableRows = document.querySelectorAll(".author-row");

                                tableRows.forEach(function(row) {
                                    var authorNameCell = row.querySelector(".author-name");
                                    var authorName = authorNameCell.textContent ||
                                        authorNameCell.innerText;

                                    // Display or hide rows based on the filter
                                    row.style.display = authorName.toUpperCase().includes(
                                        filter) ? "" : "none";
                                });
                            });
                        });
                        </script>

                        <!-- filter -->

                        <script>
                        function myFunction() {
                            // Declare variables
                            var input, filter, table, tr, td, i, txtValue;
                            input = document.getElementById("myInput");
                            filter = input.value.toUpperCase();
                            table = document.getElementById("myDIV");
                            tr = table.getElementsByClassName("author-row");

                            // Loop through all table rows, and hide those who don't match the search query
                            for (i = 0; i < tr.length; i++) {
                                td = tr[i].getElementsByClassName("author-name")[0];
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

                        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


                    </div>



                    <div class="py-3">
                        <button type="submit" class="block  text-black bg-[#dda15e] p-2 border rounded-lg mx-3 px-4 "
                            style="background: #DDA15E" name="adbook" value="Add">Add</button>
                    </div>

                </form>
                <?php endif; ?>
            </div>
            <div class="card rounded-lg">
                <?php if ($result): ?>
                <div class="grid gap-3">
                    <div class="bg-[#d5bdaf] px-[-20px] p-2">
                        <p for="" class="text-1xl font-bold w-[300px] truncate hover:ellipsis">Book: <?php echo $result['title']; ?></p>
                    </div>
                    <div class="">
                        <img src="../BOOKS/book/<?php echo $result['image']; ?>" title="<?php echo $result['image']; ?>"
                            class="h-[400px] w-[300px] rounded-lg shadow-lg">
                    </div>
                </div>
                <?php endif; ?>



            </div>

            <div class="card rounded-lg w-[200px]">
                <div class="bg-[#d5bdaf] px-[-20px] p-2 py-2">
                    <p class="font-bold">Book Authors:</p>
                </div>
                <div id="overflowTest">
                    <?php ?>

                    <?php if(isset($_GET['id'])){ ?>
                    <?php $id = $_GET['id']; ?>


                        <div>
                            <?php
                            $books = $myAuthors->getBookAuthors($id);
                            foreach ($books as $book): ?>

                            <div class="flex justify-between p-2">
                                <div><?php echo $book['author_name']; ?></div>
                                <div>
                                    <a href="delete_Spe_book.php?id=<?php echo $book['id']?>" style="color:red"><svg
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <?php endforeach; ?>

                        </div>





                    <?php } ?>
                </div>
            </div>


        </div>



        <!-- Modal toggle -->


        <!-- Main modal -->
        <div id="default-modal-for-copies" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Copies
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="default-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <!-- modal -->
                        <div>
                            <?php 
                            $join = $crud->InnerJoinBook();
                            $result = $crud->getAllBooksInCat(); ?>
                            <?php foreach ($result as $j): ?>
                            <?php  if ($j) {  ?>
                            <div class="grid justify-center gap-2 ">
                                <div class="bg-[#d5bdaf] p-2"> <b>Book:</b> &nbsp;
                                    <?= substr($j['title'], 0, 80); ?><?= strlen($j['title']) > 30 ? '...' : ''; ?>
                                </div>
                                <div>

                                    <img src="../BOOKS/book/<?php echo $j['image']; ?>"
                                        title="<?php echo $j['image']; ?>"
                                        class="h-[300px] w-[250px] rounded-lg shadow-lg">
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide="default-modal" type=""
                            class="text-black bg-[#d5bdaf] font-medium rounded-lg  text-sm px-5 py-2.5 text-center">I
                            <a class="" href="book_AddCopies.php?id=<?= $j['id']; ?>">Add Copies
                            </a></button>
                        <?php 
                }
                endforeach; ?>
                    </div>
                </div>
            </div>
        </div>







    </div>

</body>

<script>
const openModalBtn = document.getElementById('btnCategory');
const closeModalBtn = document.getElementById('closeModalBtn');
const modal = document.getElementById('categoryModal');

const openBookModalBtn = document.getElementById('btnBookList');
const closeBookModalBtn = document.getElementById('closeModalBookList');
const modalBook = document.getElementById('bookModal');


const openBookCategoryModalBtn = document.getElementById('btnBooksDelete');
const closeBookCategoryModalBtn = document.getElementById('closeBookCategoryModalBtn');
const modalBookDelete = document.getElementById('modalCategories');

openBookCategoryModalBtn.addEventListener('click', () => {
    modalBookDelete.style.display = 'block';
});

closeBookCategoryModalBtn.addEventListener('click', () => {
    modalBookDelete.style.display = 'none';
});



openModalBtn.addEventListener('click', () => {
    modal.style.display = 'block';
});

closeModalBtn.addEventListener('click', () => {
    modal.style.display = 'none';
});

openBookModalBtn.addEventListener('click', () => {
    modalBook.style.display = 'block';
});

closeBookModalBtn.addEventListener('click', () => {
    modalBook.style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
    if (event.target === modalBook) {
        modalBook.style.display = 'none';
    }

    if (event.target === modalBookDelete) {
        modalBookDelete.style.display = 'none';
    }

});
</script>
<script>
let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e) => {
        let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
        arrowParent.classList.toggle("showMenu");
    });
}
let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".bx-menu");
console.log(sidebarBtn);
sidebarBtn.addEventListener("click", () => {
    sidebar.classList.toggle("close");
});
</script>

</html>