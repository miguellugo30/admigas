$(function() {

    let currentURL = window.location.href;
    /**
     * Evento para mostrar el formulario de crear un nuevo modulo
     */
    $(document).on("click", ".newLecturista", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Nuevo Lecturista');
        $('#action').removeClass('updateLecturista');
        $('#action').addClass('saveLecturista');

        let url = currentURL + '/lecturistas/create';

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para guardar el nuevo modulo
     */
    $(document).on('click', '.saveLecturista', function(event) {
        event.preventDefault();

        let nombre = $("#nombre").val();
        let apellidos = $("#apellidos").val();
        let telefono = $("#telefono").val();
        let celular = $("#celular").val();
        let correo_electronico = $("#correo_electronico").val();

        let _token = $("input[name=_token]").val();
        let url = currentURL + '/lecturistas';

        $.post(url, {
            nombre: nombre,
            apellidos: apellidos,
            telefono: telefono,
            celular: celular,
            correo_electronico: correo_electronico,
            _token: _token
        }, function(data, textStatus, xhr) {

            $('.viewResult').html(data);
        }).done(function() {
            $('.modal-backdrop ').css('display', 'none');
            $('#modal').modal('hide');
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
     * Evento para mostrar el formulario de edicion de un canal
     */
    $(document).on("click", ".editLecturista", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Editar Lecturista');
        $('#action').removeClass('saveLecturista');
        $('#action').addClass('updateLecturista');

        let id = $("#idSeleccionado").val();

        let url = currentURL + "/lecturistas/" + id + "/edit";

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para mostrar el formulario editar modulo
     */
    $(document).on('click', '#table-lecturistas tbody tr', function(event) {
        event.preventDefault();

        let id = $(this).data("id");
        $(".editLecturista").slideDown();
        $(".deleteLecturista").slideDown();

        $("#idSeleccionado").val(id);

        $("#table-lecturistas tbody tr").removeClass('table-primary');
        $(this).addClass('table-primary');
    });
    /**
     * Evento para editar el modulo
     */
    $(document).on('click', '.updateLecturista', function(event) {
        event.preventDefault();

        let nombre = $("#nombre").val();
        let apellidos = $("#apellidos").val();
        let telefono = $("#telefono").val();
        let celular = $("#celular").val();
        let correo_electronico = $("#correo_electronico").val();
        let id = $("#idSeleccionado").val();

        let _token = $("input[name=_token]").val();
        let _method = "PUT";
        let url = currentURL + '/lecturistas/' + id;

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                nombre: nombre,
                apellidos: apellidos,
                telefono: telefono,
                celular: celular,
                correo_electronico: correo_electronico,
                _token: _token,
                _method: _method
            },
            success: function(result) {
                $('.viewResult').html(result);
                $('.viewCreate').slideUp();
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
    $(document).on('click', '.deleteLecturista', function(event) {
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
                let url = currentURL + '/lecturistas/' + id;

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
