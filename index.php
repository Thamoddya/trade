<?php
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TradeWave Login</title>
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
                <div class="col-12 col-lg-5 offset-lg-1 mt-3 mt-md-1 mt-lg-0">
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
                            <div class="w-100 mt-4">
                                <select data-error-name="your role" class="form-select border border-2"
                                        id="select-role">
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="member">Member</option>
                                </select>
                            </div>
                            <div class="form-floating mb-3 w-100 mt-4">
                                <input data-error-name="Username" type="email" class="form-control border border-2"
                                       id="email" placeholder="Email">
                                <label for="floatingInput">Email</label>
                                <span class="field-error"></span>
                            </div>
                            <div class="form-floating mb-3 w-100">
                                <input data-error-name="Password" type="password" class="form-control border border-2"
                                       id="password" placeholder=" ">
                                <label for="floatingInput">Password</label>
                                <span class="field-error"></span>
                            </div>
                            <div class="w-100">
                                <a class="text-info cursor-pointer">Forgot password</a>
                            </div>
                            <div class="d-grid w-100 mt-3">
                                <button class="button" onclick="login();">
    <span class="button_lg">
        <span class="button_sl"></span>
        <span class="button_text">Login</span>
    </span>
                                </button>
                            </div>
                            <div class="d-grid w-100 mt-1">
                                <button class="button" onclick="gotoRegister();">
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
    const gotoRegister = () => {
        window.location.href = 'register.php';
    };
    const login = () => {
        let role = $('#select-role').val();
        let email = $('#email').val();
        let password = $('#password').val();

        if (role === '' || email === '' || password === '') {
            swal.fire('Please fill in all fields');
            return;
        }
        ;

        let dataToSend = {
            role: role,
            email: email,
            password: password
        };

        $.ajax({
            type: 'POST',
            url: './process/login.process.php',
            data: dataToSend,
            success: function (response) {
                let data = JSON.parse(response);
                if (data.success == true) {
                    Swal.fire({
                        title: 'Login Success',
                        text: "Go To " + data.location + " Page",
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Go!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `${data.location}.php`;
                        }
                        ;
                    });
                } else {
                    swal.fire(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    };
</script>
</body>

</html>