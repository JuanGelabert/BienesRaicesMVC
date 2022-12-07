<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>

    <?php
        if ($resultado) {
            $mensaje = mostrarNotificacion(intval($resultado));
            if($mensaje): ?>
                <p class="alerta exito"><?php echo s($mensaje) ?></p>
            <?php endif; 
        }
    ?>

    <h2>Propiedades</h2>
    <a href="/propiedades/crear" class="boton-verde">Nueva propiedad</a>

    <table class="propiedades contenedor">
        <thead>
            <tr>
                <th>Id</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody> <!-- Mostrar los resultados -->
        <?php foreach($propiedades as $propiedad) : ?>
            <tr>
                <td><?php echo $propiedad->id; ?></td>
                <td><?php echo $propiedad->titulo; ?></td>
                <td><img src="/imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-tabla" alt="Imágen de la propiedad"></td>
                <td>$ <?php echo $propiedad->precio; ?></td>
                <td>
                    <form method="POST" class="w-100" action="/propiedades/eliminar">
                        <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                        <input type="hidden" name="tipo" value="propiedad">
                        <input type="submit" class="boton-rojo-block" value="Eliminar">
                    </form>
                    <a href="/propiedades/actualizar?id=<?php echo $propiedad->id; ?>" class="boton-celeste-block">Actualizar</a>    
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Vendedores</h2>
    <a href="/vendedores/crear" class="boton-verde">Nuevo vendedor</a>
        
    <table class="propiedades contenedor">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody> <!-- Mostrar los resultados -->
        <?php foreach($vendedores as $vendedor) : ?>
            <tr>
                <td><?php echo $vendedor->id; ?></td>
                <td><?php echo $vendedor->nombre; ?></td>
                <td><?php echo $vendedor->apellido; ?></td>
                <td><?php echo $vendedor->telefono; ?></td>
                <td>
                    <form method="POST" class="w-100" action="/vendedores/eliminar">
                        <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                        <input type="hidden" name="tipo" value="vendedor">
                        <input type="submit" class="boton-rojo-block" value="Eliminar">
                    </form>
                    <a href="/vendedores/actualizar?id=<?php echo $vendedor->id; ?>" class="boton-celeste-block">Actualizar</a>    
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</main>