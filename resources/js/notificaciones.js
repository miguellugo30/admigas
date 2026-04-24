$(function() {

    let currentURL = window.location.href;
    url = currentURL.replace('edificios', '');
    url = url.replace('credito-cobranza', '');
    url = url.replace('reportes', '');
    url = url.replace('configuracion', '');

    $.get(url + 'notificaciones', function(data, textStatus, jqXHR) {
        $(".totalNotificaciones").text( data.total );
    });

    $(document).on("click", ".notificaciones", function(e) {

        e.preventDefault();
        $.get(url+ 'notificaciones/1', function(data, textStatus, jqXHR) {
            $(".viewResult").html(data);
            $("#table-notificaciones").DataTable({
                languaje:{
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
                }
            });
        });
    });

    $(document).on("click", ".readNotification", function(e) {

        e.preventDefault();
        let depto_id = $(this).data( 'depto_id' );
        let notification_id = $(this).data( 'notification_id' );
        let type = $(this).data( 'type' );

        if ( type.includes('FechaVencida') ) {
            $.get(url+ 'notificaciones/'+depto_id+'/edit', function(data, textStatus, jqXHR) {

                if ( !data.validar ) {
                    Swal.fire({
                        title: '¿Espera?',
                        text: "Deseas agregar un cargo por Pago Extemporáneo al departamento!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, agregar cargo!',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.value) {
                            envio( notification_id, 1, depto_id );
                        } else {
                            envio( notification_id, 0, depto_id );
                        }
                    })
                } else {
                    console.log('ya tiene un cargo, se marca como leida solamente');
                    envio( notification_id, 0, depto_id );
                }

            });

        } else {
            envio( notification_id, 0, depto_id );
        }

        /*
        */
    });

    function envio(notification_id, cargo, depto_id) {

        let _token = $("input[name=_token]").val();

        $.post(url+ 'notificaciones/'+depto_id, {
            notification_id: notification_id,
            cargo: cargo,
            depto_id: depto_id,
            _method: 'PUT',
            _token: _token
        }, function(data, textStatus, xhr) {
            $.get(url + 'notificaciones', function(data, textStatus, jqXHR) {
                $(".totalNotificaciones").text( data.total );
            });


            $('.viewResult').html(data);

            $("#table-notificaciones").DataTable({
                languaje:{
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
                }
            });
        }).done(function() {
            Swal.fire(
                'Correcto!',
                'Se ha marcado como leido la notificacion.',
                'success'
            )
        });
    }

});
