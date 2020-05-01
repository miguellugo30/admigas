$(function() {

    let currentURL = window.location.href;
    /**
     * Evento para mostrar el formulario de crear un nuevo modulo
     */
    $(document).on("click", ".newTanque", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Nuevo Tanque');
        $('#action').removeClass('updateTanque');
        $('#action').addClass('saveTanque');

        let url = currentURL + '/tanques/create';

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal-edificios').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para guardar el nuevo modulo
     */
    $(document).on('click', '.saveTanque', function(event) {
        event.preventDefault();

        let num_serie = $("#num_serie").val();
        let marca = $("#marca").val();
        let estado_al_recibir = $("#estado_al_recibir").val();
        let capacidad = $("#capacidad").val();
        let inventario = $("#inventario").val();
        let admigas_unidades_id = $("#admigas_unidades_id").val();


        let _token = $("input[name=_token]").val();
        let url = currentURL + '/tanques';

        $.post(url, {
            num_serie: num_serie,
            marca: marca,
            estado_al_recibir: estado_al_recibir,
            capacidad: capacidad,
            inventario: inventario,
            admigas_unidades_id: admigas_unidades_id,
            _token: _token
        }, function(data, textStatus, xhr) {

            //$('.sidebar').html(data);

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
    });
    /**
     * Evento para mostrar el una registro
     */
    $(document).on('click', '.viewTanque', function(event) {
        event.preventDefault();
        let id = $(this).attr("id");
        let _token = $("input[name=_token]").val();

        let url = currentURL + "/tanques/" + id;

        $.ajax({
            url: url,
            type: 'GET',
            success: function(result) {
                $('.sidebar').html(result);
            }
        });

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