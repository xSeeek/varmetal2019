window.onload = function formatTable()
{
    var table = $('#tablaAdministracion').DataTable({
        "language":{
            "url":"//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "scrollX": true,
   });
   $(function () {
       $('[data-toggle="tooltip"]').tooltip();
   });
}
