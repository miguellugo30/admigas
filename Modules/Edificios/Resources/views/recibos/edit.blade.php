<div class="row">
    <div class="col-6">
        <div class="form-group row">
            <label for="motivo" class="col-sm-5 col-form-label ">Motivo*:</label>
            <div class="col-sm-7">
                <input type="text" name="motivo" id="motivo" class="form-control form-control-sm">
                @csrf
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group row">
            <label for="lectura_actual" class="col-sm-5 col-form-label ">Lectura Actual*:</label>
            <div class="col-sm-7">
                <input type="text" name="lectura_actual" id="lectura_actual" class="form-control form-control-sm" value="{{ $recibo->lectura_actual }}">
            </div>
        </div>
    </div>
</div>
