<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmigasRecibos extends Model
{
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
                                'clave_recibo',
                                'unidad',
                                'condominio',
                                'numero_departamento',
                                'calle',
                                'numero_exterior',
                                'numero_interior',
                                'colonia',
                                'delegacion',
                                'cp',
                                'calle',
                                'telefono',
                                'fecha_recibo',
                                'fecha_lectura_anterior',
                                'lectura_anterior',
                                'fecha_lectura_actual',
                                'lectura_actual',
                                'fecha_limite_pago',
                                'precio_litro',
                                'importe',
                                'gasto_admin',
                                'adeudo_anterior',
                                'cargos_adicionales',
                                'total_pagar',
                                'referencia',
                                'motivo_cancelacion',
                                'admigas_departamentos_id',
                                'admigas_condominos_id',

                            ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'admigas_recibos';
    /**
     * Funcion para obtener solo los de un departamento
     */
    public function scopeDepartamento($query, $departamento_id)
    {
        return $query->where('admigas_departamentos_id', $departamento_id );
    }
    /**
     * Funcion para obtener solo los registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('activo', 1 );
    }
    /*
    |--------------------------------------------------------------------------
    | RELACIONES DE BASE DE DATOS
    |--------------------------------------------------------------------------
    */
    /**
     * Relacion uno a uno con Departamentos
     */
    public function Departamento()
    {
        return $this->belongsTo('App\AdmigasDepartamentos', 'admigas_departamentos_id', 'id');
    }
    /**
     * Relacion muchos a uno con unidad
     */
    public function Condominios()
    {
        return $this->belongsTo('App\AdmigasEdificios', 'admigas_condominios_id', 'id');
    }
     /**
     * Relacion uno a muchos con cargos recios
     */
    public function CargosRecibos()
    {
        return $this->belongsToMany('App\AdmigasCargosAdicionales', 'admigas_cargos_recibos');
    }

}
