<?php

namespace App\Models;

use App\Mail\PasswordResetMail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class usersModel extends Model
{
    // Desactiva els camps automàtics created_at i updated_at.
    public $timestamps = false;

    protected $table = 'users';
    protected $primaryKey = 'correu';
    public $incrementing = false;  // Si la clave primaria no es autoincrementable

    protected $fillable = [
        'correu',
        'username',
        'password',
        'token',
        'token_expires',
        'profile_img',
        'autenticacio',
        'admin',
        'API_Token',
    ];

    // Oculta les dades de la contrasenya en respostes JSON.
    protected $hidden = ['password'];




    static function verificarCompte($usuari, $contrasenya)
    {
        // Buscar el usuari por nombre de usuario (o correo, según cómo hagas login)
        $usuariTrobat = self::where('username', $usuari)->first();

        if ($usuariTrobat) {
            // Verificamos la contraseña hasheada usando Hash::check
            if (Hash::check($contrasenya, $usuariTrobat->password)) {
                return true;
            }
        }

        return false;
    }

    static function seleccionarCorreu($usuari)
    {
        try {
            // Buscar el usuario por el nombre de usuario (o el campo que uses)
            $usuariTrobat = self::where('username', $usuari)->first();


            // Verificar si el usuario fue encontrado
            if ($usuariTrobat) {
                // Retornar el correo del usuario encontrado
                return $usuariTrobat->getAttributes();
            } else {
                // En caso de no encontrar el usuario
                return null;
            }
        } catch (\Throwable $e) {
            // Manejo de excepciones
            dd("Error al seleccionar el correo: " . $e->getMessage());
            return null;
        }
    }

    static function verificarUsuari($usuari)
    {
        try {

            $usuariTrobat = self::where('username', $usuari)->first();
            if ($usuariTrobat) {
                return $usuariTrobat->correu;
            } else {
                return false;
            }
        } catch (\Throwable $e) {
            // Manejo de excepciones en caso de que falle la consulta
            throw new \Exception("Error al verificar el usuario: " . $e->getMessage());
        }
    }

    static function generarToken($correu)
    {
        $token = bin2hex(random_bytes(32));

        try {
            $user = self::where('correu', $correu)->first();
            if ($user) {
                $user->API_Token = $token;
                $user->save(); // Guardamos el token en la base de datos
                return $token; // Retornamos el token generado
            } else {
                return false; // Si no se encontró el usuario, devolvemos false
            }
        } catch (\Throwable $e) {
            echo "Error de base de datos: " . $e->getMessage();
            return false;
        }
    }

    static function verificarCorreu($correu)
    {
        try {

            $user = self::where('correu', $correu)->first();
            if ($user) {
                return true; // El correo ya existe
            } else {
                return false; // El correo no existe
            }
        } catch (\Throwable $e) {
            // Manejo de excepciones en caso de que falle la consulta
            throw new \Exception("Error al verificar el correo: " . $e->getMessage());
        }

        // try {
        //     $verificarCorreu = $connexio->prepare("SELECT * FROM usuaris WHERE correu = :correu");
        //     $verificarCorreu->bindParam(":correu", $correu);
        //     $verificarCorreu->execute();

        //     if ($verificarCorreu->rowCount() > 0) {
        //         return true;
        //     }
        // } catch (Error $e) {
        //     throw new Error($e->getMessage());
        // }
    }

    static function verificarContrassenya($contrassenya2)
    {
        $resultat = false;
        if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{5,}$/", $contrassenya2)) {
            $resultat = true;
        }


        return $resultat;
    }

    static function insertarUsuari($correu, $usuari, $contrassenyaHash, $imatgePerfil)
    {
        try {
            $user = new self();
            $user->correu = $correu;
            $user->username = $usuari;
            $user->password = $contrassenyaHash;
            $user->profile_img = $imatgePerfil;
            $user->save(); // Guardamos el nuevo usuario en la base de datos
            return true; // Retornamos true si se inserta correctamente
        } catch (\Throwable $e) {
            echo "Error al insertar el usuario: " . $e->getMessage();
            return false; // Retornamos false si hay un error
        }
    }
    static function getUserByEmail($correu)
    {
        try {
            return self::where('correu', $correu)->first();
        } catch (\Throwable $e) {
            throw new \Exception("Error al obtener el usuario por correo: " . $e->getMessage());
        }
    }


    static function verificarAdmin($correu)
    {
        try {
            $user = self::where('correu', $correu)->first();

            if ($user->admin == 1) {
                return true; // El usuario es admin
            } else {
                return false; // El usuario no es admin
            }
        } catch (\Throwable $e) {
            // Manejo de excepciones en caso de que falle la consulta
            throw new \Exception("Error al verificar el admin: " . $e->getMessage());
        }
    }

    static function enviarMail($correu)
    {

        try {
            // Genera el token y la fecha de expiración
            $token = bin2hex(random_bytes(16)); // Generar un token aleatorio
            $token_expires = Carbon::now()->addMinutes(30); // Fecha de expiración (30 minutos)

            // Busca al usuario por correo
            $user = self::where('correu', $correu)->first();

            // Si el usuario existe, asigna el token y la fecha de expiración
            if ($user) {
                $user->token = $token;
                $user->token_expires = $token_expires;
                $user->save(); // Guardamos los cambios en la base de datos
            }

            Mail::to($correu)->send(new PasswordResetMail($token, $correu));
        } catch (\Throwable $e) {
            throw new \Exception("Error: " . $e->getMessage());
        }
    }

    static function verificarCompteCorreu($correu, $contrassenya)
    {
        try {
            // Consulta para obtener el hash de la contraseña a partir del correo
            $user = self::where('correu', $correu)->first();
            if ($user) {
                $hash = $user->password;

                // Verificar la contraseña usando Hash::check
                if (Hash::check($contrassenya, $hash)) {
                    return true;
                }
            }
            return false;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    static function reiniciarPassword($correu, $contrassenya, $contrassenyaCanviar)
    {
        try {
            // Buscar el usuario por correo
            $usuari = self::where('correu', $correu)->first();

            if ($usuari) {
                // Verificar la contraseña actual
                if (Hash::check($contrassenya, $usuari->password)) {
                    // Crear el hash de la nueva contraseña
                    $contrassenyaHash = Hash::make($contrassenyaCanviar);

                    // Actualizar la contraseña en la base de datos
                    DB::table('users')
                        ->where('correu', $correu)
                        ->update(['password' => $contrassenyaHash]);

                    return true;
                }

                return false; // Contraseña actual incorrecta
            }

            return false; // Usuario no encontrado
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
