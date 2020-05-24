<div class="col-sm-6">
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item"><i class="fas fa-home returnZona"  style="cursor: pointer"></i></li>
        <li class="breadcrumb-item"><i class="fas fa-map-marker"></i> <a class="returnUnidad" style="cursor: pointer" data-zona-id="{{ $unidad->first()->Zonas()->first()->id }}">{{ $unidad->first()->Zonas()->first()->nombre }}</a></li>
        <li class="breadcrumb-item active"><i class="fas fa-city"></i> <a class="unidad" data-unidad-id="{{ $unidad->first()->id }}">{{ $unidad->first()->nombre }}</a></li>
    </ol>
</div><!-- /.col -->
<div class="col-sm-6">
    <div class="dropdown float-sm-right dropleft">
        <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-cogs"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item editUnidad" href="#">
                <i class="fas fa-pencil-alt"></i>
                Editar Unidad
            </a>
            <a class="dropdown-item deleteUnidad" href="#">
                <i class="fas fa-trash-alt"></i>
                Eliminar Unidad
            </a>
        </div>
    </div>
</div><!-- /.col -->
