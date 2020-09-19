<?php

namespace Modules\Edificios\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartamentosRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'numero_departamento' => 'required',
            'numero_referencia' => 'required',
            'nombre' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'celular' => 'required|numeric|min:10',
            'correo_electronico' => 'required|email',
            'tipo' => 'required',
            'numero_serie' => 'required',
            'lectura' => 'required',
            'fecha_lectura' => 'required',
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
            'numero_departamento' => 'Numero de Departamento',
            'numero_referencia' => 'Numero de Referencia',
            'nombre' => 'Nombre',
            'apellido_paterno' => 'Apellido Paterno',
            'apellido_materno' => 'Apellido Materno',
            'celular' => 'Telefono',
            'correo_electronico' => 'Correo Electronico',
            'tipo' => 'Tipo',
            'numero_serie' => 'Numero de Serie',
            'lectura' => 'Lectura Inicial',
            'fecha_lectura' => 'Fecha Lectura Inicial',
        ];
    }
}
