$(function() {

    let currentURL = window.location.href;
    /**
     * Evento para mostrar el formulario de crear un nuevo modulo
     */
    $(document).on("click", ".capturarLecturas", function(e) {

        e.preventDefault();
        let admigas_condominios_id = $("#admigas_condominios_id").val();

        $('.list-deptos').slideUp();

        let url = currentURL + '/captura-lecturas/' + admigas_condominios_id;

        $.get(url, function(data, textStatus, jqXHR) {
            $(".list-deptos-capture").html(data);
            $(".list-deptos-capture").slideDown();
        });
    });
    /**
     * Evento para saber si la lectura actual es menor a la anterior
     */
    $(document).on("change", ".nueva_lectura", function(e) {

        let numero = parseFloat($(this).data('posicion'));
        let lectura = parseFloat($(this).data("lectura_anterior"));
        let cantidad = $(this).val();

        let diferencia = (Math.floor((cantidad - lectura) * 1000)) / 1000;


        $(".diferencia_" + numero).html(diferencia);

        if (cantidad < lectura) {

            Swal.fire(
                'Tenemos un problema!',
                'La Lectura Actual es menor a la anterior.',
                'warning'
            )
            if (!lectura > 9500 && cantidad < 1000) {

                $(".mensaje" + numero).html("La lectura Actual es menor");
            }
        } else {

            $(".mensaje" + numero).html(" ");
        }
    });
    /**
     * Evento para cuando se pierda el foco del cursor
     * se iguale la lectura
     */
    $(document).on("blur", ".nueva_lectura", function(e) {

        let cantidad = parseFloat($(this).val());
        let lectura = parseFloat($(this).data("lectura_anterior"));

        if (isNaN(cantidad)) {
            $(this).val(lectura);
        };

    });
    /**
     * Evento para guardar el nuevo modulo
     */
    $(document).on('click', '.saveLecturas', function(event) {
        event.preventDefault();

        let fecha_lectura = $("#fecha_lectura").val();
        let admigas_condominios_id = $("#admigas_condominios_id").val();
        let data = $('#formLecturasCapture').serializeArray();

        let _token = $("input[name=_token]").val();
        let url = currentURL + '/captura-lecturas';

        if (fecha_lectura == null) {
            Swal.fire(
                'Error!',
                'Debe ingresar una Fecha de Lectura.',
                'error'
            )
        } else {
            $.post(url, {
                data: data,
                fecha_lectura: fecha_lectura,
                admigas_condominios_id: admigas_condominios_id,
                _token: _token
            }, function(data, textStatus, xhr) {

                $('.viewResult').html(data);

            }).done(function() {
                Swal.fire(
                    'Correcto!',
                    'Las lecturas sean guardado correctamente.',
                    'success'
                )
            }).fail(function(data) {
                printErrorMsg(data.responseJSON.errors);
            });
        }
    });








    /**
     * Evento para mostrar regresar a zonas
     */
    $(document).on('change', '#tipo', function(event) {

        if ($(this).val() == 1) {
            $(".tipo-punto-venta").slideUp();
        } else {
            $(".tipo-punto-venta").slideDown();
        }

    });
    /**
     * Funcion para mostrar los errores de los formularios
     */
    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $(".form-control").removeClass('is-invalid');
        for (var clave in msg) {
            $("#" + clave).addClass('is-invalid');
            if (msg.hasOwnProperty(clave)) {
                $(".print-error-msg").find("ul").append('<li>' + msg[clave][0] + '</li>');
            }
        }
    }
});