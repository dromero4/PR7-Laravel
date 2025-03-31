<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class paginationModel extends Model
{
    use HasFactory;

    static function obtenerTotalArticulos()
    {
        //$query = $connexio->query("SELECT COUNT(*) FROM articles");
        //return $query->fetchColumn();

        $totalArticulos = DB::table('articles')->count();
    }

    function obtenerTotalArticulosPorUsuario($connexio, $correu)
    {
        $query = $connexio->prepare("SELECT COUNT(*) FROM articles WHERE correu = :correu");
        $query->bindParam(":correu", $correu);
        $query->execute();
        return $query->fetchColumn();
    }
}
