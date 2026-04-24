<?php

namespace Modules\Edificios\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EdificiosRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tipo' => 'required',
            'nombre' => 'required',
            'descuento' => 'required',
            'factor' => 'required',
            'gasto_admin' => 'required',
            'fecha_lectura' => 'required|date',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return[
            'tipo' => 'Tipo',
            'nombre' => 'Nombre',
            'descuento' => 'Descuento',
            'factor' => 'Factor de Conversion',
            'gasto_admin' => 'Gasto de Administracion',
            'fecha_lectura' => 'Fecha de Lectura',
        ];
    }
}
