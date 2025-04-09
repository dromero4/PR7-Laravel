<?php

namespace App\Http\Controllers;

use App\Models\articlesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class insertarController extends Controller
{
    function insertar(Request $request)
    {
        $crudSubmit = $_POST['Enviar'] ?? null; //Funcio per seleccionar depenent del que hagi triat l'usuari (ediar, inserir...)

        //Insertar
        $model = $_POST['model'] ?? null;
        $nom = $_POST['nom'] ?? null;
        $preu = $_POST['preu'] ?? null;



        //A l'hora de l'usuari (un cop logat) vol fer qualsevol cosa, aqui la controlem.
        switch ($crudSubmit) {
            case 'Insertar': //En cas d'insertar



                if (articlesModel::verificarInsertar($model, $nom, $preu)) { //Aqui verifiquem si el model que hem inserit ja existeix a la base de dades
                    echo "if 1";
                    session()->flash('error', 'Aquest producte ja existeix');
                    return redirect()->back(); // Redirige a la misma página
                } else {
                    if (!empty($model) && !empty($nom) && !empty($preu)) {
                        echo "else 1";
                        $results[] = articlesModel::insertar($model, $nom, $preu, Session::get('correu')); //Amb el correu de la persona logada que l'hagi inserit
                        session()->flash('success', 'Insertat correctament');
                        return redirect()->back(); // Redirige a la misma página
                    } else {
                        echo "else 2";
                        session()->flash('error', 'Has d\'omplir tots els camps');
                        return redirect()->back(); // Redirige a la misma página
                    }
                }

                echo "fuera";

                break;
            //En cas de voler modificar
            case 'Modificar':
                include_once '../vista/modificar.php';
                if ($id) {
                    if (verificarID($id, $connexio)) { //verifiquem que l'id de l'article que vol verificar no sigui buit
                        if (isset($_SESSION['usuari'])) { //En cas d'estar logat, només deixarà modificar l'article creat per aquest mateix usuari
                            modificar($model, $nom, $preu, $id, getCorreuByID($id, $connexio), $connexio);
                        }
                    } else {
                        $missatges[] = "No s'ha trobat l'ID $id";
                    }
                } else {
                    $missatges[] = "Has d'inserir l'ID";
                }

                break;
            case 'Eliminar':
                include_once '../vista/eliminar.php';
                //pel cas d'eliminar
                if ($id) { //si l'id no es buit
                    if (verificarID($id, $connexio)) { //verifiquem que l'id existeixi
                        if (eliminar($connexio, $id)) { //i si existeix, l'elimina
                            $missatges[] = "Eliminat correctament ID: $id";
                        } else {
                            $missatges[] = "No s'ha pogut eliminar...";
                        }
                    } else {
                        //En cas de no haver trobat l'id
                        $missatges[] = "No s'ha trobat l'ID $id";
                    }
                }

                break;
        }
    }
}
