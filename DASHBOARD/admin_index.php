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

 
                                require_once "../DATABASE/book_catalog_db.php";
                                require_once "../BOOKS/book_catalog_engine.php";
                                $crud = new CRUD();

                                 
                                $countsbook = $crud->CountAllBookReport();
                              


                                


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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


</head>

<body>

    <div class="ml-52">
        <div class="absolute mt-[-40px]">
            <h1 class="text-2xl font-bold px-3">DASHBOARD</h1>
        </div>

        <div class="flex justify-start gap-[15px] py-3 px-10">
            <div class="card bg-[#D6CCC2] pr-48 pl-2  py-2 rounded-lg grid gap-2">
                <h4 class="text-1xl text-left">Books</h4>
                <h4 class="font-bold  text-5xl ">
                    <?php echo $countsbook['TOTALId'] ?>
                </h4>
            </div>

            <?php
            require_once "../DATABASE/book_catalog_db.php";
            require_once "../BOOKS/book_catalog_engine.php";
            $crud = new CRUD();

            $result = $crud->barBook();
            $allResults = [];

            foreach ($result as $row) {
                $allResults[] = [
                    'title' => $row['title'],
                    'total_borrow_count' => $row['total_borrow_count']
                ];
            }

            // Sort the results based on total_borrow_count
            usort($allResults, function ($a, $b) {
                return $b['total_borrow_count'] - $a['total_borrow_count'];
            });

            $count = $crud->totalAppointments();
                ?>
            <div class="card bg-[#F5EBE0] pr-48 pl-2  py-2 rounded-lg grid gap-2">
                <h4 class="text-1xl text-left">Borrowers</h4>
                <h4 class="font-bold  text-5xl ">
                    <?php echo $count; ?>
                </h4>
            </div>

            <?php
            require_once "../ADMIN_LOGIN/admin_login_engine.php";
            require_once "../ADMIN_LOGIN/admin_login_db.php";
            $cruds = new CRUDADMIN();
            $users = $cruds->totalActiveAdmin();
             ?>

            <div class="card bg-[#E3D5CA] pr-48 pl-2  py-2 rounded-lg grid gap-2">
                <h4 class="text-1xl text-left w-full">Admins</h4>
                <h4 class="font-bold  text-5xl ">
                    <?php echo $users; ?>
                </h4>
            </div>


            <?php
                require_once "../END_USER/end_user_engine.php";
                require_once "../END_USER/end_user_db.php";
                $stuUsers = new END_USERS();
                $users = $stuUsers->getAllUserTOTAL();
                ?>

            <div class="card bg-[#D5BDAF] pr-44 pl-2 py-2 rounded-lg grid gap-2">
                <h4 class="text-1xl text-left">Students</h4>
                <h4 class="font-bold text-5xl ">
                    <?php echo $users; ?>
                </h4>
            </div>


        </div>

        <div>


            <div class="flex justify-center gap-5 px-10">
                <div class=" ">
                    <div class="w-[540px] h-auto  bg-[#f5ebe0] rounded-lg shadow   p-4 md:p-6">
                        <div class="flex justify-between">
                            <div class="">
                                <!-- <h5 class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">
                                    <?php echo $countsbook['TOTALId'] ?>

                                </h5> -->
                                <p class="text-base  font-bold" >Borrowers Chart</p>
                            </div>
                            <!-- <div>
                                <button id="dateRangeButton" data-dropdown-toggle="dateRangeDropdown"
                                    data-dropdown-ignore-click-outside-class="datepicker"
                                    class="p-2 rounded-lg px-3 bg-[#d5bdaf]">Filter</button>
                            </div> -->

                        </div>
                        <div class="h-96" id="area-chart"></div>

                    </div>
                    <div id="dateRangeDropdown"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-80 ml-20 lg:w-96 dark:bg-gray-700 dark:divide-gray-600">
                        <div class="p-3" aria-labelledby="dateRangeButton">
                            <div date-rangepicker datepicker-autohide class="flex items-center">
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input name="start" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Start date">
                                </div>
                                <span class="mx-2 text-gray-500 dark:text-gray-400">to</span>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input name="end" type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="End date">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-[540px] h-auto bg-[#f5ebe0] rounded-lg shadow p-4 md:p-6">
                    <div class="flex justify-between">
                        <div class="flex items-center">
                            <div>
                            
                                <p class="text-base  font-bold">Most Borrowed
                                </p>
                            </div>
                        </div>
                    </div>

                    <div id="column-chart"></div>
                    <div
                        class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                        <div class="flex justify-between items-center pt-5">

                            <a href="../BOOKS/book_category.php"
                                class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-[#2F2F2F]   dark:hover:text-blue-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                                Details
                                <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>



            </div>

        </div>

    </div>



    <!-- for line chart -->
    <script>
    <?php if (isset($dataPoints)): ?>
    const dataPoints = <?php echo json_encode($dataPoints); ?>;
    const labelsdate = dataPoints.map(item => item.date);
    const values = dataPoints.map(item => item.value);
    <?php else: ?>
    // Set default data if no filter is applied or no data is available
    const labelsdate = [];
    const values = [];
    <?php endif; ?>
    const options = {
        chart: {
            height: "100%",
            maxWidth: "100%",
            type: "area",
            fontFamily: "Inter, sans-serif",
            dropShadow: {
                enabled: true,
            },
            toolbar: {
                show: true,
            },
        },
        tooltip: {
            enabled: true,
            x: {
                show: true,
            },
        },
        fill: {
            type: "gradient",
            gradient: {
                opacityFrom: 0.55,
                opacityTo: 0,
                shade: "#1C64F2",
                gradientToColors: ["#1C64F2"],
            },
        },
        dataLabels: {
            enabled: true,
        },
        stroke: {
            width: 6,
        },
        grid: {
            show: true,
            strokeDashArray: 4,
            padding: {
                left: 2,
                right: 2,
                top: 0
            },
        },
        series: [{
            name: "Borrowers",
            data: values,
            color: "#2F2F2F",
        }, ],
        xaxis: {
            categories: labelsdate,
            legend: {
                display: true,
                labelsdate: {
                    fontColor: 'black',
                    fontSize: 12
                }
            },

            labelsdate: {
                show: true,
            },
            axisBorder: {
                show: true,
            },
            axisTicks: {
                show: true,
            },
        },
        yaxis: [{
            ticks: {
                min: 0,
                max: Math.ceil(Math.max(...values)) +
                    5 // Set the maximum value a bit higher than the max data point.
            }
        }],
    }

    if (document.getElementById("area-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("area-chart"), options);
        chart.render();
    }
    </script>




    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
    <?php if (isset($allResults)): ?>
    const allResults = <?php echo json_encode($allResults); ?>;
    const dataPointss = allResults.map(item => ({
        x: item.title,
        y: item.total_borrow_count
    }));
    <?php else: ?>
    const dataPointss = [];
    <?php endif; ?>

    const optionsbar = {
        colors: ["#2F2F2F", "#2F2F2F"],
        series: [{
            name: "Total Borrowed",
            color: "#2F2F2F",
            data: dataPointss,
        }],
        chart: {
            type: "bar",
            height: 320,
            fontFamily: "Inter, sans-serif",
            toolbar: {
                show: true,
            },
        },
        plotOptions: {
            bar: {
                horizontal: true,
                columnWidth: "50%",
                borderRadiusApplication: "end",
                borderRadius: 8,
            },
        },
        tooltip: {
            shared: true,
            intersect: false,
            style: {
                fontFamily: "Inter, sans-serif",
            },
        },
        states: {
            hover: {
                filter: {
                    type: "darken",
                    value: 1,
                },
            },
        },
        stroke: {
            show: true,
            width: 0,
            colors: ["transparent"],
        },
        grid: {
            show: false,
            strokeDashArray: 4,
            padding: {
                left: 2,
                right: 2,
                top: -14
            },
        },
        dataLabels: {
            enabled: true,
        },
        legend: {
            show: true,
        },
        xaxis: {
            floating: true,
            labels: {
                show: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                }
            },
            axisBorder: {
                show: true,
            },
            axisTicks: {
                show: true,
            },
        },
        yaxis: {
            show: true,
        },
        fill: {
            opacity: 1,
        },
    };

    if (document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("column-chart"), optionsbar);
        chart.render();
    }
    </script>



</body>

</html>