<div class="form-group">
    <label for="exampleFormControlSelect1">Edificio</label>
    <select class="form-control form-control-sm" id="edificio_no_conciliado">
        <option value="">Selecciona una opcion</option>
        @foreach ($edificios as $edificio)
            <option value="{{ $edificio->id }}">{{ $edificio->nombre }}</option>
        @endforeach

    </select>
</div>
