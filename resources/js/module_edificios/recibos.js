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
    /**
     * Evento para generar recibos
     */
    $(document).on('click', '.generateRecibos', function(event) {
        event.preventDefault();

        let admigas_condominios_id = $("#admigas_condominios_id").val();
        let fecha_recibo = $("#fecha_recibo").val();

        let _token = $("input[name=_token]").val();
        let url = currentURL + '/recibos';

        if (fecha_recibo == "") {
            Swal.fire(
                'Tenemos un problema!',
                'No se ha seleccionado una fecha de recibo.',
                'error'
            )
        } else {
            $.post(url, {
                admigas_condominios_id: admigas_condominios_id,
                fecha_recibo: fecha_recibo,
                _token: _token
            }, function(data, textStatus, xhr) {

                $('.viewResult').html(data);
                $('#table-departamentos').DataTable({
                    "responsive": true,
                    "autoWidth": false,
                });

            }).done(function() {
                Swal.fire(
                    'Correcto!',
                    'Se ha generado correctamente los recibos.',
                    'success'
                )
            }).fail(function(data) {
                printErrorMsg(data.responseJSON.errors);
            });
        }
    });
});