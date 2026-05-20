<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartamentosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'num_depto' => $this->numero_departamento,
            'num_referencia' => $this->numero_referencia,
            'contacto' => new ContactoDepartamentosResource($this->Contacto_Depto),
            'lectura' => LecturasDepartamentosResource::collection($this->Lectura->sortByDesc('id'))->first(),
        ];
    }
}
