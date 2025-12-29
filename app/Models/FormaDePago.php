<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaDePago extends Model
{
    use HasFactory;

    protected $table = 'forma_de_pago';

    protected $fillable = [
        'descripcion_formapago',
        'estado',
    ];

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
