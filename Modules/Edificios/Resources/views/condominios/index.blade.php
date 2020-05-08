<div class="col mt-2 mb-2 text-right">
    <button type="button" class="btn btn-info btn-sm newTanque" alt="Nuevo Tanque">
        <i class="fas fa-tachometer-alt"></i>
    </button>
    <button type="button" class="btn btn-info btn-sm newEdificio" alt="Nueva Unidad">
        <i class="far fa-building"></i>
    </button>
</div>
<div class="col">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent" style="font-size: 0.8rem;margin-left: -25px;">
            <li class="breadcrumb-item returnZona">
                <a class="text-white-50" > / {{ $unidad->first()->Zonas()->first()->nombre }}</a>
            </li>
            <li class="breadcrumb-item returnUnidad">
                <a class="text-white-50" > / {{ $unidad->first()->nombre }}</a>
            </li>
        </ol>
    </nav>
</div>

<input type="hidden" name="admigas_zonas_id" id="admigas_zonas_id" value="{{ $unidad->first()->Zonas()->first()->id }}">
<input type="hidden" name="admigas_unidades_id" id="admigas_unidades_id" value="{{ $unidad->first()->id }}">
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-flat" data-widget="treeview" role="menu">
        @foreach ($edificios as $edificio)
            <li id="{{ $edificio->id }}" class="nav-item viewEdificio ">
                <a class="nav-link ">
                    <i class="far fa-building"></i>
                    <p>{{$edificio->nombre}}</p>
                </a>
            </li>
        @endforeach
    </ul>
</nav>
