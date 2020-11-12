$(function() {

    let currentURL = window.location.href;

    /**
     * Evento para conciliar el archivo
     */
    $(document).on("click", "#conciliar", function(e) {
        e.preventDefault();

        let formData = new FormData(document.getElementById("formConciliacion"));
        let archivoConciliacion = $("#archivoConciliar").val();
        let _token = $("input[name=_token]").val();

        formData.append("archivoConciliacion", archivoConciliacion);
        formData.append("_token", _token);

        let url = currentURL + '/conciliacion';

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false

        })
        .done(function(data) {

            $('.viewResult').html(data);
            /*
            Swal.fire(
                'Correcto!',
                'El registro ha sido guardado.',
                'success'
            )
            */
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
