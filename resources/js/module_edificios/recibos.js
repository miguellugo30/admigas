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
    /**
     * Evento para imprimir los recibos
     */
    $(document).on("click", ".sendRecibos", function(e) {

        e.preventDefault();
        let admigas_condominios_id = $("#admigas_condominios_id").val();

       let url = currentURL + '/enviar-recibos/' + admigas_condominios_id;

        $.get(url, function(data, textStatus, jqXHR) {
            //$(".list-deptos-capture").html(data);
            //$(".list-deptos-capture").slideDown();
        });

    });
    /**
     * Evento para enviar los recibos
     */
    $(document).on("click", ".printRecibos", function(e) {

        e.preventDefault();
        let admigas_condominios_id = $("#admigas_condominios_id").val();

        let url = currentURL + '/recibos/' + admigas_condominios_id;

        window.open(url, '_blank');
        return false;

    });
    /**
     * Evento para cancelar todos los recibos
     */
    $(document).on("click", ".cancelAllRecibos", function(e) {

        e.preventDefault();

        Swal.fire({
            title: '¿Estas seguro?',
            text: "Deseas eliminar los últimos recibos generados, esta acción es irreversible!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, deseo eliminarlos!',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if (result.value) {

                Swal.fire({
                    title: 'Motivo de cancelación',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Cancelar Recibos',
                    showLoaderOnConfirm: true,
                }).then((result) => {

                    let admigas_condominios_id = $("#admigas_condominios_id").val();

                    let url = currentURL + '/recibos/' + admigas_condominios_id;
                    let _method = "DELETE";
                    let _token = $("input[name=_token]").val();

                    $.post(url, {
                        cancel: 1,
                        motivo_cancelacion: result.value,
                        _method: _method,
                        _token: _token
                    }, function(data, textStatus, xhr) {

                        $(".list-deptos-capture").html(data);
                        $(".list-deptos-capture").slideDown();

                    }).done(function() {
                        Swal.fire(
                            'Eliminado!',
                            'Se ha eliminado correctamente los recibos.',
                            'success'
                        )
                    }).fail(function(data) {
                        printErrorMsg(data.responseJSON.errors);
                    });

                })
            }
        })
    });
    /**
     * Evento para mostrar el boton de cancelar
     */
    $(document).on("click", ".cancelOneRecibo", function(e) {
        e.preventDefault();
        $('.reciboCancel').css('display', 'block');
    });
    /**
     * Evento para cancelar un solo recibo
     */
    $(document).on("click", ".reciboCancelOne", function(e) {
        e.preventDefault();
        let departamento_id = $(this).data('id-depto');

        Swal.fire({
            title: '¿Estas seguro?',
            text: "Deseas eliminar el recibo seleccionado, esta acción te permitirá crear un nuevo recibo con la información corregida!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, deseo eliminarlo!',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if (result.value) {
                Swal.fire({
                    title: 'Motivo de cancelación',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Cancelar Recibos',
                    showLoaderOnConfirm: true,
                }).then((result) => {

                })
            }
        })
    });

});
