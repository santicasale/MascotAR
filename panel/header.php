<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header>
    <div class="header-container">
        <div class="logo">
            <img src="/ONG/imagenesong/logomascotar.png" alt="Logo MascotAR">
        </div>
        <nav>
            <ul>
                <li><a href="../index.php">Inicio</a></li>

                <li>
                    <a href="../index.php#nosotros">Quiénes Somos</a>
                    <ul class="submenu">
                        <li><a href="../prensa.php">Prensa</a></li>
                    </ul>
                </li>

                <li><a href="../donacion.php">Donar</a></li>

                <li>
                    <a href="../adoptar.php">Adoptar</a>
                    <ul class="submenu">
                        <li><a href="../adoptados.php">Adoptados</a></li>
                    </ul>
                </li>
                <li class="user-menu">
                <?php if (isset($_SESSION['nick'])): ?>
                    <a href="#"><i class="fas fa-user"></i> Hola, <?= htmlspecialchars($_SESSION['nick']); ?></a>

                    <ul class="submenu">

                        <?php if (!empty($_SESSION['admin']) && $_SESSION['admin'] == "SÍ"): ?>
                             <li><a href="index.php">Ver Panel administrativo</a></li>
                            <li><a href="../ver_donaciones.php">Ver donaciones</a></li>
                            <li><a href="../ver_adopciones.php">Ver adopciones</a></li>
                            <li><a href="../ver_consultas.php">Ver Consultas</a></li>
                            <li><a href="../ingreso_mascotas.php">Ingreso de mascotas</a></li>
                            <hr>
                        <?php endif; ?>

                        <li><a href="../historial_donaciones.php">Historial de donaciones</a></li>
                        <li><a href="../historial_adopciones.php">Historial de adopciones</a></li>
                        <li><a href="../logout.php">Cerrar sesión</a></li>

                    </ul>

                <?php else: ?>
                    <li class="user-menu">
                        <a href="#"><i class="fas fa-user"></i>Ingresar</a>
                        <ul class="submenu login-submenu">
                            <li>
                                <form class="login-form" action="login.php" method="post">
                                    <h3>Iniciar sesión</h3>
                                    <input type="email" name="email" placeholder="Ingrese su correo" required>
                                    <input type="password" name="pass" placeholder="Ingrese su contraseña" required>
                                    <button type="submit">Entrar</button>
                                </form>

                                <p class="register-link">
                                    ¿No tenés cuenta? <a href="../registrarse.php">Registrate</a>
                                </p>
                            </li>
                        </ul>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </div>
</header>