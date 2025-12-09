<!--Id DE los paneles
    panel-inicio
    panel-mi-perfil
    panel-usuarios
    panel-servicios
    panel-inventario
    panel-config-pagina
    panel-roles
    panel-auditoria
    -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo $rol_usuario; ?></title>
    <link rel="icon" href="../Assets/Images/logo.jpeg" type="image/jpeg">
    <link rel="stylesheet" href="../Assets/Css/Style.css">
    <link rel="stylesheet" href="../Assets/Css/Admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <section class="admin-container">
        
        <!-- =======================================================
            barra lateral (SIDEBAR)
        ======================================================== -->
        <aside class="sidebar">
            <section class="sidebar-header">
                <h3>CVA Azucar System</h3>
                <p>Hola, <?php echo $nombre_usuario; ?></p>
                <span class="badge" style="float:none; background:#66AC4C;"><?php echo $rol_usuario; ?></span>
            </section>

            <nav class="sidebar-nav">
                <ul>
                    <!--OPCIONES COMUNES (Para todos los roles) -->
                    <li><a href="#" class="active" onclick="mostrarPanel('inicio')"><i class="fas fa-home"></i> Inicio</a></li>
                    <li><a href="#" onclick="mostrarPanel('mi-perfil')"><i class="fas fa-user"></i> Mi Perfil</a></li>

                    <!--SECCIÓN DE GESTIÓN (Visible para Administrador y SuperUsuario) -->
                    <?php if ($rol_usuario == 'Administrador' || $rol_usuario == 'SuperUsuario') { ?>
                        <li class="menu-divider">Gestión</li> <!-- Título separador -->
                        <li><a href="#" onclick="mostrarPanel('usuarios')"><i class="fas fa-users"></i> Usuarios y Solicitudes</a></li>
                        <li><a href="#" onclick="mostrarPanel('servicios')"><i class="fas fa-box-open"></i> Servicios</a></li>
                        <li><a href="#" onclick="mostrarPanel('inventario')"><i class="fas fa-clipboard-list"></i> Inventario</a></li>
                    <?php } ?>

                    <!--SECCIÓN AVANZADA (Exclusiva para SuperUsuario) -->
                    <?php if ($rol_usuario == 'SuperUsuario') { ?>
                        <li class="menu-divider">Super Usuario</li> <!-- Título separador -->
                        <li><a href="#" onclick="mostrarPanel('config-pagina')"><i class="fas fa-paint-brush"></i> Configurar Página</a></li>
                        <li><a href="#" onclick="mostrarPanel('roles')"><i class="fas fa-user-shield"></i> Gestión de Roles</a></li>
                        <li><a href="#" onclick="mostrarPanel('auditoria')"><i class="fas fa-history"></i> Auditoría del Sistema</a></li>
                        <li><a href="#" onclick="mostrarPanel('reportes')"><i class="fas fa-chart-line"></i> Reportes y Estadísticas</a></li>
                        <li><a href="#" onclick="mostrarPanel('informe-estadistico')"><i class="fas fa-book-open"></i> Informe Estadística</a></li>
                    <?php } ?>

                    <!-- Botón de Salir -->
                    <li><a href="../index.php"><i class="fas fa-globe"></i> Ir al Sitio Web</a></li>

                    <!-- Botón de Salir -->
                    <li><a href="../controladores/logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                </ul>
            </nav>
        </aside>

        <!-- =======================================================
             contenido principal (PANELES)
        ======================================================== -->
        <main class="main-content">
            
            <!-- PANEL 1: INICIO (Diferente según el rol) -->
            <section id="panel-inicio" class="panel active">
                <h1>Bienvenido al Panel de Control</h1>
                
                <!-- VISTA PARA EL ROL: USUARIO (Solo ve bienvenida) -->
                <?php if ($rol_usuario == 'Usuario') { ?>
                    <section class="user-welcome">
                        <h2>👋 ¡Hola de nuevo!</h2>
                        <p>Tu estatus actual es: <strong style="color:green;">ACTIVO</strong></p>
                        <p>Desde aquí puedes ver tus datos y el estado de tus solicitudes.</p>
                     </section>

                <!-- VISTA PARA ROLES: ADMIN Y SUPERUSUARIO (Ven estadísticas) -->
                <?php } else { ?>
                        <section class="stats-grid">
                        
                        <!-- Tarjeta Usuarios -->
                        <section class="stat-card">
                            <h3>Usuarios Activos</h3>
                            <!-- Aquí imprimimos la variable real -->
                            <p class="number"><?php echo $total_usuarios; ?></p>
                        </section>
                        
                        <!-- Tarjeta Solicitudes -->
                        <section class="stat-card warning">
                            <h3>Solicitudes Pendientes</h3>
                            <p class="number"><?php echo $total_solicitudes; ?></p>
                        </section>
                        
                        <!-- Tarjeta Inventario -->
                        <section class="stat-card">
                            <h3>Inventario Total</h3>
                            <p class="number"><?php echo $total_inventario; ?> Kg</p> <!-- O 'Sacos' según tu unidad -->
                        </section>

                    </section>
                <?php } ?>
            </section>

            <!-- PANEL 2: MI PERFIL (Común para todos) -->
            <section id="panel-mi-perfil" class="panel" style="display: none;">
                <h1>Mis Datos Personales</h1>
                <form class="config-form">
                    <label>Nombre:</label> <input type="text" value="<?php echo $nombre_usuario; ?>" readonly>
                    <label>Rol:</label> <input type="text" value="<?php echo $rol_usuario; ?>" readonly>
                    <button class="btn">Solicitar Cambio de Datos</button>
                </form>
            </section>

            <!-- =======================================================
                 gestion (ADMIN Y SUPERUSUARIO)
            ======================================================== -->
            <?php if ($rol_usuario == 'Administrador' || $rol_usuario == 'SuperUsuario') { ?>
                

                <!-- Panel: Usuarios (Aprobar/Rechazar) -->

                <section id="panel-usuarios" class="panel" style="display: none;">
                    <h1>Gestión de Usuarios</h1>
                    <p>Solicitudes pendientes.</p>

                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //Consultamos los pendientes
                            if (!empty($lista_pendientes)) {
                                foreach ($lista_pendientes as $row) {
                            ?>   
                                <tr>
                                    <td><?php echo $row['nombre_completo']; ?></td>
                                    <td><?php echo $row['correo']; ?></td>
                                    <td><?php echo $row['fecha_solicitud']; ?></td>
                                    <td>
                                        <form action="../controladores/aprobar.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="id_solicitud" value="<?php echo $row['id_solicitud']; ?>">
                                            
                                            <input type="hidden" name="id_rol_asignar" value="3"> 
                                            
                                            <button type="submit" name="accion" value="aprobar" class="btn-aprobar" style="background:#28a745; color:white; border:none; padding:5px 10px; cursor:pointer; border-radius:4px;">
                                                ✅ Aprobar
                                            </button>
                                        </form>

                                        <form action="../controladores/aprobar.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="id_solicitud" value="<?php echo $row['id_solicitud']; ?>">
                                            <button type="submit" name="accion" value="rechazar" class="btn-rechazar" style="background:#dc3545; color:white; border:none; padding:5px 10px; cursor:pointer; border-radius:4px;">
                                                ❌ Rechazar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php     
                                }
                            }else{echo "<tr><td colspan='4'>No hay solicitudes pendientes.</td></tr>";}
                            ?>
                        </tbody>
                    </table>

                        <!--Estado Activo e Innactivo-->
                        
                    <hr style="margin: 2rem 0; border: 0; border-top: 1px solid #ccc;">

                    <h2>Usuarios Registrados</h2>
                    <p>Listado de usuarios con acceso al sistema.</p>

                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Estatus</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($lista_usuarios)) {
                                    foreach ($lista_usuarios as $u) {
                                        $colorEstado = ($u['estatus'] == 'activo') ? 'green' : 'red';
                            ?>
                                <tr>
                                    <td><?php echo $u['nombre_completo']; ?></td>
                                    <td><?php echo $u['correo']; ?></td>
                                    <td><?php echo $u['nombre_rol']; ?></td>
                                    <td style="color: <?php echo $colorEstado; ?>; font-weight:bold;">
                                        <?php echo strtoupper($u['estatus']); ?>
                                    </td>
                                    <td>
                                        <!-- Botón para cambiar estatus -->
                                        <form action="../controladores/estado.php" method="POST">
                                            <input type="hidden" name="id_usuario" value="<?php echo $u['id_usuario']; ?>">
                                            <input type="hidden" name="estado_actual" value="<?php echo $u['estatus']; ?>">
                                            
                                            <?php if ($u['estatus'] == 'activo') { ?>
                                                <button type="submit" class="btn-rechazar" title="Bloquear Usuario">
                                                    🚫 Bloquear
                                                </button>
                                            <?php } else { ?>
                                                <button type="submit" class="btn-aprobar" title="Reactivar Usuario">
                                                    ✅ Activar
                                                </button>
                                            <?php } ?>
                                        </form>
                                    </td>
                                </tr>
                            <?php 
                                }
                            } else {
                                echo "<tr><td colspan='5'>No hay otros usuarios registrados.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </section>

                <!-- Panel: Servicios -->

                <section id="panel-servicios" class="panel" style="display: none;">
                    <h1>Gestión de Servicios</h1>
                    <p>Agrega nuevos servicios que aparecerán en la página principal.</p>

                    <section style="background: #f9f9f9; padding: 20px; border-radius: 8px; max-width: 600px;">
                        <h3>➕ Nuevo Servicio</h3>
                        
                        <!-- IMPORTANTE: enctype para subir fotos -->
                        <form action="../controladores/servicios_controlador.php" method="POST" enctype="multipart/form-data">
                            
                            <input type="hidden" name="accion" value="crear">

                            <label style="display:block; margin-top:10px;">Título del Servicio:</label>
                            <input type="text" name="titulo" required style="width:100%; padding:8px; margin-bottom:10px;">

                            <label style="display:block;">Descripción:</label>
                            <textarea name="descripcion" rows="3" required style="width:100%; resize: none;; padding:8px; margin-bottom:10px;"></textarea>

                            <label style="display:block;">Imagen Representativa:</label>
                            <input type="file" name="imagen" accept="image/*" required style="margin-bottom:15px;">

                            <button type="submit" class="btn-guardar" style="width:100%;">Publicar Servicio</button>
                        </form>
                    </section>

                    <hr style="margin: 2rem 0; border: 0; border-top: 1px solid #ccc;">

                    <h3>Servicios Activos</h3>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Título</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                            <tbody>
                                <?php if (!empty($lista_servicios)) {
                                    foreach ($lista_servicios as $s) { ?>
                                    <tr>
                                        <td><img src="<?php echo $s['imagen_url']; ?>" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;"></td>
                                        <td><?php echo $s['titulo']; ?></td>
                                        <td>
                                            <a href="#" class="btn-rechazar"
                                            onclick="confirmarAccion('../controladores/servicios_controlador.php?accion=eliminar&id=<?php echo $s['id_servicio']; ?>', 
                                                '¿Eliminar Servicio?', 
                                                'Desaparecerá de la página de inicio.'
                                            )">
                                            🗑️
                                            </a>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='3'>No hay servicios publicados.</td></tr>"; } ?>
                            </tbody>
                    </table>
                </section>

                <!-- Panel: Inventario -->

                <section id="panel-inventario" class="panel" style="display: none;">
                    <h1>Inventario de Azúcar</h1>
                    <p>Control de stock y materia prima.</p>

                    <section style="background: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                        <h3>📦 Registrar Producto / Entrada</h3>
                        <form action="../controladores/inventario_controlador.php" method="POST">
                            <input type="hidden" name="accion" value="crear">
                            
                            <section style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                <section>
                                    <label>Código:</label>
                                    <input type="text" name="codigo" required style="width:100%; padding:8px;">
                                </section>
                                <section>
                                    <label>Nombre del Producto:</label>
                                    <input type="text" name="nombre" required style="width:100%; padding:8px;">
                                </section>
                                <section>
                                    <label>Cantidad:</label>
                                    <input type="number" step="0.01" name="cantidad" required style="width:100%; padding:8px;">
                                </section>
                                <section>
                                    <label>Unidad:</label>
                                    <select name="unidad" style="width:100%; padding:8px;">
                                        <option value="Kg">Kilogramos (Kg)</option>
                                        <option value="Sacos">Sacos</option>
                                        <option value="Toneladas">Toneladas</option>
                                        <option value="Litros">Litros</option>
                                    </select>
                                </section>
                            </section>
                            <button type="submit" class="btn-guardar" style="margin-top:15px; width:100%;">Guardar en Inventario</button>
                        </form>
                    </section>

                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Stock</th>
                                <th>Unidad</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($lista_inventario)) {
                                foreach ($lista_inventario as $prod) { ?>
                                <tr>
                                    <td><strong><?php echo $prod['codigo_producto']; ?></strong></td>
                                    <td><?php echo $prod['nombre_producto']; ?></td>
                                    
                                    <td style="font-weight:bold; color: <?php echo ($prod['cantidad_stock'] < 10) ? 'red' : 'green'; ?>">
                                        <?php echo $prod['cantidad_stock']; ?>
                                    </td>
                                    
                                    <td><?php echo $prod['unidad_medida']; ?></td>
                                    <td>
                                        <a href="#" 
                                        class="btn-rechazar"
                                        onclick="confirmarAccion('../controladores/inventario_controlador.php?accion=eliminar&id=<?php echo $prod['id_producto']; ?>', 
                                            '¿Eliminar Producto?', 
                                            'Se eliminará del inventario de forma permanente.'
                                        )">
                                        🗑️
                                        </a>
                                    </td>
                                </tr>
                            <?php } } else { echo "<tr><td colspan='5'>Inventario vacío.</td></tr>"; } ?>
                        </tbody>
                    </table>
                </section>

                <!--Codigos Profesora de ing-->
            <?php } ?>

            <!-- =======================================================
                 paneles de super usuario
            ======================================================== -->
            <?php if ($rol_usuario == 'SuperUsuario') { ?>
                
                <!-- Panel:Cambiar colores-->

                <section id="panel-config-pagina" class="panel" style="display: none;">
                    <h1>CMS - Configuración Visual</h1>
                    <p>Personaliza la apariencia y datos de contacto de la página principal.</p>
                    
                    <section style="background: #f9f9f9; padding: 20px; border-radius: 8px; max-width: 500px;">
                        <form action="../controladores/config_controlador.php" method="POST">
                            
                            <label style="display:block; margin-bottom:5px; font-weight:bold;">Color Principal:</label>
                            <input type="color" name="color" value="<?php echo $lista_config['color_principal'] ?? '#66AC4C'; ?>" style="width: 100%; height: 40px; cursor: pointer; margin-bottom: 15px;">

                            <label style="display:block; margin-bottom:5px; font-weight:bold;">Título del Sitio:</label>
                            <input type="text" name="titulo" value="<?php echo $lista_config['titulo_sitio'] ?? 'CVA Azúcar'; ?>" required style="width: 100%; padding: 8px; margin-bottom: 15px;">

                            <label style="display:block; margin-bottom:5px; font-weight:bold;">Teléfono:</label>
                            <input type="text" name="telefono" value="<?php echo $lista_config['telefono'] ?? ''; ?>" required style="width: 100%; padding: 8px; margin-bottom: 15px;">

                            <label style="display:block; margin-bottom:5px; font-weight:bold;">Correo de Contacto:</label>
                            <input type="email" name="email" value="<?php echo $lista_config['email_contacto'] ?? ''; ?>" required style="width: 100%; padding: 8px; margin-bottom: 15px;">

                            <button type="submit" class="btn-guardar" style="width: 100%;">💾 Guardar Cambios</button>
                        </form>
                    </section>
                </section>

                <!------------------------------- Panel: Gestión de Roles (Ascender/Degradar) ------------------------->

                <section id="panel-roles" class="panel" style="display: none;">
                    <h1>Gestión de Roles y Permisos</h1>
                    <p>Aquí puedes ascender a un Usuario común a Administrador.</p>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Rol Actual</th>
                                <th>Cambiar a...</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //buscamos usuarios activos
                            if(!empty($lista_roles)){ 
                                foreach($lista_roles as $rowR){
                            ?>
                                <tr>
                                    <td>
                                        <strong><?php echo $rowR['nombre_completo']; ?></strong>
                                        <small><?php echo $rowR['correo']; ?></small>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: #333;">
                                            <?php echo $rowR['nombre_rol']; ?>
                                        </span>
                                    </td>

                                    <!--form para cambiar el rol-->
                                    <form action="../controladores/cambiar_rol.php" method="POST">
                                        <td>
                                            <input type="hidden" name="id_usuario" value="<?php echo $rowR['id_usuario']; ?>">
                                            
                                            <!-- Selector de Roles -->
                                            <select name="nuevo_rol" style="padding: 5px; border-radius: 4px;">
                                                <option value="1" <?php if($rowR['id_rol']==1) echo 'selected'; ?>>SuperUsuario</option>
                                                <option value="2" <?php if($rowR['id_rol']==2) echo 'selected'; ?>>Administrador</option>
                                                <option value="3" <?php if($rowR['id_rol']==3) echo 'selected'; ?>>Usuario</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn-guardar";">
                                                💾 Guardar
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                                <?php 
                                }
                            }else{
                                echo "<tr><td colspan='4'>No hay otros usuarios activos para gestionar.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </section>
                
                <!-------------------- Panel: Auditoría (Logs)-------------------- -->

                <section id="panel-auditoria" class="panel" style="display: none;">
                    <h1>Auditoría del Sistema</h1>
                    <p>Registro histórico de seguridad y movimientos.</p>

                    <section style="overflow-x:auto;">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                    <th>Acción</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($lista_logs)) { 
                                    foreach ($lista_logs as $log) { ?>
                                    <tr>
                                        <td style="font-size: 0.85em; color: #666; width: 150px;">
                                            <?php echo $log['fecha_hora']; ?>
                                        </td>
                                        <td style="font-weight: bold;">
                                            <?php echo $log['usuario']; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                $color = "#555"; // Gris por defecto
                                                if(strpos($log['accion'], 'Login') !== false) $color = "#007bff"; // Azul
                                                if(strpos($log['accion'], 'Logout') !== false) $color = "#6c757d"; // Gris claro
                                                if(strpos($log['accion'], 'Error') !== false) $color = "#dc3545"; // Rojo
                                                if(strpos($log['accion'], 'Nuevo') !== false) $color = "#28a745"; // Verde
                                                if(strpos($log['accion'], 'Eliminar') !== false) $color = "#fd7e14"; // Naranja
                                            ?>
                                            <span class="badge" style="background: <?php echo $color; ?>;">
                                                <?php echo $log['accion']; ?>
                                            </span>
                                        </td>
                                        <td style="font-size: 0.9em;"><?php echo $log['detalles']; ?></td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='4'>No hay registros de actividad aún.</td></tr>"; } ?>
                            </tbody>
                        </table>
                    </section>
                </section>
            <?php } ?>

                        <!-----------------------------------reportes---------------------------------->

                <section id="panel-reportes" class="panel" style="display: none;">
                    <h1>Reportes de Sistema</h1>
                    <p>Visualización y exportación de datos de usuarios.</p>

                    <section style="margin-bottom: 20px;">
                        <a href="../controladores/reporte_excel.php" target="_blank" class="btn-guardar" style="background:#217346;">
                            📊 Descargar Excel
                        </a>
                        <a href="../controladores/reporte_pdf.php" target="_blank" class="btn-rechazar" style="background:#b30b00;">
                            📄 Descargar PDF
                        </a>
                    </section>

                    <section style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <canvas id="graficoUsuarios"></canvas>
                    </section>
                </section>

                                    <!-- ---------------- Estadisticas ----------------- -->

                <section id="panel-informe-estadistico" class="panel" style="display: none;">
                    
                    <section style="background: white; padding: 20px; border-left: 5px solid #66AC4C; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 25px;">
                        <h1 style="color: #333; margin: 0; font-size: 1.8rem;">Informe de Análisis Estadístico</h1>
                        <p style="color: #666; margin-top: 5px;"><strong>Variable:</strong> Cantidad de personas que usan el sistema contable por oficina.</p>
                    </section>

                    <section style="display: grid; grid-template-columns: 35% 63%; gap: 2%; align-items: start;">
                        
                        <section style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                            <h3 style="border-bottom: 2px solid #66AC4C; padding-bottom: 10px; color: #333;">
                                📝 Datos Recolectados
                            </h3>
                            <p style="font-size: 0.8rem; color: #666; margin-bottom: 10px;">
                                Ingresa la cantidad de usuarios para cada oficina:
                            </p>

                            <table class="admin-table" style="font-size: 0.85rem;">
                                <thead>
                                    <tr style="background-color: #f4f4f4;">
                                        <th>Oficina</th>
                                        <th style="width: 80px;">Datos</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla_oficinas">
                                    <tr><td>Informática</td><td><input type="number" value="4" class="input-dato"></td></tr>
                                    <tr><td>Compra</td><td><input type="number" value="3" class="input-dato"></td></tr>
                                    <tr><td>Contabilidad</td><td><input type="number" value="4" class="input-dato"></td></tr>
                                    <tr><td>RRHH</td><td><input type="number" value="6" class="input-dato"></td></tr>
                                    <tr><td>Agrícola</td><td><input type="number" value="2" class="input-dato"></td></tr>
                                    <tr><td>Tesorería</td><td><input type="number" value="4" class="input-dato"></td></tr>
                                    <tr><td>Bienestar Social</td><td><input type="number" value="2" class="input-dato"></td></tr>
                                    <tr><td>Nómina</td><td><input type="number" value="3" class="input-dato"></td></tr>
                                    <tr><td>Planif. y Presupuesto</td><td><input type="number" value="4" class="input-dato"></td></tr>
                                    <tr><td>Seg. y Salud Laboral</td><td><input type="number" value="4" class="input-dato"></td></tr>
                                    <tr><td>Facturación</td><td><input type="number" value="1" class="input-dato"></td></tr>
                                </tbody>
                            </table>

                            <button onclick="recalcularEstadisticas()" class="btn-guardar" style="width: 100%; margin-top: 15px;">
                                🔄 Recalcular Todo
                            </button>
                            <section style="margin-top: 15px; display: flex; gap: 10px;">
                                
                                <button onclick="exportarExcel()" class="btn-guardar" style="background: #217346; flex: 1;">
                                    <i class="fas fa-file-excel"></i> Excel
                                </button>
                                
                                <button onclick="imprimirReporte()" class="btn-rechazar" style="background: #333; flex: 1;">
                                    <i class="fas fa-print"></i> PDF
                                </button>

                            </section>
                        </section>

                        <section style="display: flex; flex-direction: column; gap: 20px;">
                            
                            <section class="stats-grid" style="grid-template-columns: repeat(3, 1fr); gap: 10px;">
                                <section class="stat-card" style="padding: 10px;">
                                    <h3>Media</h3>
                                    <p class="number" id="val_media" style="font-size: 1.5rem; color: #007bff;">3.36</p>
                                </section>
                                <section class="stat-card" style="padding: 10px;">
                                    <h3>Mediana</h3>
                                    <p class="number" id="val_mediana" style="font-size: 1.5rem; color: orange;">4</p>
                                </section>
                                <section class="stat-card" style="padding: 10px;">
                                    <h3>Moda</h3>
                                    <p class="number" id="val_moda" style="font-size: 1.5rem; color: #66AC4C;">4</p>
                                </section>
                            </section>

                            <section style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #eee;">
                                <h3 style="margin-bottom: 10px;">Distribución de Usuarios</h3>
                                <section style="height: 250px;">
                                    <canvas id="graficoPasantia"></canvas>
                                </section>
                            </section>

                            <section style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #eee;">
                                <h3>📊 Tabla de Frecuencias Generada</h3>
                                <table class="admin-table" style="font-size: 0.8rem; text-align: center;">
                                    <thead>
                                        <tr style="background: #89CFF0; color: black;">
                                            <th>Data (X)</th>
                                            <th>Frec (f)</th>
                                            <th>Fa</th>
                                            <th>Fr %</th>
                                            <th>Fra %</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_tabla_frecuencia">
                                        </tbody>
                                </table>
                            </section>

                        </section>
                    </section>
                </section>

        </main>
    </section>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="../Assets/Js/admin.js"></script>
    <?php 

    //DETECTAR MENSAJES (Alertas)

    if (isset($_GET['msg'])) { 
        $mensaje = $_GET['msg'];
        $titulo = ""; $texto = ""; $icono = "success";

        switch($mensaje) {
            case 'aprobado':
                $titulo = "¡Usuario Aprobado!";
                $texto = "El usuario ha sido registrado correctamente.";
                break;
            case 'rechazado':
                $titulo = "Solicitud Rechazada";
                $texto = "La solicitud ha sido eliminada.";
                $icono = "info";
                break;
            case 'estado_cambiado':
                $titulo = "Estado Actualizado";
                $texto = "El estatus del usuario ha cambiado.";
                break;
            case 'rol_cambiado':
                $titulo = "Rol Modificado";
                $texto = "Se han actualizado los permisos del usuario.";
                break;
            case 'error':
                $titulo = "Error";
                $texto = "No se pudo realizar la operación.";
                $icono = "error";
                break;
                //casos de servicio
            case 'servicio_creado':
                $titulo = "¡Servicio Publicado!";
                $texto = "El nuevo servicio se ha agregado correctamente a la página.";
                break;
            case 'servicio_eliminado':
                $titulo = "Servicio Eliminado";
                $texto = "El servicio y su imagen han sido borrados.";
                $icono = "info";
                break;
            case 'error_imagen':
                $titulo = "Error de Imagen";
                $texto = "No se pudo subir la imagen. Verifica que sea JPG/PNG.";
                $icono = "error";
                break;
            case 'error_accion_no_detectada':
                $titulo = "Error Interno";
                $texto = "El formulario no envió la acción correcta.";
                $icono = "question";
                break;
                //casos de inventario
            case 'producto_creado':
                $titulo = "Producto Agregado";
                $texto = "El inventario se ha actualizado correctamente.";
                break;
            case 'producto_eliminado':
                $titulo = "Producto Eliminado";
                $texto = "El ítem ha sido borrado del inventario.";
                $icono = "warning";
                break;
                //caso de configuracion
                case 'config_guardada':
                $titulo = "Configuración Actualizada";
                $texto = "Los cambios se aplicaron a la página de inicio.";
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
                // Limpia la URL pero MANTIENE la pestaña
                window.history.replaceState(null, null, window.location.pathname);
            });
        </script>
    <?php } ?>


    <?php 
    if (isset($_GET['tab'])) { 
        $tab = $_GET['tab'];
    ?>
        <script>
            // Esperamos a que cargue el DOM
            document.addEventListener("DOMContentLoaded", function() {
                // Llamamos a tu función de JS para cambiar el panel
                mostrarPanel('<?php echo $tab; ?>');
            });
        </script>
    <?php } ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
    $datosGrafico = $modelo->obtenerUsuariosPorMes();
    
    //listas
    $meses = [];
    $cantidades = [];
    foreach ($datosGrafico as $d) {
        $meses[] = $d['mes']; // Eje X (Enero, Febrero...)
        $cantidades[] = $d['total']; // Eje Y (5, 10, 2...)
    }
?>

    <!--GRAFICOS Y RESPORTES-->

    <script>
        // Esperar a que cargue el panel
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('graficoUsuarios');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar', // Tipo de gráfico: 'bar' (barras) o 'line' (línea)
                    data: {
                        // Pasamos los datos de PHP a JS usando json_encode
                        labels: <?php echo json_encode($meses); ?>,
                        datasets: [{
                            label: 'Nuevos Usuarios Registrados',
                            data: <?php echo json_encode($cantidades); ?>,
                            backgroundColor: '#66AC4C',
                            borderColor: '#4CAF50',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            }
        });
    </script>
    
    <script>

        //------------------Estadisticas------------------

        let miGraficoPasantia = null;

        document.addEventListener("DOMContentLoaded", function() {
            //calculamos al cargar la pagina
            setTimeout(recalcularEstadisticas, 500); 
        });

        function recalcularEstadisticas() {
            //obtenemos los datos
            const inputs = document.querySelectorAll('.input-dato');
            let datosBrutos = [];
            
            inputs.forEach(input => {
                let val = parseInt(input.value);
                if (!isNaN(val)) {
                    datosBrutos.push(val);
                }
            });

            // Ordenar datos para calcular la mediana
            datosBrutos.sort((a, b) => a - b);
            let n = datosBrutos.length;

            // genera la tabla de frecuencia
            let frecuencias = {};
            datosBrutos.forEach(x => {
                frecuencias[x] = (frecuencias[x] || 0) + 1;
            });

            // Convertir a array de objetos [{x:1, f:1}, {x:2, f:2}...]
            let tablaFrec = [];
            for (let x in frecuencias) {
                tablaFrec.push({ x: parseInt(x), f: frecuencias[x] });
            }
            tablaFrec.sort((a, b) => a.x - b.x);

            //CALCULOS
            
            //Media (Promedio)
            let suma = datosBrutos.reduce((a, b) => a + b, 0);
            let media = n > 0 ? (suma / n).toFixed(2) : 0;

            //Mediana (Posición Central)
            let mediana = 0;
            if (n > 0) {
                let mitad = Math.floor(n / 2);
                if (n % 2 === 0) {
                    mediana = (datosBrutos[mitad - 1] + datosBrutos[mitad]) / 2;
                } else {
                    mediana = datosBrutos[mitad];
                }
            }

            //Moda (Más repetido)
            let maxFrec = 0;
            tablaFrec.forEach(d => { if(d.f > maxFrec) maxFrec = d.f; });
            let modas = tablaFrec.filter(d => d.f === maxFrec).map(d => d.x);

            //ACTUALIZAR PANTALLA
            document.getElementById('val_media').innerText = media;
            document.getElementById('val_mediana').innerText = mediana;
            document.getElementById('val_moda').innerText = modas.join(', ');

            //DIBUJAR TABLA DE FRECUENCIAS HTML
            let tbody = document.getElementById('body_tabla_frecuencia');
            tbody.innerHTML = "";
            
            let Fa = 0; // Frecuencia Acumulada
            let Fra = 0; // Frecuencia Relativa Acumulada

            tablaFrec.forEach(row => {
                Fa += row.f;
                let Fr = (row.f / n) * 100;
                Fra += Fr;

                let tr = `<tr>
                    <td><strong>${row.x}</strong></td>
                    <td>${row.f}</td>
                    <td>${Fa}</td>
                    <td>${Fr.toFixed(0)}%</td>
                    <td>${Fra.toFixed(0)}%</td>
                </tr>`;
                tbody.innerHTML += tr;
            });
            
            // Fila de Total
            tbody.innerHTML += `<tr style="background:#eee; font-weight:bold;">
                <td>Total</td>
                <td>${n}</td>
                <td>-</td>
                <td>100%</td>
                <td>-</td>
            </tr>`;

            //ACTUALIZAR GRÁFICO
            actualizarGrafico(tablaFrec);
        }

        function actualizarGrafico(datosTabla) {
            const ctx = document.getElementById('graficoPasantia');
            if (!ctx) return;

            // Preparamos arrays para Chart.js
            let labels = datosTabla.map(d => d.x + (d.x === 1 ? ' Usuario' : ' Usuarios'));
            let data = datosTabla.map(d => d.f);

            if (miGraficoPasantia) {
                miGraficoPasantia.destroy(); // para crear el nuevo
            }

            miGraficoPasantia = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Cantidad de Oficinas',
                        data: data,
                        backgroundColor: '#66AC4C',
                        borderColor: '#4CAF50',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            ticks: { stepSize: 1 },
                            title: { display: true, text: 'Nº Oficinas' }
                        },
                        x: {
                            title: { display: true, text: 'Usuarios por Sistema' }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
            function exportarExcel() {    

            let tabla = document.createElement("table");
            
            // Cabecera
            let header = "<tr><th>Dato (X)</th><th>Frecuencia (f)</th><th>Fa</th><th>Fr%</th><th>Fra%</th></tr>";
            tabla.innerHTML = header;

            // Obtener datos actuales
            let rows = document.getElementById('body_tabla_frecuencia').querySelectorAll('tr');
            
            rows.forEach(row => {
                // Clonamos la fila
                tabla.innerHTML += row.outerHTML;
            });

            //Generar enlace de descarga
            let html = tabla.outerHTML.replace(/ /g, '%20');
            let downloadLink = document.createElement("a");
            document.body.appendChild(downloadLink);
            
            // Tipo de archivo
            downloadLink.href = 'data:application/vnd.ms-excel,' + html;
            downloadLink.download = 'Reporte_Estadistica_CVA.xls';
            
            // Clic automático
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }
        function imprimirReporte() {
            //escondemos todo temporalmente
            let sidebar = document.querySelector('.sidebar');
            let navbar = document.querySelector('header');
            
            // Guardamos estado actual
            let sidebarDisplay = sidebar ? sidebar.style.display : '';
            
            // Ocultamos lo que estorba
            if(sidebar) sidebar.style.display = 'none';
            
            // Imprimimos
            window.print();
            
            // Restauramos
            if(sidebar) sidebar.style.display = sidebarDisplay;
        }
    </script>
</body>
</html>