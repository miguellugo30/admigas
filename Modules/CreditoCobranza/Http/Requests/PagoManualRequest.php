<?php

namespace Modules\CreditoCobranza\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagoManualRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'archivoConciliar' => 'required',
            'importe' => 'required|numeric',
            'fecha' => 'required|date',
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
}
