<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InnovaTube</title>
    <link href="<?php echo BASE_URL . 'Assets/css/login.css'; ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="script.js"></script>
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="container">
        <div class="login-box" id="loginBox">
            <div class="form-side">
                <div class="form-wrapper" id="formWrapper">
                    <div class="form login-form">
                        <h2>
                            <img src="<?php echo BASE_URL . 'Assets/images/icons/icono.png'; ?>" alt="Logo"
                                class="logo-icon">
                            Innova<span class="brand">Tube</span>
                        </h2>
                        <p class="description">Inicia sesión para recibir actualizaciones al momento sobre lo que te
                            interesa.</p>
                        <form id="loginForm">
                            <div class="input-group">
                                <i class="fas fa-user"></i>
                                <input type="text" placeholder="Usuario" required>
                            </div>
                            <div class="input-group">
                                <i class="fas fa-lock"></i>
                                <input type="password" placeholder="Contraseña" required>
                            </div>
                            <button type="submit" class="btn">INGRESAR</button>
                        </form>
                        <p class="signup">¿No tienes una cuenta? <a href="#" id="showRegister">Regístrate ahora</a></p>
                    </div>

                    <div class="form register-form">
                        <h2>
                            <img src="<?php echo BASE_URL . 'Assets/images/icons/icono.png'; ?>" alt="Logo"
                                class="logo-icon">
                            Regístrate <span class="brand">Ahora</span>
                        </h2>
                        <p class="description">Crea tu cuenta para disfrutar de InnovaTube.</p>
                        <form id="registerForm">
                            <div class="input-group">
                                <i class="fa-solid fa-id-card"></i>
                                <input type="text" placeholder="Nombre(s) y Apellidos" required>
                            </div>
                            <div class="input-group">
                                <i class="fas fa-user"></i>
                                <input type="text" placeholder="Usuario" required>
                            </div>
                            <div class="input-group">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" placeholder="Correo electrónico" required>
                            </div>
                            <div class="input-group">
                                <i class="fas fa-lock"></i>
                                <input type="password" placeholder="Contraseña" required>
                            </div>
                            <div class="input-group">
                            <i class="fa-solid fa-check-double"></i>
                                <input type="password" placeholder="Confirmar Contraseña" required>
                            </div>
                            <button type="submit" class="btn">REGISTRARSE</button>
                        </form>
                        <p class="signup">¿Ya tienes una cuenta? <a href="#" id="showLogin">Inicia sesión</a></p>
                    </div>
                </div>
            </div>

            <div class="image-side" id="imageSide">
                <div class="overlay">
                    <h1 class="brand-logo">∞ Por Kevin Castellanos</h1>
                    <p>"Descubre, guarda y disfruta tus videos favoritos"</p>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    window.addEventListener('load', () => {
        const preloader = document.getElementById('preloader');
        const container = document.querySelector('.container');

        preloader.style.display = 'none';
        container.style.display = 'flex';
    });

    document.addEventListener('DOMContentLoaded', () => {
        const formSide = document.querySelector('.form-side');
        const loginBox = document.getElementById('loginBox');
        const showRegister = document.getElementById('showRegister');
        const showLogin = document.getElementById('showLogin');

        showRegister.addEventListener('click', e => {
            e.preventDefault();
            formSide.classList.add('show-register');
            loginBox.classList.add('show-register');
        });

        showLogin.addEventListener('click', e => {
            e.preventDefault();
            formSide.classList.remove('show-register');
            loginBox.classList.remove('show-register');
        });
    });
</script>

</html>