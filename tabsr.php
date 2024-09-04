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

<body class="font-['Quicksand']">



    <div class="ml-52">
        <div class="relative mt-5 z-[-1px] px-2">
            <div class="flex justify-start gap-1">

                <div class="card px-10 py-2 hover:rounded-lg hover:bg-[#f5ebe0] bg-[#e3d5ca]">

                    <b><a href="generateAllBorrowReport.php">Borrowed</a></b>
                </div>
                <div class="card px-10 py-2 hover:rounded-lg hover:bg-[#f5ebe0] bg-[#e3d5ca]">

                    <b><a href="generateAllReturnedReport.php">Returned</a></b>
                </div>
                <div class="card px-10 py-2 hover:rounded-lg hover:bg-[#f5ebe0] bg-[#e3d5ca]">


                    <b><a href="generateAllBorrowPenalty.php">Penalty</a></b>
                </div>
            </div>
        </div>

    </div>

    <script>
    function loadPage(url) {
        fetch(url)
            .then(response => response.text())
            .then(data => {
                document.getElementById('content').innerHTML = data;
            });
    }
    </script>


</body>

</html>