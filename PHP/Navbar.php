<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$rolUsuario = $_SESSION['rol'] ?? '';
$nombreUsuario = $_SESSION['nombre_usuario'] ?? '';
$foto = isset($_SESSION['foto']) && !empty($_SESSION['foto']) ? 'PHP/' . $_SESSION['foto'] : 'IMG/profile.png';

?>

<<<<<<< HEAD
<nav data-step="1" data-intro="Este es el menu principal, le ayuda
        a redirigirse a otras pestañas de la página, siempre tendrá acceso a el sin importar en que parte de la página se
        encuentre" <?php if (isset($tutorialMenu) && $tutorialMenu): ?> <?php endif; ?> class="menu">
=======
<nav class="menu">
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
    <button class="dropmenu-toggle">&#9776;</button>
    <ul>
        <li><a href="inventario.php">Inicio</a></li>
        <li><a href="prestamos.php">Préstamo</a></li>
        <li><a href="instructores.php">Instructores</a></li>

        <?php if ($rolUsuario === 'Administrador'): ?>
<<<<<<< HEAD
            <li><a class="btn-admin" href="Administrador.php"><strong >Administrador</strong></a></li>
        <?php endif; ?>

        <li>
            <div data-step="2" data-intro="Aquí usted podrá editar algunos datos de su perfil">
                <button
                    onclick="toggleProfile()" popovertarget="pop">Perfil</button>
            </div>
        </li>
        <li><a href="Cerrar_sesion.php">Cerrar sesión</a></li>

        <div data-step="3" data-intro="Podrá visualizar su nombre de usuario y foto de perfil" class="bienvenida">
=======
            <li><a class="btn-admin" href="Administrador.php"><strong>Administrador</strong></a></li>
        <?php endif; ?>

        <li><button onclick="toggleProfile()" popovertarget="pop">Perfil</button></li>
        <li><a href="Cerrar_sesion.php">Cerrar sesión</a></li>

        <div class="bienvenida">
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
            <img src="<?php echo htmlspecialchars($foto); ?>" alt="Foto de perfil" class="foto-redonda">
            <?php if (!empty($nombreUsuario)): ?>
                Bienvenido, <strong><?php echo htmlspecialchars($nombreUsuario); ?></strong>
            <?php endif; ?>
        </div>
    </ul>
<<<<<<< HEAD
</nav>
    <div id="pop">
        <h2>Editar perfil</h2>
        <form action="PHP/actualizar.php" method="POST" enctype="multipart/form-data">
            <div class="profilebtn">

                <input type="file" name="profile" id="img" accept="image/*">
            </div>
            <label for="img" id="cambiar"><i class="far fa-edit"></i>Cambiar foto</label>
            <input class="casillas" type="text" name="documento" id="documento"
                value="<?php echo $_SESSION['documento']; ?>" readonly>
            <input class="casillas" name="nuevo_usuario" type="text" placeholder="Nuevo usuario"
                value="<?php echo $_SESSION['nombre_usuario']; ?>">

            <input class="casillas" name="nuevo_correo" type="email" placeholder="Correo"
                value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>">
            <input id="Listo" type="submit" value="Listo">
        </form>
    </div>
=======
</nav>
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
