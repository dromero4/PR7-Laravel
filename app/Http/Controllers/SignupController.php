<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\usersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SignupController extends Controller
{
    public function handleSignup(Request $request)
    {
        // Validar los datos del formulario utilizando el sistema de validación de Laravel
        $validator = Validator::make($request->all(), [
            'usuari' => 'required|max:20|unique:users,username',
            'correu' => 'required|email|max:40|unique:users,correu',
            'contrassenya' => 'required|min:5|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[@$!%*?&]/', // Contraseña con reglas
            'contrassenya2' => 'required|same:contrassenya', // Confirmar contraseña
        ]);

        // Si la validación falla, devolver los errores al formulario
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Recuperar los datos del formulario
        $usuari = $request->input('usuari');
        $correu = $request->input('correu');
        $contrassenya = $request->input('contrassenya');
        $contrassenya2 = $request->input('contrassenya2');
        $imatgePerfil = $request->input('imagenPerfil'); // Asumiendo que la imagen es parte del formulario

        // Encriptar la contraseña
        $contrassenyaHash = Hash::make($contrassenya);


        // Insertar el nuevo usuario en la base de datos
        try {
            $user = usersModel::create([

                'correu' => $correu,
                'username' => $usuari,
                'password' => $contrassenyaHash,
                'token' => null,
                'token_expires' => null,
                'profile_img' => $imatgePerfil ?? null, // Si la imagen está presente en el formulario

                'autenticacio' => null,
                'admin' => $usuari === 'admin' ? '1' : '0', // Asignar admin si el nombre de usuario es 'admin'
                'API_Token' => null
            ]);

            if ($user) {
                session()->flash('success', 'Usuari creat correctament!');
                return redirect('/login'); // Redirigir a la página de login o donde quieras
            }
        } catch (\Exception $e) {
            // En caso de error
            dd($e->getMessage());
            session()->flash('error', 'No s\'ha pogut crear l\'usuari. Intenta-ho de nou.');
            return back();
        }
    }
}
