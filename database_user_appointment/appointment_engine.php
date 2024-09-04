<?php

require_once "user_appointment.php";
require_once "../DATABASE/book_catalog_db.php";
require_once "../END_USER/end_user_db.php";

// require_once "../database_book_catalog/appointment_engine.php";


class CRUD_appoint extends Appointment_DB {

//LINE CHART
    public function appointmentLineChart(){
        $sql = "SELECT DATE_FORMAT(borrowing_date, '%Y-%m-%d') AS borrowing_date, COUNT(*) AS count FROM borrowings GROUP BY borrowing_date ORDER BY borrowing_date ASC";
        $stmt =  $this->connect()->query($sql);
        return $stmt;

    }

    //FILTER DATE
    public function filterDate($start_date,$end_date){
         $sql = "SELECT DATE_FORMAT(borrowing_date, '%Y-%m-%d') AS borrowing_date, COUNT(*) AS count
                FROM borrowings
                WHERE borrowing_date BETWEEN :start_date AND :end_date
                GROUP BY borrowing_date
                ORDER BY borrowing_date ASC";

        $stmt = $this->connect()->prepare($sql);
        return $stmt;   
    } 


 
 
//  public function appointmentResult($seletedCategory) {
//         $otherDatabase = 'books';   
//         $sql = "SELECT appointments.borrowings.appointment_Id,appointments.borrowings.generateId, appointments.borrowings.borrower_name, appointments.borrowings.borrowing_date, appointments.borrowings.borrower_contact,appointments.borrowings.appointmentDate, $otherDatabase.$seletedCategory.title, $otherDatabase.$seletedCategory.status FROM appointments.borrowings INNER JOIN $otherDatabase.$seletedCategory ON appointments.borrowings.book_number = $otherDatabase.$seletedCategory.book_Id ORDER BY appointments.borrowings.appointment_Id DESC";
//         $stmt = $this->connect()->prepare($sql);
//         $stmt->execute();
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }

// public function appointmentResult() {
        
//         $sql = "SELECT * FROM borrowings ORDER BY appointment_Id DESC";
//         $stmt = $this->connect()->prepare($sql);
//         $stmt->execute();
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }


    



// if(isset($_GET['appointment_Id'])){
//     $appointment_Id = $_GET['appointment_Id'];
//     $getUser = $appointment->user_get_id($appointment_Id);
// }

// public function user_get_id($appointment_Id) {
  

    
//     //  $sql = "SELECT * FROM borrowings WHERE appointment_Id = :appointment_Id";
//     // $stmt = $this->connect()->prepare($sql);
//     // $stmt->bindParam(':appointment_Id', $appointment_Id, PDO::PARAM_INT);
//     // $stmt->execute();
//     // return $stmt->fetch(PDO::FETCH_ASSOC);

//     $sql = "SELECT 
//                 borrowings.*,
//                 books.*
//             FROM 
//                 borrowings 
//             INNER JOIN 
//                 books ON borrowings.appointment_Id = books.id
//             WHERE
//                 borrowings.appointment_Id = :appointment_Id
//             ORDER BY 
//                 borrowings.appointment_Id DESC";
    
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->bindParam(':appointment_Id', $appointment_Id, PDO::PARAM_INT);
//     $stmt->execute();
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }



// public function user_get_id($appointment_Id) {
    
//   $sql = "SELECT * FROM borrowings WHERE appointment_Id = :appointment_Id";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->bindParam(':appointment_Id', $appointment_Id, PDO::PARAM_INT);
//     $stmt->execute();
//     return $stmt->fetch(PDO::FETCH_ASSOC);
// }


// public function user_get_id($appointment_Id) {
    
//   $sql = "SELECT bks.*, b.*, c.*, a.*, au.*
//             FROM borrowings b
//             INNER JOIN copies c ON b.book_Id = c.book_id
//             INNER JOIN books bks ON bks.id = c.book_Id
//             INNER JOIN authors au ON au.id = c.bks.id
//             INNER JOIN book_authors a ON a.id = c.a_id
//             WHERE appointment_Id = :appointment_Id";
            
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->bindParam(':appointment_Id', $appointment_Id, PDO::PARAM_INT);
//     $stmt->execute();
//     return $stmt->fetch(PDO::FETCH_ASSOC);
// }
public function user_get_id($appointment_Id) {
    $sql = "SELECT bks.*, b.*, c.id, ba.id, a.*
            FROM borrowings b
            INNER JOIN books bks ON bks.id = b.book_Id
            INNER JOIN copies c ON c.book_id = b.book_Id
             INNER JOIN book_authors ba ON ba.b_id = b.book_Id
            INNER JOIN authors a ON a.id  = ba.a_id
            WHERE b.appointment_Id = :appointment_Id";
            
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':appointment_Id', $appointment_Id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}



//  $sql = "SELECT b.*,c.*
//             FROM borrowings b
//             INNER JOIN copies c ON b.appointment_Id = c.id
//             ORDER BY b.appointment_Id DESC";
//     $stmt = $this->connect()->query($sql);
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);








// public function deleteAppoointment($appointment_Id){
//     $sql = "DELETE FROM borrowings WHERE appointment_Id = :appointment_Id";
//     $stmt = $this->connect()->prepare($sql);
//     return $stmt->execute(['appointment_Id'=>$appointment_Id]);

// }




//ADD BOOK TO RETRUNED

// public function addtoReturnBook($account_user_id, $borrower_user_id, $name_of_borrower, $book_borrowed,$book_id) {
//     $sql = 'INSERT INTO returnBooks (account_user_id, borrower_user_id, name_of_borrower, book_borrowed, book_id) 
//             VALUES (:account_user_id, :borrower_user_id, :name_of_borrower, :book_borrowed, :book_id)';
    
//     try {
//         $stmt = $this->connect()->prepare($sql);
//         $stmt->bindParam(':account_user_id', $account_user_id, PDO::PARAM_INT);
//         $stmt->bindParam(':borrower_user_id', $borrower_user_id, PDO::PARAM_INT);
//         $stmt->bindParam(':name_of_borrower', $name_of_borrower, PDO::PARAM_STR);
//         $stmt->bindParam(':book_borrowed', $book_borrowed, PDO::PARAM_STR);
//         $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        
//         return $stmt->execute();
//     } catch (PDOException $e) {
//         // Handle the exception, e.g., log it or throw a custom exception
//         // You may want to log the error or throw a custom exception here
//         // Example: throw new CustomException("Failed to add return book: " . $e->getMessage());
//         return false;
//     }
// } 


public function AcceptRequestBook($appointment_Id, $status, $borrowing_date, $dueDate, $book_id) {
    // Update borrowings table
    $sql = "UPDATE borrowings SET status = :status, borrowing_date = :borrowing_date, appointmentDate = :appointmentDate WHERE appointment_Id = :appointment_Id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['appointment_Id' => $appointment_Id, 'status' => $status, 'borrowing_date' => $borrowing_date, 'appointmentDate' => $dueDate]);

    // Update copies table
    $sql1 = "UPDATE copies SET statusPerCopy = 'Borrowed' WHERE id = :id";
    $stmt1 = $this->connect()->prepare($sql1);  
    $stmt1->execute(['id' => $book_id]);
}


//DeclineRequestBook
public function DeclineRequestBook($appointment_Id,$book_id) {
    // Update borrowings table
    $sql1 = "UPDATE borrowings SET status = 'Decline' WHERE appointment_Id = :appointment_Id";
    $stmt1 = $this->connect()->prepare($sql1);
    $stmt1->execute(['appointment_Id' => $appointment_Id]);

    // Update copies table
    $sql = "UPDATE copies SET statusPerCopy = 'Available' WHERE id = :id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['id' => $book_id]);
}


public function DeclineRequestBookExpired($appointment_Id, $book_Id) {
    try {
        // Update borrowings table
        $sql1 = "UPDATE borrowings SET status = 'Decline' WHERE appointment_Id = :appointment_Id";
        $stmt1 = $this->connect()->prepare($sql1);
        $stmt1->execute(['appointment_Id' => $appointment_Id]);

        // Update copies table
        $sql2 = "UPDATE copies SET statusPerCopy = 'Available' WHERE id = :id";
        $stmt2 = $this->connect()->prepare($sql2);
        $stmt2->execute(['id' => $book_Id]);

        return true; // Success
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
        return false;
    }
}






public function UpdatetoReturnBook($appointment_Id, $borrowing_date,$status,$book_id, $b_id, $return_date,$u_id) {
    $pdo = $this->connect(); // Use the same connection

    $pdo->beginTransaction();

    try {
        // Update borrowings table
        $sql = 'UPDATE borrowings 
                SET borrowing_date = :borrowing_date, status = :status
                WHERE appointment_Id = :appointment_Id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':borrowing_date', $borrowing_date, PDO::PARAM_STR);
        $stmt->bindParam(':appointment_Id', $appointment_Id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->execute();
        $rowCountBorrowings = $stmt->rowCount();

 // Update copies table
        $sql1 = "UPDATE copies SET statusPerCopy = 'Available' WHERE id = :id";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->bindParam(':id', $book_id, PDO::PARAM_INT);
        $stmt1->execute();
        $rowCountCopies = $stmt1->rowCount();

        $sqlReturn = "INSERT INTO returns (b_id, return_date, u_id) VALUES (:b_id, :return_date, :u_id)";
        $stmtR = $pdo->prepare($sqlReturn);
        
        $stmtR->bindParam(':b_id', $b_id, PDO::PARAM_INT);
        $stmtR->bindParam(':u_id', $u_id, PDO::PARAM_INT);
        $stmtR->bindParam(':return_date', $return_date, PDO::PARAM_STR);
        $stmtR->execute();
        $rowCountReturn = $stmtR->rowCount();


        
        

        if ($rowCountBorrowings > 0 && $rowCountCopies > 0 && $rowCountReturn > 0) {
            $pdo->commit();
            header("Location: admin_appointment.php");
            return true;
        } else {
            $pdo->rollBack();
            return false;
        }
    } catch (PDOException $e) {
        // Log or handle the exception appropriately
        $pdo->rollBack();
        return false;
    }
}




// public function UpdatetoReturnBook($appointment_Id, $borrowing_date, $status, $book_id) {
//     $pdo = $this->connect(); // Use the same connection

//     $pdo->beginTransaction();

//     try {
//         // Update borrowings table
//         $sql = 'UPDATE borrowings 
//                 SET borrowing_date = :borrowing_date, status = :status
//                 WHERE appointment_Id = :appointment_Id';
//         $stmt = $pdo->prepare($sql);
//         $stmt->bindParam(':borrowing_date', $borrowing_date, PDO::PARAM_STR);
//         $stmt->bindParam(':appointment_Id', $appointment_Id, PDO::PARAM_INT);
//         $stmt->bindParam(':status', $status, PDO::PARAM_INT);
//         $stmt->execute();
//         $rowCountBorrowings = $stmt->rowCount();

//         // Update copies table
//         $sql1 = "UPDATE copies SET statusPerCopy = 'Returned' WHERE id = :id";
//         $stmt1 = $pdo->prepare($sql1);
//         $stmt1->bindParam(':id', $book_id, PDO::PARAM_INT);
//         $stmt1->execute();
//         $rowCountCopies = $stmt1->rowCount();

//         if ($rowCountBorrowings > 0 && $rowCountCopies > 0) {
//             $pdo->commit();
//             header("Location: admin_appointment.php");
//             return true;
//         } else {
//             $pdo->rollBack();
//             return false;
//         }
//     } catch (PDOException $e) {
//         // Log or handle the exception appropriately
//         $pdo->rollBack();
//         return false;
//     }
// }




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


//SEE ALL RETURN BOOK
public function seeAllReturnBook($offset, $records_per_page){
    try {
      $sql = "SELECT r.*, copies.*, u.*, books.*
                FROM returns r
                INNER JOIN copies ON r.b_id = copies.id
                INNER JOIN books ON copies.book_id = books.id
                INNER JOIN users u ON r.u_id = u.user_id
                ORDER BY r.id DESC
                LIMIT :offset, :records_per_page";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle the exception (e.g., log the error, display an error message)
        echo "Error: " . $e->getMessage();
    }
}



public function TotalReturnBook(){
    try {
        $sql = "SELECT COUNT(id) AS totalReturns FROM returns";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['totalReturns'];
    } catch (PDOException $e) {
        // Handle the exception (e.g., log the error, display an error message)
        echo "Error: " . $e->getMessage();
    }
}







  




public function insert_user_borrow($borrow_name,$borrow_book_title,$borrow_user_id,$borrow_date){
     $sql = 'INSERT INTO user_borrowed (borrow_name,borrow_book_title,borrow_user_id,borrow_date) VALUES (:borrow_name,:borrow_book_title,:borrow_user_id,:borrow_date)';
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute(['borrow_name' => $borrow_name, 'borrow_book_title' => $borrow_book_title, 'borrow_user_id' => $borrow_user_id, 'borrow_date' => $borrow_date]);
}

public function get_user_borrowed() {
    $sql = "SELECT * FROM user_borrowed";
    $stmt = $this->connect()->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function get_one_user_borrowed($borrow_id) {
    $sql = "SELECT * FROM user_borrowed WHERE borrow_id = :borrow_id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':borrow_id', $borrow_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

  
// public function appointmentResult($selectedCategory) {
//     $sql = "SELECT * FROM borrowings WHERE category_id = :selectedCategory";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->bindParam(':category_id', $selectedCategory, PDO::PARAM_INT);
//     $stmt->execute();
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }


// public function appointmentResult($selectedCategory) {

    //  $sql = "
    //     SELECT b.*, a.author_name, s.status_name, c.category, cps.no_of_copies, cps.book_call_number
    //     FROM books  b
    //     INNER JOIN categories  c ON b.category_id = c.id
    //     INNER JOIN authors  a ON b.id = a.id
    //     INNER JOIN status  s ON b.id = s.id
    //     INNER JOIN copies  cps ON b.id = cps.id
    //     WHERE c.id = :categoryId
    // ";

    
//     $sql = "SELECT 
//                 borrowings.appointment_Id,
//                 borrowings.generateId, 
//                 borrowings.borrower_name, 
//                 borrowings.borrowing_date, 
//                 borrowings.borrower_contact,
//                 borrowings.appointmentDate,
//                 borrowings.user_id,
//                 books.id,
//                 books.category_id,
//                 books.title, 
//                 copies.book_call_number,
//                 status.status_name,
//                 categories.id
//             FROM 
//                 borrowings 
//             INNER JOIN 
//                 books ON borrowings.appointment_Id = books.id
//             INNER JOIN 
//                 copies ON borrowings.appointment_Id = copies.id
//             INNER JOIN 
//                 status ON borrowings.appointment_Id = status.id
//             INNER JOIN 
//                 categories ON books.id = categories.id
//             WHERE
//                 categories.id = :selectedCategory
//             ORDER BY 
//                 borrowings.appointment_Id DESC";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->bindParam(':selectedCategory', $selectedCategory, PDO::PARAM_INT);
//     $stmt->execute();
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }



// public function appointmentResult() {  
//    $sql = "SELECT * FROM borrowings ORDER BY appointment_id DESC";
//     $stmt = $this->connect()->query($sql);
//     $stmt->execute();
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }

public function appointmentResult() {
    try {
        $sql = "SELECT b.*, copies.id, bk.*, u.*
                FROM borrowings b
                INNER JOIN copies ON b.book_Id = copies.id
                INNER JOIN books bk ON b.book_Id = bk.id
                INNER JOIN users u ON b.user_id = u.user_id
                WHERE b.status = 'Available'
                ORDER BY b.appointment_Id DESC";

        // Prepare and execute the query
        $stmt = $this->connect()->query($sql);

        // Fetch all rows as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle any exceptions
        die("Error: " . $e->getMessage());
    }
}

public function appointmentResultBorrowed() {
    try {
        $sql = "SELECT b.*, copies.id, bk.*, u.*
                FROM borrowings b
                INNER JOIN copies ON b.book_Id = copies.id
                INNER JOIN books bk ON b.book_Id = bk.id
                INNER JOIN users u ON b.user_id = u.user_id
                WHERE b.status = 'Borrowed'
                ORDER BY b.appointment_Id DESC";

        // Prepare and execute the query
        $stmt = $this->connect()->query($sql);

        // Fetch all rows as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle any exceptions
        die("Error: " . $e->getMessage());
    }
}
public function CountAppointmentResultBorrowed() {
    try {
        $sql = "SELECT COUNT(appointment_Id) as AppointmentTotal
                FROM borrowings 
                WHERE status = 'Borrowed'";

        // Prepare and execute the query
        $stmt = $this->connect()->query($sql);

        // Fetch the result as an associative array
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle any exceptions
        die("Error: " . $e->getMessage());
    }
}


public function appointmentResultReturned() {
    try {
        $sql = "SELECT b.*, copies.id, bk.*, u.*
                FROM borrowings b
                INNER JOIN copies ON b.book_Id = copies.id
                INNER JOIN books bk ON b.book_Id = bk.id
                INNER JOIN users u ON b.user_id = u.user_id
                WHERE b.status = 'Returned'
                ORDER BY b.appointment_Id DESC";

        // Prepare and execute the query
        $stmt = $this->connect()->query($sql);

        // Fetch all rows as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle any exceptions
        die("Error: " . $e->getMessage());
    }
}

public function CountAppointmentResultReturned() {
    try {
        $sql = "SELECT COUNT(appointment_Id) as AppointmentTotal
                FROM borrowings 
                WHERE status = 'Returned'";

        // Prepare and execute the query
        $stmt = $this->connect()->query($sql);

        // Fetch the result as an associative array
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle any exceptions
        die("Error: " . $e->getMessage());
    }
}



public function appointmentResultPenalty() {
    try {
        $sql = "SELECT b.*, copies.id, bk.*, u.*
                FROM borrowings b
                INNER JOIN copies ON b.book_Id = copies.id
                INNER JOIN books bk ON b.book_Id = bk.id
                INNER JOIN users u ON b.user_id = u.user_id
                WHERE b.status = 'Penalty'
                ORDER BY b.appointment_Id DESC";

        // Prepare and execute the query
        $stmt = $this->connect()->query($sql);

        // Fetch all rows as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle any exceptions
        die("Error: " . $e->getMessage());
    }
}

public function CountAppointmentResultPenalty() {
    try {
        $sql = "SELECT COUNT(appointment_Id) as AppointmentTotal
                FROM borrowings 
                WHERE status = 'Penalty'";

        // Prepare and execute the query
        $stmt = $this->connect()->query($sql);

        // Fetch the result as an associative array
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle any exceptions
        die("Error: " . $e->getMessage());
    }
}


//total borrowed

public function TotalBorrowResult() {
    try {
        $sql = "SELECT COUNT(*) AS totalBorrowed FROM borrowings WHERE status = 'Borrowed'";

        // Prepare and execute the query
        $stmt = $this->connect()->query($sql);

        // Fetch the result as an associative array
        return $stmt->fetch(PDO::FETCH_ASSOC)['totalBorrowed'];
    } catch (PDOException $e) {
        // Handle any exceptions
        die("Error: " . $e->getMessage());
    }
}


//total returned


public function TotalReturnedResult() {
    try {
        $sql = "SELECT COUNT(*) AS totalBorrowed FROM borrowings WHERE status = 'Returned'";

        // Prepare and execute the query
        $stmt = $this->connect()->query($sql);

        // Fetch the result as an associative array
        return $stmt->fetch(PDO::FETCH_ASSOC)['totalBorrowed'];
    } catch (PDOException $e) {
        // Handle any exceptions
        die("Error: " . $e->getMessage());
    }
}



//total pending


public function TotalPendingResult() {
    try {
        $sql = "SELECT COUNT(*) AS totalBorrowed FROM borrowings WHERE status = 'Available'";

        // Prepare and execute the query
        $stmt = $this->connect()->query($sql);

        // Fetch the result as an associative array
        return $stmt->fetch(PDO::FETCH_ASSOC)['totalBorrowed'];
    } catch (PDOException $e) {
        // Handle any exceptions
        die("Error: " . $e->getMessage());
    }
}



//total penalty


public function TotalPenaltyResult() {
    try {
        $sql = "SELECT COUNT(*) AS totalBorrowed FROM borrowings WHERE status = 'Penalty'";

        // Prepare and execute the query
        $stmt = $this->connect()->query($sql);

        // Fetch the result as an associative array
        return $stmt->fetch(PDO::FETCH_ASSOC)['totalBorrowed'];
    } catch (PDOException $e) {
        // Handle any exceptions
        die("Error: " . $e->getMessage());
    }
}









// public function appointmentResult($selectedCategory) {
//     $sql = "SELECT 
//                 borrowings.generateId, 
//                 borrowings.borrower_name, 
//                 borrowings.borrowing_date, 
//                 borrowings.borrower_contact,
//                 FLOOR((UNIX_TIMESTAMP(borrowings.appointmentDate) - UNIX_TIMESTAMP(DATE_SUB(borrowings.appointmentDate, INTERVAL 1 DAY))) / (24 * 3600)) AS differenceInDays,
//                 books.title, 
//                 books.status 
//             FROM 
//                 borrowings 
//             INNER JOIN 
//                 books ON borrowings.book_number = books.id 
//             WHERE 
//                 books.category = :selectedCategory
//             ORDER BY 
//                 borrowings.appointment_Id DESC";

//     $stmt = $this->connect()->prepare($sql);
//     $stmt->bindParam(':selectedCategory', $selectedCategory, PDO::PARAM_STR);
//     $stmt->execute();

//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }





    
public function getAllAppointmentList($user_id){
    $sql = "SELECT * FROM borrowings WHERE user_id = :user_id ORDER BY appointment_Id DESC";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// public function UpdatetoPenalty($appointmentId) {
//     $sqlUpdate = "UPDATE borrowings SET status = 'Penalty', penaltyCount = penaltyCount + 1 WHERE appointment_Id = :appointmentId";
//     $stmtUpdate = $this->connect()->prepare($sqlUpdate);
//     $stmtUpdate->bindParam(':appointmentId', $appointmentId, PDO::PARAM_INT);
//     $stmtUpdate->execute();
// }

public function UpdatetoPenalty($appointmentId) {
    $sqlUpdate = "UPDATE borrowings SET status = 'Penalty', penaltyCount = penaltyCount + 1 WHERE appointment_Id = :appointmentId";
    $stmtUpdate = $this->connect()->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':appointmentId', $appointmentId, PDO::PARAM_INT);
    if ($stmtUpdate->execute()) {
        return true; // Update successful
    } else {
        return false; // Update failed
    }
}

// public function UpdatetoPenaltyCount($appointmentId) {
    
//     $sqlUpdate = "UPDATE borrowings SET  penaltyCount = penaltyCount + 1 WHERE appointment_Id = :appointmentId";
//     $stmtUpdate = $this->connect()->prepare($sqlUpdate);
//     $stmtUpdate->bindParam(':appointmentId', $appointmentId, PDO::PARAM_INT);
//     if ($stmtUpdate->execute()) {
//         return true; // Update successful
//     } else {
//         return false; // Update failed
//     }
// }


public function UpdatetoPenaltyCount($appointmentId, $newPenaltyCount) {
    $sqlUpdate = "UPDATE borrowings SET penaltyCount = :newPenaltyCount WHERE appointment_Id = :appointmentId";
    $stmtUpdate = $this->connect()->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':newPenaltyCount', $newPenaltyCount, PDO::PARAM_INT);
    $stmtUpdate->bindParam(':appointmentId', $appointmentId, PDO::PARAM_INT);
    if ($stmtUpdate->execute()) {
        return true; // Update successful
    } else {
        return false; // Update failed
    }
}





public function AddPenaltyCountAll($appointmentId){
     $sqlUpdate = "UPDATE borrowings SET status = 'Penalty' WHERE appointment_Id = :appointmentId";
    $stmtUpdate = $this->connect()->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':appointmentId', $appointmentId, PDO::PARAM_INT);
    $stmtUpdate->execute();
}

// public function UpdatetoAvalable($UpdateToBorrwoed){
//     $sqlUpdate = "UPDATE copies SET statusPerCopy = 'Available' WHERE appointment_Id = :appointment_Id";
//     $stmtUpdate = $this->connect()->prepare($sqlUpdate);
//     $stmtUpdate->bindParam(':id', $UpdateToBorrwoed, PDO::PARAM_INT);
//     $stmtUpdate->execute();
// }

// public function UpdatetoAvailable($appointmentId){
//      $sqlUpdate = "UPDATE borrowings SET status = 'Available' WHERE appointment_Id = :appointmentId";
//     $stmtUpdate = $this->connect()->prepare($sqlUpdate);
//     $stmtUpdate->bindParam(':appointmentId', $appointmentId, PDO::PARAM_INT);
//     $stmtUpdate->execute();
// }

// public function UpdatetoCopiesAvailable($appointmentId){
//      $sqlUpdate = "UPDATE copies SET statusPerCopy = 'Available' WHERE id = :id";
//     $stmtUpdate = $this->connect()->prepare($sqlUpdate);
//     $stmtUpdate->bindParam(':id', $appointmentId, PDO::PARAM_INT);
//     $stmtUpdate->execute();
// }

//total penalties

// public function TotalPenalties($user_id){
//     $sql = "SELECT COUNT(*) as penalty_count FROM borrowings WHERE user_id = :user_id AND status = 'Penalty'";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
//     $stmt->execute();
//     $result = $stmt->fetch(PDO::FETCH_ASSOC);
//     // Return the count of penalties
//     return $result['penalty_count'];

// }

public function TotalPenalties($user_id){
    $sql = "SELECT SUM(penaltyCount) as penalty_count FROM borrowings WHERE user_id = :user_id AND status = 'Penalty'";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchColumn();
  
    return $result;
}



public function TotalBorrowed($user_id){
    $sql = "SELECT COUNT(*) as penalty_count FROM borrowings WHERE user_id = :user_id AND status = 'Borrowed'";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchColumn();
  
    return $result;
}


// public function getAllBorrowedList($user_id){
//     $sql = "SELECT borrow_user_id FROM appointments.user_borrowed WHERE user_id = :user_id ORDER BY user_id DESC";
//     $stmt = $this->connect()->prepare($sql);
//     $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
//     $stmt->execute();
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }

public function getAllBorrowedList($user_id) {
    $sql = "SELECT borrow_user_id,borrow_name,borrow_book_title,borrow_date  FROM appointments.user_borrowed WHERE borrow_user_id = :borrow_user_id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':borrow_user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

 

//  public function getUserAppointments($user_id) {
//         $sql = "SELECT * FROM appointments.borrowings WHERE appointment_Id = :appointment_Id";
//         $stmt = $this->connect()->prepare($sql);
//         $stmt->bindParam(':appointment_Id', $user_id, PDO::PARAM_INT);
//         $stmt->execute();
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }


 public function getUserAppointments() {
        $sql = "SELECT * FROM borrowings";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   

}

?>