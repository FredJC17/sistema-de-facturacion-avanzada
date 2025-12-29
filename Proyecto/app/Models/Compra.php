<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compra';

    protected $fillable = [
        'cod_articulo',
        'cantidad',
        'precio_compra',
        'precio_venta',
        'fecha_compra',
        'comprobante_path',
    ];

    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'cod_articulo');
    }
}
