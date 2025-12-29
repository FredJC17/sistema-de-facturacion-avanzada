<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    use HasFactory;

    protected $table = 'detalle_factura';

    protected $fillable = [
        'cod_factura',
        'cod_articulo',
        'cantidad',
        'total',
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'cod_factura');
    }

    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'cod_articulo');
    }

    public function devoluciones()
    {
        return $this->hasMany(Devolucion::class, 'cod_detallefactura');
    }

    public function calculateLineTotal()
    {
        $articulo = $this->articulo;
        if ($articulo) {
            $this->total = $articulo->precio_venta * $this->cantidad;
            $this->save();
        }
    }
}
