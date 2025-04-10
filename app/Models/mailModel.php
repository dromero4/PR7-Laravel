<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class mailModel extends Model
{
    //Funcio per veure si el correu coincideix amb la contrassenya
    static public function verificarCompteCorreu($correu, $contrassenya)
    {
        try {
            $user = usersModel::where('correu', $correu)->first();

            if ($user) {
                // Verificamos la contraseña hasheada usando Hash::check
                if (Hash::check($contrassenya, $user->password)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
            // $verificarContrassenya = $connexio->prepare("SELECT contrassenya FROM usuaris WHERE correu = :correu");
            // $verificarContrassenya->bindParam(":correu", $correu);
            // $verificarContrassenya->execute();

            // $resultat = $verificarContrassenya->fetch(PDO::FETCH_ASSOC);

            // if ($resultat) {
            //     $hash = $resultat['contrassenya'];

            //     //Funcio interna del php per poder verificar una contrassenya que sigui encriptada
            //     //password_verify NOMES FUNCIONA AMB password_hash();
            //     if (password_verify($contrassenya, $hash)) {
            //         return true;
            //     } else {
            //         return false;
            //     }
            // }
        } catch (\Throwable $e) {
            throw new \Throwable($e->getMessage());
        }
    }

    static function verificarContrassenya($contrassenya2)
    {
        $resultat = false;
        if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{5,}$/", $contrassenya2)) {
            $resultat = true;
        }


        return $resultat;
    }

    static public function reiniciarPassword($correu, $contrassenya, $contrassenyaCanviar)
    {
        try {
            // Busca al usuario por correo
            $user = usersModel::where('correu', $correu)->first();

            if ($user) {
                // Verifica que la contraseña actual sea correcta
                if (Hash::check($contrassenya, $user->contrassenya)) {
                    // Hashea la nueva contraseña
                    $user->contrassenya = Hash::make($contrassenyaCanviar);
                    // Guarda los cambios
                    $user->save();

                    return true;
                } else {
                    // Contraseña actual incorrecta
                    return false;
                }
            } else {
                // Usuario no encontrado
                return false;
            }
        } catch (\Exception $e) {
            // Lanza una excepción en caso de error
            throw new \Exception($e->getMessage());
        }
    }

    static public function verificarToken($token, $correu)
    {
        try {
            // Busca al usuario por correo
            $user = usersModel::where('correu', $correu)->first();

            if ($user) {
                // Verifica si el token coincide
                if ($user->token === $token) {
                    // Compara la fecha de expiración del token con la fecha actual
                    $expiracioToken = Carbon::parse($user->token_expires);
                    $dataActual = Carbon::now();

                    if ($expiracioToken->isAfter($dataActual)) {
                        return true; // Token válido
                    } else {
                        return false; // Token expirado
                    }
                } else {
                    return false; // Token no coincide
                }
            } else {
                return false; // Usuario no encontrado
            }
        } catch (\Exception $e) {
            // Lanza una excepción en caso de error
            throw new \Exception($e->getMessage());
        }
    }

    static public function updatePassword($correu, $new_password)
    {
        try {
            // Busca al usuario por su correo
            $user = usersModel::where('correu', $correu)->first();

            if ($user) {
                // Hashea la nueva contraseña
                $user->password = Hash::make($new_password);

                // Guarda los cambios en la base de datos
                if ($user->save()) {
                    return true;
                } else {
                    return false; // Hubo un problema al guardar
                }
            } else {
                return false; // Usuario no encontrado
            }
        } catch (\Exception $e) {
            // Lanza una excepción en caso de error
            throw new \Exception($e->getMessage());
        }
    }
}
