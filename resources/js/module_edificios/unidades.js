$(function() {

    let currentURL = window.location.href;
    /**
     * Evento para mostrar el formulario de crear un nuevo modulo
     */
    $(document).on("click", ".newUnidad", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Nueva Unidad');
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
            $("#modal-body").html('');
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
        let url = currentURL + "/unidades/" + id;

        $.ajax({
            url: url,
            type: 'GET',
            success: function(result) {
                $('.sidebar').html(result);
            }
        });

        let urlb = currentURL + "/unidades-breadcrumb/" + id;

        $.ajax({
            url: urlb,
            type: 'GET',
            success: function(result) {
                $('.breadcrumb').html(result);
            }
        });

        let urlc = currentURL + "/tanques/" + id;

        $.ajax({
            url: urlc,
            type: 'GET',
            success: function(result) {
                $('.viewResult').html(result);
            }
        });

    });
    /**
     * Evento para mostrar regresar a zonas
     */
    $(document).on('click', '.returnUnidad', function(event) {
        event.preventDefault();
        $('.viewResult').html("");
        let admigas_zonas_id = $("#admigas_zonas_id").val();
        let url = currentURL + "/zonas-unidades/" + admigas_zonas_id;

        $.ajax({
            url: url,
            type: 'GET',
            success: function(result) {
                $('.sidebar').html(result);
            }
        });

        /**
         * Mostrar el breacrumd
         */
        let urlb = currentURL + "/zonas-breadcrumb/" + admigas_zonas_id;

        $.ajax({
            url: urlb,
            type: 'GET',
            success: function(result) {
                $('.breadcrumb').html(result);
            }
        });
    });
    /**
     * Eliminamos las clases agregadas dinamicamente
     */
    $("#modal-edificios").on("hide.bs.modal", function() {
        $('#action').removeClass('updateUnidad');
        $('#action').removeClass('saveUnidad');
    });
    /**
     * Evento para mostrar el formulario de edicion
     */
    $(document).on("click", ".editUnidad", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Editar Unidad');
        $('#action').removeClass('saveUnidad');
        $('#action').addClass('updateUnidad');

        let id = $('.unidad').data('unidad-id');

        let url = currentURL + "/unidades/" + id + "/edit";

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal-edificios').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para editar el modulo
     */
    $(document).on('click', '.updateUnidad', function(event) {
        event.preventDefault();

        let nombre = $("#nombre").val();
        let calle = $("#calle").val();
        let numero = $("#numero").val();
        let colonia = $("#colonia").val();
        let municipio = $("#municipio").val();
        let cp = $("#cp").val();
        let estado = $("#estado").val();
        let entre_calles = $("#entre_calles").val();
        let id = $("#unidad_id").val();

        let _token = $("input[name=_token]").val();
        let _method = "PUT";
        let url = currentURL + '/unidades/' + id;

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                nombre: nombre,
                calle: calle,
                numero: numero,
                colonia: colonia,
                municipio: municipio,
                cp: cp,
                estado: estado,
                entre_calles: entre_calles,
                _token: _token,
                _method: _method
            },
            success: function(result) {
                $('.breadcrumb').html(result);
            }
        }).done(function(data) {
            $("#modal-body").html('');
            $('.modal-backdrop ').css('display', 'none');
            $('#modal-edificios').modal('hide');
            Swal.fire(
                'Correcto!',
                'El registro ha sido actualizado.',
                'success'
            )
        }).fail(function(data) {
            printErrorMsg(data.responseJSON.errors);
        });
    });
    /**
     * Evento para eliminar un registro
     */
    $(document).on('click', '.deleteUnidad', function(event) {
        event.preventDefault();
        Swal.fire({
            title: '¿Estas seguro?',
            text: "Deseas eliminar el registro seleccionado!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                let id = $('.unidad').data('unidad-id');

                let _token = $("input[name=_token]").val();
                let _method = "DELETE";
                let url = currentURL + '/unidades/' + id;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: _token,
                        _method: _method
                    },
                    success: function(result) {

                        let id = $('.returnUnidad').data('zona-id');
                        let url = currentURL + "/zonas/" + id;

                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function(result) {
                                $('.sidebar').html(result);
                            }
                        });
                        /**
                         * Mostrar el breacrumd
                         */
                        let urlb = currentURL + "/zonas-breadcrumb/" + id;

                        $.ajax({
                            url: urlb,
                            type: 'GET',
                            success: function(result) {
                                $('.breadcrumb').html(result);
                            }
                        });


                        Swal.fire(
                            'Eliminado!',
                            'El registro ha sido eliminado.',
                            'success'
                        )
                    }
                });
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
