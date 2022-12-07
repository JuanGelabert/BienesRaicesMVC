<main class="contenedor seccion contenido-centrado">
    <h1>Contacto</h1>

    <?php if($mensaje) { ?>
            <p class="alerta exito"><?php echo $mensaje ?></p>
    <?php } ?>

    <picture>
        <source srcset="build/img/destacada3.webp" type="image/webp">
        <source srcset="build/img/destacada3.jpg" type="image/jpeg">
        <img src="build/img/destacada3.jpg" alt="Imagen de contacto">
    </picture>
    <h2>Llene el formulario de contacto</h2>

    <form action="/contacto" class="formulario" method="POST">
        <fieldset>
            <legend>Información personal</legend>

            <label for="nombre">Nombre</label>
            <input type="text" placeholder="Tu nombre" id="nombre" name="contacto[nombre]">

            <label for="apellido">Apellido</label>
            <input type="text" placeholder="Tu apellido" id="apellido" name="contacto[apellido]">

            <label for="mensaje">Mensaje</label>
            <textarea id="mensaje" name="contacto[mensaje]"></textarea>
        </fieldset>

        <fieldset>
            <legend>Información sobre la operacion</legend>

            <label for="tipo">Deseo:</label>

            <select id="tipo" name="contacto[tipo]">
                <option disabled selected="selected" value="">-- Selección --</option>

                <option value="compra">Comprar</option>

                <option value="venta">Vender</option>
            </select>

            <label for="precio">Precio o presupuesto</label>

            <input type="number" min="0" placeholder="Tu precio o presupuesto" id="precio" name="contacto[precio]">
        </fieldset>

        <fieldset>
            <legend>Contacto</legend>

            <p>¿Cómo desea ser contactado?</p>

            <div class="forma-contacto">
                <label for="contactar-telefono">Teléfono</label>
                <input type="radio" id="contactar-telefono" value="telefono" name="contacto[contacto]">

                <label for="contactar-email">E-mail</label>
                <input type="radio" id="contactar-email" value="email" name="contacto[contacto]">
            </div>

            <div id="contacto"></div>
        </fieldset>

        <input type="submit" value="Enviar" class="boton-verde">
    </form>

</main>