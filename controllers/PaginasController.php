<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {

    public static function index(Router $router) {

        $propiedades = Propiedad::get(3);
        
        $router->render('paginas/index', [
            'inicio' => true,
            'propiedades' => $propiedades,
        ]);
    }

    public static function nosotros(Router $router) {

        $router->render('paginas/nosotros');
    }

    public static function propiedades(Router $router) {

        $propiedades = Propiedad::all();

        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }

    public static function propiedad(Router $router) {
        // Validar ID o redirigir
        $id = validarORedirigir('/');
    
        // Consultar por la propiedad del anuncio
        $propiedad = Propiedad::find($id);
        // Si no existe redirecciona
        if (!$propiedad->id) {
            header('Location: /');
        }
        
        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }

    public static function blog(Router $router) {

        $router->render('paginas/blog');
    }

    public static function entrada(Router $router) {
        
        $router->render('paginas/entrada');
    }

    public static function contacto(Router $router) {

        $mensaje = null;
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $respuesta = $_POST['contacto'];

            //Validar teléfono argentino
            $respuesta['telefono'] = strval(validarTelArgentino($respuesta['telefono']));
            
            // Crea una instancia de PHPMailer
            $mail = new PHPMailer();

            // Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '5aea2d5b1896a7';
            $mail->Password = '4e21d82d9c4d0a';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            // Configurar el contenido del mail
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $mail->Subject = 'Nueva consulta de ' . $respuesta['tipo'];

            // Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            // Definir el contenido
            $contenido = '<html>';
            $contenido .= '<h1>Nueva consulta</h1>';
            $contenido .= '<p>Nombre: ' . $respuesta['nombre'] . '</p>';
            $contenido .= '<p>Apellido: ' . $respuesta['apellido'] . '</p>';
            $contenido .= '<p>Tipo de operacion: ' . $respuesta['tipo'] . '</p>';
            $contenido .= '<p>Precio deseado: $ ' . $respuesta['precio'] . '</p>';
            $contenido .= '<p>Mensaje: <br>' . $respuesta['mensaje'] . '</p>';

            // Mensaje condicional - tipo de contacto
            if ($respuesta['contacto'] === 'telefono') {
                $contenido .= '<p>Desea ser contactado vía teléfono</p>';
                $contenido .= '<p>Teléfono: ' . $respuesta['telefono'] . '</p>';
                $contenido .= '<p>Día: ' . $respuesta['fecha'] . '</p>';
                $contenido .= '<p>Hora: ' . $respuesta['hora'] . '</p>';
            } else {
                $contenido .= '<p>Desea ser contactado vía email</p>';
                $contenido .= '<p>Email: ' . $respuesta['email'] . '</p>';
            }
    
            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es texto alternativo sin HTML';

            // Enviar el email
            if ($mail->send()) {
                $mensaje = "Mensaje enviado correctamente";
            } else {
                $mensaje = "Hubo un error y estamos trabajando para solucionarlo";
            }
        }

        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}