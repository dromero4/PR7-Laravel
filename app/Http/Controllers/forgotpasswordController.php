<?php

namespace App\Http\Controllers;

use App\Models\usersModel;
use Illuminate\Http\Request;

class forgotpasswordController extends Controller
{
    function forgotPassword(Request $request)
    {
        $correu = $_POST['correu'] ?? null;


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (!empty($correu)) {
                if (usersModel::verificarCorreu($correu)) {
                    if (usersModel::enviarMail($correu)) {
                        session()->flash('error', 'Error al enviar el correu');
                        return redirect()->back(); // Redirige a la misma página
                    } else {

                        session()->flash('success', 'Verifica el teu correu: T\'hem enviat un ellaç perquè puguis reestablir la teva contrassenya...');
                        return redirect()->back(); // Redirige a la misma página
                    }
                } else {

                    session()->flash('error', 'El correu no existeix');
                    return redirect()->back(); // Redirige a la misma página
                }
            } else {

                session()->flash('error', 'Has d\'omplir el correu');
                return redirect()->back(); // Redirige a la misma página
            }
        } else {
            session()->flash('error', 'Hi ha hagut un error al enviar el formulari');
            return redirect()->back(); // Redirige a la misma página
        }
    }
}
