<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;

class paginationModel extends Model
{
    use HasFactory;

    static function obtenerTotalArticulos()
    {
        //$query = $connexio->query("SELECT COUNT(*) FROM articles");
        //return $query->fetchColumn();

        $totalArticulos = DB::table('articles')->count();

        return $totalArticulos;
    }

    static function obtenerTotalArticulosPorUsuario($correu)
    {
        //$query = $connexio->prepare("SELECT COUNT(*) FROM articles WHERE correu = :correu");
        //$query->bindParam(":correu", $correu);
        //$query->execute();
        //return $query->fetchColumn();

        $totalArticulosPorUsuario = DB::table('articles')->whereRaw("correu = ?", [$correu])->get()->count();

        return $totalArticulosPorUsuario;
    }

    static public function obtenerArticulosPorUsuario($articulosPorPagina, $correu, $orderBy)
    {

        if ($articulosPorPagina <= 0) {
            // Evitar división por cero
            $articulosPorPagina = 10; // o cualquier valor predeterminado
        }
        $fetch = DB::table('articles')
            ->where('correu', $correu)
            ->orderByRaw($orderBy)
            ->paginate($articulosPorPagina); //<----

        return $fetch;
    }

    static private function generarOrdenSQL($orderBy)
    {
        $ordenesValidos = [
            'dateAsc' => 'id ASC',
            'dateDesc' => 'id DESC',
            'AlphabeticallyAsc' => 'nom ASC',
            'AlphabeticallyDesc' => 'nom DESC'
        ];
        // Si el valor no es válido, usar 'id ASC' como predeterminado
        return $ordenesValidos[$orderBy] ?? 'id ASC';
    }



    static function obtenerArticulos($start, $articulosPorPagina, $orderBy)
    {
        // Asumiendo que generarOrdenSQL devuelve un string como 'titulo ASC' o 'fecha DESC'
        $order = explode(' ', self::generarOrdenSQL($orderBy)); // ['titulo', 'ASC']
        $columna = $order[0] ?? 'id';
        $direccion = $order[1] ?? 'ASC';

        return DB::table('articles')->orderBy($columna, $direccion)
            ->skip($start)
            ->take($articulosPorPagina)
            ->get()
            ->toArray();
    }

    static function searchBar($query)
    {
        $results = DB::table('articles')
            ->where('nom', 'LIKE', '%' . $query . '%')
            ->get();

        if ($results->isEmpty()) {
            return false;
        }

        return $results;
    }
}
