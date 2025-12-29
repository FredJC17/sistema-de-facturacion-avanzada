<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoArticulo extends Model
{
    use HasFactory;

    protected $table = 'tipo_articulo';

    protected $fillable = [
        'descripcion_articulo',
        'estado',
    ];

    public function articulos()
    {
        return $this->hasMany(Articulo::class, 'cod_tipo_articulo');
    }

    // Scopes para estado
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopeInactivos($query)
    {
        return $query->where('estado', 'inactivo');
    }

    // Métodos para gestionar estado
    public function desactivar()
    {
        $this->estado = 'inactivo';
        return $this->save();
    }

    public function activar()
    {
        $this->estado = 'activo';
        return $this->save();
    }

    public function estaActivo()
    {
        return $this->estado === 'activo';
    }
}
