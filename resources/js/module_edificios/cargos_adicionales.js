$(function() {

    let currentURL = window.location.href;

    /**
     * Evento para mostrar el formulario de crear un nuevo modulo
     */
    $(document).on("click", ".cargosAdicionales", function(e) {

        e.preventDefault();
        $('#modal-condominio #tituloModal').html('Cargos Adicionales');
        $('#modal-condominio #action').removeClass('updateCargosAdicionales');
        $('#modal-condominio #action').addClass('saveCargosAdicionales');

        let admigas_condominios_id = $("#admigas_condominios_id").val();

        let url = currentURL + '/create-cargos-adicionales/' + admigas_condominios_id;

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal-condominio').modal('show');
            $("#modal-condominio #modal-body").html(data);
        });
    });
    /**
     * Evento para clonar finas de la tabla
     */
    $(document).on('click', '#addDeptoCargos', function(event) {

        var clickID = $(".tableNewForm tbody tr.clonar:last").attr('id').replace('tr_', '');
        // Genero el nuevo numero id
        var newID = parseInt(clickID) + 1;

        let IDInput = ['depto']; //ID de los inputs dentro de la fila

        fila = $(".tableNewForm tbody tr:eq()").clone().appendTo(".tableNewForm"); //Clonamos la fila

        for (let i = 0; i < IDInput.length; i++) {
            fila.find('#' + IDInput[i]).attr('name', IDInput[i] + "_" + newID); //Cambiamos el nombre de los campos de la fila a clonar
        }
        fila.find('.btn-danger').css('display', 'initial');
        fila.attr("id", 'tr_' + newID);
    });
    /**
     * Evento para eliminar una fila de la tabla 
     */
    $(document).on('click', '.tr_clone_remove', function () {
        var tr = $(this).closest('tr');
        tr.remove();
    });
    /**
     * Evento para guardar 
     */
    $(document).on('click', '.saveCargosAdicionales', function(event) {
        event.preventDefault();

        let servicio = $("#servicio").val();
        let plazo = $("#plazo").val();
        let admigas_condominios_id = $("#admigas_condominios_id").val();
        let dataForm = $("#formCargosCapture").serializeArray();
        
        var data = {};
        $(dataForm).each(function(index, obj) {
            data[obj.name] = obj.value;
        });
        
        let _token = $("input[name=_token]").val();
        let url = currentURL + '/cargos-adicionales';

        $.post(url, {
            dataForm: data,
            servicio: servicio,
            plazo: plazo,
            admigas_condominios_id: admigas_condominios_id,
            _token: _token
        }, function(data, textStatus, xhr) {
            $('.modal-backdrop ').css('display', 'none');
            $('#modal-condominio').modal('hide');
            $('.viewResult').html(data);
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
     * Evento para mostrar los cargos adicionales de un departamento
     */
    $(document).on("click", ".viewCargo", function(e) {

        e.preventDefault();
        $('#modal-condominio #tituloModal').html('Cargos Adicionales al Departamento');
        $('#modal-condominio #action').removeClass('updateCargosAdicionales');
        $('#modal-condominio #action').addClass('saveCargosAdicionales');

        let id_depto = $(this).data('id_depto');

        let url = currentURL + '/cargos-adicionales/' + id_depto;

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal-condominio').modal('show');
            $("#modal-condominio #modal-body").html(data);
        });
    });
    /**
     * Evento para eliminar un cargo de un departamento
     */
    $(document).on("click", ".viewCargo", function(e) {

        e.preventDefault();
        $('#modal-condominio #tituloModal').html('Cargos Adicionales al Departamento');
        $('#modal-condominio #action').removeClass('updateCargosAdicionales');
        $('#modal-condominio #action').addClass('saveCargosAdicionales');

        let id_depto = $(this).data('id_depto');

        let url = currentURL + '/cargos-adicionales/' + id_depto;

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal-condominio').modal('show');
            $("#modal-condominio #modal-body").html(data);
        });
    });

});