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
    <?php
    include_once './components/header.php';
    ?>
</head>
<body class="container-fluid">
<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand"><?php echo $liveUserData['name'] ?></a>
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
</nav>

<div class="container-fluid">
    <div class="row mt-2">
        <div class="col-12 col-md-4 border-white border border-2 bg-dark  justify-content-center align-items-center text-white text-center">
            <br>
            <p>Account Balance : <?php echo $liveUserData['balance'] ?> $</p>
            <br>
        </div>
        <div class="col-12 col-md-4 border-white border border-2 bg-dark  justify-content-center align-items-center text-white text-center">
            <br>
            <p>Referral Balance : coming soon </p>
            <br>
        </div>
        <div class="col-12 col-md-4 border-white border border-2 bg-dark  justify-content-center align-items-center text-white text-center">
            <br>
            <p>Ongoing Balance : <?php echo $liveUserData['balance'] ?> $</p>
            <br>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12 col-md-6 border border-2 border-white rounded-2 bg-dark text-white">
            <div class="row">
                <div class="col-12 mt-2">
                    <h4>User Data</h4>
                    <hr>
                </div>
                <div class="col-12 mt-1">
                    <p>Wallet ID : <?php echo $userData['0']->walletID ?> </p>
                    <!--                    <input type="text" class="input-group rounded bg-transparent border-dark text-white" value="-->
                    <?php //echo $userData['0']->walletID ?><!--" readonly>-->
                </div>
                <div class="col-12">
                    <p>Referral ID : <?php echo $userData['0']->referral ?> </p>
                </div>
                <div class="col-12">
                    <p>Verified Status :
                        <?php
                        if ($liveUserData['emailVerifyed'] == '0') {
                            echo "<span class='text-danger'>Email Not Verified <a href='#accountVerify'  data-bs-toggle='offcanvas'  >Click Here To Verify</a> </span>";
                        } else {
                            echo "<span class='text-success'>Verified</span>";
                        }
                        ?>
                    </p>
                </div>
                <div class="col-12 mb-2">
                    <div class="row">
                        <div class="col-6">
                            <button type="button" class="button-9" onclick="goToDiscord();">Recharge Account</button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="button-9">Withdraw Money</button>
                        </div>
                        <div class="col-12 mt-1">

                            <a href='#sendMoney' data-bs-toggle='offcanvas'>
                                <button type="button" class="button-9"> Send Money</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 border border-2 border-white rounded-2 bg-dark text-white">
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
                <div class="col-12 mt-3">
                    <img src="./assets/img/tradewave%20banner.svg" style="width: 100%;border: none">
                </div>
            </div>
        </div>
        <div class="col-12 border border-2 border-white rounded-2 mt-2 bg-dark text-white">
            <table class="table table-dark table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Member ID</th>
                    <th>Previous Amount</th>
                    <th>New Amount</th>
                    <th>Added Date</th>
                </tr>
                </thead>
                <tbody>
                <?php
                // Fetch balance log data from the database
                $query = "SELECT * FROM balancelog WHERE nic ='" . $liveUserData['nic'] . "' ORDER BY id DESC  LIMIT 8 ";
                $result = $pdo->query($query);

                while ($entry = $result->fetch(PDO::FETCH_ASSOC)):
                    ?>
                    <tr>
                        <td><?php echo '#' . rand('0000000', '9999999') ?></td>
                        <td><?php echo $entry['nic']; ?></td>
                        <td><?php echo $entry['previousAmount']; ?></td>
                        <td><?php echo $entry['newAmount']; ?></td>
                        <td><?php echo $entry['addedDate']; ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            </table>
        </div>
    </div>
</div>
<div class="container">
    <canvas id="dailyProfitLossChart" width="400" height="200"></canvas>
</div>

<p class="text-danger">*Please Note that , this website is still developing and This is the beta version</p>
<div class="offcanvas offcanvas-start" tabindex="-1" id="accountVerify" aria-labelledby="accountVerify">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">TRADEWAVE | Verify Email</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <hr>
        <div>
            Your Email is not verified.Click the given button to get verification code to your email and enter the code
            and Verify Your account for future transactions.
        </div>

        <div class="col-12">
            <button class="button-9" id="sendEmailButton"
                    onclick="sendEmailCode(<?php echo $liveUserData['verification-code'] ?>);">Get Code To Email
            </button>
        </div>
        <div class="col-12 mt-3">
            <input type="text" class="input-group border border-dark" id="inputVerifyCode"
                   placeholder="Enter Your Code Here">
            <button type="button" class="buttonDownload mt-2" onclick="verifyAccount();">Verify Account</button>
        </div>
    </div>
</div>


<div class="offcanvas offcanvas-start" tabindex="-1" id="sendMoney" aria-labelledby="sendMoney">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">TRADEWAVE | Send Transfer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <hr>
        <div>
            Check The receivers wallet address before sending.
        </div>
        <div class="col-12 mt-3">
            <input type="text" class="input-group border border-dark" id="sendMoneyValue"
                   placeholder="Enter Value Here">
            <p class="text-danger">Your Running Account Balance is : <span
                        id="Invalue"><?php echo $liveUserData['balance'] ?></span> $</p>
        </div>
        <div class="col-12 mt-3">
            <input type="text" class="input-group border border-dark" id="walletId"
                   placeholder="Enter Receiver wallet ID">
        </div>
        <div class="col-12">
            <button class="button-9" id="sendMoney" onclick="sendMoney();">
                Confirm Transfer
            </button>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php
include_once './components/footer.php';
?>

<script>


    let moneySuccess;
    const sendMoney = () => {
        let walletID = $("#walletId").val();
        let price = $("#sendMoneyValue").val();
        let Invalue = parseInt($("#Invalue").html());

        if (checkTypedPrice(Invalue, price) == true) {
            let form = new FormData();
            form.append("walletID", walletID);
            form.append("price", price);
            $.ajax({
                type: 'POST',
                url: './process/sendMoney.ptocess.php',
                data: form,
                contentType: false,
                processData: false,
                success: (response) => {
                    let data = JSON.parse(response);
                    if (data.error == 'false') {
                        Swal.fire({
                            title: 'Fund Transaction Done !',
                            text: "Press Ok To Continue",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        })
                    } else {
                        swal.fire(data.errormsg);
                    }
                }
            });
        } else {
            swal.fire("Your transfer amount must be less than the available balance. ")
        }

    };

    const checkTypedPrice = (inValue, price) => {

        if (price < inValue) {
            return true;
        } else {
            return false;
        }
    }


    const sendEmailCode = (verifyID) => {
        $('#sendEmailButton').prop('disabled', true);
        $('#sendEmailButton').html('Wait...');

        let form = new FormData();
        form.append("verifyID", verifyID);

        $.ajax({
            type: 'POST',
            url: './process/sendCode.process.php',
            data: form,
            contentType: false,
            processData: false,
            success: (response) => {
                let data = JSON.parse(response);
                if (data.error == 'false') {
                    swal.fire("Done");
                } else {
                    console.log(data.errormsg)
                }
                ;
            }
        });
    };

    const verifyAccount = () => {
        let enteredCode = $("#inputVerifyCode").val();
        let form = new FormData();
        form.append("code", enteredCode);
        form.append("Realcode", '<?php echo $liveUserData["verification-code"] ?>');

        $.ajax({
            type: 'POST',
            url: './process/verifyAccount.process.php',
            data: form,
            contentType: false,
            processData: false,
            success: (response) => {
                console.log(response)
                let data = JSON.parse(response);
                if (data.error == 'false') {
                    swal.fire("Done");
                    window.location.reload();
                } else {
                    swal.fire(data.errorMsg)
                }
                ;
            }
        });
    };

    const goToDiscord = () => {
        Swal.fire({
            title: '<strong>Recharge Account</strong>',
            icon: 'info',
            html:
                'Click Here To <b>Recharge Account</b>, ' +
                '<a href="https://discord.gg/9VRQjYW2">Click Here</a> ' +
                'Contact To Recharge ',
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
        });
    };

    fetch('./process/fetch_data2.php')
        .then(response => response.json())
        .then(data => {
            console.log(data)
            const memberIds = data.map(entry => entry.nic);
            const profitLoss = data.map(entry => entry.profit_loss);

            // Create the bar chart using Chart.js
            const ctx = document.getElementById('dailyProfitLossChart').getContext('2d');
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

</script>
</body>
</html>
