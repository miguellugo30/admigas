$(function() {

    let currentURL = window.location.href;
    /**
     * Evento para el menu de sub categorias y mostrar la vista
     */
    $(document).on("click", ".menu", function(e) {
        e.preventDefault();
        let id = $(this).attr("id");
        console.log(id)
        if (id == '15') {
            url = currentURL + '/saldos';
            table = ' #table-saldos';
        } else if (id == '16') {
            url = currentURL + '/antiguedad';
            table = ' #table-antiguedad';
        } else if (id == '17') {
            url = currentURL + '/estado-cuenta';
            table = ' #table-estado-cuenta';
        } else if (id == '18') {
            url = currentURL + '/cargos-adicionales';
            table = ' #table-cargos-adicionales';
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
