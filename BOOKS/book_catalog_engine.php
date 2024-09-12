<?php
require_once "../database_archive/archive_book_db.php";
require_once '../DATABASE/book_catalog_db.php';
require_once '../END_USER/end_user_engine.php';
require_once '../END_USER/end_user_db.php';

require_once '../AUTHORS/authors_engine.php';
require_once '../AUTHORS/author_db.php';
// require_once '../database_user_appointment/admin_appointment.php';


class CRUD extends BookCatalagoueDB {
 
    public function categoriesBook($category){
          $sql = 'INSERT INTO categories (category) VALUES (:category)';
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute(['category' => $category]);
    }


    public function selectAllCategory(){
        $sql = 'SELECT * FROM categories ORDER  BY id';
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }


    public function selectCategory($id){
        $sql = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function updateCategory($id,$category){
        $sql = "UPDATE categories SET category = :category WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['id' => $id, 'category' => $category]);
        return $stmt;
    }

    public function deleteCategory($id){
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt;
    }


    public function DeletecopiesBooks($id){
         $sql = "DELETE FROM copies WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt;
    }

    
    
public function SelectedUpdateBook($id) {
    $sql = "
        SELECT books.*, authors.*,status.*, copies.*, publishers.*
        FROM books
        JOIN authors ON books.id = authors.id
        JOIN status ON books.id = status.id
        JOIN copies ON books.id = copies.id
        JOIN publishers ON books.id = publishers.id
         
        WHERE books.id = :id
    ";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $id]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}



public function selectAddBookCopies($id) {
    $sql = "
        SELECT cps.*, b.*
        FROM copies cps
       INNER JOIN books b ON cps.book_id = b.id
        WHERE b.id = :id;
    ";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}



public function getAllCps(){
    $sql = "SELECT * FROM copies";
    $stmt = $this->connect()->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function getBookCount(){
    $sql = "SELECT COUNT(*) as total FROM books";
    $stmt = $this->connect()->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}


//total notavailable
public function getBookNotAvailable(){
    $sql = "SELECT COUNT(*) as total FROM status WHERE status_name = 'Not_Available'";
    $stmt = $this->connect()->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}



public function allArchive(){
    $sql = "SELECT COUNT(*) as total FROM archives";
    $stmt = $this->connect()->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}

public function allTotalCopies(){
    $sql = "SELECT COUNT(*) as total FROM copies";
    $stmt = $this->connect()->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}


public function allBorrowedCopies(){
    $sql = "SELECT COUNT(*) as total FROM copies WHERE statusPerCopy = 'Borrowed'";
    $stmt = $this->connect()->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}

 



 
public function selectUpdateBookCopy($id) {
    $sql = "SELECT books.*, copies.*
            FROM copies
            INNER JOIN books ON copies.book_id = books.id
            WHERE copies.id = :id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function UpdatecopiesBooks($id,$statusPerCopy,$book_call_number){
    $sql = "UPDATE copies SET statusPerCopy = :statusPerCopy, book_call_number= :book_call_number WHERE id = :id";
    $stmt = $this->connect()->prepare($sql);
    return $stmt->execute(['id' => $id, 'statusPerCopy' => $statusPerCopy, 'book_call_number' => $book_call_number]);
}


//get copies in book 
public function getAllCpsBook($id){
    $sql = "
        SELECT books.*, copies.*
        FROM books 
        JOIN copies ON books.id = copies.book_id
        WHERE books.id = :id
    ";

   // $sql = "SELECT c.id, c.book_id, c.no_of_copies, c.statusPerCopy, c.book_call_number, b.* FROM copies c INNER JOIN books b ON c.id = b.id WHERE c.id = :id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    
public function getBookDetails($bookId){

 
    $sql = "
        SELECT b.*, b.id AS book_ID, a.author_name, s.status_name, cps.* 
        FROM books b
        INNER JOIN authors a ON b.id = a.id  
        INNER JOIN status s ON b.id = s.id  
        LEFT JOIN copies cps ON b.id = cps.book_id
        WHERE b.id = :id AND cps.statusPerCopy = 'Available'
        ORDER BY b.id
        LIMIT 1
    ";

    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $bookId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



public function getAlAvaialble($bookId){
    
    $sql = "
           SELECT COUNT(cps.id) AS available_copies
        FROM books b
        LEFT JOIN copies cps ON b.id = cps.book_id AND cps.statusPerCopy = 'Available'
        WHERE b.id = :id
    ";

    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $bookId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['available_copies'];
}

    
public function getBorrowId($bookId,$user_id,$selectedTable,$copy_id){


    $sql = "SELECT c.*, b.title, b.id, a.author_name, b.image
    FROM copies c 
    JOIN books b ON c.book_id = b.id 
    JOIN authors a ON c.book_id = a.id
    WHERE c.id = :id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $bookId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);


}












//getsumCPS

public function getsumCPS($id){
    $sql = "
        SELECT books.*, SUM(copies.no_of_copies) AS totalCPS
        FROM books 
        JOIN copies ON books.id = copies.book_id
        WHERE books.id = :id
    ";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


//getSumTotalCPs
public function getSumATotalCPs($id){
    $sql = "
        SELECT books.*, SUM(copies.no_of_copies) AS totalCPS
        FROM books 
        JOIN copies ON books.id = copies.book_id
        WHERE copies.statusPerCopy = 'Available' AND books.id = :id
    ";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



//getSumTotalCPs
public function getSumBTotalCPs($id){
    $sql = "
        SELECT books.*, SUM(copies.no_of_copies) AS totalCPS
        FROM books 
        JOIN copies ON books.id = copies.book_id
        WHERE copies.statusPerCopy = 'Borrowed' AND books.id = :id
    ";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function SelectBooktoArchive($id){
    $sql = "SELECT * FROM books WHERE id = :id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function AddcopiesBooks($book_id,$no_of_copies,$book_call_number,$statusPerCopy){
    $sql = "INSERT INTO copies (book_id, no_of_copies, book_call_number,statusPerCopy) VALUES (:book_id, :no_of_copies, :book_call_number,:statusPerCopy)";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['book_id' => $book_id , 'no_of_copies' => $no_of_copies, 'book_call_number' => $book_call_number, 'statusPerCopy' => $statusPerCopy]);
    header("location: admin_bookList.php");
     
}

public function updateBook($id,$title, $status_name,$book_date_published,$synopsis,$book_isbn,$publisher) {
    $this->connect()->beginTransaction();

    try {
        $sql = "UPDATE books SET title = :title, book_date_published = :book_date_published, synopsis = :synopsis, book_isbn = :book_isbn  WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['id' => $id, 'title' => $title, 'book_date_published' => $book_date_published, 'synopsis' => $synopsis,  'book_isbn' => $book_isbn]);
        $rowCountBooks = $stmt->rowCount();


        $sql = "UPDATE status SET status_name = :status_name WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['id' => $id, 'status_name' => $status_name]);
        $rowCountStatus = $stmt->rowCount();


         $sql = "UPDATE publishers SET publisher = :publisher WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['id' => $id, 'publisher' => $publisher]);
        $rowCountPublishers = $stmt->rowCount();


    
        if ($rowCountBooks > 0 && $rowCountStatus > 0 && $rowCountPublishers > 0) {
            $this->connect()->commit();
            return true; 
        } else {
            $this->connect()->rollBack();
            return false; 
        }
    } catch (PDOException $e) {
        //header("Location: admin_bookList.php");
        
    }
}



public function selectedBooksS($id, $offset, $limit) {
    // Your SQL query should include LIMIT and OFFSET
    $sql = "SELECT b.*, a.author_name, s.*, c.category, 
                (SELECT COUNT(cps_sub.id) FROM copies cps_sub WHERE cps_sub.book_id = b.id) AS totalCPS,
                (SELECT COUNT(cps_sub2.id) FROM copies cps_sub2 WHERE cps_sub2.book_id = b.id AND cps_sub2.statusPerCopy = 'available') AS totalAvailableCPS
            FROM books b
            INNER JOIN categories c ON b.category_id = c.id
            INNER JOIN authors a ON b.id = a.id
            INNER JOIN status s ON b.id = s.id
            WHERE c.id = :id
            LIMIT :offset, :limit";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}




public function countBooks($id) {
    $sql = "SELECT COUNT(*) FROM books WHERE category_id = :id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}





public function homeselectedBookAll(){
    $sql = "
         SELECT b.*, a.author_name, s.*, c.*, c.id AS tblId, publishers.*, cp.book_call_number, cp.statusPerCopy
        FROM books b
        INNER JOIN categories c ON b.category_id = c.id
        INNER JOIN book_authors ba ON b.id = ba.b_id
        INNER JOIN authors a ON ba.a_id = a.id
        INNER JOIN status s ON b.id = s.id
        INNER JOIN publishers ON b.id = publishers.id
        INNER JOIN copies cp ON b.id = cp.book_id
        GROUP BY b.id
    ";
    $stmt = $this->connect()->query($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


//ALL COPIES IN DATABASE

public function getAllCopiesCheck(){
    $sql = "SELECT book_call_number FROM copies";
    $stmt = $this->connect()->query($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}


public function homeselectedBook($categoryId){
    $sql = "
        SELECT b.*, a.author_name, s.*, c.category, publishers.*, cp.book_call_number
        FROM books b
        INNER JOIN categories c ON b.category_id = c.id
        INNER JOIN book_authors ba ON b.id = ba.b_id
        INNER JOIN authors a ON ba.a_id = a.id
        INNER JOIN status s ON b.id = s.id
        INNER JOIN publishers ON b.id = publishers.id
        INNER JOIN copies cp ON b.id = cp.book_id
        WHERE c.id = :id
        GROUP BY b.id
    ";

    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $categoryId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}






public function getLastBook(){
    $sql = "SELECT image, title FROM books ORDER BY id DESC LIMIT 1;";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getAllBooksInCat(){
    $sql = "SELECT id, title, image FROM books ORDER BY id DESC LIMIT 1;";
    $stmt = $this->connect()->query($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



public function selectedBook($categoryId){
   $sql = "
    

      SELECT b.*, a.author_name, s.*, c.category, publishers.*, cp.book_call_number
        FROM books b
        INNER JOIN categories c ON b.category_id = c.id
        INNER JOIN book_authors ba ON b.id = ba.b_id
        INNER JOIN authors a ON ba.a_id = a.id
        INNER JOIN status s ON b.id = s.id
        INNER JOIN publishers ON b.id = publishers.id
        INNER JOIN copies cp ON b.id = cp.book_id
        WHERE c.id = :id
        GROUP BY b.id
";

$stmt = $this->connect()->prepare($sql);
$stmt->execute(['id' => $categoryId]);
 
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



//get all books in main page

public function selectedBookAll(){
   $sql = "
    

      SELECT b.*, a.author_name, s.*, c.category, publishers.*, cp.book_call_number
        FROM books b
        INNER JOIN categories c ON b.category_id = c.id
        INNER JOIN book_authors ba ON b.id = ba.b_id
        INNER JOIN authors a ON ba.a_id = a.id
        INNER JOIN status s ON b.id = s.id
        INNER JOIN publishers ON b.id = publishers.id
        INNER JOIN copies cp ON b.id = cp.book_id
        
        GROUP BY b.id
";

$stmt = $this->connect()->query($sql);
$stmt->execute();
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function selectedBooks($categoryId){
    $sql = "
        SELECT b.*, a.author_name, s.*, c.category, cps.id AS copy_id, COUNT(cps.id) AS totalCPS, cps.statusPerCopy 
        FROM books b
        INNER JOIN categories c ON b.category_id = c.id
        INNER JOIN authors a ON b.id = a.id
        INNER JOIN status s ON b.id = s.id
        LEFT JOIN copies cps ON b.id = cps.book_id  
        WHERE c.id = :id
        GROUP BY b.id
    ";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $categoryId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}





public function selectedBooktoAddCopie($id, $limit, $offset) {
    $sql = "
        SELECT b.id, b.title, c.category, cps.id AS copy_id
        FROM books b
        INNER JOIN categories c ON b.category_id = c.id
        LEFT JOIN copies cps ON b.id = cps.id
        WHERE c.id = :id
        LIMIT :limit OFFSET :offset
    ";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}


public function countBooksInCategory($id) {
    $sql = "SELECT COUNT(*) FROM books WHERE category_id = :id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}






public function getTotalBooks($categoryId) {
    $sql = "SELECT COUNT(*) AS total_books FROM books WHERE category_id = :categoryId";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['categoryId' => $categoryId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_books'];
}


public function getBookAvailable($categoryId){
    $sql = "
        SELECT c.category, COUNT(s.id) AS totalStat
        FROM books b
        INNER JOIN categories c ON b.category_id = c.id
        INNER JOIN status s ON b.id = s.id
        WHERE s.status_name = 'Available' AND c.id = :id
        GROUP BY c.id
    ";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $categoryId]);
    return $stmt->fetch(PDO::FETCH_ASSOC)['totalStat'];
}



  



public function getTotalStatus($StatId){
    $sql = "
        SELECT COUNT(*) AS totalStat, b.* FROM status s 
        INNER JOIN books b ON s.id = b.id
        WHERE s.id = :id
        GROUP BY b.id
    ";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $StatId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




//get category name
public function getCat($bookCat){
    $sql = "SELECT category FROM categories WHERE id = :id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $bookCat]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['category'];
}







public function DeleteBook($bookId) {
    $querySelect = "SELECT * FROM books WHERE id = :id";
    $queryInsert = "INSERT INTO archives (archive_b_id,archive_book_title) VALUES (:archive_b_id,:archive_book_title)";
    $queryDelete = "DELETE FROM books WHERE id = :id";
    $queryAuthorDelete = "DELETE FROM authors WHERE id = :id";
    $queryStatusDelete = "DELETE FROM status WHERE id = :id";

    // Retrieve book details from active books table
    $stmtSelect = $this->connect()->prepare($querySelect);
    $stmtSelect->bindParam(':id', $bookId, PDO::PARAM_INT);
    $stmtSelect->execute();
    $book = $stmtSelect->fetch(PDO::FETCH_ASSOC);

    if ($book) {
        // Insert the book into the archived books table
        $stmtInsert = $this->connect()->prepare($queryInsert);
        $stmtInsert->bindParam(':archive_b_id', $book['id'], PDO::PARAM_INT);
        $stmtInsert->bindParam(':archive_book_title', $book['title'], PDO::PARAM_STR);

        
        $stmtInsert->execute();

        // Delete the book from the active books table
        $stmtDelete = $this->connect()->prepare($queryDelete);
        $stmtDelete->bindParam(':id', $bookId, PDO::PARAM_INT);
        $stmtDelete->execute();

        $stmtDelete = $this->connect()->prepare($queryAuthorDelete);
        $stmtDelete->bindParam(':id', $bookId, PDO::PARAM_INT);
        $stmtDelete->execute();

        $stmtDelete = $this->connect()->prepare($queryStatusDelete);
        $stmtDelete->bindParam(':id', $bookId, PDO::PARAM_INT);
        $stmtDelete->execute();
        header("Location: admin_BookList.php");

        return true;
    } else {
        return false;
    }
}
 

//list authors

public function GetAllAuthors(){
    $sql = "SELECT * FROM authors";
    $stmt = $this->connect()->query($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);  
}



public function GetAllBookss(){
    $sql = "SELECT * FROM books ORDER BY id DESC";
    $stmt = $this->connect()->query($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);  
}

  //insert book              
public function createBook($title,$category_id,$status_name,$no_of_copies,$book_call_number,$book_id,$publisher,$book_isbn,$synopsis,$statusPerCopy,$book_date_published,$admin_id)
{
    // Check if an image is uploaded
    if ($_FILES["image"]["error"] === 4) {
        echo '<script>alert("Image does not exist")</script>';
    } else {
        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));

        if (!in_array($imageExtension, $validImageExtension)) {
            echo '<script>alert("Invalid image file extension")</script>';
        } else if ($fileSize > 100000000000000) {
            echo '<script>alert("Image is too large")</script>';
        } else {
            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;

            move_uploaded_file($tmpName, 'book/' . $newImageName);

            try {
                $pdo = $this->connect();

                // Insert into the books table
                $sql = "INSERT INTO books (title, category_id, image, synopsis, book_isbn,book_date_published,admin_id) VALUES (:title, :category_id, :image, :synopsis, :book_isbn, :book_date_published, :admin_id)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':title', $title, PDO::PARAM_STR);
                $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
                $stmt->bindParam(':image', $newImageName, PDO::PARAM_STR);
                $stmt->bindParam(':synopsis', $synopsis, PDO::PARAM_STR); // Fixed missing colon
               
                $stmt->bindParam(':book_isbn', $book_isbn, PDO::PARAM_STR);
                $stmt->bindParam(':book_date_published', $book_date_published, PDO::PARAM_STR);
                $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_STR);

        
                
                $stmt->execute();

                $bookId = $pdo->lastInsertId();
                
                // Insert into the status table
                $sql = "INSERT INTO status (status_name) VALUES (:status_name)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':status_name', $status_name, PDO::PARAM_STR);
                $stmt->execute();


                  // Insert into the publishers table
                $sql = "INSERT INTO publishers (publisher,book_id) VALUES (:publisher,:book_id)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':publisher', $publisher, PDO::PARAM_STR);
                $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
                $stmt->execute();

                // Insert into the copies table
                $sql = "INSERT INTO copies (book_id, no_of_copies, book_call_number, statusPerCopy) VALUES (:book_id, :no_of_copies, :book_call_number, :statusPerCopy)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT); // Use $bookId here
                $stmt->bindParam(':no_of_copies', $no_of_copies, PDO::PARAM_INT);
                $stmt->bindParam(':book_call_number', $book_call_number, PDO::PARAM_STR);
                $stmt->bindParam(':statusPerCopy', $statusPerCopy, PDO::PARAM_STR);

                $stmt->execute();

                return true; // Success
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
                return false; // Failure
            }
        }
    }
}





   public function createAuthor($author_name,$book_author_id) {
    try {
        $sql = "INSERT INTO authors (author_name,book_author_id) VALUES (:author_name,:book_author_id)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':author_name', $author_name, PDO::PARAM_STR);
        $stmt->bindParam(':book_author_id', $book_author_id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}


//insert status
public function bookStatus($status_name){
     try {
        $sql = "INSERT INTO status (status_name) VALUES (:status_name)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':status_name', $status_name, PDO::PARAM_STR);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}



public function featuredBook() {
    try {
        $sql = "
            SELECT
                b.*,
                br.*,
                ba.*,
                a.author_name,
                c.*,
                COUNT(br.book_Id) AS borrow_count,
                publishers.*
            FROM
                books b
            INNER JOIN 
                categories c ON b.category_id = c.id
            INNER JOIN
                borrowings br ON b.id = br.book_Id
            INNER JOIN
                book_authors ba ON b.id = ba.b_id
            INNER JOIN
                authors a ON ba.a_id = a.id
            INNER JOIN 
                publishers ON b.id = publishers.id
            GROUP BY
                b.id
            ORDER BY
                borrow_count DESC
            LIMIT 1;
        ";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Log the error or handle it appropriately
        echo "Error: " . $e->getMessage();
        return [];
    }
}





//BAK UP 
// public function featuredBook() {
//     try {
//         $sql = "
//             SELECT
//                 b.*,
//                 COUNT(br.count) AS total_borrow_count,
//                 a.author_name
//             FROM
//                 books b
//             INNER JOIN
//                 borrowings br ON b.id = br.appointment_Id
//             INNER JOIN
//                 authors a ON b.id = a.id
//             GROUP BY
//                 b.id
//             ORDER BY
//                 total_borrow_count DESC
//             LIMIT 1
//         ";

//         $stmt = $this->connect()->prepare($sql);
//         $stmt->execute();

//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     } catch (PDOException $e) {
//         // Log the error or handle it appropriately
//         echo "Error: " . $e->getMessage();
//         return [];
//     }
// }




//select all book

  public function selectAllBooks(){
        $sql = 'SELECT * FROM books';
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }




    public function sampleBookA() {

        $sql = "SELECT 
                    b.id, 
                    b.title, 
                    GROUP_CONCAT(a.author_name ORDER BY a.author_name SEPARATOR ', ') AS authors, 
                    s.status_name, 
                    c.no_of_copies, 
                    c.book_call_number  
                FROM books b
                INNER JOIN book_authors ba ON b.id = ba.b_id
                INNER JOIN authors a ON ba.a_id = a.id
                INNER JOIN status s ON b.id = s.id
                INNER JOIN copies c ON b.id = c.book_id
                GROUP BY b.id, b.title, s.status_name, c.no_of_copies, c.book_call_number";
    
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  
    }
    

    

    //inner join

    public function InnerJoinBook() {

        $sql = "SELECT  b.id, b.title, a.author_name, s.status_name, c.no_of_copies, c.book_call_number
            FROM books b
            INNER JOIN authors a ON b.id = a.id
            INNER JOIN status s ON b.id = s.id
            INNER JOIN copies c ON b.id = c.id";
            
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);  
}


   public function InnerJoinBookArchive() {
    $sql = "SELECT * FROM archives";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}





// public function InnerJoinBookArchive() {
//     try {
//         $sql = "SELECT * FROM archives";
        
//         $stmt = $this->connect()->prepare($sql);
//         $stmt->execute();
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     } catch (PDOException $e) {
//         // Handle database errors
//         echo "Error: " . $e->getMessage();
//         return false;
//     }
// }








// public function InnerJoinBook() {
//     $sql = "SELECT b.id, b.title, a.author_name FROM books b INNER JOIN authors a ON b.id = a.id";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->execute();
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }


// public function InnerJoinBook() {
//     $sql = "SELECT b.id, b.title, a.author_name, s.status_name FROM books b INNER JOIN authors a ON b.id = a.id, books b INNER JOIN status s ON b.id = s.id";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->execute();
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }



    
              



// public function SelectedUpdateBook($selectedTable,$book_Id){
//     $query = "SELECT * FROM $selectedTable WHERE book_Id = ?";
//     $stmt = $this->connect()->prepare($query);
//     $stmt->execute([$book_Id]);
//     return $stmt->fetch(PDO::FETCH_ASSOC);
// }



// public function UpdateBook($book_Id,$title,$author,$status,$selectedTable,$no_of_copies,$book_call_number,$book_abstract){
   
//     $sql = "UPDATE $selectedTable SET title = :title, author = :author, status = :status, no_of_copies= :no_of_copies, book_call_number = :book_call_number, book_abstract = :book_abstract WHERE book_Id = :book_Id";
//     $stmt = $this->connect()->prepare($sql);

//     $stmt->bindParam(':title', $title, PDO::PARAM_STR);
//     $stmt->bindParam(':author', $author, PDO::PARAM_STR);
//     $stmt->bindParam(':status', $status, PDO::PARAM_STR);
//     $stmt->bindParam(':no_of_copies', $no_of_copies, PDO::PARAM_INT);
//     $stmt->bindParam(':book_Id', $book_Id, PDO::PARAM_INT);
//     $stmt->bindParam(':book_call_number', $book_call_number, PDO::PARAM_STR);
//     $stmt->bindParam(':book_abstract', $book_abstract, PDO::PARAM_STR);
    
//     return $stmt->execute();
// }


//ADD COPIES

// public function AddCopies($selectedTable,$id,$no_of_copies,$status){
   
//     $sql = "UPDATE $selectedTable SET no_of_copies= :no_of_copies, status= :status WHERE book_Id = :book_Id";
//     $stmt = $this->connect()->prepare($sql);

    
//     $stmt->bindParam(':no_of_copies', $no_of_copies, PDO::PARAM_INT);
//     $stmt->bindParam(':status', $status, PDO::PARAM_STR);
//     $stmt->bindParam(':book_Id', $id, PDO::PARAM_INT);
   
    
//     return $stmt->execute();
// }


// //update into out of stock 

// //$result = $crud->udpdateStatusInBookCopies($selectedTable,$update);
public function udpdateStatusInBookCopies($selectedTable, $book_Id){
    $sql = "UPDATE status SET status_name = 'Not_Available' WHERE id = :id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':id', $book_Id, PDO::PARAM_INT);
    return $stmt->execute();
}


// //search book
// public function getFilteredBook($selectedTable, $searchBook) {
//     $sql = "SELECT * FROM $selectedTable WHERE title  LIKE :searchBook";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->execute(['searchBook' => '%' . $searchBook . '%']);
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }





 
//   public function SelectedDeleteBook($selectedTable,$book_Id){
//     $query = "SELECT * FROM $selectedTable WHERE book_Id = ?";
//     $stmt = $this->connect()->prepare($query);
//     $stmt->execute([$book_Id]);
//     return $stmt->fetch(PDO::FETCH_ASSOC);
// }

// public function DeleteBook($book_Id, $selectedTable) {
//     $querySelect = "SELECT * FROM $selectedTable WHERE book_Id = :book_Id";
//     $queryInsert = "INSERT INTO archive.archives (arc_title, arc_author) VALUES (:arc_title, :arc_author)";
//     $queryDelete = "DELETE FROM $selectedTable WHERE book_Id = :book_Id";

//     // Retrieve book details from active books table
//     $stmtSelect = $this->connect()->prepare($querySelect);
//     $stmtSelect->bindParam(':book_Id', $book_Id, PDO::PARAM_INT);
//     $stmtSelect->execute();
//     $book = $stmtSelect->fetch(PDO::FETCH_ASSOC);

//     if ($book) {
//         // Insert the book into the archived books table
//         $stmtInsert = $this->connect()->prepare($queryInsert);
//         $stmtInsert->bindParam(':arc_title', $book['title'], PDO::PARAM_STR);
//         $stmtInsert->bindParam(':arc_author', $book['author'], PDO::PARAM_STR);
//         $stmtInsert->execute();

//         // Delete the book from the active books table
//         $stmtDelete = $this->connect()->prepare($queryDelete);
//         $stmtDelete->bindParam(':book_Id', $book_Id, PDO::PARAM_INT);
//         $stmtDelete->execute();

//         return true;
//     } else {
//         return false;
//     }
// }





 



//    public function bookListQuery(){
//        $sql = "
//         SELECT categories.*  
//         FROM books
//         JOIN categories ON books.id = categories.id
//         WHERE books.id = :id
//     ";
//     $stmt = $this->connect()->query($sql);
//     return $stmt->fetchAll(PDO::FETCH_COLUMN);
// }


public function bookListQuery(){
    $sql = "SELECT id, category FROM categories"; // Fetch both 'id' and 'category'
    $stmt = $this->connect()->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
}

// public function bookCat($mytbl){
//     $sql = "SELECT category FROM categories WHERE id = :id";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->bindParam(':id', $mytbl, PDO::PARAM_INT);
//     $stmt->execute();

//     // Check if the query is successful
//     if ($stmt->rowCount() > 0) {
//         // Fetch and return the result
//         return $stmt->fetch(PDO::FETCH_COLUMN);
//     } else {
//         // Return false if no result is found
//         return false;
//     }
// }


    
// // create book category    -- book_pdf LONGBLOB,
//    public function createBookTable($tableName) {
//     $space = str_replace(' ', '_', $tableName);  
//     $createQuery = "CREATE TABLE `$space` (
//         `book_Id` INT(11) AUTO_INCREMENT PRIMARY KEY,
//         `title` VARCHAR(255),
//         `author` VARCHAR(255),
//         `total_borrow_count` INT(11) NOT NULL,
//         `status` TEXT NULL,
//         `image` TEXT NULL,
//         `no_of_copies` INT(11) NULL,
//         `book_call_number` VARCHAR(255) NULL,
//         `book_abstract` TEXT NULL
//     )";


//         try {
//             $stmt = $this->connect()->exec($createQuery);
//             return $stmt; 
//         } catch (PDOException $e) {
            
//             echo "Error creating table: " . $e->getMessage();
//             return false; 
//         }
//     }

//     // delete book category
// public function deleteBookTable($tableName) {
        
//         $createQuery = "DROP TABLE `$tableName`";

//         try {
//             $stmt = $this->connect()->exec($createQuery);
//             return $stmt; 
//         } catch (PDOException $e) {
            
//             echo "Error creating table: " . $e->getMessage();
//             return false; 
//         }
//     }

    

    


//     public function selectedBook($selectedTable){
//         $selectedTables = str_replace(' ','_',($selectedTable));
//         $sql = "SELECT * FROM $selectedTables ORDER BY title ASC";  
//         $stmt = $this->connect()->query($sql);
//         return  $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }



// public function barBook() {
//     $sql = "SELECT COUNT(*) as cat_id FROM borrowings";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->execute();
//     $result = $stmt->fetch(PDO::FETCH_ASSOC);
//     return $result['cat_id'];
// }


//     // barchart of books
public function barBook() {
    try {
        $sql = "SELECT cat.category as title, cat.id, COUNT(*) as total_borrow_count
                FROM borrowings br
                -- INNER JOIN books b ON br.category_id = b.id
                INNER JOIN categories cat ON br.category_id = cat.id
                GROUP BY cat.id";

        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}










//  $sql = "SELECT *,SUM(total_borrow_count) AS total_borrow_count FROM $table ORDER BY total_borrow_count DESC";


//  public function barBook($id) {
//     try {
//         $sql = "SELECT cat.id, cat.*, b.*, bor.*,
//                 SUM(bor.count) AS total_borrow_count
//                 FROM categories cat
//                 INNER JOIN books b ON cat.id = b.id
//                 INNER JOIN borrowings bor ON cat.id = bor.appointment_Id
//                 WHERE cat.id = :id
//                 GROUP BY cat.id, cat.category, b.id, b.title, bor.appointment_Id, bor.count
//                 ORDER BY total_borrow_count DESC";

//         $stmt = $this->connect()->prepare($sql);
//         $stmt->bindParam(':id', $id, PDO::PARAM_INT);
//         $stmt->execute();

//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     } catch (PDOException $e) {
//         // Handle the exception, log, or return an empty array based on your needs
//         echo "Error: " . $e->getMessage();
//         return [];
//     }
// }




//     //Popular book
     public function popularBook($table){
       $sql = "SELECT *,SUM(total_borrow_count) AS total_borrow_count FROM books ORDER BY total_borrow_count DESC LIMIT 1";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


// //get all number of copies
//     public function getTotalCopies($selectedTable) {
//     $sql = "SELECT COUNT(book_Id) AS book_Id FROM $selectedTable";
//     $stmt = $this->connect()->query($sql);
//     $result = $stmt->fetch(PDO::FETCH_ASSOC);
//     return $result['book_Id'];
// }

// //get all total book
// public function getTotalBooks($selectedTable) {
//     $sql = "SELECT SUM(book_Id) AS book_Id FROM $selectedTable";
//     $stmt = $this->connect()->query($sql);
//     $result = $stmt->fetch(PDO::FETCH_ASSOC);
//     return $result['book_Id'];
// }


//     //Popular category
        public function bookListPopular() {
          
            $sql = "SELECT * FROM categories";
            $stmt = $this->connect()->query($sql);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }


//     // //total_appointments

   public function totalAppointments() {
    $stmt = $this->connect()->query("SELECT COUNT(count) as total FROM borrowings");
    $count_result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $count_result['total'];
}


//     //bookCategory
    public function bookCateory(){
        $bookCategory = "SELECT * FROM categories";
        $bookShow = $this->connect()->query($bookCategory);
        return $bookShow->fetchAll(PDO::FETCH_COLUMN);
    }


   

//     //selectedBookCatergory
// public function selectedBookCategory($selectedBook) {
//     $sql = "SELECT b.*, br.*, c.*, COUNT(br.book_Id) AS borrow_count
//             FROM books b
//             INNER JOIN categories c ON b.category_id = c.id
//             INNER JOIN borrowings br ON b.id = br.book_Id
//             WHERE c.id = :id
//             GROUP BY b.id
//             ORDER BY borrow_count DESC LIMIT 1";

//     $stmt = $this->connect()->prepare($sql);
//     $stmt->execute(['id' => $selectedBook]);
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }



public function selectedBookCategory($selectedBook) {
    $sql = "SELECT b.*, br.*, c.*, ba.*, a.*, COUNT(br.book_Id) AS borrow_count, publishers.*
            FROM books b
            INNER JOIN categories c ON b.category_id = c.id
            INNER JOIN borrowings br ON b.id = br.book_Id
            INNER JOIN book_authors ba ON b.id = ba.b_id
            INNER JOIN authors a ON ba.a_id = a.id
            INNER JOIN publishers ON b.id = publishers.id
            WHERE c.id = :id
            GROUP BY b.id
            ORDER BY borrow_count DESC LIMIT 1;";

    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $selectedBook]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




public function leastBorrowedBook($selectedBook) {
     $sql = "SELECT b.*, br.*, c.*, ba.*, a.*, COUNT(br.book_Id) AS borrowing_count
            FROM books b
            INNER JOIN categories c ON b.category_id = c.id
            INNER JOIN borrowings br ON b.id = br.book_Id
            INNER JOIN book_authors ba ON b.id = ba.b_id
            INNER JOIN authors a ON ba.a_id = a.id
            WHERE c.id = :id
            GROUP BY b.id
            ORDER BY borrowing_count DESC LIMIT 5;";

    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $selectedBook]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// public function leastBorrowedBook($selectedBook) {
//     $sql = "SELECT b.*, br.*, COUNT(*) AS borrowing_count
//             FROM categories c 
//             INNER JOIN books b ON b.category_id = c.id
//             INNER JOIN borrowings br ON b.id = br.appointment_Id
//             GROUP BY b.id
//             ORDER BY borrowing_count ASC
//             LIMIT 5";

//     $stmt = $this->connect()->query($sql);
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }




//     //selectedBookInCategory
//     public function selectedBookInCategory($selectedBook){
//         $sql = "SELECT * FROM $selectedBook ORDER BY total_borrow_count DESC LIMIT 1";
//         $stmt = $this->connect()->query($sql);
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }






// public function availableBooks() {
//     $sql = "SELECT b.*, s.*, a.*, ba.*
//             FROM books b 
//             INNER JOIN status s ON b.status_id = s.id
//             INNER JOIN book_authors ba ON b.id = ba.b_id
//             INNER JOIN authors a ON ba.a_id = a.id";
//     $stmt = $this->connect()->query($sql);
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }


// public function availableBooks() {
//     $sql = "SELECT b.*, s.*, a.*, ba.*
//             FROM books b 
//             INNER JOIN status s ON b.status_id = s.id
//             INNER JOIN authors a ON ba.a_id = a.id
//             INNER JOIN book_authors ba ON b.id = ba.b_id
//             ";
//     $stmt = $this->connect()->query($sql);
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }


// public function availableBooks() {
//     $sql = "SELECT b.*, s.*, a.*, ba.*
//             FROM books b 
//             INNER JOIN status s ON b.status_id = s.id
//             INNER JOIN book_authors ba ON b.id = ba.b_id
//             INNER JOIN authors a ON ba.a_id = a.id";
//     $stmt = $this->connect()->query($sql);
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }


//NewAcquiredBooks

// public function NewAcquiredBooks(){
//      $sql = "SELECT b.*, s.*, a.*
//             FROM books b 
//             INNER JOIN status s ON b.id = s.id
//             INNER JOIN authors a ON b.id = a.id ORDER BY b.id DESC LIMIT 10";
//      $stmt = $this->connect()->query($sql);
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }


public function availableBooks() {
    $sql = "
      SELECT b.*, a.author_name, s.*, c.category,publishers.*
        FROM books b
         INNER JOIN categories c ON b.category_id = c.id
        INNER JOIN book_authors ba ON b.id = ba.b_id
        INNER JOIN authors a ON ba.a_id = a.id
        INNER JOIN status s ON b.id = s.id
        INNER JOIN publishers ON b.id = publishers.id
        WHERE s.status_name = 'Available'
        GROUP BY b.id LIMIT 4
        
    ";
    $stmt = $this->connect()->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


//   SELECT b.*, a.author_name, s.*, c.category, cps.id AS copy_id, COUNT(cps.id) AS totalCPS, cps.book_call_number
//         FROM books b
//         INNER JOIN categories c ON b.category_id = c.id
//         INNER JOIN authors a ON b.id = a.id
//         INNER JOIN status s ON b.id = s.id
//         LEFT JOIN copies cps ON b.id = cps.book_id
//         WHERE c.id = :id
//         GROUP BY b.id

public function NewAcquiredBooks(){
    $sql = "SELECT b.*, a.author_name, s.*, c.category, publishers.*, cs.id AS copyId, cs.book_call_number
        FROM books b
        INNER JOIN categories c ON b.category_id = c.id
        INNER JOIN book_authors ba ON b.id = ba.b_id
        INNER JOIN authors a ON ba.a_id = a.id
        INNER JOIN status s ON b.id = s.id
        INNER JOIN publishers ON b.id = publishers.id
        INNER JOIN copies cs ON b.id = cs.book_id
        GROUP BY b.id
        ORDER BY b.id DESC LIMIT 4";
    $stmt = $this->connect()->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


 

// public function NewAcquiredBooks(){
//     $sql = "SELECT b.*, s.*, a.*, ba.*
//         FROM books b
//         INNER JOIN status s ON b.id = s.id
//         INNER JOIN book_authors ba ON b.id = ba.id
//         INNER JOIN authors a ON ba.b_id = a.id
//         GROUP BY b.id DESC";
//     $stmt = $this->connect()->query($sql);
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }



















//public function popularTitleBook($title) {
    // $sql = "SELECT b.*, s.*, a.*, c.*, cat.*,bor.*
    //         FROM borrowings bor
    //         INNER JOIN status s ON bor.appointment_Id = s.id
    //         INNER JOIN authors a ON bor.appointment_Id = a.id
    //         INNER JOIN copies c ON bor.appointment_Id = c.id
    //         INNER JOIN categories cat ON bor.appointment_Id = cat.id
    //         WHERE borrowings.appontment_Id = :id";

    // $stmt = $this->connect()->prepare($sql);
    // $stmt->bindParam(':id', $title, PDO::PARAM_STR);
    // $stmt->execute();
    // return $stmt->fetchAll(PDO::FETCH_ASSOC);



    // $sql = "SELECT b.*, s.*, a.*, c.*, cat.*
    //         FROM books b 
    //         INNER JOIN status s ON b.id = s.id
    //         INNER JOIN authors a ON b.id = a.id
    //         INNER JOIN copies c ON b.id = c.id
    //         INNER JOIN categories cat ON b.id = cat.id
    //         WHERE b.id = :id";

    // $stmt = $this->connect()->prepare($sql);
    // $stmt->bindParam(':id', $title, PDO::PARAM_STR);
    // $stmt->execute();
    // return $stmt->fetchAll(PDO::FETCH_ASSOC);
//}




//   public function AvailableTitleBook($title){
//      $sql = "SELECT * FROM $title WHERE status = 'Available'  ORDER BY RAND() LIMIT 20";
   
//     $stmt = $this->connect()->query($sql);
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }

public function popularTitleBooks($categoryId) {
    try {
        $sql = "SELECT b.*, bor.count, bor.book_number
                FROM books b 
                INNER JOIN borrowings bor ON b.id = bor.appointment_Id 
                WHERE bor.appointment_Id = :id 
                ORDER BY bor.count DESC 
                LIMIT 1";

        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle the exception, log, or return an empty array based on your needs
        echo "Error: " . $e->getMessage();
        return [];
    }
}



//     //leastBorrowedBook
 
//    // Update the book image
public function updatedImage($image, $id)
{
    try {
        $query = "UPDATE books SET image = :image WHERE id = :id";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":image", $image);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return true; // Return true on success
    } catch (PDOException $e) {
        throw new Exception("Error updating image: " . $e->getMessage());
    }
    }


    public function getBookCategories() {
        $sql = "SELECT * FROM categories";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

//     //getbook in bookmark
   public function getSelectedBook($book_table_name, $book_Id) {
    $book_sql = "SELECT b.title, a.author_name,b.image
                 FROM books b
                 INNER JOIN authors a ON b.id = a.id 
                 WHERE b.id = :id";

    $book_stmt = $this->connect()->prepare($book_sql);
    $book_stmt->bindParam(':id', $book_Id, PDO::PARAM_INT);
    $book_stmt->execute();
    return $book_stmt->fetch(PDO::FETCH_ASSOC);
}


//     //get status in book
     public function getStatus($book_table_name, $book_Id){
    $sql = "SELECT s.status_name, b.title 
            FROM status s 
            INNER JOIN books b ON s.id = b.id 
            WHERE b.id = :id";

    $book_stmt = $this->connect()->prepare($sql);
    $book_stmt->bindParam(':id', $book_Id, PDO::PARAM_INT);
    $book_stmt->execute();
    return $book_stmt->fetch(PDO::FETCH_ASSOC);
}


//     //getBookmarkedBook
     public function getBookmarkedBook($book_table_name,$book_Id){
        $book_sql = "SELECT * FROM books WHERE id = :id";
        $book_stmt = $this->connect()->prepare($book_sql);
        $book_stmt->bindParam(':id', $book_Id, PDO::PARAM_INT);
        $book_stmt->execute();
                    
        return $book_stmt->fetch(PDO::FETCH_ASSOC);
    }


//     // APPONTMENT PLACE 


public function appointmentGetBookId($selectedTable, $bookId, $user_id) {
    $sql = "
        SELECT 
            books.*, 
            authors.*, 
            status.*, 
            COUNT(borrowings.book_Id) AS borrow_count, 
            users.*,
            publishers.*
        FROM 
            books
        JOIN 
            authors ON books.id = authors.id
        JOIN 
            status ON books.id = status.id
        LEFT JOIN 
            borrowings ON books.id = borrowings.book_Id
        LEFT JOIN 
            users ON borrowings.user_id = users.user_id
        INNER JOIN 
            publishers ON books.id = publishers.id
        WHERE 
            books.id = :id
        GROUP BY 
            books.id
    ";

    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $bookId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    


// public function appointmentGetBookId($selectedTable,$bookId,$user_id){
//      $sql = "
//         SELECT books.*, authors.*,status.*
//         FROM books
//         JOIN authors ON books.id = authors.id
//         JOIN status ON books.id = status.id
//         WHERE books.id = :id
//     ";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->execute(['id' => $bookId]);
//     return $stmt->fetch(PDO::FETCH_ASSOC);
// }





//  public function getBorrowId($bookId){
//       $sql = "
//         SELECT books.*, authors.*,status.*,copies.*,copies.book_id, copies.book_call_number
//         FROM books
//         JOIN authors ON books.id = authors.id
//         JOIN status ON books.id = status.id
//         JOIN copies ON books.id = copies.id
//         WHERE books.id = :id
//     ";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->execute(['id' => $bookId]);
//     return $stmt->fetch(PDO::FETCH_ASSOC);
// }


 


     public function ViewBook($selectedTable,$bookId){
        $query = "SELECT * FROM books WHERE id = ?";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute([$bookId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    }



//     // Increment the borrow count for the book
public function CountOfBook($book_number, $selectedTable) {
    try {
        $pdo = $this->connect();
        // Delete rows from the "copies" table where the "book_id" matches
        $stmt_copies = $pdo->prepare("UPDATE copies SET statusPerCopy = 'Borrowed' WHERE id = ?");
        $stmt_copies->execute([$book_number]);
        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}


public function AddTotal_borrow_count($book_number, $total_borrow_count) {
    try {
        $pdo = $this->connect();

        $stmt_books = $pdo->prepare("INSERT INTO total_borrows (book_id, total_borrow_count) VALUES (:book_id, :total_borrow_count)");
        $stmt_books->bindParam(':book_id', $book_number, PDO::PARAM_INT);
        $stmt_books->bindParam(':total_borrow_count', $total_borrow_count, PDO::PARAM_INT);
        $stmt_books->execute();

        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}








//     // Update the count in the borrowings table based on borrowing date
    public function UpdateCountBorrowings($borrowingDate){
        $stmt = $this->connect()->prepare("UPDATE borrowings SET count = count + 1 WHERE borrowing_date = ?");
        return $stmt->execute([$borrowingDate]);
    }


//        //borrowdate
    public function BorrowDate($borrowingDate){
        $stmt = $this->connect()->prepare("SELECT count FROM borrowings WHERE borrowing_date = ? LIMIT 5");
        $stmt->execute([$borrowingDate]);
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

     
    
//     // Insert the borrowing record into the borrowings table
    public function InsertRecord($generateId, $book_number, $borrowerName, $borrowingDate, $book_title, $book_author, $borrower_address, $borrower_email, $status, $user_id,$dueDate,$book_call_number,$category_id,$book_Id,$copy_id){
        $stmt = $this->connect()->prepare("INSERT INTO borrowings (generateId, book_number, borrower_name, borrowing_date, book_title, book_author, borrower_address, borrower_email, status, user_id, appointmentDate,book_call_number,category_id,book_Id,copy_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?)");
        return $stmt->execute([$generateId, $book_number, $borrowerName, $borrowingDate, $book_title, $book_author, $borrower_address, $borrower_email, $status, $user_id,$dueDate,$book_call_number,$category_id,$book_Id,$copy_id]);
    }




public function SelectAllAuthors(){
    $sql = "
       SELECT * FROM books;
    ";
    $stmt = $this->connect()->query($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function checkAccessionNumber($book_call_number) {
    $sql = "SELECT book_call_number FROM copies WHERE book_call_number = :book_call_number";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':book_call_number', $book_call_number, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result !== false;
}



public function SelectAllAuthorsWithLimit($results_per_page, $offset){
    $sql = "SELECT * FROM books LIMIT :limit OFFSET :offset";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindValue(':limit', $results_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




public function AllCpsINBooks(){
    $sql = "
       SELECT * FROM books;
    ";
    $stmt = $this->connect()->query($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



public function Alllistofthebook() {
    // Your SQL query should include LIMIT and OFFSET
    $sql = "SELECT b.*, a.author_name, s.*, c.category, 
                (SELECT COUNT(cps_sub.id) FROM copies cps_sub WHERE cps_sub.book_id = b.id) AS totalCPS,
                (SELECT COUNT(cps_sub2.id) FROM copies cps_sub2 WHERE cps_sub2.book_id = b.id AND cps_sub2.statusPerCopy = 'available') AS totalAvailableCPS
            FROM books b
            INNER JOIN categories c ON b.category_id = c.id
            INNER JOIN authors a ON b.id = a.id
            INNER JOIN status s ON b.id = s.id
            GROUP BY b.id";
    $stmt = $this->connect()->query($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}



public function existing_authors(){

    $sql = "SELECT author_name FROM authors";
    
    $stmt = $this->connect()->query($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getBookOverview($bookId){
    $sql = "
        SELECT 
            books.*, 
            authors.*, 
            status.*, 
            borrowings.*, 
            COUNT(borrowings.book_Id) AS borrow_count, 
            users.*,
            categories.*,
            publishers.*
        FROM 
            books
        JOIN 
            authors ON books.id = authors.id
        JOIN 
            status ON books.id = status.id
        LEFT JOIN 
            borrowings ON books.id = borrowings.book_Id
        LEFT JOIN 
            users ON borrowings.user_id = users.user_id
        LEFT JOIN 
            categories ON books.category_id = categories.id
        LEFT JOIN 
            publishers ON books.id = publishers.id
        WHERE 
            books.id = :id
        GROUP BY 
            books.id
    ";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $bookId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}



public function CountInnerJoinBookArchive() {
    try {
        $sql = "SELECT COUNT(id) as BookArchiveId FROM archives";
        $stmt = $this->connect()->query($sql);

        // Fetch the result as an associative array
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle any exceptions
        die("Error: " . $e->getMessage());
    }
}

 



    public function getAllBookReport(){
        //back up
        $sql = "
            SELECT b.*, a.author_name, s.*, pub.*, c.category
            FROM books b
            INNER JOIN categories c ON b.category_id = c.id
            INNER JOIN authors a ON b.id = a.id
            INNER JOIN status s ON b.id = s.id
            INNER JOIN publishers pub ON b.id = pub.id
            LEFT JOIN copies cps ON b.id = cps.book_id
            GROUP BY b.id
        ";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }







public function CountAllBookReport() {
    $sql = 'SELECT COUNT(id) as TOTALId FROM books';
    $stmt = $this->connect()->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    
}



?>