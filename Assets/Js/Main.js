document.addEventListener("DOMContentLoaded", function(){

    // ---CARRUSEL---
    const listaCarruseles = document.querySelectorAll('.carrusel');
    const prevBoton = document.querySelector('.carrusel-control.anterior');
    const nextBoton = document.querySelector('.carrusel-control.siguiente');

    if (listaCarruseles.length > 0) {
        let carruselActual = 0;

        // Función para cambiar la clase activa
        function mostrarCarrusel(indiceCarrusel){
            listaCarruseles.forEach(itemDelCarrusel => {
                itemDelCarrusel.classList.remove('activo');
            });
            listaCarruseles[indiceCarrusel].classList.add('activo');
        }

        function irSiguiente() {
            carruselActual++;
            if (carruselActual >= listaCarruseles.length) {
                carruselActual = 0;
            }
            mostrarCarrusel(carruselActual);
        }

        function irAnterior() {
            carruselActual--;
            if(carruselActual < 0) {
                carruselActual = listaCarruseles.length - 1;
            }
            mostrarCarrusel(carruselActual);
        }

        // Eventos de los botones
        if(prevBoton) {
            prevBoton.addEventListener('click', irAnterior);
        }

        if(nextBoton) {
            nextBoton.addEventListener('click', irSiguiente);
        }

        setInterval(irSiguiente, 7000); 
    }

    // ---AÑO, TOGGLE MENÚ Y SCROLL ---
    const yearSpan = document.getElementById('year');
    if(yearSpan) yearSpan.textContent = new Date().getFullYear();

    const navList = document.querySelector('.nav-list');
    const toggleMenu = document.querySelector('.nav-toggle'); 

    if(toggleMenu && navList){
        toggleMenu.addEventListener('click', function(){
            navList.classList.toggle('open');
        });
    }

    // Cerrar menú al hacer clic en un enlace
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e){
            if (navList && navList.classList.contains('open')) {
                navList.classList.remove('open');
            }
        });
    });

    // ---MODALES (LOGIN Y REGISTRO) ---
    const btnMostrarLogin = document.getElementById('btn-mostrar-login');
    const btnMostrarRegistro = document.getElementById('btn-mostrar-registro');
    const modalLogin = document.getElementById('modal-login');
    const modalRegistro = document.getElementById('modal-registro');
    const btnCerrar = document.querySelectorAll('.modal-cerrar');

    // Abrir Modales
    if (btnMostrarLogin) {
        btnMostrarLogin.addEventListener('click', (e) => {
            e.preventDefault();
            modalLogin.classList.add('visible');
        });
    }
    if (btnMostrarRegistro) {
        btnMostrarRegistro.addEventListener('click', (e) => {
            e.preventDefault();
            modalRegistro.classList.add('visible');
        });
    }

    // Cerrar Modales (Botón X)
    btnCerrar.forEach(btn => {
        btn.addEventListener('click', () => {
            if(modalLogin) modalLogin.classList.remove('visible');
            if(modalRegistro) modalRegistro.classList.remove('visible');
        });
    });

    // Cerrar Modales (Clic afuera)
    window.addEventListener('click', (e) => {
        if (e.target === modalLogin) modalLogin.classList.remove('visible');
        if (e.target === modalRegistro) modalRegistro.classList.remove('visible');
    });

    // ---VALIDACIÓN DE REGISTRO (CLIENTE) ---
    const formRegistro = document.getElementById('form-registro');
    
    if (formRegistro) {
        formRegistro.addEventListener('submit', (e) => {
            const pass = document.getElementById('reg-pass').value;
            const passConfirm = document.getElementById('reg-pass-confirmar').value;

            if (pass !== passConfirm) {
                e.preventDefault(); // Detenemos el envío a PHP
                
                // Usamos SweetAlert para el error de contraseña
                Swal.fire({
                    title: "Error",
                    text: "Las contraseñas no coinciden.",
                    icon: "error",
                    confirmButtonColor: '#66AC4C'
                });
            }
            // Si coinciden, dejamos pasar al PHP
        });
    }

    // ---INDICADOR DE SECCIÓN ACTIVA (SCROLL SPY) ---
    const secciones = document.querySelectorAll('section[id], footer[id]');
    const navLinks = document.querySelectorAll('.nav-list li a');

    function actualizarMenuActivo() {
        let scrollY = window.pageYOffset;
        let seccionActual = "";

        secciones.forEach(seccion => {
            const seccionTop = seccion.offsetTop - 150; 
            if (scrollY >= seccionTop) {
                seccionActual = seccion.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('link-activo');
            if (link.getAttribute('href').includes(seccionActual) && seccionActual !== "") {
                link.classList.add('link-activo');
            }
        });
    }
    window.addEventListener('scroll', actualizarMenuActivo);

    //MENÚ DE PERFIL (DROPDOWN)
    // Esta función la llamamos desde el HTML onclick="toggleProfileMenu()"
    const avatarBtn = document.querySelector('.profile-avatar');
    const dropdown = document.getElementById('profileDropdown');

    if (avatarBtn && dropdown) {
        // Al hacer clic en la foto
        avatarBtn.addEventListener('click', (e) => {
            e.stopPropagation(); // Evita que el clic llegue al document y lo cierre inmediatamente
            dropdown.classList.toggle('active');
        });

        // Cerrar si hago clic fuera
        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target) && !avatarBtn.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });
    }

});