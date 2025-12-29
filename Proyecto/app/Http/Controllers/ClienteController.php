<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\TipoDocumento;
use App\Models\Ciudad;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::with(['tipoDocumento', 'ciudad']);

        // Filter: Clients and Administrators (all)
        $query->whereIn('rol', ['client', 'administrator']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido', 'like', "%{$search}%")
                  ->orWhere('documento', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Sorting functionality
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');

        // Always put inactive items at the bottom
        $query->orderByRaw("CASE WHEN estado = 'inactivo' THEN 1 ELSE 0 END ASC");

        switch ($sortBy) {
            case 'compras_monto':
                $query->withSum('facturas as total_compras', 'total_factura')
                      ->orderBy('total_compras', $sortOrder);
                break;
            case 'actividad':
                $query->withCount('facturas')
                      ->orderBy('facturas_count', $sortOrder);
                break;
            case 'nombre':
                $query->orderBy('nombre', $sortOrder);
                break;
            default:
                $query->orderBy('id', $sortOrder);
        }

        $clientes = $query->paginate(10)->withQueryString();

        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        $tiposDocumento = TipoDocumento::all();
        $ciudades = Ciudad::all();
        return view('clientes.create', compact('tiposDocumento', 'ciudades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'documento' => 'required|string|max:15|unique:cliente,documento',
            'cod_tipo_documento' => 'required|exists:tipo_documento,id',
            'nombre' => 'required|string|max:30',
            'apellido' => 'required|string|max:30',
            'direccion' => 'nullable|string|max:20',
            'cod_ciudad' => 'required|exists:ciudad,id',
            'telefono' => 'nullable|string|max:15',
            'email' => 'required|email|unique:cliente,email',
            'password' => 'required|min:6',
            'rol' => 'required|in:administrator,client',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Cliente::create($validated);

        return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente.');
    }

    public function edit(Cliente $cliente)
    {
        $tiposDocumento = TipoDocumento::all();
        $ciudades = Ciudad::all();
        return view('clientes.edit', compact('cliente', 'tiposDocumento', 'ciudades'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'documento' => 'required|string|max:15|unique:cliente,documento,' . $cliente->id,
            'cod_tipo_documento' => 'required|exists:tipo_documento,id',
            'nombre' => 'required|string|max:30',
            'apellido' => 'required|string|max:30',
            'direccion' => 'nullable|string|max:20',
            'cod_ciudad' => 'required|exists:ciudad,id',
            'telefono' => 'nullable|string|max:15',
            'email' => 'required|email|unique:cliente,email,' . $cliente->id,
            'rol' => 'required|in:administrator,client',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $cliente->update($validated);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado permanentemente.');
    }

    public function activate(Cliente $cliente)
    {
        $cliente->activar();
        return redirect()->route('clientes.index')->with('success', 'Cliente activado exitosamente.');
    }
}
