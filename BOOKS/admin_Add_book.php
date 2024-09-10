<?php
 
 ob_start();



require_once "../DATABASE/book_catalog_db.php";
require_once "book_catalog_engine.php";




$tables = [];
session_start();
 include "../dashdesign.php";
$crud = new CRUD();
error_reporting(0);        // Turn off all error reporting
ini_set('display_errors', 0);

// if (isset($_POST['submit'])) {
//     $tableName = $_POST['table_name'];
//     $crud->createBookTable($tableName); 
// }


 

if (isset($_POST['adbook'])) {

    $book_call_number = htmlspecialchars($_POST['book_call_number']);
    $checkAccesssion = $crud->checkAccessionNumber($book_call_number);

    if ($checkAccesssion) {
        echo "<script>
                alert('The Accession Number already exists');
                location.replace('../BOOKS/admin_Add_book.php');
              </script>";
    } else {
        // Validate and sanitize form data
        $title = htmlspecialchars($_POST['title']);
        $category_id = intval($_POST['category_id']);
        $status_name = htmlspecialchars($_POST['status_name']);
        $no_of_copies = intval($_POST['no_of_copies']);
        $book_call_number = htmlspecialchars($_POST['book_call_number']);
        $book_id = intval($_POST['book_id']);
        $synopsis = htmlspecialchars($_POST['synopsis']);
        $publisher = htmlspecialchars($_POST['publisher']);
        $book_isbn = htmlspecialchars($_POST['book_isbn']);
        $statusPerCopy = htmlspecialchars($_POST['statusPerCopy']);
        $book_date_published = htmlspecialchars($_POST['book_date_published']);
        $admin_id = htmlspecialchars($_POST['admin_id']);

        // Perform additional validation if needed

        // Process the form data using the createBook method
        $crud->createBook($title, $category_id, $status_name, $no_of_copies, $book_call_number, $book_id, $publisher, $book_isbn, $synopsis, $statusPerCopy, $book_date_published,$admin_id);

        header("Location: admin_Add_moreAuthorsAfter_AddingBook.php");
        exit(); // Ensure that subsequent code is not executed after redirection
    }
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
</head>


<body>
    <div class="ml-52 p-2">
        <div class="absolute mt-[-50px]">
            <h1 class="text-2xl font-bold px-3">ADD BOOK</h1>
            
        </div>
        <form method="POST" action="admin_Add_book.php" enctype="multipart/form-data">
            <input type="hidden" name="admin_id" value="<?php  echo $_SESSION['admin_Id']; ?>" id="">
            <div class="flex justify-evenly px-5 py-4 gap-10">
                <div class="w-[600px]">
                    <?php 
                                $getAllBookID = $crud->GetAllBookss();
                                foreach($getAllBookID as $getB): 
                                if($getB >=1){
                                ?>
                    <input type="hidden" name="book_id" value="<?php echo $getB['id']; ?>">
                    <?php 
                                    break;
                                }
                                endforeach; ?>


                    <label for="small-input" class="block text-sm font-medium font-black">Category:</label>
                    <select class="p-1 rounded-lg border-gray-400 text-sm" style="width:550px" name="category_id">
                        <option value="">Select a Category</option>
                        <?php 
                                    $categories = $crud->selectAllCategory();
                                    foreach($categories as $category):?>

                        <option value="<?php echo htmlspecialchars($category['id']); ?>">
                            <?php echo htmlspecialchars($category['category']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                    <br>

                    <div class="flex grid-cols-2 justify-between">
                        <div class="w-[250px]">
                            <label for="small-input" class="block text-sm font-medium font-black">Title:</label>
                            <input type="text" name="title" id="small-input" placeholder="Book Title:"
                                class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <br>
                        </div>
                        <div class="w-[250px]">
                            <?php
 
                                // Assume you have a method to check call number existence in your CRUD class
                                if(isset($_POST['book_call_number'])){
                                    $callNumber = $_POST['book_call_number'];
                                    $existingCallNumbers = $crud->getAllCopiesCheck();
                                    if(in_array($callNumber, $existingCallNumbers)){
                                        echo 'exists';
                                    } else {
                                        echo 'not_exists';
                                    }
                                }
 

                                ?>

                            <label for="small-input" class="block text-sm font-medium font-black">Accession
                                Number:</label>
                            <input type="text" placeholder="Accession Number:" name="book_call_number" id="small-input"
                                class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <br>

                            <script>
                            < script src = "https://code.jquery.com/jquery-3.6.0.min.js" >
                            </script>
                            <script>
                            $(document).ready(function() {
                                $('#book_call_number').on('input', function() {
                                    var callNumber = $(this).val();
                                    if (callNumber !== '') {
                                        $.ajax({
                                            url: 'check_call_number.php',
                                            type: 'POST',
                                            data: {
                                                call_number: callNumber
                                            },
                                            success: function(response) {
                                                if (response === 'exists') {
                                                    $('#callNumberFeedback').html(
                                                        '<span style="color: red;">This call number is already in use.</span>'
                                                    );
                                                } else {
                                                    $('#callNumberFeedback').html('');
                                                }
                                            }
                                        });
                                    } else {
                                        $('#callNumberFeedback').html('');
                                    }
                                });
                            });
                            </script>
                            </script>

                        </div>
                    </div>

                    <div class="flex grid-cols-2 justify-between">

                        <div class="w-[250px]">
                            <label for="small-input" class="block text-sm font-medium font-black">Date
                                Published:</label>
                            <input type="date" name="book_date_published" id="small-input"
                                class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <br>
                        </div>
                        <div class="w-[250px]">
                            <label for="small-input" class="block text-sm font-medium font-black">ISBN:</label>
                            <input type="text" placeholder="ISBN:" name="book_isbn" id="small-input"
                                class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <br>
                        </div>
                    </div>
                    <label for="message"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description:</label>
                    <textarea id="message" rows="4" name="synopsis"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Description"></textarea>
                    <br>

                    <label for="message"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Publisher:</label>
                    <input type="text"
                        class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        name="publisher" id="publisher" placeholder="Publisher" required>

                </div>

                <div class="w-[600px]">

                   
                    <label for="small-input" class="block text-sm font-medium font-black">Add Book Cover:</label>
                    <button id="btn">Show Image</button>
                    <input type="file" class="form-control-sm" name="image" id="image" accept=".jpg, .jpeg, .png"
                        value="Add Book Cover" >
                    <img alt="" style="" class="w-96 h-96 shadow-lg" id="imagePreview">



                </div>

                
                                <script>
                const defaultImage = '../images/lis.jpg';  // Your image path
                const button = document.getElementById('btn');
                const imagePreview = document.getElementById('imagePreview');
                
                button.addEventListener('click', () => {
                    imagePreview.src = defaultImage;  // Set the image src
                    imagePreview.style.display = 'block';  // Make the image visible
                });
            </script>
                            

                <script>
                     const img = '../images/lis.jpg';
             
                window.addEventListener('DOMContentLoaded', () => {
                    const image = document.getElementById('imagePreview');
                    const input = document.getElementById('image');
                   
                    input.addEventListener('change', (e) => {
                        if (e.target.files && e.target.files[0]) {
                            const reader = new FileReader();
                            reader.onload = (event) => {
                                image.src = event.target.result;
                            };

                            reader.readAsDataURL(e.target.files[0]);
                        }
                    });
                });
                </script>
            </div>


            <input type="hidden" name="statusPerCopy" value="Available">
            <input type="hidden" name="status_name" value="Available">

            <?php $copies = 1; ?>
            <input type="hidden" value="<?php echo $copies; ?>" name="no_of_copies" id="no_of_copies" required>

            <div class="ml-5">
                <button type="submit" name="adbook" style="background: #dda15e" class="p-2 rounded-lg px-10">
                    Add
                </button>
            </div>

        </div>


    <!-- <input type="submit" class="btn" style="background:#dda15e" name="adbook" value="Add Book"> -->
    </form>
    </div>
</body>

</html>