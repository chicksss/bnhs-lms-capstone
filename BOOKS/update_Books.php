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
    $result = $crud->SelectedUpdateBook($id);
}

 

if (isset($_POST['adbook'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $status_name = $_POST['status_name'];
    $book_date_published = $_POST['book_date_published'];
    $synopsis = $_POST['synopsis'];
  
   
    $book_isbn = $_POST['book_isbn'];
    // $book_issn = $_POST['book_issn'];
    // $book_edition = $_POST['book_edition'];
     $publisher = $_POST['publisher'];
    
    

    $crud->updateBook($id,$title, $status_name,$book_date_published,$synopsis,$book_isbn,$publisher);
}


if (isset($_POST['updateIMg'])) {
    $targetDirectory = "book/";
    $image = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $imagePath = $targetDirectory . $image;

    if (move_uploaded_file($imageTmp, $imagePath)) {
        try {
            $updatedImage = $crud->updatedImage($image, $id, $selectedTable);
            if ($updatedImage) {
                header("Location: admin_bookList.php");
                exit();
            } else {
                echo "Error updating image.";
            }
        } catch (PDOException $e) {
            echo "Error updating data in the database: " . $e->getMessage();
        }
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
            <h1 class="text-2xl font-bold px-3">UPDATE BOOKS</h1>
        </div>


        <div class="flex justify-between py-2 px-10">

            <div class="">
                <div class="bg-[#d5bdaf] p-2">
                    <h1>Update Book Information</h1>
                </div><?php if($result){ ?>
                <div class="py-2">
                    <form method="POST" action="update_Books.php">
                        <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                        <div class="flex justify-start gap-10">

                            <div class="grid gap-1">
                                <label for="title" style="color:black; font-weight:bold">Title</label>
                                <input type="text" class="rounded-lg p-2" placeholder="Enter Book Title" name="title"
                                    id="title" value="<?php echo $result['title'] ?>"> <br>

                                <b style="color:black; font-weight:bold">Published date</b>
                                <input type="date" class="rounded-lg p-2" placeholder="Enter Published date"
                                    name="book_date_published" id="book_date_published"
                                    value="<?php echo $result['book_date_published']; ?>">
                                <br>
                                <label for="Published date" style="color:black; font-weight:bold">Publisher</label> <br>
                                <input type="text" class="rounded-lg p-2" placeholder="Enter publisher "
                                    name="publisher" id="language" value="<?php echo $result['publisher']; ?>">
                                <br>
                            </div>
                            <div class="p-1">
                                <div class="mt-[9px]">
                                    <label for="Published date" style="color:black; font-weight:bold">Status</label><br>
                                    <select class="rounded-lg p-2 w-full" name="status_name">
                                        <option value="Available">Available</option>
                                        <option value="Not_Available">Not Available</option>
                                    </select>
                                </div>
                                <br>
                                <div class="mt-[9px]">
                                    <label for="Published date" style="color:black; font-weight:bold">ISBN</label>
                                    <br>
                                    <input type="text" class="rounded-lg p-2" placeholder="Enter ISBN " name="book_isbn"
                                        id="book_isbn" value="<?php echo $result['book_isbn']; ?>">
                                </div>

                                <br>
                            </div>
                        </div>
                        <div class="py-2">
                            <label for="Synopsis" style="color:black; font-weight:bold">Synopsis</label> <br>
                            <textarea class="rounded-lg p-2" placeholder="Enter Book Synopsis" name="synopsis"
                                id="author_name" rows="10" cols="50"
                                required><?php echo $result['synopsis']; ?></textarea>
                            <br>


                            <button type="submit" class="rounded-lg px-5 p-1" style="background:#dda15e" name="adbook">
                                Update</button>

                        </div>


                    </form>
                </div>



                <?php } ?>
            </div>
            <div>
                <div class="bg-[#d5bdaf] p-2">
                    <h1>Update Cover</h1>
                </div>
                <?php   if ($result) {
                        echo '<img src="book/' . $result['image'] . '" title="' . $result['image'] . '" style="height:300px; width:400px">';
                        }
                        ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="file" class="form-control" name="image" id="image" accept=".jpg, .jpeg, .png"
                        value="' . $result['image'] . '">
                    <!-- <input type="submit" class="btn-primary" name="updateIMg" value="Update"> -->
                    <button class="rounded-lg px-5 p-1" style="background: #dda15e" name="updateIMg">Update</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>