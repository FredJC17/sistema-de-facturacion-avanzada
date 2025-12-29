<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedor';

    protected $fillable = [
        'nro_documento',
        'cod_tipo_documento',
        'nombre',
        'apellido',
        'cod_ciudad',
        'direccion',
        'telefono',
        'estado',
    ];

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'cod_tipo_documento');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'cod_ciudad');
    }

    public function articulos()
    {
        return $this->hasMany(Articulo::class, 'cod_proveedor');
    }

    public function getNombreCompleto()
    {
        return $this->nombre . ' ' . $this->apellido;
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
