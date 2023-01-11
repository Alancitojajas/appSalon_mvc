<h1 class="nombre-pagina">Panel de administracion</h1>

<?php
include_once __DIR__ . '/../templates/barra.php';
?>

<h3>Buscar Citas</h3>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input id="fecha" type="date" name="fecha" value="<?php echo $fecha ?>"/>
        </div>
    </form>
</div>

<?php 
    if(count($citas) ===0){
        echo "<h2>No hay citas en esta fecha</h2>";
    }
?>

<div id="ciras-admin">
    <ul class="citas">
        <?php
        $idCita =0;
        foreach ($citas as $key =>$cita) {
     
            if($idCita != $cita->id){

                $idCita = $cita->id;
                $total = 0;
        ?>
        <li>
            <p>ID: <span><?php echo($cita->id) ?></span>
            <p>Hora: <span><?php echo($cita->hora) ?></span>
            <p>Cliente: <span><?php echo($cita->cliente) ?></span>
            <p>Email: <span><?php echo($cita->email) ?></span>
            <p>Telefono: <span><?php echo($cita->telefono) ?></span>
            <h3>Servicios</h3>
            <?php }//fin de if
            $total += $cita->precio; 
            ?>
            <p class="servicio"><?php echo($cita->servicio. ". $" .$cita->precio)?></p>

        <?php
            $actual = $cita->id;
            $proximo = $citas[$key+1]->id ?? 0;

                if(esUltmo($actual, $proximo)){ ?>
                <p class="total">Total: <span>$ <?php echo $total ?></span></p>

                <form action="/api/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                    <input type="submit" class="boton-eliminar" value="Eliminar">
                </form>
        <?php } 
        } //fin foreach
        ?>
    </ul>
</div>

<?php 
    $script = "<script src='build/js/buscador.js'></script>";
?>