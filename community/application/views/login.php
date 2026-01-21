<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(120deg, #f6d365, #fda085);
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1100px;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,.2);
        }

        /* LEFT SIDE */
        .login-left {
            background: linear-gradient(
                rgba(198,40,40,.7),
                rgba(198,40,40,.7)
            ),
            url('https://images.unsplash.com/photo-1503376780353-7e6692767b70');
            background-size: cover;
            background-position: center;
            color: #fff;
            padding: 60px;
        }

        .login-left h1 {
            font-weight: 600;
            font-size: 42px;
        }

        .login-left p {
            opacity: .9;
            margin-top: 20px;
            font-size: 15px;
        }

        /* RIGHT SIDE */
        .login-right {
            padding: 60px 50px;
        }

        .login-right h4 {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .login-right small {
            color: #777;
        }

        .form-control {
            height: 45px;
            border-radius: 8px;
        }

        .input-group-text {
            background: transparent;
            border-right: none;
        }

        .form-control {
            border-left: none;
        }

        .password-toggle {
            cursor: pointer;
        }

        .btn-login {
            background: #c62828;
            color: #fff;
            border-radius: 8px;
            height: 45px;
            font-weight: 500;
        }

        .btn-login:hover {
            background: #a61f1f;
            color: #fff;
        }

        .login-footer {
            font-size: 14px;
        }

        /* MOBILE VERSION */
        @media (max-width: 768px) {
            body {
                background: linear-gradient(135deg, #c62828, #ff5252);
                padding: 20px;
            }

            .login-left {
                display: none !important;
            }

            .login-wrapper {
                border-radius: 16px;
            }

            .login-right {
                padding: 35px 25px;
            }

            .login-right h4,
            .login-right small {
                text-align: center;
            }

            .form-control {
                height: 50px;
                font-size: 15px;
            }

            .btn-login {
                height: 50px;
                border-radius: 12px;
                font-size: 16px;
            }
        }
    </style>
</head>

<body>

<div class="login-wrapper row no-gutters">

    <!-- LEFT -->
    <div class="col-md-6 login-left d-flex flex-column justify-content-center">
        <h1>ESC Community.<br>Disciples Community.</h1>
        <p>
            Terjadi Perubahan Hidup dan Melahirkan Pemurid baru
        </p>
    </div>

    <!-- RIGHT -->
    <div class="col-md-6 login-right">

        <!-- Mobile Brand -->
        <div class="text-center mb-4 d-md-none">
            <h3 style="color:#c62828;font-weight:600;">Xinar</h3>
        </div>

        <h4>Login Account</h4>
        <small>Sign in to continue</small>

        <form class="mt-4" action="<?php echo site_url('login/cek_login') ?>" method="post">

            <!-- USERNAME -->
            <div class="form-group">
                <label>Username</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" name="username" required>
                </div>
            </div>

            <!-- PASSWORD -->
            <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" class="form-control" name="password" id="password" required>
                    <div class="input-group-append">
                        <span class="input-group-text password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-login btn-block mt-4">
                Login
            </button>

            <!-- <div class="text-center login-footer mt-4">
                Don't have an account? <a href="#">Sign Up</a>
            </div> -->

        </form>
    </div>
</div>

<!-- PASSWORD TOGGLE SCRIPT -->
<script>
function togglePassword() {
    const password = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");

    if (password.type === "password") {
        password.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        password.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>

<?php
$pesan = $this->session->flashdata("pesan");
if (!empty($pesan)) {
    echo $pesan;
}
?>

</body>
</html>
