<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    use HasFactory;

    protected $table = 'devolucion';

    protected $fillable = [
        'cod_detallefactura',
        'motivo',
        'fecha_devolucion',
        'cantidad',
    ];

    public function detalleFactura()
    {
        return $this->belongsTo(DetalleFactura::class, 'cod_detallefactura');
    }
}
