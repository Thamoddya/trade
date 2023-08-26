<?php
session_start();
$userData = json_decode($_SESSION['userData']);
include_once './connection.php';

$getUserData = $pdo->prepare("SELECT * FROM member WHERE nic=:nic");
$getUserData->bindValue(':nic', $userData[0]->nic);
$getUserData->execute();
$liveUserData = $getUserData->fetch(PDO::FETCH_ASSOC);
if ($liveUserData['status'] == 0) {
    echo "Hello " . $liveUserData['name'] . ".Your Account has been not activated yet.Please Come back Later.";
    exit();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TRADEWAVE Member | HOME</title>
    <link rel="stylesheet" href="./assets/css/icon.css">
    <?php
    include_once './components/header.php';
    ?>

    <style>
        .div1 {
            background-color: rgba(239, 254, 240, 0.31);
        }
    </style>
</head>
<body style="background-color: #0dcaf0">

<nav class="navbar  fixed-top position-relative" style="background-color: #0dcaf0">
    <div class="container-fluid">
        <button class="navbar-toggler border border-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span><i class="fa fa-bars"></i></span>
        </button>
        <a class="navbar-brand  text-center" href="#">TRADE WAVE</a>
        <a class="navbar-brand  text-center" href="#">
            <icon class="fa fa-bell"/>
        </a>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel"
             style="background-color: #0dcaf0">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">TRADE WAVE</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">TRADE WAVE | HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Settings</a>
                    </li>
                </ul>
                <form class="d-flex mt-3" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
</nav>


<div class="container-fluid  border border-5 border-primary  rounded rounded-1"
     style="border-color: #0dcaf0;border: 20px">
    <div class="row">
        <div class="col-12   rounded rounded-3">
            <div class="row">
                <div class="col-12 mt-3">
                    <h3 class="text-white ">Welcome Back, Sanija Nirmal !</h3>
                </div>
                <div class="col-12 mt-3">
                    <h6 class="text-white ">Your Account Balance</h6>
                </div>
                <div class="col-12 d-flex justify-content-start align-items-start">
                    <h1 class="text-white ">$ 250 </h1>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 ">
            <div class="col-12 mt-3">
                <Strong class="text-white m">Your Wallet</Strong>
            </div>
        </div>
    </div>


    <div class="row border border-2 rounded rounded-3 ">
        <div class="col-12 div1  ">
            <div class="row">
                <div class="col-4 mt-3 mb-3 d-flex justify-content-center align-items-center">
                    <img src="./assets/img/userimg.svg" style="height: 70px;width: 70px">
                </div>
                <div class="col-8 mt-3 justify-content-start align-items-start">
                    <div class="row">
                        <div class="col-12 ">
                            <p class="text-white text-opacity-75">Referral Balance <br> <span
                                        class="text-white fs-4 fw-bold"> 0.00$</span>
                                <br> <span class="fs-5" style="color: #04f010">+0.00$ (10%) Bonus</span>
                                <icon class="fa fa-arrow-circle-right"/>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-12 ">
            <div class="row">
                <div class="col-6 div1 mt-3 mb-3 border border-2 mt-2 rounded rounded-3" >
                    <div class="row">
                        <div class="col-4 mt-3 mb-3">
                            <img src="./assets/img/btc.png" style="">
                        </div>
                        <div class="col-8 mt-3 mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="text-white">BTC</h4>
                                </div>
                                <div class="col-12">
                                    <h6 class="text-white" id="btcPrice"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 div1 mt-3 mb-3 border border-2 mt-2 rounded rounded-3">
                    <div class="row">
                        <div class="col-4 mt-3 mb-3">
                            <img src="./assets/img/sol.png" style="">
                        </div>
                        <div class="col-8 mt-3 mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="text-white">BTC</h4>
                                </div>
                                <div class="col-12">
                                    <h6 class="text-white" id="solPrice"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 div1 mt-3 mb-3 border border-2 mt-2 rounded rounded-3">
                    <div class="row">
                        <div class="col-4 mt-3 mb-3">
                            <img src="./assets/img/trx.png" style="">
                        </div>
                        <div class="col-8 mt-3 mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="text-white">BTC</h4>
                                </div>
                                <div class="col-12">
                                    <h6 class="text-white" id="trxPrice"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 div1 mt-3 mb-3 border border-2 mt-2 rounded rounded-3">
                    <div class="row">
                        <div class="col-4 mt-3 mb-3">
                            <img src="./assets/img/btc.png" style="">
                        </div>
                        <div class="col-8 mt-3 mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="text-white">BTC</h4>
                                </div>
                                <div class="col-12">
                                    <h6 class="text-white" id="dogePrice"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php
include_once './components/footer.php';
?>

</body>
</html>