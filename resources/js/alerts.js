import Swal from 'sweetalert2';

const successful = Swal.mixin({
    title: '¡Logrado!',
    icon: 'success',
    confirmButtonText: 'Genial',
    confirmButtonColor: '#3085d6',
});

const mistake = Swal.mixin({
    title: 'Hubo un problema',
    icon: 'error',
    confirmButtonColor: '#d33',
});

// Lo exponemos globalmente
window.successful   = successful;
window.mistake      = mistake;
window.Swal         = Swal;