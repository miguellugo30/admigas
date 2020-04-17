$(function() {

    let currentURL = window.location.href;
    /**
     * Evento para mostrar el formulario de crear un nuevo modulo
     */
    $(document).on("click", ".newMenu", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Nuevo Menu');
        $('#action').removeClass('updateMenu');
        $('#action').addClass('saveMenu');

        let url = currentURL + '/menus/create';

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para guardar el nuevo modulo
     */
    $(document).on('click', '.saveMenu', function(event) {
        event.preventDefault();

        let nombre = $("#nombre").val();
        let icono = $("#icono").val();
        let modulo = $("#modulo").val();

        let _token = $("input[name=_token]").val();
        let url = currentURL + '/menus';

        $.post(url, {
            nombre: nombre,
            icono: icono,
            modulo: modulo,
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
    $(document).on("click", ".editMenu", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Editar Menu');
        $('#action').removeClass('saveMenu');
        $('#action').addClass('updateMenu');

        let id = $("#idSeleccionado").val();

        let url = currentURL + "/menus/" + id + "/edit";

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para mostrar el formulario editar modulo
     */
    $(document).on('click', '#table-menus tbody tr', function(event) {
        event.preventDefault();

        let id = $(this).data("id");
        $(".editMenu").slideDown();
        $(".deleteMenu").slideDown();

        $("#idSeleccionado").val(id);

        $("#table-menus tbody tr").removeClass('table-primary');
        $(this).addClass('table-primary');
    });
    /**
     * Evento para editar el modulo
     */
    $(document).on('click', '.updateMenu', function(event) {
        event.preventDefault();

        let nombre = $("#nombre").val();
        let icono = $("#icono").val();
        let modulo = $("#modulo").val();
        let id = $("#idSeleccionado").val();

        let _token = $("input[name=_token]").val();
        let _method = "PUT";
        let url = currentURL + '/menus/' + id;

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                nombre: nombre,
                icono: icono,
                modulo: modulo,
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
    $(document).on('click', '.deleteMenu', function(event) {
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
                let url = currentURL + '/menus/' + id;

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