<div class="col">
    <div class="form-group">
        <label for="nombre">Nombre *:</label>
        <input type="text" class="form-control form-control-sm" id="nombre" placeholder="Nombre" value="{{ $menu->nombre }}">
        @csrf
    </div>
    <div class="form-group">
        <label for="icono">Icono *:</label>
        <input type="text" class="form-control form-control-sm" id="icono" placeholder="Icono" value="{{ $menu->icono }}">
    </div>
    <div class="form-group">
        <label for="modulo">Modulo *:</label>
        <select name="modulo" id="modulo" class="form-control form-control-sm">
            <option value="">Selecciona un modulo</option>
            @foreach( $modulos as $modulo )
                <option value="{{ $modulo->id }}" {{ $menu->admigas_cat_modulos_id == $modulo->id ? 'selected="selected"' : '' }} >{{ $modulo->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <small class="form-text text-muted"> <b>*Campos obligatorios.</b></small>
    </div>
    <div class="alert alert-danger print-error-msg" role="alert" style="display:none">
        <ul></ul>
    </div>
</div>
