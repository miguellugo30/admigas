$(function() {

    let currentURL = window.location.href;
    /**
     * Evento para mostrar el formulario editar modulo
     */
    $(document).on('click', '#table-tanques tbody tr', function(event) {
        event.preventDefault();

        let id = $(this).data("id");
        $(".editTanque").slideDown();
        $(".deleteTanque").slideDown();

        $("#idSeleccionado").val(id);

        $("#table-tanques tbody tr").removeClass('table-primary');
        $(this).addClass('table-primary');
    });
    /**
     * Evento para mostrar el formulario de crear un nuevo modulo
     */
    $(document).on("click", ".newTanque", function(e) {

        e.preventDefault();
        $('#modal-edificios #tituloModal').html('Nuevo Tanque');
        $('#modal-edificios #action').removeClass('updateTanque');
        $('#modal-edificios #action').addClass('saveTanque');

        let url = currentURL + '/tanques/create';

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal-edificios').modal('show');
            $("#modal-edificios #modal-body").html(data);
        });
    });
    /**
     * Evento para guardar el nuevo modulo
     */
    $(document).on('click', '.saveTanque', function(event) {
        event.preventDefault();

        let num_serie = $("#num_serie").val();
        let marca = $("#marca").val();
        let fecha_fabricacion = $("#fecha_fabricacion").val();
        let estado_al_recibir = $("#estado_al_recibir").val();
        let capacidad = $("#capacidad").val();
        let inventario = $('input:radio[name=inventario]:checked').val();
        let admigas_unidades_id = $("#admigas_unidades_id").val();


        let _token = $("input[name=_token]").val();
        let url = currentURL + '/tanques';

        $.post(url, {
            num_serie: num_serie,
            marca: marca,
            fecha_fabricacion: fecha_fabricacion,
            estado_al_recibir: estado_al_recibir,
            capacidad: capacidad,
            inventario: inventario,
            admigas_unidades_id: admigas_unidades_id,
            _token: _token
        }, function(data, textStatus, xhr) {
            $('.viewResult').html(data);
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
     * Evento para mostrar el formulario de edicion de un canal
     */
    $(document).on("click", ".editTanque", function(e) {

        e.preventDefault();
        $('#modal-file-foto #tituloModal').html('Editar Tanque');
        $('#modal-file-foto #action').removeClass('saveTanque');
        $('#modal-file-foto #action').addClass('updateTanque');

        let id = $("#idSeleccionado").val();

        let url = currentURL + "/tanques/" + id + "/edit";

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal-file-foto').modal('show');
            $("#modal-file-foto #modal-body").html(data);
        });
    });
    /**
     * Evento para guardar el nuevo modulo
     */
    $(document).on('click', '.updateTanque', function(event) {
        event.preventDefault();

        let tanque_id = $("#tanque_id").val();
        let admigas_unidades_id = $("#admigas_unidades_id").val();
        let num_serie = $("#num_serie").val();
        let marca = $("#marca").val();
        let fecha_fabricacion = $("#fecha_fabricacion").val();
        let estado_al_recibir = $("#estado_al_recibir").val();
        let capacidad = $("#capacidad").val();
        let inventario = $('input:radio[name=inventario]:checked').val();
        let _token = $("input[name=_token]").val();
        let url = currentURL + '/tanques/' + tanque_id;

        $.post(url, {
            tanque_id: tanque_id,
            admigas_unidades_id: admigas_unidades_id,
            num_serie: num_serie,
            marca: marca,
            fecha_fabricacion: fecha_fabricacion,
            estado_al_recibir: estado_al_recibir,
            capacidad: capacidad,
            inventario: inventario,
            _token: _token,
            _method: 'PUT',
        }, function(data, textStatus, xhr) {
            $('.viewResult').html(data);
        }).done(function() {
            $('.modal-backdrop ').css('display', 'none');
            $('#modal-file-foto').modal('hide');
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
     * Evento para eliminar el modulo
     */
    $(document).on('click', '.deleteTanque', function(event) {
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
                let url = currentURL + '/tanques/' + id;

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
        $('#action').removeClass('updateTanque');
        $('#action').removeClass('saveTanque');
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
