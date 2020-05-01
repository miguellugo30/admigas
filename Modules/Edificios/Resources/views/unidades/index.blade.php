<div class="row">
    <div class="col-10">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item returnZona">
                    <i class="fas fa-home text-white"></i>
                    <a class="text-white-50" >{{ $zona->first()->nombre }}</a>
                </li>
            </ol>
        </nav>
    </div>
    <div class="col-2 mt-2 mb-2 text-right">
        <button type="button" class="btn btn-info btn-sm newUnidad" alt="Nueva Unidad">
            <i class="fas fa-plus"></i>
        </button>
        <input type="hidden" name="admigas_zonas_id" id="admigas_zonas_id" value="{{ $zona->first()->id }}">
    </div>
</div>
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-flat" data-widget="treeview" role="menu">
        @foreach ($unidades as $unidad)
            <li id="{{ $unidad->id }}" class="nav-item viewUnidad ">
                <a class="nav-link ">
                    <i class="fas fa-city"></i>
                    <p>{{$unidad->nombre}}</p>
                </a>
            </li>
        @endforeach
    </ul>
</nav>
