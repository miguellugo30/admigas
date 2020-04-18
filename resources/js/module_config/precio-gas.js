$(function() {

    let currentURL = window.location.href;
    /**
     * Evento para mostrar el formulario de crear un nuevo modulo
     */
    $(document).on("click", ".newPrecioGas", function(e) {

        e.preventDefault();
        $('#tituloModal').html('Nuevo Precio Gas');
        $('#action').removeClass('updatePrecioGas');
        $('#action').addClass('savePrecioGas');

        let url = currentURL + '/precio-gas/create';

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para guardar el nuevo modulo
     */
    $(document).on('click', '.savePrecioGas', function(event) {
        event.preventDefault();

        let precio = $("#precio").val();
        let _token = $("input[name=_token]").val();
        let url = currentURL + '/precio-gas';

        $.post(url, {
            precio: precio,
            _token: _token
        }, function(data, textStatus, xhr) {

            $('.viewResult').html(data);
            $('.viewIndex #tableEdoCli').DataTable({
                "lengthChange": true,
                "order": [
                    [5, "asc"]
                ]
            });
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