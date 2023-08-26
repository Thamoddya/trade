<?php
session_start();
include_once "./connection.php";
//if($_SESSION['role'] == 'admin'){
//    header('Location : ./index.php');
//}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TradeWave Admin</title>
    <link rel="shortcut icon" href="./assets/img/login.main.svg" type="image/x-icon">
    <?php
    include_once './components/header.php';
    ?>

</head>

<body style="background-color: #1f1151;width: 100%;height: 100vh">

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">ADMIN | TRADEWAVE</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./verify.admin.php">Verification</a>
                </li>
                <!--                <li class="nav-item">-->
                <!--                    <a class="nav-link" href="#">Link</a>-->
                <!--                </li>-->
                <!--                <li class="nav-item dropdown">-->
                <!--                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">-->
                <!--                        Dropdown-->
                <!--                    </a>-->
                <!--                    <ul class="dropdown-menu">-->
                <!--                        <li><a class="dropdown-item" href="#">Action</a></li>-->
                <!--                        <li><a class="dropdown-item" href="#">Another action</a></li>-->
                <!--                        <li><hr class="dropdown-divider"></li>-->
                <!--                        <li><a class="dropdown-item" href="#">Something else here</a></li>-->
                <!--                    </ul>-->
                <!--                </li>-->
                <!--                <li class="nav-item">-->
                <!--                    <a class="nav-link disabled" aria-disabled="true">Disabled</a>-->
                <!--                </li>-->
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="row mt-5">

                <div class="col-12  border border-2 border-white rounded-2 bg-dark text-white">
                    <div class="row mt-3 border-dark border border-2">
                        <table class=" col-12 table table-bordered border-primary">
                            <tbody>
                            <tr class="text-center">
                                <td>BTC : <span id="btcPrice"></span></td>
                                <td>SOL : <span id="solPrice"></span></td>
                            </tr>
                            <tr class="text-center">
                                <td>DOGE : <span id="dogePrice"></span></td>
                                <td>TRX : <span id="trxPrice"></span></td>
                            </tr>
                            </tbody>
                        </table>
                        <table class=" col-12 table table-bordered border-primary">
                            <tbody>
                            <tr class="text-center">
                                <td>Member Count : <?php

                                    $getMemberCountQuery = "SELECT COUNT(id) FROM member";
                                    $getMemberCount = $pdo->query($getMemberCountQuery);
                                    $MemberCount = $getMemberCount->fetch(PDO::FETCH_ASSOC);
                                    echo $MemberCount['COUNT(id)'];
                                    ?> </td>
                                <td>Total Invest :
                                    <?php
                                    $getInvestBalanceQuery = "SELECT sum(balance) FROM member";
                                    $getInvestBalance = $pdo->query($getInvestBalanceQuery);
                                    $InvestBalance = $getInvestBalance->fetch(PDO::FETCH_ASSOC);
                                    echo '$ ' . $InvestBalance['sum(balance)'];
                                    ?>
                                </td>
                            </tr>
                            <tr class="text-center">
                                <td>Verified Member Count : <?php

                                    $getVerifyedMemberCountQuery = "SELECT COUNT(id) FROM member WHERE `emailVerifyed` = '1'";
                                    $getVerifyedMemberCount = $pdo->query($getVerifyedMemberCountQuery);
                                    $VerifyedMemberCount = $getVerifyedMemberCount->fetch(PDO::FETCH_ASSOC);
                                    echo $VerifyedMemberCount['COUNT(id)'];
                                    ?> </td>
                                <td>Total Invest :
                                    <?php
                                    $getInvestBalanceQuery = "SELECT sum(balance) FROM member";
                                    $getInvestBalance = $pdo->query($getInvestBalanceQuery);
                                    $InvestBalance = $getInvestBalance->fetch(PDO::FETCH_ASSOC);
                                    echo '$ ' . $InvestBalance['sum(balance)'];
                                    ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="col-12 mt-3">
                            <img src="./assets/img/tradewave%20banner.svg" style="width: 100%;border: none">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <canvas id="profitLossChart" width="400" height="200"></canvas>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="text-white ">Member Details</h2>
        </div>
        <div class="col-12 overflow-auto">
            <table class="table table-dark table-hover">
                <?php
                $memberDataGet = $pdo->prepare('SELECT * FROM member WHERE `status`="1" ');
                $memberDataGet->execute();
                ?>
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Balance</th>
                    <th scope="col"></th>
                    <th scope="col">Go</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $count = 1;
                while ($memberData = $memberDataGet->fetch(PDO::FETCH_ASSOC)) {
                    $memberNic = $memberData['nic'];
                    $name = $memberData['name'];
                    $email = $memberData['email'];
                    $balance = $memberData['balance'];
                    ?>
                    <tr>
                        <th scope='row'><?php echo $count ?></th>
                        <td><?php echo $name ?></td>
                        <td><?php echo $email ?></td>
                        <td><?php echo $balance ?> USD</td>
                        <td>
                            <input type='number' id='balance_<?php echo $memberNic ?>'/>
                            <button class='buttonDownload' onclick='updateBalance("<?php echo $memberNic ?>")'>UPDATE
                            </button>
                        </td>
                        <td>
                            <button class='buttonDownload'>View</button>
                        </td>
                    </tr>
                    <?php

                    $count++;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php
include_once './components/footer.php';
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    fetch('./process/fetch_data.php')
        .then(response => response.json())
        .then(data => {
            console.log(data)
            const memberIds = data.map(entry => entry.nic);
            const profitLoss = data.map(entry => entry.profit_loss);

            // Create the bar chart using Chart.js
            const ctx = document.getElementById('profitLossChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: memberIds,
                    datasets: [{
                        label: 'Profit/Loss',
                        data: profitLoss,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });

    const updateBalance = (nic) => {
        let balance = $(`#balance_${nic}`).val();

        let form = new FormData();
        form.append("nic", nic);
        form.append("balance", balance);

        $.ajax({
            type: 'POST',
            url: './process/updateBalance.process.php',
            data: form,
            contentType: false,
            processData: false,
            success: (response) => {
                let data = JSON.parse(response);
                if (data.error == 'false') {
                    swal.fire("Done");
                    window.location.reload();
                } else {
                    swal.fire(data.errormsg)
                }
            }
        })
    }


</script>
</body>

</html>