<?php
session_start();
//Inserim el navbar per poder-nos moure de lloc
include_once(base_path() . '/resources/views/navbar.blade.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar article</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <h3 style="color: white">Quin element vols inserir? </h3>

    <form action="{{ route('insertar-controller') }}" method="POST">
        @csrf
        <label for="model"></label>
        <!-- input per inserir el model de l'article -->
        <input type="text" id="model" name="model" placeholder="Model: "><br><br>

        <label for="nom"></label>
        <!-- input per inserir el nom de l'article -->
        <input type="text" id="nom" name="nom" placeholder="Nom: "><br><br>

        <label for="preu"></label>
        <!-- input per inserir el preu de l'article -->
        <input type="number" id="preu" name="preu" placeholder="Preu: "><br><br>

        <!-- botó type submit -->
        <input type="submit" name="Enviar" value="Insertar">
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