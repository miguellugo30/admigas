<?php

namespace Modules\Configuracion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresasRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'razon_social' => 'required',
            'rfc' => 'required',
            'cuenta' => 'required',
            'clabe' => 'required',
            'convenio_cie' => 'required'
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
            'razon_social' => 'Razon Social',
            'rfc' => 'RFC',
            'cuenta' => 'Cuenta Bancaria',
            'clabe' => 'Clabe Interbancaria',
            'convenio_cie' => 'Convenio CIE'
        ];
    }
}
