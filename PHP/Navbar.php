<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$rolUsuario = $_SESSION['rol'] ?? '';
$nombreUsuario = $_SESSION['nombre_usuario'] ?? '';
$foto = isset($_SESSION['foto']) && !empty($_SESSION['foto']) ? 'PHP/' . $_SESSION['foto'] : 'IMG/profile.png';

?>

<nav class="menu">
    <button class="dropmenu-toggle">&#9776;</button>
    <ul>
        <li><a href="inventario.php">Inicio</a></li>
        <li><a href="prestamos.php">Préstamo</a></li>
        <li><a href="instructores.php">Instructores</a></li>

        <?php if ($rolUsuario === 'Administrador'): ?>
            <li><a class="btn-admin" href="Administrador.php"><strong>Administrador</strong></a></li>
        <?php endif; ?>

        <li><button onclick="toggleProfile()" popovertarget="pop">Perfil</button></li>
        <li><a href="Cerrar_sesion.php">Cerrar sesión</a></li>

        <div class="bienvenida">
            <img src="<?php echo htmlspecialchars($foto); ?>" alt="Foto de perfil" class="foto-redonda">
            <?php if (!empty($nombreUsuario)): ?>
                Bienvenido, <strong><?php echo htmlspecialchars($nombreUsuario); ?></strong>
            <?php endif; ?>
        </div>
    </ul>
</nav>