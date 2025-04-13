<?php

namespace App\Http\Controllers;

use App\Models\paginationModel;
use App\Models\usersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ArticuloController extends Controller
{
    public function index(Request $request)
    {
        // Valores por defecto o desde el formulario
        $pagina = $request->query('page', 1);
        $articulosPorPagina = $request->query('post_per_page', 5);
        $orderBy = $request->query('orderBy', 'dateDesc');
        $correu = Session::get('correu'); // Asegúrate de que esto esté en sesión

        $start = ($pagina - 1) * $articulosPorPagina;

        $articles = paginationModel::obtenerArticulosPorUsuario($start, $articulosPorPagina, $correu, $orderBy);

        // Total de artículos para paginar
        $total = paginationModel::obtenerTotalArticulosPorUsuario($correu);
        $pages = ceil($total / $articulosPorPagina);

        return view('index', compact('articles', 'pagina', 'pages', 'orderBy', 'articulosPorPagina'));
    }
}
