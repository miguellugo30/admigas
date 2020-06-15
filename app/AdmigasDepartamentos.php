<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasDepartamentos extends Model
{
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'numero_departamento', 'numero_referencia', 'factor', 'descuento', 'fecha_lectura', 'suministro', 'admigas_condominios_id',
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_departamentos';
    /**
     * Funcion para obtener solo los registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('activo', 1);
    }
    /**
     * Funcion para obtener solo los registros activos
     */
    public function scopeCondominio($query, $condominio_id)
    {
        return $query->where('admigas_condominios_id', $condominio_id );
    }
    /*
    |--------------------------------------------------------------------------
    | RELACIONES DE BASE DE DATOS
    |--------------------------------------------------------------------------
    */
    /**
     * Relacion muchos a uno con unidad
     */
    public function Condominios()
    {
        return $this->belongsTo('App\AdmigasEdificios', 'admigas_condominios_id', 'id');
    }
    /**
     * Relacion uno a uno con Contacto Departamento
     */
    public function Contacto_Depto()
    {
        return $this->hasOne('App\AdmigasContactoDepartamentos', 'admigas_departamentos_id', 'id');
    }
    /**
     * Relacion uno a uno con Medidores
     */
    public function Medidores()
    {
        return $this->hasOne('App\AdmigasMedidores', 'admigas_departamentos_id', 'id');
    }
    /**
     * Relacion uno a muchos con lecturas medidores
     */
    public function Lectura()
    {
        return $this->hasMany('App\AdmigasLecturasMedidores', 'admigas_departamentos_id', 'id');
    }
    /**
     * Relacion uno a uno con Saldos
     */
    public function Saldo()
    {
        return $this->hasOne('App\AdmigasSaldos', 'admigas_departamentos_id', 'id');
    }
    /**
     * Relacion uno a muchos con recibos
     */
    public function Recibos()
    {
        return $this->hasMany('App\AdmigasRecibos', 'admigas_departamentos_id', 'id');
    }
    /**
     * Relacion uno a muchos con cargos adicionales
     */
    public function CargosAdicionales()
    {
        return $this->hasMany('App\AdmigasCargosAdicionales', 'admigas_departamentos_id', 'id');
    }
}
