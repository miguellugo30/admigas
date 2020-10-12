@extends('adminlte::page')

@section('title', 'Admigas')


@section('content')
<!-- Main content -->
<div class="content">
    <input type="hidden" name="id" id="id" value="{{ \Auth::user()->Departamentos->first()->id }}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title"><b> Su saldo al dia es: </b></h3>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <div class="col">
                            <h1>$ {{ number_format( $recibos->first()->total_pagar,2 ) }}</h1>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col text-left">
                                    <button type="button" class="btn btn-info">Ver detalle</button>
                                </div>
                                <div class="col text-right">
                                    <button type="button" class="btn btn-primary ">Pagar ahora</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->

                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title"><b>Grafica de consumos</b></h3>
                    </div>
                    <div class="card-body">
                        <div class="col canvas">
                            <canvas id="canvas"></canvas>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title"><b>Su fecha limite de pago es:</b></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col text-center">
                            @if ( date('Y-m-d') > $recibos->first()->fecha_limite_pago )
                                <h2 class="text-danger">{{ date('d-m-Y', strtotime( $recibos->first()->fecha_limite_pago)) }}</h2>
                            @else
                                <h2>{{ date('d-m-Y', strtotime( $recibos->first()->fecha_limite_pago)) }}</h2>
                            @endif
                        </div>
                        <div class="col text-left" >
                            @if ( date('Y-m-d') > $recibos->first()->fecha_limite_pago )
                                <p class="text-danger">Su fecha de pago ha vencido, pague de manera inmediato y evite cortes en su sumistro de gas</p>
                            @else
                                <p>Le pedimos pagar ha tiempo, para no generar cargos adicionales</p>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- /.card -->
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title"><b>Consulte y descargue sus recibos</b></h3>
                    </div>
                    <div class="card-body text-center">
                        <p>Puedes visualizar y descargar tus ultimos 6 recibos</p>
                        @php
                            \Carbon\Carbon::setlocale(config('app.locale'));
                        @endphp
                        <div class="form-group">
                            <select class="form-control" id="recibos">
                                <option value="">Selecciona una opcion</option>
                                @for ($i = 0; $i < count( $ultimosRecibos ); $i++)
                                    <option value="{{ $ultimosRecibos[$i]->id }}">
                                        {{
                                            \Str::ucfirst( \Carbon\Carbon::parse($ultimosRecibos[$i]->fecha_recibo)->translatedFormat('F') )
                                        }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col">
                            <button type="button" id="viewRecibo" class="btn btn-primary viewRecibo">
                                <i class="fas fa-binoculars"></i>
                                Visualizar
                            </button>
                            <button type="button" id="downloadRecibo" class="btn btn-primary downloadRecibo">
                                <i class="fas fa-download"></i>
                                Descargar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
