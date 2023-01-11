<h1 class="nombre-pagina">Olvide mi password</h1>
<p class="descripcion-pagina">Reestablece tu password
    escribiendo tu email
</p>

<?php 
include_once __DIR__."/../templates/alertas.php";
?>

<form class="formulario" method="POST" action="/olvide">
    <div class="campo">
        <label for="email">E-mail</label>
        <input 
        type="email"
        id="email"
        name="email"
        placeholder="Tu email"
        />
    </div>

    <input type="submit" class="boton" value="Recuperar contraseña">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crear una</a>
    <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crear una</a>
</div>