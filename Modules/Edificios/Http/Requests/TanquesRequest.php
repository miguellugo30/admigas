<?php

namespace Modules\Edificios\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TanquesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'num_serie' => 'required',
            'estado_al_recibir' => 'required',
            'capacidad' => 'required',
            'fecha_fabricacion' => 'required',
            'inventario' => 'required',
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
            'num_serie' => 'Numero de Serie',
            'estado_al_recibir' => 'Porcentaje Inicial',
            'fecha_fabricacion' => 'Fecha de Fabricación',
            'capacidad' => 'Capacidad',
            'inventario' => 'Inventario',
        ];
    }
}
