const { post } = require("jquery");

$(function () {

    let URL =  window.location.href;
    let currentURL =  URL.replace('#','');
    let departamento_id = document.getElementById('id').value;

    $.get(currentURL + '/' + departamento_id, function (data, textStatus, jqXHR) {
        var ctx = document.getElementById('canvas').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.fechas,
                datasets: [{
                    label: 'Litros',
                    data: data.litros,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    });
    /**
     * Evento para visualizar el recibo
     */
    document.getElementById("viewRecibo").addEventListener("click", function (event) {

        let recibo_id = document.getElementById('recibos').value;
        if (recibo_id === '') {
            Swal.fire(
                'Error!',
                'Debe seleccionar una fecha, para mostrar un recibo.',
                'error'
            )
        } else {
            window.open(currentURL+"/showRecibo/"+recibo_id+"/1", '_blank');
        }

    }, false);
    /**
     * Evento para descargar el recibo
     */
    document.getElementById("downloadRecibo").addEventListener("click", function (event) {

        let recibo_id = document.getElementById('recibos').value;
        if (recibo_id === '') {
            Swal.fire(
                'Error!',
                'Debe seleccionar una fecha, para descargar un recibo.',
                'error'
            )
        } else {
            window.open(currentURL+"/showRecibo/"+recibo_id+"/2", '_blank');
        }

    }, false);

    $(document).on('click', '.menu', function(event) {
        let menu_id = $(this).attr('id');
        let departamento_id = $("#id").val();
        let _token = $("input[name=_token]").val();
        console.log( currentURL );
        if (menu_id == 8) {
            url = currentURL + "/mi_cuenta"
        } else if( menu_id == 10 ) {
            url = currentURL + "/estado_cuenta"
        } else if( menu_id == 9 ) {
            url = currentURL + "/medios_contacto"
        }

        $.post(url, {
                departamento_id: departamento_id,
                _token: _token
            }, function(data, textStatus, xhr) {
                $('.content').html(data);
                if ( menu_id == 10 ) {
                    $('.table').DataTable( {
                                                "scrollY":        "380px",
                                                "scrollCollapse": true,
                                                "paging":         false,
                                                "ordering": false,
                                                "searching": false,
                                                "info": false,
                                            } );
                }
            });
    });

    $(document).on('click', '.viewDetail', function(event) {
        $('#modal').modal('show');
    });

    $(document).on('click', '.editClient', function(event) {
        $('#modal').modal('show');
    });

    $(document).on('click', '#actionSave', function(event) {

        let departamento_id = $("#id").val();
        let nombre = $("#nombre").val();
        let apellido_paterno = $("#apellido_paterno").val();
        let apellido_materno = $("#apellido_materno").val();
        let telefono = $("#telefono").val();
        let celular = $("#celular").val();
        let correo_electronico = $("#correo_electronico").val();
        let _token = $("input[name=_token]").val();
        let url = currentURL + "/update_departamento/" + departamento_id

        $.post(url, {
            nombre: nombre,
            apellido_paterno: apellido_paterno,
            apellido_materno: apellido_materno,
            telefono: telefono,
            celular: celular,
            correo_electronico: correo_electronico,
            departamento_id: departamento_id,
            _token: _token
        }, function(data, textStatus, xhr) {

            let url = currentURL + "/mi_cuenta";
            $.post(url, {
                departamento_id: departamento_id,
                _token: _token
            }, function(data, textStatus, xhr) {
                $('.content').html(data);
            });
        }).done(function() {
            $('.modal-backdrop ').css('display', 'none');
            $('#modal').modal('hide');
            Swal.fire(
                'Correcto!',
                'La información se actualizado correctamente.',
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