$(function () {

    let currentURL = window.location.href;
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
        alert(recibo_id);
        if (recibo_id === '') {
            Swal.fire(
                'Error!',
                'Debe seleccionar una fecha, para mostrar un recibo.',
                'error'
            )
        } else {
            alert('no es nulo');
        }

    }, false);
    /**
     * Evento para descargar el recibo
     */
    document.getElementById("downloadRecibo").addEventListener("click", function (event) {

        let recibo_id = document.getElementById('recibos').value;
        alert(recibo_id);
        if (recibo_id === '') {
            Swal.fire(
                'Error!',
                'Debe seleccionar una fecha, para descargar un recibo.',
                'error'
            )
        } else {
            alert('no es nulo');
        }

    }, false);

});