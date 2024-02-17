<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ControllerProfile extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        try {
            $user->save();
        } catch (\Exception $e) {
            // Puedes imprimir el mensaje de error para depuración
            // dd($e->getMessage());
            return redirect()->route('profile.edit')->with('error', 'Error al actualizar el perfil.');
        }

        return redirect()->route('profile.edit')->with('success', 'Perfil actualizado exitosamente.');
    }
}








