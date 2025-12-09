
//Cambio de los paneles

function mostrarPanel(idPanel) {
    //Ocultar TODOS los paneles primero
    const paneles = document.querySelectorAll('.panel');
    paneles.forEach(panel => {
        //style.display = 'none' para ocultarlos
        panel.style.display = 'none';
        // También quitamos la clase 'active' por si acaso
        panel.classList.remove('active');
    });

    //Quitar la clase 'active' de todos los botones
    const links = document.querySelectorAll('.sidebar-nav a');
    links.forEach(link => {
        link.classList.remove('active');
    });

    //Mostrar SOLO el panel que pidió el usuario
    const panelSeleccionado = document.getElementById('panel-' + idPanel);
    
    if (panelSeleccionado) {
        // Lo mostramos
        panelSeleccionado.style.display = 'block';
        panelSeleccionado.classList.add('active');
    } else {
        console.error('Error: No se encontró el panel con ID: panel-' + idPanel);
    }

    //Resaltar el botón que presionó
    // Buscamos el elemento que disparó el evento
    const evento = window.event;
    if (evento && evento.currentTarget) {
       evento.currentTarget.classList.add('active');
    } else if (evento && evento.target) {
        let target = evento.target;
        // Subimos hasta encontrar la etiqueta A
        while (target && target.tagName !== 'A') {
            target = target.parentElement;
        }
        if (target) {
            target.classList.add('active');
        }
    }
}

//(Si lo necesitamos en el futuro)
const modalAsignar = document.getElementById('modal-asignar');
const userLabel = document.getElementById('user-to-approve');

function abrirModalAprobar(nombreUsuario) {
    if(userLabel) userLabel.textContent = nombreUsuario;
    if(modalAsignar) modalAsignar.classList.add('visible'); 
}

function cerrarModalAprobar() {
    if(modalAsignar) modalAsignar.classList.remove('visible');
}

// Simulacion de Guardar Configuración (CMS)
function guardarConfiguracion() {
    // Aquí podrías agregar lógica AJAX para guardar sin recargar
    alert('Configuración Guardada. Los usuarios verán el nuevo color.');
}

// Función Global confirmar
function confirmarAccion(urlRedireccion, titulo = '¿Estás seguro?', texto = 'No podrás revertir esto.') {
    Swal.fire({
        title: titulo,
        text: texto,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',   // Rojo peligro
        cancelButtonColor: '#3085d6', // Azul cancelar
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si dice que SÍ, redirigimos a la URL que nos pasaron
            window.location.href = urlRedireccion;
        }
    });
}