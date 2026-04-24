<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasMenus extends Model
{
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'nombre', 'url', 'icono', 'permiso', 'admigas_cat_modulos_id',
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_menus';
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
    public function Modulos()
    {
        return $this->hasMany('App\AdmigasCatModulos', 'id', 'admigas_cat_modulos_id');
    }
}
