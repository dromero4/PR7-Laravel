<?php

namespace App\Http\Controllers;

use App\Models\mailModel;


class passwordAfterMailController extends Controller
{
    public function passwordAfterMail()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['email']) && isset($_POST['token'])) {
                $correu = $_POST['email'];
                $token = $_POST['token'];
                $new_contrassenya = $_POST['contrassenyaReiniciada1'];
                $new_contrassenya2 = $_POST['contrassenyaReiniciada2'];

                if (mailModel::verificarToken($token, $correu)) {
                    if (mailModel::verificarContrassenya($new_contrassenya) && mailModel::verificarContrassenya($new_contrassenya2)) {
                        if ($new_contrassenya == $new_contrassenya2) {
                            if (mailModel::updatePassword($correu, $new_contrassenya)) {
                                session()->flash('success', 'Contrassenya canviada correctament.');
                                return redirect()->back(); // Redirige a la misma página
                            } else {
                                session()->flash('error', 'La contrassenya no s\'ha pogut recuperar...');
                                return redirect()->back(); // Redirige a la misma página
                            }
                        } else {
                            session()->flash('error', 'Les contrassenyes no coincideixen.');
                            return redirect()->back(); // Redirige a la misma página
                        }
                    } else {
                        session()->flash('error', '<br>La contrassenya ha de tenir:
                            <br>- Al menys 5 caràcters.
                            <br>- Al menys una lletra majuscula.
                            <br>- Al menys una lletra minúscula.
                            <br>- Al menys un numero.
                            <br>- Al menys un caràcter especial.');
                        return redirect()->back(); // Redirige a la misma página


                    }
                } else {
                    session()->flash('error', 'Token no vàlid');
                    return redirect()->back(); // Redirige a la misma página
                }
            }
        }
    }
}
