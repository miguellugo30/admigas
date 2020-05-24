<div class="row">
    <div class="col mt-2 mb-2 text-right">
        <button type="button" class="btn btn-info btn-sm newZona" alt="Nueva Zona">
            <i class="fas fa-plus"></i>
        </button>
    </div>
</div>
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-flat" data-widget="treeview" role="menu">
        @foreach ($zonas as $zona)
            <li id="{{ $zona->id }}" class="nav-item viewZonas context-zona">
                <a class="nav-link ">
                    <i class="fas fa-map-marker "></i>
                    <p>{{$zona->nombre}}</p>
                </a>
            </li>
        @endforeach
    </ul>
</nav>
