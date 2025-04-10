<?php
include_once(base_path() . '/resources/views/navbar.blade.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>

<body>
    <h3 style="color: white">Has oblidat la contrassenya?</h3>
    <form action="{{ route('forgot-password-controller') }}" method="post">
        @csrf
        <label for="correu"></label>
        <input type="text" name="correu" id="correu" placeholder="Correu">

        <input type="submit" name="forgotPassword" id="forgotPassword" value="Enviar correu">
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