$(function() {

    let currentURL = window.location.href;
    /**
     * Evento para el menu de sub categorias y mostrar la vista
     */
    $(document).on("click", ".menu", function(e) {
        e.preventDefault();
        let id = $(this).attr("id");

        if (id == '15') {
            url = currentURL + '/saldos';
            table = ' #table-usuarios';
        } else if (id == '16') {
            url = currentURL + '/antiguedad';
            table = ' #table-precio-gas';
        } else if (id == '17') {
            url = currentURL + '/estado-cuenta';
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
