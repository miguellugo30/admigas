$(function() {

    let currentURL = window.location.href;

    $(document).on("click", ".generateReporteRecibosGenerados", function(e) {

        e.preventDefault();
        $(".exportReporteRecibosGenerados").slideDown();

        let desde = $("#desde").val();
        let hasta = $("#hasta").val();
        let _token = $("input[name=_token]").val();
        let url = currentURL + '/recibos-generados';

        $.post(url, {
            desde: desde,
            hasta: hasta,
            _token: _token
        }, function(data, textStatus, xhr) {
            $('.showResult').html(data);
        });
    });

    $(document).on("click", ".exportReporteRecibosGenerados", function(e) {

        e.preventDefault();
        let desde = $("#desde").val();
        let hasta = $("#hasta").val();
        let url = currentURL + '/litros/export/'+desde+'/'+hasta;

        window.open( url);

    });

});
