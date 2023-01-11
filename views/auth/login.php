<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>

<?php 
include_once __DIR__."/../templates/alertas.php";
?>

<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">E-mail</label>
        <input 
            type="email" 
            placeholder="Escribe tu correo"
            id="email"
            name="email"        
        />
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input 
        type="password" 
        name="password" 
        id="password"
        placeholder="Password"
        />
    </div>

    <input class="boton" type="submit" value="Iniciar Sesion">
</form>


<div class="acciones">
    <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crear una</a>
    <a href="/olvide">¿Olvidaste tu contrasña?</a>
</div>