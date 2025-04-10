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

    static public function obtenerArticulosPorUsuario($start, $articulosPorPagina, $correu, $orderBy)
    {
        $orderClause = self::generarOrdenSQL($orderBy);
        $articles = DB::table('articles')
            ->where('correu', $correu)
            ->orderByRaw($orderClause)
            ->offset($start)
            ->limit($articulosPorPagina)
            ->get();

        return $articles;
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
        // $orderClause = generarOrdenSQL($orderBy);
        // $query = $connexio->prepare("SELECT * FROM articles ORDER BY $orderClause LIMIT :start, :articulosPorPagina");
        // $query->bindValue(':start', $start, PDO::PARAM_INT);
        // $query->bindValue(':articulosPorPagina', $articulosPorPagina, PDO::PARAM_INT);
        // $query->execute();
        // return $query->fetchAll(PDO::FETCH_ASSOC);
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
