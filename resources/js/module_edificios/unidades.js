$(function() {

    let currentURL = window.location.href;
    /**
     * Evento para mostrar el formulario de crear un nuevo modulo
     */
    $(document).on("click", ".newUnidad", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Nuevo Unidad');
        $('#action').removeClass('updateUnidad');
        $('#action').addClass('saveUnidad');

        let url = currentURL + '/unidades/create';

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal-edificios').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para guardar el nuevo modulo
     */
    $(document).on('click', '.saveUnidad', function(event) {
        event.preventDefault();

        let nombre = $("#nombre").val();
        let calle = $("#calle").val();
        let numero = $("#numero").val();
        let colonia = $("#colonia").val();
        let municipio = $("#municipio").val();
        let cp = $("#cp").val();
        let estado = $("#estado").val();
        let entre_calles = $("#entre_calles").val();
        let admigas_zonas_id = $("#admigas_zonas_id").val();

        let _token = $("input[name=_token]").val();
        let url = currentURL + '/unidades';

        $.post(url, {
            nombre: nombre,
            calle: calle,
            numero: numero,
            colonia: colonia,
            municipio: municipio,
            cp: cp,
            estado: estado,
            entre_calles: entre_calles,
            admigas_zonas_id: admigas_zonas_id,
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
    });
    /**
     * Evento para mostrar un registro
     */
    $(document).on('click', '.viewUnidad', function(event) {
        event.preventDefault();
        let id = $(this).attr("id");
        let _token = $("input[name=_token]").val();

        let url = currentURL + "/unidades/" + id;

        $.ajax({
            url: url,
            type: 'GET',
            success: function(result) {
                $('.sidebar').html(result);
            }
        });

    });
    /**
     * Evento para mostrar regresar a zonas
     */
    $(document).on('click', '.returnUnidad', function(event) {
        event.preventDefault();
        let admigas_zonas_id = $("#admigas_zonas_id").val();
        let url = currentURL + "/zonas-unidades/" + admigas_zonas_id;

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