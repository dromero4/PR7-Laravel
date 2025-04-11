<?php

namespace App\Http\Controllers;

use App\Models\profileModel;
use App\Models\usersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        // Inicializar variable para mensajes
        $missatges = [];

        if ($request->isMethod('post')) {
            // Obtener los datos enviados por el formulario
            $usuari = $request->input('usuariPerfil');
            $correu = $request->input('correuPerfil');
            $fotoPerfil = $request->input('imagen');  // Foto de perfil del formulario

            // Obtener datos actuales de la sesión
            $sessionUsuari = Session::get('usuari');
            $sessionCorreu = Session::get('correu');
            $sessionFoto = Session::get('fotoPerfil');

            // Variables para realizar actualizaciones
            $actualitzarUsuari = false;
            $actualitzarCorreu = false;
            $actualitzarFoto = false;

            // Verificar si el usuario ha cambiado
            if ($usuari && $usuari != $sessionUsuari) {
                if (profileModel::verificarUsuari($usuari)) {
                    $missatges[] = ""; // Usuario ya registrado
                    session()->flash('error', 'L\'usuari ja existeix');
                    return back();
                } else {
                    $actualitzarUsuari = true;
                }
            }

            // Verificar si el correo ha cambiado
            if ($correu && $correu != $sessionCorreu) {
                if (usersModel::verificarCorreu($correu)) {
                    session()->flash('error', 'El correu ja existeix');
                    return back();
                } else {
                    $actualitzarCorreu = true;
                }
            }

            // Verificar si la imagen ha cambiado
            if ($fotoPerfil && $fotoPerfil != $sessionFoto) {
                if (profileModel::verificarImatge($fotoPerfil)) {
                    $actualitzarFoto = true;
                } else {
                    session()->flash('error', 'La imatge no es vàlida');
                    return back();
                }
            } else {
                // Si no hay nueva imagen, mantener la foto actual
                $fotoPerfil = $sessionFoto;
            }

            // Comprobar si hay cambios para actualizar
            if ($actualitzarUsuari || $actualitzarCorreu || $actualitzarFoto) {
                if (profileModel::actualitzarUsuari($usuari, $correu, $sessionCorreu, $fotoPerfil)) {
                    // Actualizar datos en la sesión
                    Session::put('usuari', $usuari ?: $sessionUsuari);
                    Session::put('correu', $correu ?: $sessionCorreu);
                    Session::put('fotoPerfil', $fotoPerfil);

                    // Actualizar cookie si existe
                    if (Cookie::has('cookie_user')) {
                        Cookie::queue('cookie_user', $usuari, 43200); // 30 días de validez
                    }

                    // Mensaje de éxito
                    session()->flash('success', 'Perfil actualitzat correctament');
                    return back();
                } else {
                    session()->flash('error', 'No s\'ha pogut actualitzar el perfil');
                    return back();
                }
            } else {
                session()->flash('error', 'No s\'han realitzat canvis');
                return back();
            }
        }
    }
}
