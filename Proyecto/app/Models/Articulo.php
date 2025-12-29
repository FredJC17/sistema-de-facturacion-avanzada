<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;

    protected $table = 'articulo';

    protected $fillable = [
        'descripcion',
        'precio_venta',
        'precio_costo',
        'stock',
        'cod_proveedor',
        'cod_tipo_articulo',
        'estado',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'cod_proveedor');
    }

    public function tipoArticulo()
    {
        return $this->belongsTo(TipoArticulo::class, 'cod_tipo_articulo');
    }

    public function detalleFacturas()
    {
        return $this->hasMany(DetalleFactura::class, 'cod_articulo');
    }

    public function updateStock($quantity)
    {
        $this->stock += $quantity;
        $this->save();
    }

    public function hasStock($quantity)
    {
        return $this->stock >= $quantity;
    }

    public function reduceStock($quantity)
    {
        if ($this->hasStock($quantity)) {
            $this->stock -= $quantity;
            $this->save();
            return true;
        }
        return false;
    }

    public function increaseStock($quantity)
    {
        $this->stock += $quantity;
        $this->save();
    }

    public function isLowStock($threshold = 10)
    {
        return $this->stock <= $threshold;
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
