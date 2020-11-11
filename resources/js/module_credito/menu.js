$(function() {

    let currentURL = window.location.href;
    /**
     * Evento para el menu de sub categorias y mostrar la vista
     */
    $(document).on("click", ".menu", function(e) {
        e.preventDefault();
        let id = $(this).attr("id");

        if (id == '8') {
            url = currentURL + '/pagos-portal';
            table = ' #table-usuarios';
        } else if (id == '9') {
            url = currentURL + '/conciliacion';
            table = ' #table-precio-gas';
        }

        $.get(url, function(data, textStatus, jqXHR) {
            $(".viewResult").html(data);
            /*
            $('.viewResult' + table).DataTable({
                "lengthChange": true
            });
            */
        });
    });
});
