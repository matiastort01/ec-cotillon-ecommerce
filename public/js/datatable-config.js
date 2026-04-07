$(document).ready(function() {
    $('#categoriasTable').DataTable({
        "processing": true,
        "serverSide": true,  // Usado cuando se hace con AJAX
        "ajax": {
            "url": "{{ route('admin.categorias.data') }}",  // Aquí iría la URL que devuelve los datos en formato JSON
            "type": "GET"
        },
        "language": {
            "url": 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/Spanish.json'
        }
    });
});