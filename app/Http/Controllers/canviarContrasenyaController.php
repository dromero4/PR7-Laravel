<?php

namespace App\Http\Controllers;

use App\Models\usersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class canviarContrasenyaController extends Controller
{
    public function canviarContrasenya()
    {
        $contrassenyaCanviar = $_POST['contrassenyaCanviar'] ?? null;
        $contrassenya = $_POST['contrassenya'] ?? null;


        if (!empty($contrassenya) && !empty($contrassenyaCanviar)) {

            if (usersModel::verificarCompteCorreu(Session::get('correu'), $contrassenya)) {

                if (usersModel::verificarContrassenya($contrassenyaCanviar)) {

                    if (usersModel::reiniciarPassword(Session::get('correu'), $contrassenya, $contrassenyaCanviar)) {

                        session()->flash('success', 'Contrasenya canviada correctament.');
                        return redirect()->back();
                    } else {

                        session()->flash('error', 'No s\'ha pogut canviar la contrasenya');
                        return redirect()->back();
                    }
                } else {

                    session()->flash('error', 'La contrasenya no és vàlida<br>
                            Ha de tenir com a minim:
                                - 5 caràcters
                                - Una lletra majuscula
                                - Una lletra minuscula
                                - Un numero
                                - Un caràcter especial');
                    return redirect()->back();
                }
            } else {

                session()->flash('error', 'Contrasenya incorrecte');
                return redirect()->back();
            }
        } else {

            session()->flash('error', 'Has d\'omplir els camps');
            return redirect()->back();
        }
    }
}
