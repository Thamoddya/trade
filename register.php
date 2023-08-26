<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TradeWave Register</title>
    <link rel="shortcut icon" href="./assets/img/login.main.svg" type="image/x-icon">
    <?php
    include_once './components/header.php';
    ?>
</head>

<body id="loginPage" style="background-color: #1f1151;width: 100%;height: 100vh">

<div class="container-fluid h-100">
    <div class="row">
        <div class="col-12 mt-md-5 ">
            <div class="row mt-md-5 ">
                <div class="col-12 col-lg-5 offset-lg-1 mt-3 mt-md-5 ">
                    <div class="row">
                        <div class="col-12">
                            <img src="./assets/img/login.main.svg" alt="LMS"
                                 style="width: 100%;height: 100%;background-position: center;background-size: cover"
                                 class="border border-white">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="row">
                        <div>
                            <div class="text-center">
                                <span class="fw-bold fs-1 text-white">TRADEWAVE</span><br/>
                            </div>
                            <div class="form-floating mb-2 w-100 mt-4">
                                <input data-error-name="name" type="text" class="form-control border border-2"
                                       id="name" placeholder="Full Name">
                                <label for="floatingInput">Full Name</label>
                                <span class="field-error"></span>
                            </div>
                            <div class="form-floating mb-2 w-100 mt-4">
                                <input data-error-name="Username" type="email" class="form-control border border-2"
                                       id="email" placeholder="Email">
                                <label for="floatingInput">Email</label>
                                <span class="field-error"></span>
                            </div>
                            <div class="form-floating mb-2 w-100 mt-4">
                                <input data-error-name="NICNo" type="text" class="form-control border border-2"
                                       id="nic" placeholder="NIC No">
                                <label for="floatingInput">NIC No</label>
                                <span class="field-error"></span>
                            </div>
                            <div class="form-floating mb-2 w-100 mt-4">
                                <input data-error-name="NICNo" type="file" class="form-control border border-2"
                                       id="nicpic" placeholder="NIC No">
                                <label for="floatingInput">NIC Image</label>
                                <span class="field-error"></span>
                            </div>
                            <div class="form-floating mb-2 w-100">
                                <input data-error-name="Password" type="password" class="form-control border border-2"
                                       id="password" placeholder=" ">
                                <label for="floatingInput">Password</label>
                                <span class="field-error"></span>
                            </div>
                            <div class="w-100">
                                <a href="./index.php" class="text-info">Back To Login</a>
                            </div>
                            <div class="d-grid w-100 mt-1">
                                <button class="button" id="registerButton" onclick="register();">
                            <span class="button_lg">
        <span class="button_sl"></span>
        <span class="button_text">Register</span>
    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once './components/footer.php';
?>

<script>
    const register = () => {
        $('#registerButton').addClass('d-none');
        var formData = new FormData();
        formData.append('name', $('#name').val());
        formData.append('email', $('#email').val());
        formData.append('nic', $('#nic').val());
        formData.append('password', $('#password').val());
        formData.append('nicpic', $('#nicpic')[0].files[0]);

        $.ajax({
            url: './process/register.process.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response);
                let data = JSON.parse(response);
                if(data.error == 'false'){
                    swal.fire("Account Create successful.Please Check Your Email");
                }else{
                    swal.fire(data.errorMsg);
                    $('#registerButton').removeClass('d-none');
                };
            };
        });
    };
</script>

</body>

</html>