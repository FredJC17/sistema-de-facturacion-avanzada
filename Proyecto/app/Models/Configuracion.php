<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table = 'configuraciones';

    protected $fillable = [
        'cod_usuario',
        'tema',
        'idioma',
    ];

    /**
     * Relación con el modelo Cliente (usuario)
     */
    public function usuario()
    {
        return $this->belongsTo(Cliente::class, 'cod_usuario');
    }

    /**
     * Obtener o crear configuración para un usuario
     */
    public static function obtenerOCrear($codUsuario)
    {
        return static::firstOrCreate(
            ['cod_usuario' => $codUsuario],
            ['tema' => 'claro', 'idioma' => 'es']
        );
    }

    /**
     * Cambiar tema del usuario
     */
    public function cambiarTema($nuevoTema)
    {
        $this->tema = $nuevoTema;
        return $this->save();
    }
}
