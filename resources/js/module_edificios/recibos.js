$(function() {

    let currentURL = window.location.href;
    /**
     * Evento para mostrar el formulario de crear un nuevos recibos
     */
    $(document).on("click", ".generarRecibos", function(e) {

        e.preventDefault();
        let admigas_condominios_id = $("#admigas_condominios_id").val();

        $('.list-deptos').slideUp();

        let url = currentURL + '/generar-recibos/' + admigas_condominios_id;

        $.get(url, function(data, textStatus, jqXHR) {
            $(".list-deptos-capture").html(data);
            $(".list-deptos-capture").slideDown();
        });
    });
});