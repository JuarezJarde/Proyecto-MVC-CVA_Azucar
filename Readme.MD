# Sistema Web de Gestión "CVA Azúcar" (Versión MVC)

Este proyecto es una aplicación web dinámica desarrollada bajo la arquitectura Modelo-Vista-Controlador (MVC) para la empresa CVA Azúcar

El sistema ha evolucionado de una maqueta estática (SPA) a una funcional que permite la gestión de usuarios, control de inventario, publicación de servicios, auditoría de seguridad y generación de reportes estadísticos, conectada a una base de datos en MySQL.

---

## ⚠️ Nota Importante sobre la Ejecución

Este proyecto **NO puede ejecutarse directamente desde GitHub** ni visualizarse mediante GitHub Pages.

Al ser un sistema desarrollado con **PHP** y **MySQL**, requiere un entorno de servidor local (como XAMPP, WAMP, MAMP o Docker) para procesar el código del lado del servidor y conectar con la base de datos.

---

## Cómo Ejecutar el Proyecto

**Sigue estos pasos para ejecutar el proyecto en un entorno local (XAMPP):**

1. Archivos:

- Descarga en archivo .zip llendo a "Code" y Luego a Download ZIP
- Descomprime el archivo y Copia la carpeta del proyecto dentro de la carpeta "htdocs" (en XAMPP).

2.  Base de Datos:

- Abre phpMyAdmin.
- Crea una base de datos llamada "cva_azucar_db"
- Importa el archivo SQL ubicado en "db/cva_azucar_db.sql"

3.  Ejecucion:

- Abre tu navegador y ve a: "http://localhost/Proyecto-MVC/"
- Usuario Maestro:
  Correo: "super@gmail.com"
  Contraseña: "123456"

---

## Características Implementadas

- **1.Modulo Publico (fronted)**
  La cara visible para los visitantes, totalmente dinámica y configurable desde el panel administrativo.

- Diseño Responsivo: Adaptable a móviles y escritorio.

- Servicios Dinámicos: Las tarjetas de servicios se cargan directamente desde la base de datos (título,descripción e imagen).

- Personalización (CMS): El color principal de la marca, el título de la web y los datos de contacto (teléfono, correo) se pueden cambiar desde el panel sin tocar código.

- **2.Modulo de Seguridad y Usuaris**
- Login seguro con contraseñas encriptadas(password_hash) validacion de minimo 8 letras y almenos 1 numero(se puden desactivar estas validaciones para trabajar mejor cambiando el parametro de las validaciones en "controladores/resgistro.php").
- Roles de Usuarios.
  -Super Usuario: Acceso total.
  -Administrador: Gestión de inventario, servicios y usuarios.
  -Usuario: consulta basica.
- Lista de espera: los nuevos usuarios entran en una lista de espera para ser aceptados por un administrador o super usuario.
- Gestion de Estatus(activo o innactivo).

- **3. Panel Administrativo (Dashboard)**
  Un centro de control con las siguientes funcionalidades:

- Estadísticas en Tiempo Real: Tarjetas con conteo de usuarios, solicitudes e inventario.

- Gestión de Inventario: CRUD (Crear, Leer, Actualizar, Borrar) de productos, control de stock y unidades de medida.

- Gestión de Servicios: Subida de imágenes al servidor y publicación de nuevos servicios en la web principal.

- Reportes y Gráficos:

Gráficos interactivos con Chart.js (Usuarios por mes, Distribución de datos).

Informe de Pasantía Integrado: Módulo interactivo donde se calculan automáticamente la Media, Mediana y Moda de los datos recolectados.

Exportación: Generación de reportes en PDF (usando FPDF) y Excel (JS).

- Configuración: Panel para cambiar la identidad visual (colores y textos) del sitio.

- Auditoría del Sistema (Logs): Registro histórico de seguridad que guarda fecha, usuario, acción (Login, Eliminar, Crear) e IP del cliente.

---

### Tecnologias Implementadas

- **Backend & Base de Datos:**

- PHP 8: Leguaje Principal.
- Mysql: Base de Datos.
- Arquitectura MVC: Separación lógica de Modelos (DB), Vistas (UI) y Controladores (Lógica).

- **Fronted**

- HTML5 y CSS: Visual de todo
- JavaScript(vanilla. sin Frameworks :C):logica del cliente y calculos estadisticos

- **Librerias Usadas**

- SweetAlert2: Para alertas y notificaciones modernas.
- Chart.js: Para la generación de gráficos estadísticos interactivos.
- FPDF: Para la generación de reportes PDF dinámicos desde PHP.

---

### Diseño y UI

- **Diseño Responsivo (Mobile-First):** Totalmente adaptable a móviles, tablets y escritorio.
- **Header Fijo:** La barra de navegación se mantiene visible al hacer scroll.
- **Carrusel de Banners:** Sección "Hero" con un carrusel de 3 imágenes con transición de desvanecido (fade).
- **Componentes reutilizables:** Estilos consistentes para botones, tarjetas y modales.

---

### Secciones de la Página

- **Inicio:** Carrusel de bienvenida y llamado a la acción.
- **Servicios:**
  - Tarjetas de servicios ("Materia Prima", "Producto", "Procesos") con imágenes.
- **Nosotros:**
  - Sección de "Misión y Visión" (incorporada en "Contacto").
  - Grid responsivo con las tarjetas de los 4 miembros del equipo.
- **Diagrama**
  - Inclusión del **Diagrama de Funcionamiento (SVG)** del sistema.
- **Mision y Vision**
- **Contacto:** Formulario de contacto estático.
- **Footer:** Pie de página con información de copyright y año dinámico.

---

## Autores

Este sistema fue diseñado como proyecto de pasantías para el Instituto Universitario Jesús Obrero (IUJO) por:

- **Jardeivis Juarez**
- **Emmanuel Oropeza**
- **María Duin**
- **Eduardo Vargas**
