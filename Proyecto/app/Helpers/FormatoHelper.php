<?php

namespace App\Helpers;

use Carbon\Carbon;

class FormatoHelper
{
    /**
     * Formatear fecha a DD/MM/YYYY
     */
    public static function formatearFecha($fecha)
    {
        if (!$fecha) {
            return '';
        }
        
        try {
            return Carbon::parse($fecha)->format('d/m/Y');
        } catch (\Exception $e) {
            return $fecha;
        }
    }

    /**
     * Format fecha y hora a DD/MM/YYYY HH:MM
     */
    public static function formatearFechaHora($fecha)
    {
        if (!$fecha) {
            return '';
        }
        
        try {
            return Carbon::parse($fecha)->format('d/m/Y H:i');
        } catch (\Exception $e) {
            return $fecha;
        }
    }

    /**
     * Formatear moneda a formato peruano S/. XX,XXX.XX
     */
    public static function formatearMoneda($monto)
    {
        if ($monto === null || $monto === '') {
            return 'S/. 0.00';
        }
        
        return 'S/. ' . number_format((float)$monto, 2, '.', ',');
    }

    /**
     * Formatear número con separadores de miles
     */
    public static function formatearNumero($numero, $decimales = 0)
    {
        if ($numero === null || $numero === '') {
            return '0';
        }
        
        return number_format((float)$numero, $decimales, '.', ',');
    }

    /**
     * Obtener badge HTML para estado
     */
    public static function badgeEstado($estado)
    {
        if ($estado === 'activo') {
            return '<span class="badge bg-success">Activo</span>';
        } else {
            return '<span class="badge bg-secondary">Inactivo</span>';
        }
    }

    /**
     * Calcular IGV (18%)
     */
    public static function calcularIGV($subtotal)
    {
        return (float)$subtotal * 0.18;
    }

    /**
     * Calcular total (subtotal + IGV)
     */
    public static function calcularTotal($subtotal)
    {
        $igv = static::calcularIGV($subtotal);
        return (float)$subtotal + $igv;
    }
}
