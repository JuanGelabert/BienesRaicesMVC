<?php

define ('TEMPLATES_URL', __DIR__ . '/templates');
define ('FUNCIONES_URL', __DIR__  . 'funciones.php');
define ('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function includeTemplate( string $nombre, bool $inicio = false ) {
    include TEMPLATES_URL . "/{$nombre}.php";
}

function estaAutenticado() {
    // Verifica si la sesión está activa
    session_start();

    if (!$_SESSION['login']) {
        header('Location: /');
    }
}

function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapar/sanitizar a el HTML
function s($html) : string{
    $s = htmlspecialchars($html);
    return $s;
}

// Validar tipo de contenido
function validarTipoContenido($tipo) {
    $tipos = ['vendedor', 'propiedad'];

    return in_array($tipo, $tipos);
}

// Muestra notificaciones
function mostrarNotificacion($codigo) {
    $mensaje = '';

    switch($codigo) {
        case 1:
            $mensaje = 'Creado correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado correctamente';
            break;
        default:
            $mensaje = false;
    }

    return $mensaje;
}

// Validar ID o redirigir
function validarORedirigir($url) {
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header('Location: ' . $url);
    }

    return $id;
}

// Validar un teléfono argentino
function validarTelArgentino ( $tel ) {
    //eliminamos todo lo que no es dígito
    $num = preg_replace( '/\D+/', '', $tel);
    //devolver si coincidió con el regex
    return preg_match(
        '/^(?:(?:00)?549?)?0?(?:11|[2368]\d)(?:(?=\d{0,2}15)\d{2})??\d{8}$/D',
        $num
    );
}

