$(function() {

    let currentURL = window.location.href;

    $(document).on("click", ".generateReportCargo", function(e) {

        e.preventDefault();
        let desde = $("#desde").val();
        let hasta = $("#hasta").val();
        let _token = $("input[name=_token]").val();
        let url = currentURL + '/cargos-adicionales';

        $.post(url, {
            desde: desde,
            hasta: hasta,
            _token: _token
        }, function(data, textStatus, xhr) {
            $('.showResult').html(data);
        });
    });

});
