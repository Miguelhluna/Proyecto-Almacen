<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link rel="icon" href="img/logoicon.png">
    <link rel="stylesheet" href="css/Login.css?v=<?php echo time(); ?>">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script src="js/script.js"></script>




</head>

<body>

    <div class="container">
        <div class="desing">
            <div class="ovalo-1 rotate-45"></div>
            <div class="ovalo-2 rotate-45"></div>
            <div class="ovalo-3 rotate-45"></div>
            <div class="ovalo-4 rotate-45"></div>
        </div>
        <div class="login">
            <form action="PHP/login_Admin.php" method="POST">
                <h2>Iniciar sesión</h2>
                <div class="input-box">
                    <input type="text" class="document" placeholder="Documento" name="document" required>
                    <ion-icon name="person"></ion-icon>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Contraseña" name="password" required> <ion-icon
                        name="lock-closed"></ion-icon>

                </div>
                <div>
                    <a href="#" class="btn-password" onclick="mostrarModalPassword();">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="btn">Ingresar</button>
            </form>

        </div>
    </div>
    <!-- Backdrop + Modal -->
    <div class="backdrop" id="modal">
        <div class="modal">
            <div id="match-message"></div>
            <h2>Cambie su contraseña</h2>
            <form action="PHP/generarCodigo.php" method="POST">
                <input type="text" placeholder="Documento" name="documentoCode" id="documento" required>
                <button type="submit">Enviar código</button>
                <a href="#" onclick="modalCodigo();" class="btn-password">¿Ya tiene un código?</a>
            </form>
            <form action="PHP/cambiarContraseña.php" method="post" style="display: none;" id="cambioContraseña">
                <input type="text" placeholder="Documento" id="document" name="documento" required>
                <input type="password" placeholder="Nueva contraseña" id="password" name="nueva_contrasena" required>
                <input type="password" placeholder="Confirmar contraseña" id="confirm-password"
                    name="confirmar_contrasena" required>
                <input type="text" name="ingresarcodigo" id="" placeholder="Ingrese su código" required>
                <div class="strength-bar">
                    <div class="fill" id="strength-fill"></div>
                    <span class="strength-text" id="strength-text">Escribe una contraseña</span>
                </div>
                <div class="password-checklist" id="checklist">
                    <p><span class="check" id="length">✖</span> Mínimo 6 caracteres</p>
                    <p><span class="check" id="uppercase">✖</span> Una letra mayúscula</p>
                    <p><span class="check" id="number">✖</span> Un número</p>
                    <p><span class="check" id="symbol">✖</span> Un símbolo</p>
                </div>

                <!-- ✅ Agregar la clase btn-submit aquí -->
                <button type="submit" class="btn-submit" disabled> Cambiar contraseña</button>
            </form>

        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if (isset($_SESSION['mensaje'])): ?>
        <script>
            Swal.fire({
                icon: <?= json_encode($_SESSION["mensaje"]["tipo"]) ?>,
                title: <?= json_encode($_SESSION["mensaje"]["titulo"]) ?>,
                text: <?= json_encode($_SESSION["mensaje"]["texto"]) ?>,
                confirmButtonText: 'Aceptar'
            });
        </script>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('confirm-password');
            const strengthFill = document.getElementById('strength-fill');
            const strengthText = document.getElementById('strength-text');
            const matchMessage = document.getElementById('match-message');
            const submitBtn = document.querySelector('.btn-submit'); // ✅ CORREGIDO

            const checkLength = document.getElementById('length');
            const checkUppercase = document.getElementById('uppercase');
            const checkNumber = document.getElementById('number');
            const checkSymbol = document.getElementById('symbol');

            function toggleCheck(element, isValid) {
                if (isValid) {
                    element.classList.add('valid');
                    element.classList.remove('check');
                    element.textContent = '✔';
                } else {
                    element.classList.remove('valid');
                    element.classList.add('check');
                    element.textContent = '✖';
                }
            }

            function getStrengthVisual(level) {
                switch (level) {
                    case 0:
                        return {
                            percent: '0%', color: '#e0e0e0', text: 'Escribe una contraseña'
                        };
                    case 1:
                        return {
                            percent: '25%', color: '#dc3545', text: 'Débil'
                        };
                    case 2:
                        return {
                            percent: '50%', color: '#ffc107', text: 'Media'
                        };
                    case 3:
                        return {
                            percent: '75%', color: '#007bff', text: 'Fuerte'
                        };
                    case 4:
                        return {
                            percent: '100%', color: '#28a745', text: 'Muy segura'
                        };
                }
            }

            function validatePasswordStrength(val) {
                const hasLength = val.length >= 6;
                const hasUpper = /[A-Z]/.test(val);
                const hasNumber = /[0-9]/.test(val);
                const hasSymbol = /[^A-Za-z0-9]/.test(val);

                toggleCheck(checkLength, hasLength);
                toggleCheck(checkUppercase, hasUpper);
                toggleCheck(checkNumber, hasNumber);
                toggleCheck(checkSymbol, hasSymbol);

                let strength = hasLength + hasUpper + hasNumber + hasSymbol;
                const {
                    percent,
                    color,
                    text
                } = getStrengthVisual(strength);

                strengthFill.style.width = percent;
                strengthFill.style.backgroundColor = color;
                strengthText.textContent = text;

                return strength === 4;
            }

            function validateMatch(pwd, confirm) {
                if (confirm === '') {
                    matchMessage.textContent = '';
                    return false;
                } else if (pwd === confirm) {
                    matchMessage.textContent = '✅ Las contraseñas coinciden';
                    matchMessage.style.background = '#d4edda';
                    matchMessage.style.color = 'green';
                    return true;
                } else {
                    matchMessage.textContent = '❌ Las contraseñas no coinciden';
                    matchMessage.style.background = '#f8d7da';
                    matchMessage.style.color = 'red';
                    return false;
                }
            }

            function checkFormStatus() {
                const pwd = passwordInput.value;
                const confirm = confirmInput.value;

                const requisitosOK = validatePasswordStrength(pwd);
                const coincidenciaOK = validateMatch(pwd, confirm);

                submitBtn.disabled = !(requisitosOK && coincidenciaOK); // ✅ Habilita/deshabilita
            }

            passwordInput.addEventListener('input', checkFormStatus);
            confirmInput.addEventListener('input', checkFormStatus);
        });

        // Mostrar modal sin bloquear inputs
        window.mostrarModalPassword = function() {
            const modal = document.getElementById("modal");
            modal.style.display = "flex";
        };
    </script>


    <script>
        // Alterna visibilidad del modal de contraseña
        window.mostrarModalPassword = function(event) {
            if (event) event.preventDefault(); // Evita recargar si viene de un enlace
            const modal = document.getElementById("modal");
            modal.style.display = modal.style.display === "block" ? "none" : "block";
        };
        window.modalCodigo = function() {
            document.getElementById("cambioContraseña").style.display = "block";
        };
    </script>


</body>

</html>