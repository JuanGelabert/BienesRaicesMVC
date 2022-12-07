<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;


class PropiedadController {
    
    public static function index(Router $router) {

        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'vendedores' => $vendedores,
            'resultado' => $resultado
        ]);
    }

    public static function crear(Router $router) {

        // Creo un nuevo objeto de propiedad
        $propiedad = new Propiedad;
        // Listo todos los vendedores
        $vendedores = Vendedor::all();
        // Arreglo con mensajes de errores para validar formulario
        $errores = Propiedad::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Crea una nueva instancia de la clase
            $propiedad = new Propiedad($_POST['propiedad']);

            // Verifica que se haya seleccionado una imagen
            if ($_FILES['propiedad']['tmp_name']['imagen']) {

                // Genera un nombre random a la imagen
                $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

                // Setea el nombre de la imagen en el objeto
                $propiedad->setImagen($nombreImagen);
            }

            
            // Validar
            $errores = $propiedad->validar();
            
            // Revisar que el array de errores este vacío
            if(empty($errores)) {

                // Realiza un resize "fit()" a la imagen con intervention
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                                
                // Almacena la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);

                // Crea el registro en la BD
                $resultado = $propiedad->guardar();
            }
        }
        
        $router->render('propiedades/crear',[
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);

    }

    public static function actualizar(Router $router) {
        // Validar URL por ID válido
        $id = validarORedirigir('/admin');

        // Obtener los datos de la propiedad
        $propiedad = Propiedad::find($id);

        // Consulta para obtener los vendedores
        $vendedores = Vendedor::all();

        // Arreglo  para llenar con los errores
        $errores = Propiedad::getErrores();
        
        
        // Ejecutar el código después de que el usuario envía el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Asignar los atributos
            $args = $_POST['propiedad'];
            
            // Sincronizar los datos con el objeto en memoria
            $propiedad->sincronizar($args);
            
            // Si existe la imagen
            if ($_FILES['propiedad']['tmp_name']['imagen']) {

                // Genera un nombre único para la imágen
                $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
                
                // Setea la imagen
                $propiedad->setImagen($nombreImagen);
                
                // Realiza un resize "fit()" a la imagen con intervention
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);

                // Almacena la imágen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);
            }
            
            // Validar los datos enviados del formulario
            $errores = $propiedad->validar();
            
            // Si el array de errores este vacío
            if(empty($errores)) {
                
                // Actualiza el registro en BD
                $propiedad->guardar();
            }
        }

        $router->render('propiedades/actualizar',[
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function eliminar(Router $router) {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Validar el id enviado en POST
            if($id = $_POST['id']) {

                // Si existe aplica un filtro para que sea un entero y evitar inyecciones de código
                $id = filter_var($id, FILTER_VALIDATE_INT);
                
                $tipo = $_POST['tipo'];

                // Validación del tipo (vendedor o propiedad) para evitar inyecciones de código
                if (validarTipoContenido($tipo)) {
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            }
        }
    }
}