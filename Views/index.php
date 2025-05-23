<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InnovaTube</title>
    <link href="<?php echo BASE_URL . 'Assets/css/login.css'; ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="container">
        <div class="login-box" id="loginBox">
            <div class="form-side">
                <div class="form-wrapper" id="formWrapper">
                    <div class="form login-form active">
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
                                <input type="text" id="usuario_l" name="usuario_l" placeholder="Usuario" required>
                            </div>
                            <div class="input-group">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="contraseña_l" name="contraseña_l" placeholder="Contraseña"
                                    required>
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
                                <input type="text" id="nombre_r" name="nombre_r" placeholder="Nombre(s) y Apellidos"
                                    required>
                            </div>
                            <div class="input-group">
                                <i class="fas fa-user"></i>
                                <input type="text" id="usuario_r" name="usuario_r" placeholder="Usuario" required>
                            </div>
                            <div class="input-group">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" id="correo_r" name="correo_r" placeholder="Correo electrónico"
                                    required>
                            </div>
                            <div class="input-group">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="contraseña_r" name="contraseña_r" placeholder="Contraseña"
                                    required>
                            </div>
                            <div class="input-group">
                                <i class="fa-solid fa-check-double"></i>
                                <input type="password" id="contraseña_rc" name="contraseña_rc"
                                    placeholder="Confirmar contraseña" required>
                            </div>
                            <div class="g-recaptcha" data-sitekey="6Lc4yUYrAAAAABMOCCY4ZQ-Ho0sBYAm8vRrIykXq"></div>
                            <button type="submit" class="btn">REGISTRARSE</button>
                        </form>
                        <p class="signup">¿Ya tienes una cuenta? <a href="#" id="showLogin">Inicia sesión</a></p>
                    </div>
                </div>
            </div>

            <div class="image-side" id="imageSide">
                <div class="overlay">
                    <h1 class="brand-logo">∞ By Kevin Castellanos</h1>
                    <p>"Descubre, guarda y disfruta tus videos favoritos"</p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://www.google.com/recaptcha/api.js?render=6LfQxkYrAAAAAHcO74S8K7DtmwMZDOeaN_zVe6OW"></script>
</body>

<script>
    const base_url = '<?php echo BASE_URL; ?>';
</script>
<script src="<?php echo BASE_URL . 'Assets/js/login.js'; ?>"></script>

</html>