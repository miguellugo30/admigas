$(function() {

    let currentURL = window.location.href;

    $(document).on("click", ".generateReportSaldo", function(e) {

        e.preventDefault();
        let desde = $("#desde").val();
        let _token = $("input[name=_token]").val();
        let url = currentURL + '/saldos';

        $.post(url, {
            desde: desde,
            _token: _token
        }, function(data, textStatus, xhr) {
            $('.showResult').html(data);
        });
    });

});
