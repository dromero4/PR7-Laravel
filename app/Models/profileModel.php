<?php

namespace App\Models;

use App\Models\usersModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class profileModel extends Model
{
    static function getImage($correu)
    {
        try {
            // Obtener la URL de la imagen de perfil desde la base de datos
            $imatge = usersModel::where('correu', $correu)->value('profile_img');

            // Si se encuentra la imagen, retornarla; de lo contrario, retornamos "Hola"
            return $imatge;
        } catch (\Exception $e) {
            // Manejo de errores
            echo $e->getMessage();
            return null;
        }
    }

    static function verificarUsuari($usuari)
    {
        try {
            // Verificar si existe un registro con el usuario dado
            return usersModel::where('username', $usuari)->exists();
        } catch (\Exception $e) {
            // Manejo de excepciones en caso de error
            throw new \Exception("Error al verificar el usuario: " . $e->getMessage());
        }
    }

    static function verificarImatge($imatge)
    {
        if (!filter_var($imatge, FILTER_VALIDATE_URL)) {
            return false;
        } else {
            return true;
        }
    }

    static function actualitzarUsuari($usuari, $correu, $correuActual, $fotoPerfil)
    {
        try {
            // Usamos una transacción para asegurar que ambas operaciones sean atómicas
            DB::transaction(function () use ($usuari, $correu, $correuActual, $fotoPerfil) {
                // Actualizar el usuario en la tabla `usuaris`
                usersModel::where('correu', $correuActual)
                    ->update([
                        'username' => $usuari,
                        'correu' => $correu,
                        'profile_img' => $fotoPerfil
                    ]);


                // Actualizar los artículos relacionados en la tabla `articles` usando el constructor de consultas
                DB::table('articles')
                    ->where('correu', $correuActual)
                    ->update(['correu' => $correu]);
            });

            return true; // Operación exitosa
        } catch (\Exception $e) {
            // Manejar errores y lanzar una excepción
            throw new \Exception("Error: " . $e->getMessage());
        }
    }
}
