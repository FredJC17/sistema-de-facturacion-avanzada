<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormaDePago;

class FormaDePagoController extends Controller
{
    public function index(Request $request)
    {
        $query = FormaDePago::query();

        if ($request->filled('search')) {
            $query->where('descripcion_pago', 'like', "%{$request->search}%");
        }

        if ($request->filled('estado')) {
            if ($request->estado === 'activo') {
                $query->activos();
            } elseif ($request->estado === 'inactivo') {
                $query->inactivos();
            }
        } else {
            $query->activos();
        }

        $formasPago = $query->orderBy('descripcion_pago')->paginate(15)->withQueryString();
        
        return view('formas-pago.index', compact('formasPago'));
    }

    public function create()
    {
        return view('formas-pago.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion_pago' => 'required|string|max:50|unique:forma_de_pago,descripcion_pago',
        ]);

        $validated['estado'] = 'activo';

        FormaDePago::create($validated);

        return redirect()->route('formas-pago.index')->with('success', 'Forma de pago creada exitosamente.');
    }

    public function edit(FormaDePago $formasPago)
    {
        return view('formas-pago.edit', compact('formasPago'));
    }

    public function update(Request $request, FormaDePago $formasPago)
    {
        $validated = $request->validate([
            'descripcion_pago' => 'required|string|max:50|unique:forma_de_pago,descripcion_pago,' . $formasPago->id,
        ]);

        $formasPago->update($validated);

        return redirect()->route('formas-pago.index')->with('success', 'Forma de pago actualizada exitosamente.');
    }

    public function destroy(FormaDePago $formasPago)
    {
        $formasPago->desactivar();

        return redirect()->route('formas-pago.index')->with('success', 'Forma de pago desactivada exitosamente.');
    }

    public function activate(FormaDePago $formasPago)
    {
        $formasPago->activar();

        return redirect()->route('formas-pago.index')->with('success', 'Forma de pago activada exitosamente.');
    }
}
