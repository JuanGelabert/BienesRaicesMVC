<fieldset>
    <legend>Información general</legend>

    <label for="titulo">Titulo:</label>
    <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Titulo Propiedad" value="<?php echo s($propiedad->titulo); ?>">

    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="propiedad[precio]" min="1" max="99999999" placeholder="Precio Propiedad" value="<?php echo s($propiedad->precio); ?>">

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="propiedad[imagen]" accept="image/jpeg, image/png">

    <?php if($propiedad->imagen): ?>
        <img src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="Imagen de la propiedad" class="imagen-small">
    <?php endif; ?>

    <label for="descripcion">Descripcion</label>
    <textarea id="descripcion" name="propiedad[descripcion]"><?php echo s($propiedad->descripcion); ?></textarea>
</fieldset>

<fieldset>
    <legend>Información de la propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input type="number" id="habitaciones" name="propiedad[habitaciones]" min="1" max="9" placeholder="Cantidad de habitaciones" value="<?php echo s($propiedad->habitaciones); ?>">

    <label for="baños">Baños:</label>
    <input type="number" id="baños" name="propiedad[baños]" min="1" max="9" placeholder="Cantidad de baños" value="<?php echo s($propiedad->baños); ?>">

    <label for="estacionamientos">Estacionamientos:</label>
    <input type="number" id="estacionamientos" name="propiedad[estacionamientos]" min="0" max="9" placeholder="Cantidad de estacionamientos" value="<?php echo s($propiedad->estacionamientos); ?>">
</fieldset>

<fieldset>
    <legend>Vendedor</legend>
    
    <select name="propiedad[vendedor_id]" id='vendedor'>
        <option selected disabled value="">-- Seleccione --</option>
        <?php foreach ($vendedores as $vendedor) { ?>
            <option 
                <?php echo $propiedad->vendedor_id === $vendedor->id ? 'selected' : ''; ?>
                value="<?php echo s($vendedor->id) ?>"
            >
                <?php echo s($vendedor->nombre) . " " . s($vendedor->apellido); ?>
            </option>
        <?php } ?>
    </select>
</fieldset>