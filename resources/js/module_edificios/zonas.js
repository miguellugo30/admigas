$(function() {

    let currentURL = window.location.href;

    $.get(currentURL + '/zonas', function(data, textStatus, jqXHR) {
        $('.sidebar').html(data);
    });
    /**
     * Evento para mostrar el formulario de crear un nuevo modulo
     */
    $(document).on("click", ".newZona", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Nuevo Zona');
        $('#action').removeClass('updateZona');
        $('#action').addClass('saveZona');

        let url = currentURL + '/zonas/create';

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal-edificios').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para guardar el nuevo modulo
     */
    $(document).on('click', '.saveZona', function(event) {
        event.preventDefault();

        let nombre = $("#nombre").val();
        let descripcion = $("#descripcion").val();

        let _token = $("input[name=_token]").val();
        let url = currentURL + '/zonas';

        $.post(url, {
            nombre: nombre,
            descripcion: descripcion,
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
     * Evento para mostrar el una registro
     */
    $(document).on('click', '.viewZonas', function(event) {
        event.preventDefault();
        let id = $(this).attr("id");
        let url = currentURL + "/zonas/" + id;

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
    $(document).on('click', '.returnZona', function(event) {
        event.preventDefault();
        let url = currentURL + "/zonas";

        $.ajax({
            url: url,
            type: 'GET',
            success: function(result) {
                $('.sidebar').html(result);
            }
        });
    });







    /**
     * Evento para mostrar el formulario de edicion de un canal
     */
    $(document).on("click", ".editZona", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Editar Zona');
        $('#action').removeClass('saveZona');
        $('#action').addClass('updateZona');

        let id = $("#idSeleccionado").val();

        let url = currentURL + "/zonas/" + id + "/edit";

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para editar el modulo
     */
    $(document).on('click', '.updateZona', function(event) {
        event.preventDefault();

        let nombre = $("#nombre").val();
        let descripcion = $("#descripcion").val();
        let id = $("#idSeleccionado").val();

        let _token = $("input[name=_token]").val();
        let _method = "PUT";
        let url = currentURL + '/zonas/' + id;

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                nombre: nombre,
                descripcion: descripcion,
                _token: _token,
                _method: _method
            },
            success: function(result) {
                $('.sidebar').html(result);
            }
        }).done(function(data) {
            $('.modal-backdrop ').css('display', 'none');
            $('#modal').modal('hide');
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
     * Evento para eliminar el modulo
     */
    $(document).on('click', '.deleteZona', function(event) {
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
                let id = $("#idSeleccionado").val();
                let _token = $("input[name=_token]").val();
                let _method = "DELETE";
                let url = currentURL + '/zonas/' + id;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: _token,
                        _method: _method
                    },
                    success: function(result) {
                        $('.viewResult').html(result);
                        $('.viewCreate').slideUp();
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
     * Evento para mostrar los permisos por menu
     */
    $(document).on('click', '.modulo', function() {
        var id = $(this).data("value");
        if ($(this).prop('checked')) {
            $("#sub_cat_" + id).slideDown();
        } else {
            $("#sub_cat_" + id).slideUp();
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