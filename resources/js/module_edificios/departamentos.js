$(function() {

    let currentURL = window.location.href;
    /**
     * Evento para mostrar el formulario de crear un nuevo modulo
     */
    $(document).on("click", ".newDepartamento", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Nuevo Departamento');
        $('#action').removeClass('updateDepartamento');
        $('#action').addClass('saveDepartamento');

        let url = currentURL + '/departamentos/create';

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para guardar el nuevo modulo
     */
    $(document).on('click', '.saveDepartamento', function(event) {
        event.preventDefault();

        let numero_departamento = $("#numero_departamento").val();
        let numero_referencia = $("#numero_referencia").val();
        let nombre = $("#nombre").val();
        let apellidos = $("#apellidos").val();
        let telefono = $("#telefono").val();
        let celular = $("#celular").val();
        let correo_electronico = $("#correo_electronico").val();
        let tipo = $("#tipo").val();
        let marca = $("#marca").val();
        let numero_serie = $("#numero_serie").val();
        let lectura = $("#lectura").val();
        let fecha_lectura = $("#fecha_lectura").val();
        let admigas_condominios_id = $("#admigas_condominios_id").val();

        let _token = $("input[name=_token]").val();
        let url = currentURL + '/departamentos';

        $.post(url, {
            numero_departamento: numero_departamento,
            numero_referencia: numero_referencia,
            nombre: nombre,
            apellidos: apellidos,
            telefono: telefono,
            celular: celular,
            correo_electronico: correo_electronico,
            tipo: tipo,
            marca: marca,
            numero_serie: numero_serie,
            lectura: lectura,
            fecha_lectura: fecha_lectura,
            admigas_condominios_id: admigas_condominios_id,
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
    $(document).on("click", ".editDepartamento", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Editar Departamento');
        $('#action').removeClass('saveDepartamento');
        $('#action').addClass('updateDepartamento');

        let id = $("#idSeleccionado").val();

        let url = currentURL + "/departamentos/" + id + "/edit";

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para mostrar el formulario editar modulo
     */
    $(document).on('click', '#table-departamentos tbody tr', function(event) {
        event.preventDefault();

        let id = $(this).data("id");
        $(".editDepartamento").slideDown();
        $(".deleteDepartamento").slideDown();

        $("#idSeleccionado").val(id);

        $("#table-departamentos tbody tr").removeClass('table-primary');
        $(this).addClass('table-primary');
    });
    /**
     * Evento para editar el modulo
     */
    $(document).on('click', '.updateDepartamento', function(event) {
        event.preventDefault();

        let nombre = $("#nombre").val();
        let mensaje = $("#mensaje").val();
        let id = $("#idSeleccionado").val();

        let _token = $("input[name=_token]").val();
        let _method = "PUT";
        let url = currentURL + '/departamentos/' + id;

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                nombre: nombre,
                mensaje: mensaje,
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
    $(document).on('click', '.deleteDepartamento', function(event) {
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
                let url = currentURL + '/departamentos/' + id;

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
     * Eliminamos las clases agregadas dinamicamente
     */
    $("#modal-edificios").on("hide.bs.modal", function() {
        $('#action').removeClass('saveDepartamento');
        $('#action').removeClass('updateDepartamento');
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