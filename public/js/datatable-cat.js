$(document).ready(function() {
    $('#categoriasTable').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json'
        },

        pageLength: 10,
        responsive: true,
    });
});

