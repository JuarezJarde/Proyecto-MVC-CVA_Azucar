<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPA - Proyecto Spa</title>
    <link rel="icon" href="Assets/Images/logo.jpeg" type="image/jpeg">
    <link rel="stylesheet" href="Assets/Css/Style.css">
    <meta name="description" content="Single Page Application con 4 secciones: Inicio, Servicios, Nosotros y Contacto">
    <style>
        :root {
            /* Actualizamos la variable global */
            --color-primary: <?php echo $config['color_principal']; ?> !important;
        }
        
        .btn:not(.btn-secundario) {
            background-color: <?php echo $config['color_principal']; ?> !important;
            color: white;
        }

        .btn-secundario {
            background-color: transparent !important;
            border: 2px solid <?php echo $config['color_principal']; ?> !important;
            color: <?php echo $config['color_principal']; ?> !important;
        }

        .btn-secundario:hover {
            background-color: <?php echo $config['color_principal']; ?> !important;
            color: white !important;
        }

        .nav-list a:hover, 
        .carrusel-control:hover, 
        .social-link:hover {
            background-color: <?php echo $config['color_principal']; ?> !important;
        }

        /* Títulos */
        h2, h3 {
            color: <?php echo $config['color_principal']; ?> !important;
        }
    </style>
</head>
<body>
    <header>
        <nav class="main-nav" aria-label="Menú principal">
            <section class="brand">
                <img src="Assets/Images/logo.jpeg" alt="Logo CVA Azúcar">
                <span>CVA Azúcar</span>
            </section>
            <ul class="nav-list">
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#servicios">Servicios</a></li>
                <li><a href="#nosotros">Nosotros</a></li>
                <li><a href="#contacto">Contacto</a></li>
            </ul>

            <section class="nav-iconos-derecha">
                <section class="menu-auth">
                    <?php if (isset($_SESSION['id_usuario'])) { ?>
                        
                        <section class="profile-container">
                            <section class="profile-avatar" onclick="toggleProfileMenu()">
                                <img src="Assets/Images/Hombre.jpg" alt="Perfil">
                            </section>

                            <section class="profile-dropdown" id="profileDropdown">
                                <section class="dropdown-header">
                                    <strong><?php echo $_SESSION['nombre']; ?></strong>
                                    <span class="badge-rol">
                                        <?php echo ($_SESSION['rol'] == 1) ? 'SuperUsuario' : (($_SESSION['rol'] == 2) ? 'Admin' : 'Usuario'); ?>
                                    </span>
                                </section>
                                <hr>
                                <a href="controladores/panel.php">
                                    <i class="fas fa-columns"></i> Ir al Panel
                                </a>
                                <a href="controladores/logout.php" class="link-logout">
                                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                </a>
                            </section>
                        </section>

                    <?php } else { ?>

                        <button id="btn-mostrar-login" class="btn btn-secundario">Iniciar Sesión</button>
                        <button id="btn-mostrar-registro" class="btn">Únete a nosotros</button>

                    <?php } ?>
                </section>
            </section>

            <button class="nav-toggle" aria-controls="menu" aria-expanded="false">☰</button>
          <!--  <button id="dack-mode-toggle" class="nav-toggle" aria-label="Cambiar tema"></button>--> 


        </nav>
    </header>

    <main>
        <!--------------Inicio-------------->
        <section id="inicio" class="section hero-carrusel">

            <section class="carrusel-container">

                <section class="carrusel activo">
                    <section class="container">
                        <h1 class="text-border">Bienvenido a Nuestra Página Empresarial</h1>
                        <p class="text-border">Quienes somos,para quien trabajamos y que hacemos todo está aqui.</p>
                        <a class="btn" href="#servicios">Ver servicios</a>
                    </section>
                </section>

                <section class="carrusel">
                    <section class="container">
                        <h1 class="text-border">Calidad y tradicion</h1>
                        <p class="text-border">Descubre nuestro proceso de la caña de azúcar.</p>
                        <a class="btn" href="#contacto">Contáctanos</a>
                    </section>
                </section>

                <section class="carrusel">
                    <section class="container">
                        <h1 class="text-border">Compromiso Venezolano</h1>
                        <p class="text-border">Apoyando a la industria nacional.</p>
                        <a class="btn" href="#nosotros">Conócenos</a>
                    </section>
                </section>

            </section>

            <button class="carrusel-control siguiente" aria-label="Siguiente">&#10095;</button>
            <button class="carrusel-control anterior" aria-label="Retroceder">&#10094;</button>
        </section>

        <!--------------Servicios-------------->

        <section id="servicios" class="section">
            <section class="container">
                <h2>Servicios</h2>
                <p>Ofrecemos Caña de Azúcar de alta calidad, y otros servicios de la industria alimenticia venezolana.</p>
                
                <section class="cards">

                    <?php 
                    if (!empty($lista_servicios_publicos)) {
                        foreach ($lista_servicios_publicos as $servicio) {
                    ?>
                        <article class="card">
                            <img src="<?php echo str_replace('../', '', $servicio['imagen_url']); ?>" alt="..." class="card-img">
                            
                            <section class="card-content">
                                <h3><?php echo $servicio['titulo']; ?></h3>
                                <p><?php echo $servicio['descripcion_servicio']; ?></p>
                            </section>
                        </article>
                    <?php 
                        } 
                    } else {
                        // Mensaje por si no hay servicios en la BD
                        echo "<p>No hay servicios disponibles en este momento.</p>";
                    }
                    ?>
                    </section>
            </section>
        </section>

        <!--------------Nosotros-------------->

        <section id="nosotros" class="section">
            <section class="container">
                <h2>Nosotros</h2>
                <p>Un equipo de profesionales comprometidos con darte la mejor calidad de Azúcar de la industria.</p>
                    
                <section class="nosotros-contenedor">

                    <article class="nosotros-tarjeta">
                        <img src="Assets/Images/Hombre.jpg" alt="Emmanuel Oropeza" class="nosotros-imagen">
                        <article class="Nosotros-info">
                            <h3 class="nosotros-nombre">Emmanuel Oropeza</h3>
                            <p class="nosotros-puesto">Título: TSU Informática</p> 
                            <p class="nosotros-descripcion">Programador Junior con Conocimientos básicos, en distintos Lenguajes</p>
                        </article> 
                    </article>

                    <article class="nosotros-tarjeta"> 
                        <img src="Assets/Images/Hombre.jpg" alt="Jardeivis Juarez" class="nosotros-imagen">
                        <article class="Nosotros-info">
                            <h3 class="nosotros-nombre">Jardeivis Juarez</h3>
                            <p class="nosotros-puesto">Título: TSU Informática</p>
                            <p class="nosotros-descripcion">Programador Junior con Conocimientos básicos, en distintos Lenguajes</p>

                        </article> 
                    </article>

                    <article class="nosotros-tarjeta">
                        <img src="Assets/Images/Mujer.jpg" alt="María Duin" class="nosotros-imagen">
                        <article class="Nosotros-info">
                            <h3 class="nosotros-nombre">María Duin</h3>
                            <p class="nosotros-puesto">Título: TSU Informática</p> 
                            <p class="nosotros-descripcion">Programador Junior con Conocimientos básicos, en distintos Lenguajes</p>
                        </article>
                    </article>

                    <article class="nosotros-tarjeta">
                        <img src="Assets/Images/Hombre.jpg" alt="Eduardo Vargas" class="nosotros-imagen">
                        <article class="Nosotros-info">
                            <h3 class="nosotros-nombre">Eduardo Vargas</h3>
                            <p class="nosotros-puesto">Título: TSU Informática</p> 
                            <p class="nosotros-descripcion">Programador Junior con Conocimientos básicos, en distintos Lenguajes</p>
                        </article> 
                    </article>
                
                </section>
            </section>
        </section>

        <!--------------Mision y vision-------------->

        <section class="section">
            <section class="container">
                <h2>Nuestra Misión</h2>
                <p>CVA AZÚCAR es una corporación socialista venezolana, cuyo objeto es establecer, supervisar, ejecutar, inspeccionar y desarrollar la producción, comercialización, industrialización, importación y exportación de la caña de azúcar y sus derivados, que basada en principios y valores, busca como norte satisfacer las necesidades del pueblo venezolano abasteciendo la demanda del azúcar y sus derivados.</p>
                <h2>Nuestra Visión</h2>
                <p>Ser una empresa agroalimentaria venezolana, con-fiable vanguardista, reconocida nacional e internacionalmente que basada en altos principios socialistas, éticos y morales, que contribuya a mejorar la calidad de vida del pueblo venezolano abasteciendo la demanda del azúcar y sus derivados, a precios justos y razonables.</p>
            </section>
        </section>
    </main>

    <!--Footer-->

    <footer id="contacto">
        
        <section class="container footer-content">
            
            <section class="footer-section">
                <h3>Contáctanos</h3>
                <p>Estamos atentos a tus redes y mensajes.</p>
                
                <section class="social-links">
                    <a href="https://youtu.be/xvFZjo5PgG0?si=ALr2fVAo-_8J5WgD" class="social-link btn-rickroll">📘 Facebook</a>
                    <a href="https://youtu.be/xvFZjo5PgG0?si=ALr2fVAo-_8J5WgD" class="social-link btn-rickroll">📷 Instagram</a>
                    <a href="https://youtu.be/xvFZjo5PgG0?si=ALr2fVAo-_8J5WgD" class="social-link btn-rickroll">🐦 Twitter</a>
                </section>
            </section>

            <section class="footer-section">
                <h3>Ubicación</h3>
                <p>📍 Barquisimeto, Lara. Venezuela</p>
                <p>📧 <?php echo $config['email_contacto']; ?></p>
                <p>📞 <?php echo $config['telefono']; ?></p>
                <p>&copy; <span id="year"></span> <?php echo $config['titulo_sitio']; ?></p>
            </section>

        </section>
        
        <section class="footer-copyright">
            <p>&copy; <span id="year"></span> CVA Azúcar S.A - Todos los derechos reservados</p>
        </section>
    </footer>

    <!--------------Login y Registro (MODAL)-------------->

    <section id="modal-login" class="modal-overlay">
        <section class="modal-contenido">
            <button class="modal-cerrar" arial-label="Cerrar">&times;</button>
            <h3>Iniciar Sesión</h3>
            <form id="form-login" class="modal-form" action="controladores/login.php" method="POST">
                <label for="login-email">Correo Electrónico</label>
                <input id="login-email" name="email" type="email" required>

                <label for="login-pass">Contraseña</label>
                <input id="login-pass" name="password" type="password" required>

                <button type="submit" class="btn">Entrar</button>
            </form>
        </section>
    </section>

    <section id="modal-registro" class="modal-overlay">
        <section class="modal-contenido">
            <button class="modal-cerrar" aria-label="Cerrar">&times;</button>
            <h3>Crear Cuenta</h3>
            <form id="form-registro" class="modal-form" action="controladores/registro.php" method="POST">
                <label for="reg-nombre">Nombre Completo</label>
                <input id="reg-nombre" name="nombre_completo" type="text" required>

                <label for="reg-email">Correo Electrónico</label>
                <input id="reg-email" name="email" type="email" required>

                <label for="reg-pass">Contraseña</label>
                <input id="reg-pass" name="password" type="password" required>

                <label for="reg-pass-confirmar">Repetir Contraseña</label>
                <input id="reg-pass-confirmar" name="password_confirm" type="password" required>

                <button type="submit" class="btn">Enviar Solicitud</button>
            </form>
        </section>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script src="Assets/Js/Main.js"></script>

    <?php 
    if (isset($_GET['msg'])) { 
        $mensaje = $_GET['msg'];
        $titulo = "";
        $texto = "";
        $icono = "error"; // Por defecto error

        switch($mensaje) {
            // REGISTRO
            case 'registro_exito':
                $titulo = "¡Solicitud Enviada!";
                $texto = "Tu cuenta está en lista de espera. El administrador debe aprobarte.";
                $icono = "success";
                break;
            case 'pass_no_coincide':
                $titulo = "Error de Contraseña";
                $texto = "Las contraseñas no coinciden.";
                break;
            case 'usuario_existe':
                $titulo = "Ya Registrado";
                $texto = "Este correo ya pertenece a un usuario activo.";
                $icono = "warning";
                break;
            case 'solicitud_existe':
                $titulo = "En Espera";
                $texto = "Ya tienes una solicitud pendiente. Ten paciencia.";
                $icono = "info";
                break;
            case 'error_registro':
                $titulo = "Error";
                $texto = "Ocurrió un error al registrar. Intenta de nuevo.";
                break;
            
            // LOGIN
            case 'login_fallido':
                $titulo = "Acceso Denegado";
                $texto = "Contraseña incorrecta.";
                break;
            case 'usuario_inactivo':
                $titulo = "Cuenta Inactiva";
                $texto = "Tu usuario está bloqueado o aún no ha sido aprobado.";
                $icono = "warning";
                break;
            case 'email_no_encontrado':
                $titulo = "No Encontrado";
                $texto = "Este correo no está registrado.";
                break; 
            // CASOS DE CONTRASEÑA
            case 'pass_no_coincide':
                $titulo = "Error";
                $texto = "Las contraseñas no son iguales.";
                $icono = "error";
                break;
            case 'pass_muy_corta':
                $titulo = "Contraseña Débil";
                $texto = "Debe tener al menos 8 caracteres.";
                $icono = "warning";
                break;
            case 'pass_sin_numero':
                $titulo = "Contraseña Débil";
                $texto = "Debe incluir al menos un número.";
                $icono = "warning";
                break;
        }
    ?>
        <script>
            Swal.fire({
                title: "<?php echo $titulo; ?>",
                text: "<?php echo $texto; ?>",
                icon: "<?php echo $icono; ?>",
                confirmButtonColor: '#66AC4C'
            }).then(() => {
                // Limpiar URL para que no salga la alerta al recargar
                window.history.replaceState(null, null, window.location.pathname);
            });
        </script>
    <?php } ?>
</body>
</html>