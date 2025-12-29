<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Cliente extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'cliente';

    protected $fillable = [
        'documento',
        'cod_tipo_documento',
        'nombre',
        'apellido',
        'direccion',
        'cod_ciudad',
        'telefono',
        'email',
        'password',
        'rol',
        'estado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'cod_tipo_documento');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'cod_ciudad');
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'cod_cliente');
    }

    public function configuracion()
    {
        return $this->hasOne(Configuracion::class, 'cod_usuario');
    }

    // Scopes para roles
    public function scopeAdministrators($query)
    {
        return $query->where('rol', 'administrator');
    }

    public function scopeClients($query)
    {
        return $query->where('rol', 'client');
    }

    public function isAdministrator()
    {
        return $this->rol === 'administrator';
    }

    public function isClient()
    {
        return $this->rol === 'client';
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
