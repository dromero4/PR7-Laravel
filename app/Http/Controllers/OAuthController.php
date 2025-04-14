<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\usersModel;
use Illuminate\Foundation\Auth\User as AuthUser;

class OAuthController extends Controller
{
    public function redirectToGitHub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGitHubCallback()
    {
        try {
            // Obtener el usuario de GitHub
            $githubUser = Socialite::driver('github')->user();

            // Crear o actualizar el usuario
            $user = usersModel::updateOrCreate(
                ['github_id' => $githubUser->getId()],
                [
                    'username' => $githubUser->getName(),
                    'correu' => $githubUser->getEmail(),
                    'autentiacio' => 'github', // Aquí estamos estableciendo el valor del campo 'autentiacio'
                    'password' => bcrypt(uniqid()) // No es necesario, pero puede ser necesario para completar el registro
                ]
            );

            // Iniciar sesión con el usuario
            Auth::login($user);

            // Redirigir al usuario después de login
            return redirect()->intended('/home'); // O la página a la que desees redirigir

        } catch (\Exception $e) {
            // Si hay algún error, redirigir al login
            return redirect()->route('login');
        }
    }
}
