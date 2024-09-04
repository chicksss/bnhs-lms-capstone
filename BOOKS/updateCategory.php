<?php
 
require_once "../DATABASE/book_catalog_db.php";
require_once "book_catalog_engine.php";
include "../dashdesign.php";



$tables = [];

$crud = new CRUD();

// if (isset($_POST['submit'])) {
//     $tableName = $_POST['table_name'];
//     $crud->createBookTable($tableName); 
// }

 
 if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = $crud->selectCategory($id);
 }


if(isset($_POST['updateCat'])){
    $id = $_POST['id'];
    $category = $_POST['category'];
    $crud->updateCategory($id,$category);
    header("Location: admin_book_home.php");
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



    <title>Document</title>
</head>

<body>


    <div class="ml-52 p-2 px-5">
        <?php if($result){ ?>
        <div class="form-group">
            <input type="hidden" name="id" value="<?= htmlspecialchars($result['id']); ?>">
            <label for="category" style="color:black">Update Category:</label>
            <input type="text" class="form-control" placeholder="Enter Book Section" name="category" id="category"
                value="<?php echo $result['category'] ?>" required>
        </div> <br>
        <input type="submit" class="btn" style="background: #dda15e" name="updateCat" value="Update">
        </form>
        <?php } ?>
    </div>

</body>

</html>