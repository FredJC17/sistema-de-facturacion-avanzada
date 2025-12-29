<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('tipo_documento')->insert([
            ['descripcion' => 'DNI', 'created_at' => now(), 'updated_at' => now()],
            ['descripcion' => 'RUC', 'created_at' => now(), 'updated_at' => now()],
            ['descripcion' => 'Pasaporte', 'created_at' => now(), 'updated_at' => now()],
            ['descripcion' => 'Carnet Extranjeria', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('ciudad')->insert([
            ['codigo_ciudad' => 1, 'nombre' => 'Lima', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_ciudad' => 2, 'nombre' => 'Arequipa', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_ciudad' => 3, 'nombre' => 'Cusco', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_ciudad' => 4, 'nombre' => 'Trujillo', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_ciudad' => 5, 'nombre' => 'Chiclayo', 'created_at' => now(), 'updated_at' => now()],
            ['codigo_ciudad' => 6, 'nombre' => 'Piura', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('forma_de_pago')->insert([
            ['descripcion_formapago' => 'Efectivo', 'created_at' => now(), 'updated_at' => now()],
            ['descripcion_formapago' => 'Tarjeta', 'created_at' => now(), 'updated_at' => now()],
            ['descripcion_formapago' => 'Transferencia', 'created_at' => now(), 'updated_at' => now()],
            ['descripcion_formapago' => 'Yape/Plin', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('tipo_articulo')->insert([
            ['descripcion_articulo' => 'Electrónica', 'created_at' => now(), 'updated_at' => now()],
            ['descripcion_articulo' => 'Ropa', 'created_at' => now(), 'updated_at' => now()],
            ['descripcion_articulo' => 'Alimentos', 'created_at' => now(), 'updated_at' => now()],
            ['descripcion_articulo' => 'Hogar', 'created_at' => now(), 'updated_at' => now()],
            ['descripcion_articulo' => 'Deportes', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('cliente')->insert([
            'documento' => '12345678',
            'cod_tipo_documento' => 1,
            'nombre' => 'Admin',
            'apellido' => 'Sistema',
            'direccion' => 'Av. Principal 123',
            'cod_ciudad' => 1,
            'telefono' => '999888777',
            'email' => 'admin@sistema.com',
            'password' => Hash::make('admin123'),
            'rol' => 'administrator',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('cliente')->insert([
            'documento' => '87654321',
            'cod_tipo_documento' => 1,
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'direccion' => 'Calle Los Olivos 456',
            'cod_ciudad' => 1,
            'telefono' => '987654321',
            'email' => 'juan@email.com',
            'password' => Hash::make('cliente123'),
            'rol' => 'client',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('proveedor')->insert([
            [
                'nro_documento' => '20123456789',
                'cod_tipo_documento' => 2,
                'nombre' => 'Distribuidora',
                'apellido' => 'Tech SAC',
                'cod_ciudad' => 1,
                'direccion' => 'Av. Industrial 100',
                'telefono' => '014567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nro_documento' => '20987654321',
                'cod_tipo_documento' => 2,
                'nombre' => 'Comercial',
                'apellido' => 'Perú EIRL',
                'cod_ciudad' => 2,
                'direccion' => 'Jr. Comercio 200',
                'telefono' => '054123456',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('articulo')->insert([
            [
                'descripcion' => 'Laptop HP 15"',
                'precio_venta' => 2500,
                'precio_costo' => 2000,
                'stock' => 10,
                'cod_proveedor' => 1,
                'cod_tipo_articulo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Mouse Inalámbrico Logitech',
                'precio_venta' => 50,
                'precio_costo' => 35,
                'stock' => 50,
                'cod_proveedor' => 1,
                'cod_tipo_articulo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Teclado Mecánico RGB',
                'precio_venta' => 150,
                'precio_costo' => 100,
                'stock' => 25,
                'cod_proveedor' => 1,
                'cod_tipo_articulo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
