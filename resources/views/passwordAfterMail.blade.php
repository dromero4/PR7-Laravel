<?php
include_once(base_path() . '/resources/views/navbar.blade.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot password</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>

<body>
    <form action="{{ route('passwordAfterMail-controller') }}" method="post">
        @csrf
        <input type="hidden" name="token" value="<?php echo isset($_GET['token']) ? $_GET['token'] : ''; ?>">
        <input type="hidden" name="email" value="<?php echo isset($_GET['email']) ? $_GET['email'] : ''; ?>">

        <label for="contrassenya1"></label>
        <input type="password" id="contrassenyaReiniciada1" name="contrassenyaReiniciada1" placeholder="Contrassenya"><br><br>

        <label for="contrassenya2"></label>
        <input type="password" id="contrassenyaReiniciada2" name="contrassenyaReiniciada2" placeholder="Confirma la contrassenya"><br><br>

        <input type="submit" id="contrassenyaReiniciada" name="contrassenyaReiniciada" value="Enviar"><br><br>


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