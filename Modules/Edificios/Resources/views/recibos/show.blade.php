<style>
    .fondo{
        position: relative;
        display: inline-block;
    }
    @page {
            margin: 0px 0px 0px 0px !important;
            padding: 0px 0px 0px 0px !important;
            font-size: 12px;
    }
    .contenido{
        position: absolute;
    top: 10px;
    left: 10px;
    }
    .row{
        width: 100%;
    }
    .invoice{
        /*background-color: red;*/
        height: 430px;
    }
    .invoice-info{
        width: 100%;
        height: 140px;
        margin: 5px;
        /*background-color: yellow;*/
        overflow: hidden;
    }
    .col-sm-6{
        width: 50%;
        height: auto;
        padding: 10px;
        float:left;
        /*background-color: blue;*/
    }

</style>


@for ($i = 0; $i < (count( $recibos )/ 2); $i++)

<div class="fondo">

    <img src="{{'data:image/jpeg;base64,' . base64_encode($url_recibo)}}" alt="" width="800" height="1000">

    @foreach ($recibos as $recibo)

        <div class="contenido">
            <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                <div class="col-12">
                    <h4>
                    <i class="fas fa-globe"></i>
                    <small class="float-right">{{ $recibo->clave_recibo }}</small>
                    </h4>
                </div>
                <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                <div class="col-sm-6 invoice-col">
                    DATOS CLIENTE
                    <address>
                    <strong>Admin, Inc.</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (804) 123-5432<br>
                    Email: info@almasaeedstudio.com
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 invoice-col">
                    <b>PERIODO DE CONSUMO</b><br>
                    <br>
                    <b>Order ID:</b> 4F3S8J<br>
                    <b>Payment Due:</b> 2/22/2014<br>
                    <b>Account:</b> 968-34567
                </div>
                <!-- /.col -->
                </div>
                <!-- /.row -->
                <!-- Table row -->
                <div class="row invoice-info">
                    <div class="col-sm-6 invoice-col">
                        ULTIMOS ^ MESES DE CONSUMO
                        <address>
                        <strong>Admin, Inc.</strong><br>
                        795 Folsom Ave, Suite 600<br>
                        San Francisco, CA 94107<br>
                        Phone: (804) 123-5432<br>
                        Email: info@almasaeedstudio.com
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6 invoice-col">
                        <b>DETALLE DE CONSUMO</b><br>
                        <br>
                        <b>Order ID:</b> 4F3S8J<br>
                        <b>Payment Due:</b> 2/22/2014<br>
                        <b>Account:</b> 968-34567
                    </div>
                </div>
                <!-- /.row -->
                <div class="row invoice-info">
                    <div class="col-sm-6 invoice-col">
                        METODOS DE PAGO
                        <address>
                        <strong>Admin, Inc.</strong><br>
                        795 Folsom Ave, Suite 600<br>
                        San Francisco, CA 94107<br>
                        Phone: (804) 123-5432<br>
                        Email: info@almasaeedstudio.com
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6 invoice-col">
                        <b>TOTAL A PAGAR</b><br>
                        <br>
                        <b>Order ID:</b> 4F3S8J<br>
                        <b>Payment Due:</b> 2/22/2014<br>
                        <b>Account:</b> 968-34567
                    </div>
                <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>

        </div>


    @endforeach

</div>

@endfor

