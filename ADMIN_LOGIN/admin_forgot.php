<?php
require_once "admin_login_engine.php";
require_once "admin_login_db.php";

   


$crud = new CRUDADMIN();

/* admin page */


    



?>


<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <!-- font awesome -->

    <script src="https://kit.fontawesome.com/6122121193.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
</head>
<style>
#overlay {
    position: fixed;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 2;
    cursor: pointer;
    /* Add a pointer on hover */
}

.card {
    background: rgba(255, 255, 255, 0.75);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.18);
    border-radius: 15px;
    width: 400px;
    margin: auto;
    padding: 10px;
    height: 25rem;
}

.cards {
    background: rgba(255, 255, 255, 0.95);

    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.18);
    border-radius: 15px;
    width: 400px;
    margin: auto;
    padding: 10px;
    height: 25rem;
}



body {
    background-image: url(../images/bautista.jpg);
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
}







@media (min-width: 577px) and (max-width: 992px) {
    .form_admin {
        max-width: 100rem;
    }
}

.log {
    font-size: 30px;
    text-align: center;
}
</style>

<body>
    <section style="margin-top: 150px">


        <!-- <div class="row" style="text-align: center; margin: auto">
            <div class="card">
                <div class="col" style="text-align: center">



                    <div class="cards"
                        style="border-radius:100%; height:90px; width:90px; z-index:1; margin-top:-50px;background-color:#00457c">
                        <i class="fa-regular fa-user"
                            style="color: white; z-index:2; font-size:50px; margin-top:8px"></i>
                    </div>

                    <br>

                    <div class="container">
                        <form class="form_admin" method="post" action="index.php">
                            <div class="form-group">
                                <label for="name" style="font-weight: bold;">Username:</label>
                                <input type="text" class="form-control" id="name" name="username"
                                    style="background-color: aliceblue; color: black;" placeholder="Username" />
                            </div>
                            <div class="form-group">
                                <label for="password" style="font-weight: bold;">Password:</label>
                                <input type="password" class="form-control" name="password"
                                    style="background-color: aliceblue; color: black;" placeholder="Password" />
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>

                    <br>

                    <span> <a href="" style="color:black;"> Forgot Password?</a></span>
                    <br>
                    <br>

                   

                    <button type="submit" value="Login" class="btn" style="
                    width: 100%;
                    text-align: center;
                    margin: auto;
                    color:#E0FCFD;
                    background-color: #4B5FC2;
                ">
                        Log in
                    </button>

                    </form>

                </div>
            </div>
        </div> -->


        </div>



        <div class="container card">

            <h5 class="log">Enter your ID</h5>
            <br>
            <div class="tab-content">
                <div class="tab-pane fade show active container" id="pills-login" role="tabpanel"
                    aria-labelledby="tab-login">
                    <form class="form_admin" method="get" action="admin_forgot_update.php">


                        <!-- Email input -->
                        <div class="form-outline mb-4">

                            <input type="number" name="admin_Id" style="border-radius: 15px;" id="loginName"
                                class="form-control" />
                            <label class="form-label" for="loginName">Enter your ID</label>
                        </div>
                        <div class="text-center">
                            <button type="submit" style="text-align:center" class="btn btn-primary btn-block mb-4">
                                Enter
                            </button>
                            <br>


                        </div>
                    </form>
                </div>

            </div>

        </div>
        <!-- Pills content -->
    </section>
</body>

</html>