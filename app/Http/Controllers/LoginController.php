<?php

namespace App\Http\Controllers;

use App\Models\usersModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function handleLogin(Request $request)
    {

        include_once(base_path() . '/lib/claus_recaptcha/claus.php');
        require_once(app_path() . '/Models/usersModel.php');



        $usuari = $_POST['usuari'] ?? null;
        $contrassenya = $_POST['contrassenya'] ?? null;



        //$recaptcha_token = $request->input('g-recaptcha-response');

        if (isset($usuari)) {
            // Verificar si los campos de usuario y contraseña están vacíos
            if (!empty($usuari) && !empty($contrassenya)) {
                // Verificar las credenciales del usuario
                if (usersModel::verificarCompte($usuari, $contrassenya)) {
                    // Variables del usuario
                    Session::put('usuari', $usuari);
                    $resultatCorreu = usersModel::seleccionarCorreu($usuari);
                    if ($resultatCorreu == null) {
                        session()->flash('error', 'No s\'ha trobat l\'usuari');
                    } else {
                        Session::put('correu', $resultatCorreu['correu']);
                    }






                    //Generar i insertar l'api-token a la base de dades de l'usuari
                    $token_api = usersModel::generarToken(Session::get('correu'));



                    // Si las credenciales son correctas
                    session(['intents_recaptcha' => 0]); // Reseteamos el contador de intentos fallidos
                    Session::put('imatge_perfil', $resultatCorreu['profile_img']);

                    // Establecer el tiempo de expiración de la sesión a 40 minutos
                    $timeout_duration = 40 * 60;

                    // Verificar si hay una sesión activa
                    if (Session::get('LAST_ACTIVITY') !== null) {
                        // Calcular el tiempo transcurrido desde la última actividad
                        $elapsed_time = time() - Session::get('LAST_ACTIVITY');

                        // Si ha pasado más tiempo del límite establecido, cerrar la sesión
                        if ($elapsed_time > $timeout_duration) {
                            Session::flush(); // Elimina las variables de sesión
                            Session::invalidate(); // Destruye la sesión
                            return redirect('resources\views\login.blade.php');; // Redirige a la página de login
                            exit;
                        }
                    }

                    // Actualizar la última actividad
                    Session::put('LAST_ACTIVITY', time());



                    // Recordar al usuario (Remember Me)
                    $remember = $_POST['rememberMe'] ?? null;
                    if ($remember === 'on') {
                        // Si está marcado, guardar las cookies
                        setcookie('cookie_user', $usuari, time() + 60 * 60 * 24 * 30, "/"); // 1 mes
                        setcookie('cookie_password', $contrassenya, time() + 60 * 60 * 24 * 30, "/");
                    } else {
                        // Si no está marcado, eliminar las cookies
                        unset($_COOKIE['cookie_user']);
                        unset($_COOKIE['cookie_password']);
                    }

                    // Redirigir a la página principal si ya está logueado
                    if (isset($_SESSION['usuari'])) {
                        return redirect('/');
                    }
                    return view('index');
                } else {
                    // Si la contraseña es incorrecta
                    session()->flash('error', 'Contrasenya incorrecte');

                    // // Incrementar los intentos fallidos
                    // $_SESSION['intents_recaptcha'] = ($_SESSION['intents_recaptcha'] ?? 0) + 1;
                    // //dd($_SESSION['intents_recaptcha']);
                    // // Si hemos alcanzado 3 intentos fallidos, activar el reCAPTCHA
                    // if ($_SESSION['intents_recaptcha'] >= 3) {
                    //     $recaptcha_validat = $this->verificarRecaptcha($recaptcha_token);
                    //     if (!$recaptcha_validat) {
                    //         $missatges[] = "ReCAPTCHA no validat ";
                    //     } else {
                    //         $missatges[] = "ReCAPTCHA validat!";
                    //         $_SESSION['intents_recaptcha'] = 0; // Reiniciar el contador de intentos fallidos
                    //     }
                    // }
                }
            } else {
                // Si no se han rellenado los campos de usuario y contraseña
                session()->flash('error', 'Has d\'introduïr les dades');
            }


            return view('/login');
        }
    }

    // private function verificarRecaptcha($recaptcha_token)
    // {
    //     // Accede a la clave secreta desde el archivo de configuración
    //     $secret_key = config('services.recaptcha.secret_key.secret_key');

    //     // Hacer la petición a Google para verificar el token reCAPTCHA
    //     $respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret_key}&response={$recaptcha_token}");
    //     $json = json_decode($respuesta);

    //     return $json->success;
    // }


}
