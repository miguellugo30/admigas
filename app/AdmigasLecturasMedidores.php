<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasLecturasMedidores extends Model
{
        /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'lectura', 'fecha_lectura', 'activo', 'admigas_departamentos_id', 'admigas_medidores_id',
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_lecturas_medidores';
    /**
     * Funcion para obtener solo los registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('activo', 1);
    }
    /*
    |--------------------------------------------------------------------------
    | RELACIONES DE BASE DE DATOS
    |--------------------------------------------------------------------------
    */
    /**
     * Relacion muchos a uno con medidores
     */
    public function Medidores()
    {
        return $this->belongsTo('App\AdmigasMedidores', 'admigas_medidores_id', 'id');
    }
    /**
     * Relacion uno a uno con departamentos
     */
    public function Departamentos()
    {
        return $this->belongsTo('App\AdmigasDepartamentos', 'admigas_departamentos_id', 'id');
    }
}
