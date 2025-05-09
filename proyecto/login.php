<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/Login.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/script.js" defer></script>

</head>

<body>


    <div class="container">
        <div class="form-box login">
            <form action="PHP/login_user.php" method="post">
                <h2>Administrador</h2>
               
                <div class="input-box">
                    <input type="text" class="document" placeholder="Documento" name="document" required>
                    <ion-icon name="person"></ion-icon>
                </div>
                <div class="input-box">
                    <input type="password" class="password" placeholder="Contraseña" name="password" required> <ion-icon
                        name="lock-closed"></ion-icon>
                </div>
                <div class="forgot-link">
                    <a href="#">¿Olvidaste tu Contraseña?</a>
                </div>
                <button type="submit" class="btn">Ingresar</button>

            </form>
        </div>

        <div class="form-box register">
            <form action="PHP/registro_usuario.php" method="post">
                <h2>Almacenista</h2>


                <div class="input-box">
                    <input type="text" class="document" placeholder="Documento" name="document" required>
                    <ion-icon name="id-card"></ion-icon>
                </div>

                <div class="input-box">
                    <input type="password" class="password" placeholder="Contraseña" name="password" required>
                    <ion-icon name="lock-closed"></ion-icon>
                </div>
                <button type="submit" class="btn">Ingresar</button>


            </form>
        </div>

        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h2>Gestion de prestamos</h2>
                <p>¿No tienes una cuenta?</p>
                <button class="btn register-btn">Soy almacenista</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h2>¡Bienvenido, de nuevo!</h2>
                <p>¿Ya tienes una cuenta?</p>
                <button class="btn login-btn">Soy administrador</button>
            </div>
        </div>
    </div>


</body>

</html>