<div class="row">
    <div class="col mt-2 mb-2 text-right">
        <button type="button" class="btn btn-info btn-sm newTanque mt-1" alt="Nuevo Tanque">
            <i class="fas fa-tachometer-alt"></i>
        </button>
        <button type="button" class="btn btn-info btn-sm newEdificio mt-1" alt="Nueva Unidad">
            <i class="far fa-building"></i>
        </button>
    </div>
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
