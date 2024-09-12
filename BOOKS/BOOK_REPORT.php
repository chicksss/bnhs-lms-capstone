<?php


session_start();
 include "../dashdesign.php";


  //FOR APPOINTMENT LINE CHART
        require_once "../database_user_appointment/user_appointment.php";
        require_once "../database_user_appointment/appointment_engine.php";
      
        $crud  = new CRUD_appoint();

       
        $dataPoints = array();
        $result = $crud->appointmentLineChart();
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) { // Added $row =
                $dataPoints[] = array(
                    'date' => $row['borrowing_date'],
                    'value' => (int)$row['count']
                );
            }
        }


        //FILTER DATES 

        
if (isset($_POST['submit'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Ensure $start_date is earlier or equal to $end_date to avoid invalid queries
    if ($start_date <= $end_date) {
        
        $stmt = $crud->filterDate($start_date,$end_date);
        $stmt->execute([
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

        $dataPoints = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dataPoints[] = array(
                'date' => $row['borrowing_date'],
                'value' => (int)$row['count']
            );
        }
    }
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

    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <title>Document</title>
</head>


<body>

    <div class="ml-52 p-2">
        <div class="mt-[-50px]">
            <h1 class="text-2xl font-bold px-3">REPORT</h1>
        </div>
        <div class="flex flex-wrap justify-start py-5 gap-5">
            <div>
                <a href="generateBookReport.php">
                    <div class="card px-20 py-6"
                        style="background-image: url(../images/borrow.png); background-size: cover; background-repeat; no-repeat">
                        <div class="row">
                            <div class="col col-lg-6">
                                <h4 class="font-bold">Category</h4>
                            </div>

                        </div>

                    </div>
                </a>
            </div>


            <div>
                <a href="../REPORTS/generateAllBorrowReport.php">
                    <div class="card px-20 py-6" style="background-image: url(../images/hands.png); background-size: cover; background-repeat;
                    no-repeat">
                        <div class="row">
                            <div class="col col-lg-5">
                                <h4 class="font-bold">Borrower</h4>
                            </div>

                        </div>

                    </div>
                </a>
            </div>

            <div>
                <a href="../STUDENT_REPORT/StudentReport.php">
                    <div class="card px-20 py-6"
                        style="background-image: url(../images/student.png); background-size: cover; background-repeat; no-repeat">
                        <div class="row">
                            <div class="col col-lg-5">
                                <h4 class="font-bold">Students</h4>
                            </div>

                        </div>

                    </div>
                </a>
            </div>

            <div>
                <a href="../REPORTS/generateAllBookReport.php">
                    <div class="card px-20 py-6"
                        style="background-image: url(../images/books.png); background-size: cover; background-repeat; no-repeat">
                        <div class="row">
                            <div class="flex justify-start">
                                <h4 class="font-bold text-left">Books</h4>
                            </div>

                        </div>

                    </div>
                </a>
            </div>

            <div>
                <a href="../AUTHORS_REPORT/authors_report.php">
                    <div class="card px-20 py-6"
                        style="background-image: url(../images/author.png); background-size: cover; background-repeat; no-repeat">
                        <div class="row">
                            <div class="px-[10px]">
                                <h4 class="font-bold">Author</h4>
                            </div>

                        </div>

                    </div>
                </a>
            </div>

            <div>
                <a href="../BOOK_ARCHIVED/book_archivedReport.php">
                    <div class="card px-20 py-6"
                        style="background-image: url(../images/trash.png); background-size: cover; background-repeat; no-repeat">
                        <div class="row">
                            <div class="px-[10px]">
                                <h4 class="font-bold">Archive</h4>
                            </div>

                        </div>

                    </div>
                </a>
            </div>

            <div>
                <a href="../COPIES/copies_report.php">
                    <div class="card px-20 py-6"
                        style="background-image: url(../images/cps.png); background-size: cover; background-repeat; no-repeat">
                        <div class="row">
                            <div class="px-[10px]">
                                <h4 class="font-bold">Copies</h4>
                            </div>

                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>

</body>

</html>