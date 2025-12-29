<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Factura;
use App\Models\Articulo;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\Cliente $user */
        $user = Auth::user();
        
        if ($user->isAdministrator()) {
            return $this->adminDashboard();
        }

        return $this->clientDashboard($user);
    }

    private function adminDashboard()
    {
        $stats = [
            'total_clientes' => Cliente::where('rol', 'client')->count(),
            'total_articulos' => Articulo::with('tipoArticulo')->count(),
            'total_facturas' => Factura::count(),
            'articulos_bajo_stock' => Articulo::where('stock', '<=', 10)->count(),
        ];

        $recent_facturas = Factura::with('cliente')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $articulos_bajo_stock = Articulo::with('tipoArticulo')
            ->where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'recent_facturas', 'articulos_bajo_stock'));
    }

    private function clientDashboard($user)
    {
        $stats = [
            'mis_facturas' => Factura::where('cod_cliente', $user->id)->count(),
            'total_gastado' => Factura::where('cod_cliente', $user->id)->sum('total_factura'),
        ];

        $recent_facturas = Factura::with('cliente')
            ->where('cod_cliente', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact('stats', 'recent_facturas'));
    }
}
