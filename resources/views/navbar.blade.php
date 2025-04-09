<!DOCTYPE html>
<!-- DAVID ROMERO -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>

<body>
    <?php

    use App\Models\usersModel;



    // Definir la ruta de la carpeta de vistas
    $vistaDir = base_path() . '/resources/views';
    $admin = false;
    if (isset($_SESSION['usuari'])) {
        $admin = usersModel::verificarAdmin($connexio, $_SESSION['correu']);
    }

    function getCurrentPage()
    {
        return basename($_SERVER['PHP_SELF'], '.php');
    }

    $currentPage = getCurrentPage();
    ?>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark" id="navbar">
        <div class="container-fluid">
            <a class="navbar-brand ms-2" href="/" tabindex="1">Brand Padel</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['usuari']) && !$admin): ?>
                        <a href="<?= $currentPage === 'insertar' ? $vistaDir . '/insertarArticleQR.php' : $vistaDir . '/insertar.php' ?>" class="nav-link" tabindex="2">
                            <button class="botones mt-1">
                                <?= $currentPage === 'insertar' ? 'Insertar article per QR' : '<img src="' . $vistaDir . '/../imagenes/icones/plus-svgrepo-com.svg" id="menu" style="width: 25px" alt="Agregar artículo"> Add article' ?>
                            </button>
                        </a>

                        <li class="nav-link dropdown" id="drpdwn" tabindex="3">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">
                                <?= htmlspecialchars($_SESSION['correu']) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end bg-dark">
                                <li><a class="dropdown-item text-white" href="<?= $vistaDir ?>/profile.php" tabindex="4">Perfil</a></li>
                                <li><a class="dropdown-item text-white" href="<?= $vistaDir ?>/reiniciarPassword.php" tabindex="5">Canviar contrasenya</a></li>
                                <li><a class="dropdown-item text-white" href="<?= $vistaDir ?>/../controlador/logout.php" tabindex="6">Logout</a></li>
                            </ul>
                        </li>

                    <?php elseif (isset($_SESSION['usuari']) && $admin): ?>
                        <a href="<?= $currentPage === 'insertar' ? $vistaDir . '/insertarArticleQR.php' : $vistaDir . '/insertar.php' ?>" class="nav-link" tabindex="2">
                            <button class="botones mt-1">
                                <?= $currentPage === 'insertar' ? 'Insertar article per QR' : '<img src="' . $vistaDir . '/../imagenes/icones/plus-svgrepo-com.svg" id="menu" style="width: 25px" alt="Agregar artículo"> Add article' ?>
                            </button>
                        </a>

                        <li class="nav-link dropdown" id="drpdwn" tabindex="3">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">
                                <?= htmlspecialchars($_SESSION['correu']) . ': Admin' ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end bg-dark">
                                <li><a class="dropdown-item text-white" href="<?= $vistaDir ?>/users.php" tabindex="4">Usuaris</a></li>
                                <li><a class="dropdown-item text-white" href="<?= $vistaDir ?>/profile.php" tabindex="5">Perfil</a></li>
                                <li><a class="dropdown-item text-white" href="<?= $vistaDir ?>/reiniciarPassword.php" tabindex="6">Canviar contrasenya</a></li>
                                <li><a class="dropdown-item text-white" href="<?= $vistaDir ?>/../controlador/logout.php" tabindex="7">Logout</a></li>
                            </ul>
                        </li>

                    <?php else: ?>
                        <li class="nav-link dropdown" id="drpdwn" tabindex="3">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">
                                Menu
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end bg-dark">
                                <li><a class="dropdown-item text-white" href="/login" tabindex=" 4">Login</a></li>
                                <li><a class="dropdown-item text-white" href="/signup" tabindex="5">Register</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>

</body>

</html>