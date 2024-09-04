<?php
 
 require_once "author_db.php";
class authorsBook extends authorDB {

 

//authors
public function getAllAuthors() {
    $sql = "SELECT id, author_name FROM authors";
    $stmt = $this->connect()->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getAllAuthorscheck($author_name){
    $sql = "SELECT author_name FROM authors WHERE author_name = :author_name";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':author_name', $author_name, PDO::PARAM_STR);
    $stmt->execute();
    $stmt->fetch(PDO::FETCH_ASSOC);
    return $result !== false;
}

// public function checkLRnUser($user_LRN){
//     $sql = "SELECT user_LRN FROM users WHERE user_LRN = :user_LRN";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->bindParam(':user_LRN', $user_LRN, PDO::PARAM_STR);
//     $stmt->execute();
//     $stmt->fetch(PDO::FETCH_ASSOC);
//     return $result !== false;
// }




public function GetAllAuthorsCount(){
    $sql = "SELECT COUNT(*) AS totalAuthorsnumber FROM authors";
    $stmt = $this->connect()->query($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);  
}





public function CountgetAllAuthors() {
    try {
        $sql = "SELECT COUNT(id) as AuthorId FROM authors";
        $stmt = $this->connect()->query($sql);

        // Fetch the result as an associative array
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle any exceptions
        die("Error: " . $e->getMessage());
    }
}

public function SelectedUpdateAuthor($id) {
    $sql = "
        SELECT * FROM authors WHERE id = :id;
    ";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


 



public function updateAuthor($id, $author_name) {
    $this->connect()->beginTransaction();
    try {
        $sql = "UPDATE authors SET author_name = :author_name WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['id' => $id, 'author_name' => $author_name]);
        $rowCountAuthors = $stmt->rowCount();
        if ($rowCountAuthors > 0) {
            $this->connect()->commit();
            return true; 
        } else {
            $this->connect()->rollBack();
            return false; 
        }
    } catch (PDOException $e) {
        header("Location: ../BOOKS/admin_authors.php");
    }
}


public function deleteAuthor($id) {
    $sql = "DELETE FROM authors WHERE id = :id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
         header("Location: ../BOOKS/admin_authors.php");
        return true;
    } else {
        // Deletion failed
        return false;
    }
}



public function deleteBook_authors_Spe($id){
     $sql = "DELETE FROM book_authors WHERE id = :id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
         header("Location: ../BOOKS/admin_Add_moreAuthors.php");
        return true;
    } else {
        // Deletion failed
        return false;
    }
}

public function AddNewAuthors($author_name) {
    try {
        // Check if the author already exists
        $authorExists = $this->isAuthorExists($author_name);

        if ($authorExists) {
            // Author already exists, show alert
            echo "Author with the name".$author_name." already exists.";
        } else {
            // Author doesn't exist, proceed with insertion
            $sql = "INSERT INTO authors (author_name) VALUES (:author_name)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':author_name', $author_name, PDO::PARAM_STR);
            $stmt->execute();
            
            echo "<script>alert('Author added successfully'); location.replace('../BOOKS/admin_authors.php')</script>";
        }
    } catch (Exception $e) {
        // Handle other exceptions (display an alert and redirect)
        echo "<script>alert('" . $e->getMessage() . "'); location.replace('../BOOKS/admin_authors.php')</script>";
    }
}

// Function to check if an author with the given name already exists
private function isAuthorExists($author_name) {
    $sql = "SELECT COUNT(*) FROM authors WHERE author_name = :author_name";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':author_name', $author_name, PDO::PARAM_STR);
    $stmt->execute();

    $count = $stmt->fetchColumn();

    return $count > 0;
}



public function selectBooksByAuthorId($id){
    $sql = "
       SELECT b.id, b.title, c.category, a.*
        FROM books b
        INNER JOIN categories c ON b.category_id = c.id
        LEFT JOIN authors a ON b.id = a.id
        WHERE c.id = :id
    ";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}





// public function selectBooksByAuthorId($id){
//     $sql = "
//        SELECT b.id, b.title, c.category, a.*, ba.*
//         FROM books b
//         INNER JOIN categories c ON b.category_id = c.id
//         INNER JOIN book_authors ba ON b.id = ba.b_id
//         INNER JOIN authors a ON ba.a_id = a.id
//         WHERE c.id = :id
//         GROUP BY b.id
//     ";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->execute(['id' => $id]);
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }


public function getAllAuthorsBook($id){
    $sql = "
        SELECT books.*, authors.*
        FROM books
        JOIN authors ON books.id = authors.id
        WHERE books.id = :id
    ";

    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getBookAuthors($id){
    $sql = "
        SELECT ba.*, a.author_name 
        FROM book_authors ba 
        INNER JOIN authors a ON ba.a_id = a.id 
        WHERE ba.b_id = :id
    ";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([':id' => $id]); // Use ':id' instead of 'id'
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// public function getBookAuthors($id) {
//     $sql = "
//         SELECT ba.*, a.*
//         FROM book_authors ba
//         INNER JOIN authors a ON ba.a_id = a.id
//         WHERE ba.b_id = :id
       
//     ";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->execute(['id' => $id]);
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }



// public function getBookAuthorsperBook(){
//     $sql = "
//         SELECT a.*, ba.*, b.*
//         FROM book_authors ba
//         INNER JOIN authors a ON ba.a_id = a.id
//         INNER JOIN books b ON ba.b_id = b.id
//     ";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->execute();
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }


// public function selectAddBoolAuthorss($id) {
//     $sql = "
//         SELECT * FROM book_authors WHERE id = :id;
//     ";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->execute(['id' => $id]);  // Removed the colon (:) before 'id'
//     return $stmt->fetch(PDO::FETCH_ASSOC);
// }


public function SelectbookAtoDelete($id) {
    $sql = "
        SELECT * FROM book_authors WHERE id = :id;
    ";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


// public function SelectbookAtoDelete($id) {
//     $sql = "
//         SELECT authors.* 
//         FROM book_authors
//         INNER JOIN authors ON authors.id = book_authors.a_id 
//         WHERE book_authors.a_id = :id;
//     ";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->execute([':id' => $id]);
//     return $stmt->fetch(PDO::FETCH_ASSOC);
// }




// public function SelectbookAtoDelete($id) {
//     $sql = "
//         SELECT books.title, books.*, book_authors.*, a.*
//         FROM book_authors 
//         INNER JOIN books ON book_authors.b_id = books.id
//         INNER JOIN authors a ON book_authors.a_id = a.id
//         WHERE book_authors.a_id = :id;
//     ";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->execute([':id' => $id]);
//     return $stmt->fetch(PDO::FETCH_ASSOC);
// }





public function selectAddBoolAuthors($id) {
    $sql = "
        SELECT a.*, b.*
        FROM authors a
       INNER JOIN books b ON a.id = b.id
       
        WHERE a.id = :id;
    ";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function addAuthorsinBook($b_id,$a_id){
    $sql = "INSERT INTO book_authors (b_id,a_id) VALUES (:b_id, :a_id)";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':b_id', $b_id, PDO::PARAM_INT);
    $stmt->bindParam(':a_id', $a_id, PDO::PARAM_INT);
    $stmt->execute();    
    return $stmt;

}

 
public function getAuthorsWithLimit($start, $limit) {
    $sql = "SELECT * FROM authors
    LIMIT :start, :limit";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getTotalAuthors() {
    $sql = "SELECT COUNT(*) AS totalAuthorsnumber FROM authors";
    $stmt = $this->connect()->query($sql);
    return $stmt->fetchColumn();  
}


// public function selectedBooksS($id, $offset, $limit) {
//     // Your SQL query should include LIMIT and OFFSET
//     $sql = "SELECT b.*, a.author_name, s.*, c.category, 
//                 (SELECT COUNT(cps_sub.id) FROM copies cps_sub WHERE cps_sub.book_id = b.id) AS totalCPS,
//                 (SELECT COUNT(cps_sub2.id) FROM copies cps_sub2 WHERE cps_sub2.book_id = b.id AND cps_sub2.statusPerCopy = 'available') AS totalAvailableCPS
//             FROM books b
//             INNER JOIN categories c ON b.category_id = c.id
//             INNER JOIN authors a ON b.id = a.id
//             INNER JOIN status s ON b.id = s.id
//             WHERE c.id = :id
//             LIMIT :offset, :limit";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->bindParam(':id', $id, PDO::PARAM_INT);
//     $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
//     $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
//     $stmt->execute();
//     return $stmt->fetchAll();
// }



    
}



?>