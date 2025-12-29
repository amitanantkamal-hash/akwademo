<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class registerController extends Controller
{
    public function store(Request $request)
    {
        dd($request);
        $request->validate([
            'phone' => 'required|numeric',
        ]);

        // Redirigir o devolver una respuesta
        return redirect()->back()->with('success', 'Número de teléfono guardado con éxito');
    }
}
