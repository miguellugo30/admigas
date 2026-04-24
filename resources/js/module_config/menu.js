$(function() {

    let currentURL = window.location.href;
    /**
     * Evento para el menu de sub categorias y mostrar la vista
     */
    $(document).on("click", ".menu", function(e) {
        e.preventDefault();
        let id = $(this).attr("id");

        if (id == '1') {
            url = currentURL + '/usuarios';
            table = ' #table-usuarios';
        } else if (id == '2') {
            url = currentURL + '/precio-gas';
            table = ' #table-precio-gas';
        } else if (id == '3') {
            url = currentURL + '/servicios';
            table = ' #table-servicios';
        } else if (id == '4') {
            url = currentURL + '/mensajes';
            table = ' #table-mensajes';
        } else if (id == '5') {
            url = currentURL + '/menus';
            table = ' #table-menus';
        } else if (id == '6') {
            url = currentURL + '/empresas';
            table = ' #table-empresas';
        } else if (id == '7') {
            url = currentURL + '/lecturistas';
            table = ' #table-lecturistas';
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
