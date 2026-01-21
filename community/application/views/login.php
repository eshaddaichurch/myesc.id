<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap 4 -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

<!-- Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
* {
    box-sizing: border-box;
}

body {
    min-height: 100vh;
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(120deg, #e0f2f1, #fdecea);
    display: flex;
    align-items: center;
    justify-content: center;
}

/* MAIN CARD */
.login-container {
    width: 100%;
    max-width: 1100px;
    height: 600px;
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0,0,0,.25);
    display: flex;
}

.login-hero {
    width: 55%;
    position: relative;
    background: url('https://images.unsplash.com/photo-1501785888041-af3ef285b470')
                center / cover no-repeat;
}

.login-hero::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(
        rgba(21, 87, 36, 0.75),
        rgba(21, 87, 36, 0.85)
    );
}


.hero-content {
    position: relative;
    z-index: 2;
    height: 100%;
    padding: 60px;
    color: #fff;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.hero-content h1 {
    font-size: 42px;
    font-weight: 600;
    line-height: 1.2;
}

.hero-content p {
    margin-top: 20px;
    font-size: 15px;
    opacity: .9;
    max-width: 380px;
}

/* RIGHT FORM */
.login-form {
    width: 45%;
    padding: 60px 50px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.login-form h4 {
    font-weight: 600;
}

.login-form small {
    color: #777;
}

/* INPUT */
.form-control {
    height: 48px;
    border-radius: 10px;
    font-size: 14px;
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

/* BUTTON */
.btn-login {
    height: 48px;
    border-radius: 10px;
    background: #1b1e21;
    color: #fff;
    font-weight: 500;
}

.btn-login:hover {
    background: #a61f1f;
    color: #fff;
}

/* ===================== */
/* ===== MOBILE ======== */
/* ===================== */
@media (max-width: 768px) {

    body {
        background: linear-gradient(135deg, #155724, #155724);
        padding: 15px;
    }

    .login-container {
        flex-direction: column;
        height: auto;
        max-width: 420px;
        border-radius: 18px;
    }

    .login-hero {
        display: none;
    }

    .login-form {
        width: 100%;
        padding: 35px 25px;
    }

    .login-form h4,
    .login-form small {
        text-align: center;
    }

    .mobile-brand {
        text-align: center;
        margin-bottom: 20px;
    }

    .mobile-brand h3 {
        font-weight: 600;
        color: #c62828;
    }

    .btn-login {
        height: 52px;
        font-size: 16px;
        border-radius: 14px;
    }
}
</style>
</head>

<body>

<div class="login-container">

    <!-- LEFT -->
    <div class="login-hero">
        <div class="hero-content">
            <h1>
                ESC Community.<br>
                Disciples Community.
            </h1>
            <p>
                Terjadi Perubahan Hidup dan Melahirkan Pemurid Baru
            </p>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="login-form">

        <!-- MOBILE BRAND -->
        <div class="mobile-brand d-md-none">
            <h3>ESC DC</h3>
        </div>

        <h4>Login Account DM</h4>
        <small>Sign in to continue</small>

        <form class="mt-4" action="<?php echo site_url('login/cek_login') ?>" method="post">

            <div class="form-group">
                <label>Username</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" name="username" required>
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
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

        </form>
    </div>

</div>

<script>
function togglePassword() {
    const pass = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");

    if (pass.type === "password") {
        pass.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        pass.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
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
