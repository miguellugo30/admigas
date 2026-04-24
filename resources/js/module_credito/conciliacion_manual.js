$(function() {

    let currentURL = window.location.href;

    /**
     * Evento para conciliar el archivo
     */
    $(document).on("change", "#unidad_no_conciliado", function(e) {

        let url = currentURL + '/buscar-edificio/'+ $(this).val();

        $.get(url, function(data, textStatus, xhr) {
            $('.result-search-edificio').html(data);
        });
    });

    $(document).on("change", "#edificio_no_conciliado", function(e) {

        let url = currentURL + '/buscar-depto/'+ $(this).val();

        $.get(url, function(data, textStatus, xhr) {
            $('.result-search-depto').html(data);
        });
    });

    $(document).on("click", ".conciliar-button", function(e) {


        let depto_id = $('#depto_no_conciliado').val();
        let pago_id = $('input[name=pago_no_conciliado]').val();
        let _token = $("input[name=_token]").val();
        let url = currentURL + '/conciliacion-manual';

        $.post(url, {
            depto_id: depto_id,
            pago_id: pago_id,
            _token: _token
        }, function(data, textStatus, xhr) {
            $('.viewResult').html(data);
        });
    });
});
