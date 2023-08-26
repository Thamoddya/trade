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

<body  style="background-color: #1f1151;width: 100%;height: 100vh">

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="./admin.php">ADMIN | TRADEWAVE</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./verify.admin.php">Verification</a>
                </li>
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
            <h2 class="text-white ">Unverified Members</h2>
        </div>
        <div class="col-12 overflow-auto">
            <table class="table table-dark table-hover">
                <?php
                $memberDataGet = $pdo->prepare('SELECT * FROM member WHERE `status`="0" ');
                $memberDataGet->execute();
                ?>
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">NIC NO</th>
                    <th scope="col">NIC Image</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $count = 1;
                while ($memberData = $memberDataGet->fetch(PDO::FETCH_ASSOC)) {
                    $memberNic = $memberData['nic'];
                    $name = $memberData['name'];
                    $email = $memberData['email'];
                    $nic = $memberData['nic'];
                    ?>
                    <tr>
                        <th scope='row'><?php echo $count ?></th>
                        <td><?php echo $name ?></td>
                        <td><?php echo $email ?></td>
                        <td><?php echo $nic ?></td>
                        <td><button class='buttonDownload'> <a href='./process/uploads/"<?php echo $nic ?>".png'>View NIC</a> </button></td>
                        <td><button class='buttonDownload' onclick='approveAccount("<?php echo $nic ?>");'>Approve</button></td>
                        <td><button class='buttonDownload'>Disapprove</button></td>
                        </tr>
                <?php
                    $count++;
                };
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php
include_once './components/footer.php';
?>

<script>

    const approveAccount = (nic)=>{
        let enteredCode = $("#inputVerifyCode").val();

        let form = new FormData();
        form.append("nic", nic);

        $.ajax({
            type: 'POST',
            url: './process/statusOne.process.php',
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
    }


</script>
</body>

</html>