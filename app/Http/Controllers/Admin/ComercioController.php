<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\Comercio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ComercioController extends Controller
{
    public function index()
    {
        $comercios = Comercio::with('user')->latest()->paginate(10);
        return view('admin.comercios.index', compact('comercios'));
    }

    public function create()
    {
        $usuarios = User::where('role', Role::Comerciante)
            ->whereDoesntHave('comercio')
            ->get();
        return view('admin.comercios.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'direccion'   => 'nullable|string|max:255',
            'telefono'    => 'nullable|string|max:20',
            'email'       => 'nullable|email|max:255',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            // Datos del nuevo usuario comerciante
            'user_name'   => 'required|string|max:255',
            'user_email'  => 'required|email|unique:users,email',
            'user_password' => 'required|string|min:8',
        ]);

        // Crear usuario comerciante
        $user = User::create([
            'name'     => $request->user_name,
            'email'    => $request->user_email,
            'password' => Hash::make($request->user_password),
            'role'     => Role::Comerciante,
        ]);

        // Subir logo si existe
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        Comercio::create([
            'user_id'     => $user->id,
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'direccion'   => $request->direccion,
            'telefono'    => $request->telefono,
            'email'       => $request->email,
            'logo'        => $logoPath,
            'activo'      => true,
        ]);

        return redirect()->route('admin.comercios.index')
            ->with('success', 'Comercio registrado correctamente.');
    }

    public function show(Comercio $comercio)
    {
        $comercio->load(['user', 'productos', 'pedidos']);
        return view('admin.comercios.show', compact('comercio'));
    }

    public function edit(Comercio $comercio)
    {
        return view('admin.comercios.edit', compact('comercio'));
    }

    public function update(Request $request, Comercio $comercio)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'direccion'   => 'nullable|string|max:255',
            'telefono'    => 'nullable|string|max:20',
            'email'       => 'nullable|email|max:255',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'activo'      => 'boolean',
        ]);

        $logoPath = $comercio->logo;
        if ($request->hasFile('logo')) {
            if ($logoPath) Storage::disk('public')->delete($logoPath);
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $comercio->update([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'direccion'   => $request->direccion,
            'telefono'    => $request->telefono,
            'email'       => $request->email,
            'logo'        => $logoPath,
            'activo'      => $request->boolean('activo'),
        ]);

        return redirect()->route('admin.comercios.index')
            ->with('success', 'Comercio actualizado correctamente.');
    }

    public function destroy(Comercio $comercio)
    {
        if ($comercio->logo) {
            Storage::disk('public')->delete($comercio->logo);
        }
        $comercio->delete();
        return redirect()->route('admin.comercios.index')
            ->with('success', 'Comercio eliminado correctamente.');
    }

    public function toggleActivo(Comercio $comercio)
    {
        $comercio->update(['activo' => !$comercio->activo]);
        $estado = $comercio->activo ? 'activado' : 'desactivado';
        return back()->with('success', "Comercio {$estado} correctamente.");
    }
}
