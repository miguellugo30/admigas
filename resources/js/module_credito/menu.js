$(function() {

    let currentURL = window.location.href;
    /**
     * Evento para el menu de sub categorias y mostrar la vista
     */
    $(document).on("click", ".menu", function(e) {
        e.preventDefault();
        let id = $(this).attr("id");

        if (id == '11') {
            url = currentURL + '/pagos-portal';
            table = ' #table-usuarios';
        } else if (id == '12') {
            url = currentURL + '/conciliacion';
            table = ' #table-precio-gas';
        } else if (id == '13') {
            url = currentURL + '/pagos-conciliados';
            table = ' #table-precio-gas';
        } else if (id == '14') {
            url = currentURL + '/pagos-no-conciliados';
            table = ' #table-precio-gas'
        } else if (id == '19') {
            url = currentURL + '/conciliacion-manual';
            table = ' #table-precio-gas';
        }else if (id == '22') {
            url = currentURL + '/pagos-manual';
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
