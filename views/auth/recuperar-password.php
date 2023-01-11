<h1 class="nombre-pagina">Recuperar password</h1>
<p class="descripcion-pagina">Coloca tu nuevo password a continuacion</p>

<?php 
include_once __DIR__."/../templates/alertas.php";
?>

<?php 
    if($error) return;
?>

<form class="formulario" method="post">
    <div class="campo">
        <label for="password">Password</label>
        <input 
        type="text" 
        name="password" 
        placeholder="Tu nuevo password"
        />
    </div>

    <input type="submit" class="boton" value="Guardar nuevo password">

    <div class="acciones">
        <a href="/">¿Ya tienes cuenta? Iniciar sesion</a>
        <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crea una</a>
    </div>