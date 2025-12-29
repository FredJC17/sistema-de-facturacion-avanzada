<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'factura';

    protected $fillable = [
        'nro_factura',
        'cod_cliente',
        'fecha_emision',
        'fecha_facturacion',
        'subtotal',
        'igv',
        'total_factura',
        'estado',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cod_cliente');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleFactura::class, 'cod_factura');
    }

    public static function generateInvoiceNumber()
    {
        $lastInvoice = self::orderBy('id', 'desc')->first();
        $number = $lastInvoice ? intval(substr($lastInvoice->nro_factura, 4)) + 1 : 1;
        return 'FAC-' . str_pad($number, 8, '0', STR_PAD_LEFT);
    }

    public function calculateTotal()
    {
        $this->subtotal = $this->detalles()->sum('total');
        $this->igv = $this->subtotal * 0.18; // IGV 18%
        $this->total_factura = $this->subtotal + $this->igv;
        $this->save();
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
