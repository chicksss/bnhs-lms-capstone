<?php
 
require_once "../DATABASE/book_catalog_db.php";
require_once "../BOOKS/book_catalog_engine.php";

$tables = [];

session_start();
 include "../dashdesign.php";
$crud = new CRUD();

$join = $crud->sampleBookA();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<table>
    <thead>
        <th>Title</th>
        <th>Books</th>
    </thead>

    <tbody>
        <?php foreach($join as $u){ ?>
        <tr>
            <td><?php echo $u['title']?></td>
            <td><?php echo $u['authors'] ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
    
</body>
</html>