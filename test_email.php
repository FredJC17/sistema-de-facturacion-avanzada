<?php

use Illuminate\Support\Facades\Mail;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Intentando enviar correo de prueba...\n";

try {
    Mail::raw('Este es un correo de prueba de SFA', function ($message) {
        $message->to('prueba@ejemplo.com')
                ->subject('Prueba de Conexión SMTP');
    });
    
    echo "¡ÉXITO! El correo se envió correctamente a Mailtrap.\n";
    echo "Revisa tu inbox ahora.\n";
} catch (\Exception $e) {
    echo "¡ERROR! No se pudo enviar el correo.\n";
    echo "Mensaje de error: " . $e->getMessage() . "\n";
    echo "Detalles: \n";
    echo $e->getTraceAsString();
}
