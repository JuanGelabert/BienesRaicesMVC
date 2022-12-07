<?php

namespace Controllers;
use MVC\Router;
use Model\Vendedor;

class VendedorController {

    public static function crear(Router $router) {

        // Creo un nuevo objeto de propiedad
        $vendedor = new Vendedor;
        // Arreglo con mensajes de errores para validar formulario
        $errores = Vendedor::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Crea una nueva instancia de la clase
            $vendedor = new Vendedor($_POST['vendedor']);
            
            // Validar
            $errores = $vendedor->validar();
            
            // Revisar que el array de errores este vacío
            if(empty($errores)) {

                // Crea el registro en la BD
                $resultado = $vendedor->guardar();
            }
        }
        
        $router->render('vendedores/crear',[
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);

    }

    public static function actualizar(Router $router) {
        // Validar URL por ID válido
        $id = validarORedirigir('/admin');

        $vendedor = Vendedor::find($id);

        // Arreglo  para llenar con los errores
        $errores = Vendedor::getErrores();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $args = $_POST['vendedor']; // Asigna los atributos

            $vendedor->sincronizar($args); // Sincroniza con el objeto en memoria

            $errores = $vendedor->validar(); // Valida los datos

            if (empty($errores)) {
                $vendedor->guardar(); // Almacena en BD
            }
            
        }

        $router->render('vendedores/actualizar', [
            'vendedor' => $vendedor,
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
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }
        }
    }
}