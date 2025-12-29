use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

Schema::create('compra', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('cod_articulo');
    $table->integer('cantidad');
    $table->decimal('precio_compra', 10, 2);
    $table->decimal('precio_venta', 10, 2)->nullable();
    $table->date('fecha_compra');
    $table->string('comprobante_path')->nullable();
    $table->timestamps();
    
    $table->foreign('cod_articulo')->references('id')->on('articulo')->onDelete('cascade');
});

echo "Table 'compra' created successfully\n";
