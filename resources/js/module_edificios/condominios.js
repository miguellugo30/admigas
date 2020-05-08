$(function() {

    let currentURL = window.location.href;
    /**
     * Evento para mostrar el formulario de crear un nuevo modulo
     */
    $(document).on("click", ".newEdificio", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Nuevo Edificio');
        $('#action').removeClass('updateEdificio');
        $('#action').addClass('saveEdificio');

        let admigas_unidades_id = $("#admigas_unidades_id").val();


        let url = currentURL + '/condominios-create/' + admigas_unidades_id;

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal-edificios').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para guardar el nuevo modulo
     */
    $(document).on('click', '.saveEdificio', function(event) {
        event.preventDefault();

        let tipo = $("#tipo").val();
        let nombre = $("#nombre").val();
        let descuento = $("#descuento").val();
        let factor = $("#factor").val();
        let gasto_admin = $("#gasto_admin").val();
        let fecha_lectura = $("#fecha_lectura").val();
        let admigas_unidades_id = $("#admigas_unidades_id").val();

        let tanques = $('[name="tanques[]"]:checked').map(function() {
            return this.value;
        }).get();

        let _token = $("input[name=_token]").val();
        let url = currentURL + '/condominios';

        if (tanques.length == 0) {
            Swal.fire(
                'Error!',
                'Debe vincular por lo menos un tanque al edificio.',
                'error'
            )
        } else {
            $.post(url, {
                tipo: tipo,
                nombre: nombre,
                descuento: descuento,
                factor: factor,
                gasto_admin: gasto_admin,
                fecha_lectura: fecha_lectura,
                tanques: tanques,
                admigas_unidades_id: admigas_unidades_id,
                _token: _token
            }, function(data, textStatus, xhr) {
                $('.sidebar').html(data);
            }).done(function() {
                $('.modal-backdrop ').css('display', 'none');
                $('#modal-edificios').modal('hide');
                Swal.fire(
                    'Correcto!',
                    'El registro ha sido guardado.',
                    'success'
                )
            }).fail(function(data) {
                printErrorMsg(data.responseJSON.errors);
            });
        }

    });
    /**
     * Evento para mostrar el una registro
     */
    $(document).on('click', '.viewEdificio', function(event) {
        event.preventDefault();
        let id = $(this).attr("id");

        let url = currentURL + "/condominios/" + id;

        $.ajax({
            url: url,
            type: 'GET',
            success: function(result) {
                $('.viewResult').html(result);
                $('#table-departamentos').DataTable({
                    "responsive": true,
                    "autoWidth": false,
                });
            }
        });

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
     * Eliminamos las clases agregadas dinamicamente
     */
    $("#modal-edificios").on("hide.bs.modal", function() {
        $('#action').removeClass('updateEdificio');
        $('#action').removeClass('saveEdificio');
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