<?php

namespace App\Http\Controllers;

use App\Models\paginationModel;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        if ($request->isMethod('post')) {
            // Obtener la entrada del formulario
            $query = $request->input('search-input');

            // Buscar resultados utilizando el modelo
            $resultados = paginationModel::searchBar($query);

            // Retornar la vista con los resultados
            return view('index', compact('resultados', 'query'));
        }

        // Si no es un POST, retornar la vista inicial (sin resultados)
        return view('index');
    }
}
