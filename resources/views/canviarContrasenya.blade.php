<?php
include_once(base_path() . '/resources/views/navbar.blade.php');
?>
<!DOCTYPE html>
<!-- DAVID ROMERO -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reiniciar Password</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- Formulari per reinciiar el password -->
    <form action="{{ route('canviarContrasenya-controller') }}" method="post">
        @csrf
        <label for="correu"></label>
        <label for="contrassenya"></label>
        <input type="password" id="contrassenya" name="contrassenya" placeholder="Contrassenya actual" value=""><br><br>

        <label for="contrassenya2"></label>
        <input type="password" id="contrassenyaCanviar" name="contrassenyaCanviar" placeholder="Nova contrassenya" value=""><br><br>

        <input type="submit" id="reiniciarPassword" name="reiniciarPassword" value="Enviar">
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