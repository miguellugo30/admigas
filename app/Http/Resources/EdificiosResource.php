<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EdificiosResource extends JsonResource
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
            'nombre' => $this->nombre,
            'factor' => $this->factor,
            'unidad' => new UnidadesResource($this->Unidades),
            'departamentos' => DepartamentosResource::collection($this->Departamentos)
        ];
    }
}
