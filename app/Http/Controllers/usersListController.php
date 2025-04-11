<?php

namespace App\Http\Controllers;

use App\Models\articlesModel;
use App\Models\usersModel;
use Illuminate\Http\Request;

class usersListController extends Controller
{
    public function usersList(Request $request)
    {
        // Obtener la opción enviada por el formulario
        $opcio = $request->input('article-button');

        switch ($opcio) {
            case 'delete':
                $id = $request->input('id');
                if ($id) { // Si el ID no es nulo
                    if (articlesModel::eliminar($id)) { // Si existe y se elimina correctamente
                        session()->flash('success', 'Article eliminat correctament');
                        return back();
                    } else {
                        session()->flash('error', 'No s\'ha pogut eliminar l\'article');
                        return back();
                    }
                }
                break;

            case 'deleteUser':
                $correu = $request->input('article-button-mail');
                if ($correu) {
                    usersModel::deleteUser($correu);
                    session()->flash('success', 'L\'usuari s\'ha eliminat correctament');
                    return back();
                }
                session()->flash('error', 'No s\'ha pogut eliminar l\'usuari');
                return back();
                break;

            default:
                session()->flash('error', 'Acció no vàlida');
                return back();
        }
    }
}
