<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propuesta login</title>
    <link rel="stylesheet" href="CSS/Login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
</head>

<body>

    <main>
        <!--Contenedor de todo el inicio de sesión-->
        <div class="container_all">
            <!--Caja trasera con opacidad-->
            <div class="box_behind">
                <!--Caja donde te habilita el formulario de inicio de sesión-->
                <div class="box_behind_login">
                    <h1>¿Ya tienes cuenta?</h1>
                    <p>Inicia sesión para poder disfrutar de todos los beneficios</p>
                    <button id="btn_login">Iniciar sesión</button>
                </div>
                <!--Caja donde te habilita el formulario de registro-->
                <div class="box_behind_register">
                    <h1>¿No tienes cuenta?</h1>
                    <p>Registrate para poder disfrutar de todos los beneficios</p>
                    <button id="btn_register">Registrarse</button>
                </div>
            </div>

            <div class="container_login_register">

                <!--Formulario de inicio de sesión-->
                <form class="form_login" action="PHP/login_user.php" method="POST">
                    <h2> Iniciar sesión </h2>
                    <input type="text" class="document" placeholder="Documento" name="document" required>
                    <input type="password" class="password" placeholder="Contraseña" name="password" required>
                    <button type="submit"> Iniciar sesión</button>
                </form>

                <!--Formulario de registro-->

                <form class="form_register" action="PHP/registro_usuario.php" method="POST">
                    <h2>Registrarse</h2>
                    <input type="text" id="name" placeholder="Nombre completo" name="name" required>
                    <input type="text" class="document" placeholder="Documento" name="document" required>
                    <input type="text" id="phone" placeholder="Teléfono" name="phone" required>
                    <input type="email" id="email" placeholder="Correo Electrónico" name="email" required>
                    <input type="password" class="password" placeholder="Contraseña" name="password" required>
                    <button type="submit"> Registrarse</button>
                </form>
            </div>
















        </div>





    </main>

    <script src="JS/login.js"></script>

</body>

</html>