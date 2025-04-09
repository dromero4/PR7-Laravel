<?php
//Incluïm el navbar per poder-nos moure de lloc
include_once(base_path() . '/resources/views/navbar.blade.php');

//Variables perque en cas d'equivocar-se, es quedi al input el que hem ficat perque no s'esborri
$correu = isset($_POST['correu']) ? $_POST['correu'] : '';
$usuari = isset($_POST['usuari']) ? $_POST['usuari'] : '';
$contrassenya = isset($_POST['contrassenya']) ? $_POST['contrassenya'] : '';
$contrassenya2 = isset($_POST['contrassenya2']) ? $_POST['contrassenya2'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</head>

<body>
    <form action="{{ route('signup-controller') }}" method="POST">
        @csrf
        <label for="correu" aria-label="correu">
            <input type="text" id="correu" name="correu" placeholder="Correu" value="<?php echo htmlspecialchars($correu); ?>"><br><br>
        </label>

        <label for="usuari" aria-label="usuari">
            <input type="text" id="usuari" name="usuari" placeholder="Usuari" value="<?php echo htmlspecialchars($usuari); ?>"><br><br>
        </label>

        <label for="contrassenya" aria-label="contrassenya">
            <input type="password" id="contrassenya" name="contrassenya" placeholder="Contrassenya" value="<?php echo htmlspecialchars($contrassenya); ?>"><br><br>
        </label>

        <label for="contrassenya2" aria-label="contrassenya2">
            <input type="password" id="contrassenya2" name="contrassenya2" placeholder="Contrassenya" value="<?php echo htmlspecialchars($contrassenya2); ?>"><br><br>
        </label>

        <label for="imagenPerfil" aria-label="imagenPerfil">
            <input type="text" id="imagenPerfil" name="imagenPerfil" placeholder="URL de la imatge">
        </label>

        <input type="submit" name="login" value="Sign Up">
    </form>
</body>

</html>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<!-- Mostrar errores de validación -->
@foreach ($errors->all() as $error)
<div class="alert alert-danger">{{ $error }}</div>
@endforeach


<?php

?>