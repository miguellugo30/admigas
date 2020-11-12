<?php

namespace Modules\CreditoCobranza\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class conciliacionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'archivoConciliar' => 'required|mimes:txt',
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
