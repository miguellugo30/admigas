$(function() {

    let currentURL = window.location.href;

    $(document).on("click", ".generateReportLitros", function(e) {

        e.preventDefault();
        $(".exportReportLitros").slideDown();

        let desde = $("#desde").val();
        let hasta = $("#hasta").val();
        let _token = $("input[name=_token]").val();
        let url = currentURL + '/litros';

        $.post(url, {
            desde: desde,
            hasta: hasta,
            _token: _token
        }, function(data, textStatus, xhr) {
            $('.showResult').html(data);
        });
    });

    $(document).on("click", ".exportReportLitros", function(e) {

        e.preventDefault();
        let desde = $("#desde").val();
        let hasta = $("#hasta").val();
        let url = currentURL + '/litros/export/'+desde+'/'+hasta;

        window.open( url);

    });

});
