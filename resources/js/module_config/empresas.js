$(function() {

    let currentURL = window.location.href;
    /**
     * Evento para mostrar el formulario de crear un nuevo modulo
     */
    $(document).on("click", ".newEmpresa", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Nuevo Empresa');
        $('#action').removeClass('updateEmpresa');
        $('#action').addClass('saveEmpresa');

        let url = currentURL + '/empresas/create';

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para guardar el nuevo modulo
     */
    $(document).on('click', '.saveEmpresa', function(event) {
        event.preventDefault();

        let razon_social = $("#razon_social").val();
        let rfc = $("#rfc").val();
        let calle = $("#calle").val();
        let numero = $("#numero").val();
        let colonia = $("#colonia").val();
        let municipio = $("#municipio").val();
        let cp = $("#cp").val();
        let cuenta = $("#cuenta").val();
        let clabe = $("#clabe").val();
        let convenio_cie = $("#convenio_cie").val();

        let _token = $("input[name=_token]").val();
        let url = currentURL + '/empresas';

        $.post(url, {
            razon_social: razon_social,
            rfc: rfc,
            calle: calle,
            numero: numero,
            colonia: colonia,
            municipio: municipio,
            cp: cp,
            cuenta: cuenta,
            clabe: clabe,
            convenio_cie: convenio_cie,
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
    $(document).on("click", ".editEmpresa", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Editar Empresa');
        $('#action').removeClass('saveEmpresa');
        $('#action').addClass('updateEmpresa');

        let id = $("#idSeleccionado").val();

        let url = currentURL + "/empresas/" + id + "/edit";

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para mostrar el formulario editar modulo
     */
    $(document).on('click', '#table-empresas tbody tr', function(event) {
        event.preventDefault();

        let id = $(this).data("id");
        $(".editEmpresa").slideDown();
        $(".deleteEmpresa").slideDown();

        $("#idSeleccionado").val(id);

        $("#table-empresas tbody tr").removeClass('table-primary');
        $(this).addClass('table-primary');
    });
    /**
     * Evento para editar el modulo
     */
    $(document).on('click', '.updateEmpresa', function(event) {
        event.preventDefault();

        let razon_social = $("#razon_social").val();
        let rfc = $("#rfc").val();
        let calle = $("#calle").val();
        let numero = $("#numero").val();
        let colonia = $("#colonia").val();
        let municipio = $("#municipio").val();
        let cp = $("#cp").val();
        let cuenta = $("#cuenta").val();
        let clabe = $("#clabe").val();
        let convenio_cie = $("#convenio_cie").val();
        let id = $("#idSeleccionado").val();

        let _token = $("input[name=_token]").val();
        let _method = "PUT";
        let url = currentURL + '/empresas/' + id;

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                razon_social: razon_social,
                rfc: rfc,
                calle: calle,
                numero: numero,
                colonia: colonia,
                municipio: municipio,
                cp: cp,
                cuenta: cuenta,
                clabe: clabe,
                convenio_cie: convenio_cie,
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
    $(document).on('click', '.deleteEmpresa', function(event) {
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
                let url = currentURL + '/empresas/' + id;

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