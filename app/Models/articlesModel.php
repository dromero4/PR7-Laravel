<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB; // Importar el Query Builder
use PHPUnit\Event\Code\Throwable;

class articlesModel extends Model
{
    //Verifica si l'article que vols inserir no existeixi a la base de dades


    static public function verificarInsertar($model, $nom, $preu)
    {
        try {
            // Verificar si existe un artículo con los mismos valores
            $existe = DB::table('articles') // Indica la tabla 'articles'
                ->where('model', $model)
                ->where('nom', $nom)
                ->where('preu', $preu)
                ->exists(); // Verifica si existe al menos un registro

            return $existe; // Devuelve true si existe, false si no
        } catch (\Throwable $e) {
            // Lanza un error con el mensaje correspondiente
            throw new \Exception($e->getMessage());
        }
    }

    static function insertar($model, $nom, $preu, $correu)
    {
        try {
            // Inserción de datos en la tabla 'articles'
            $insertarArticle = DB::table('articles')->insert([
                'model' => $model,
                'nom' => $nom,
                'preu' => $preu,
                'correu' => $correu
            ]);

            // Obtener el último ID insertado
            $ultimID = DB::getPdo()->lastInsertId();

            return [$insertarArticle, $ultimID]; // Devuelve el resultado de la inserción y el último ID
        } catch (\Throwable $e) {
            // Manejo de errores
            throw new \Throwable($e->getMessage());
        }
        // try {
        //     $insertarArticle = $connexio->prepare("INSERT INTO articles (model, nom, preu, correu) VALUES(:model, :nom, :preu, :correu)");
        //     $insertarArticle->bindParam(":model", $model);
        //     $insertarArticle->bindParam(":nom", $nom);
        //     $insertarArticle->bindParam(":preu", $preu);
        //     $insertarArticle->bindParam(":correu", $correu);
        //     $insertarArticle->execute();

        //     $ultimID = $connexio->lastInsertId();
        //     echo "Inserit correctament! ID: $ultimID";
        // } catch (Error $e) {
        //     throw new Error($e->getMessage());
        // }
    }
}
