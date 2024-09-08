<?php
  ob_start();
require_once "../DATABASE/book_catalog_db.php";
require_once "book_catalog_engine.php";




$tables = [];

session_start();
include "../dashdesign.php";
$crud = new CRUD();

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = $crud->selectAddBookCopies($id);
}



if (isset($_POST['adbook'])) {
    $book_id = $_POST['book_id'];
    $no_of_copies = $_POST['no_of_copies'];
    $book_call_number = $_POST['book_call_number'];
    $statusPerCopy = $_POST['statusPerCopy'];
    $crud->AddcopiesBooks($book_id,$no_of_copies,$book_call_number,$statusPerCopy);
    header("Location: book_AddCopiesAFTERADDINGAUTHOR.php?id=" . $book_id);
     


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

<body>


    <div class="ml-52 p-2">
    <div class="absolute mt-[-55px]">
            <h1 class="text-2xl font-bold px-3">BOOK COPIES</h1>
        </div>

        <div class="flex justify-start gap-10 px-10 py-2">
            <?php if($result){ ?>
            <div>
                <div class="bg-[#d5bdaf] p-2 rounded-lg py-2">
                    <?php echo "Title: ".$result['title'];  ?>
                </div>

                <img src="../BOOKS/book/<?php echo $result['image']; ?>" title="<?php echo $result['image']; ?>"
                    class="h-[450px] w-[350px] rounded-lg shadow-lg py-2">
            </div>
            <?php } ?>

            <div>
                <div class="overflow-x-auto" id="overflowTest">
                    <form method="POST" action="book_AddCopiesAFTERADDINGAUTHOR.php">
                        <input type="hidden" name="book_id" value="<?php echo $result['id'] ?>">
                        <input type="hidden" name="statusPerCopy" value="Available">

                        <div class="form-group">

                            <input type="hidden" class="form-control-sm" placeholder="Enter Book Copies"
                                name="no_of_copies" id="copies" value="1" required>


                            <!-- <?php
                                         
                        // Check if the session variable is set
                        if (!isset($_SESSION['currentRandomNumber'])) {
                            // If not set, initialize it with a random number between 1 and 100
                            $_SESSION['currentRandomNumber'] = mt_rand(1, 1000);
                        }
                      
                        $_SESSION['currentRandomNumber']++;
                                   ?> -->

                            <input type="text" class="py-2 rounded-lg" placeholder="Enter Accession Number"
                                name="book_call_number" id="book_call_number">
                            <button type="submit" class="p-2 rounded-lg" style="background-color: #DDA15E" name="adbook"
                                value="Add Copies">Add</button>

                        </div>
                        <br>



                    </form>
                    <?php if(isset($_GET['id'])){ ?>
                    <?php $id = $_GET['id']; ?>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-[#d5bdaf]">
                            <th class="px-6 py-3">Accession Number</th>
                            <th class="px-6 py-3">Status</th>
                            <!-- <th class="px-6 py-3">Edit</th>
                            <th class="px-6 py-3">Delete</th> -->
                        </thead>
                        <tbody>
                            <?php       
                $books = $crud->getAllCpsBook($id);
                foreach ($books as $book): 
                 
                ?>
                            <tr>
                                <!-- how can i code this the "this book_call_number is already use" -->
                                <td class="px-6 py-3">
                                    <?php echo $book['book_call_number']; ?>
                                </td>
                                <td class="px-6 py-3"><?php echo $book['statusPerCopy']; ?></td>
                                <!-- <td class="px-6 py-3"><a href="book_CopiesUpdate.php?id=<?php echo $book['id']; ?>"><svg
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>

                                </td>

                                <td class="px-6 py-3">
                                    <a href="book_CopiesDelete.php?id=<?php echo $book['id']; ?>"><svg
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </a>
                                </td> -->
                            </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>


                    <?php } ?>
                </div>
            </div>
        </div>

        <i class=" flex justify-center">If you want to add a book again click -> <a href="admin_add_book.php" class="underline"> " Add Book"</a></i>

    </div>
</body>

</html>