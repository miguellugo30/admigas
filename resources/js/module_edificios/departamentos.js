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

        let admigas_condominios_id = $("#admigas_condominios_id").val();
        let url = currentURL + '/departamentos/create/'+admigas_condominios_id;

        $.get(url, function(data, textStatus, jqXHR) {
            $('#modal').modal('show');
            $("#modal-body").html(data);
        });
    });
    /**
     * Evento para completar la referencia
     */
    $(document).on('blur', '#numero_departamento', function(event) {
        let num_depto = $(this).val();
        let referencia = $("#referencia_digitos").val();
        let clasificacion = $('input:radio[name=clasificacion]:checked').val();
        let medio = $('input:radio[name=medio]:checked').val();

        if ( clasificacion == 'propio' ) {
            clas = 'P';
        } else if( clasificacion == 'arrendado' ) {
            clas = 'A';
        }

        if ( medio == 'digital' ) {
            med = 'E';
        } else if( medio == 'fisico' ) {
            med = 'I';
        }

        ref = referencia + num_depto.padStart(4, '0') + clas + med;
        $("#basic-addon1").text( ref );
        $("#referencia_digitos").val( ref );
    });

    $(document).on('change', 'input:radio[name=clasificacion]', function(event) {
        let clasificacion = $(this).val();
        let referencia = $("#referencia_digitos").val();

        if ( clasificacion == 'propio' ) {
            ref = referencia.replace('A', 'P');
        } else if( clasificacion == 'arrendado' ) {
            ref = referencia.replace('P', 'A');
        }
        //ref = referencia + num_depto.padStart(4, '0') + clas + med;
        $("#basic-addon1").text( ref );
        $("#referencia_digitos").val( ref );

    });

    $(document).on('change', 'input:radio[name=medio]', function(event) {
        let clasificacion = $(this).val();
        let referencia = $("#referencia_digitos").val();

        if ( clasificacion == 'digital' ) {
            ref = referencia.replace('I', 'E');
            $("#gasto_admin").val(10);
        } else if( clasificacion == 'fisico' ) {
            ref = referencia.replace('E', 'I');
            $("#gasto_admin").val(15);
        }
        //ref = referencia + num_depto.padStart(4, '0') + clas + med;
        $("#basic-addon1").text( ref );
        $("#referencia_digitos").val( ref );

    });

    /**
     * Evento para guardar el nuevo modulo
     */
    $(document).on('click', '.saveDepartamento', function(event) {
        event.preventDefault();

        let numero_departamento = $("#numero_departamento").val();
        let referencia_digitos = $("#referencia_digitos").val();
        let digito_banco = $("#digito_banco").val();
        let nombre = $("#nombre").val();
        let apellido_paterno = $("#apellido_paterno").val();
        let apellido_materno = $("#apellido_materno").val();
        let telefono = $("#telefono").val();
        let celular = $("#celular").val();
        let correo_electronico = $("#correo_electronico").val();
        let tipo = $("#tipo").val();
        let marca = $("#marca").val();
        let numero_serie = $("#numero_serie").val();
        let lectura = $("#lectura").val();
        let fecha_lectura = $("#fecha_lectura").val();
        let clasificacion = $("input:radio[name=clasificacion]").val();
        let medio = $("input:radio[name=medio]:checked").val();
        let gasto_admin = $("#gasto_admin").val();
        let admigas_condominios_id = $("#admigas_condominios_id").val();
        let numero_referencia = referencia_digitos+digito_banco;

        let _token = $("input[name=_token]").val();
        let url = currentURL + '/departamentos';

        $.post(url, {
            numero_departamento: numero_departamento,
            numero_referencia: numero_referencia,
            nombre: nombre,
            apellido_paterno: apellido_paterno,
            apellido_materno: apellido_materno,
            telefono: telefono,
            celular: celular,
            correo_electronico: correo_electronico,
            tipo: tipo,
            marca: marca,
            numero_serie: numero_serie,
            lectura: lectura,
            fecha_lectura: fecha_lectura,
            clasificacion: clasificacion,
            medio: medio,
            gasto_admin: gasto_admin,
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

        let numero_departamento = $("#numero_departamento").val();
        let numero_referencia = $("#numero_referencia").val();
        let referencia_anterior = $("#referencia_anterior").val();
        let nombre = $("#nombre").val();
        let apellido_paterno = $("#apellido_paterno").val();
        let apellido_materno = $("#apellido_materno").val();
        let telefono = $("#telefono").val();
        let celular = $("#celular").val();
        let correo_electronico = $("#correo_electronico").val();
        let admigas_departamentos_id = $("#admigas_departamentos_id").val();
        let id_condominio = $("#id_condominio").val();
        let clasificacion = $("input:radio[name=clasificacion]").val();
        let medio = $("input:radio[name=medio]:checked").val();
        let gasto_admin = $("#gasto_admin").val();

        let _token = $("input[name=_token]").val();
        let _method = "PUT";
        let url = currentURL + '/departamentos/' + admigas_departamentos_id;

        console.log(numero_referencia + '!=' + referencia_anterior);

        if (numero_referencia != referencia_anterior) {

            Swal.fire({
                title: '¿Estas seguro?',
                text: "Se esta modificando el número de refencia!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, actualizar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {

                if (result.value) {

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            numero_departamento: numero_departamento,
                            numero_referencia: numero_referencia,
                            nombre: nombre,
                            apellido_paterno: apellido_paterno,
                            apellido_materno: apellido_materno,
                            telefono: telefono,
                            celular: celular,
                            correo_electronico: correo_electronico,
                            clasificacion: clasificacion,
                            medio: medio,
                            gasto_admin: gasto_admin,
                            admigas_departamentos_id: admigas_departamentos_id,
                            id_condominio: id_condominio,
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

                }

            });

        }
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                numero_departamento: numero_departamento,
                numero_referencia: numero_referencia,
                nombre: nombre,
                apellido_paterno: apellido_paterno,
                apellido_materno: apellido_materno,
                telefono: telefono,
                celular: celular,
                correo_electronico: correo_electronico,
                clasificacion: clasificacion,
                medio: medio,
                gasto_admin: gasto_admin,
                admigas_departamentos_id: admigas_departamentos_id,
                id_condominio: id_condominio,
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
     * Evento para ver el detalle de un departamento
     */
    $(document).on("dblclick", "#table-departamentos tbody tr", function (e) {

        e.preventDefault();
        let id = $(this).data("id");

        $('.list-deptos').slideUp();

        let url = currentURL + '/departamentos/' + id;

        $.get(url, function (data, textStatus, jqXHR) {
            $(".list-deptos-capture").html(data);
            $(".list-deptos-capture").slideDown();
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
                        $('#table-departamentos').DataTable({
                            "responsive": true,
                            "autoWidth": false,
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
     * Evento para visualizar los recibos
     */
    $(document).on('click', '.viewRecibo', function(event) {
        let departamentos_id = $("#idSeleccionado").val();
        let recibos_id = $(this).data('id_recibo');

        console.log(departamentos_id+" "+recibos_id);

        let url = currentURL + '/departamentos/show_recibo/'+departamentos_id+'/'+recibos_id;
        window.open(url, '_blank');

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
