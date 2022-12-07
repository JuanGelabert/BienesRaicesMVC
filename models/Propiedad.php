<?php

namespace Model;

class Propiedad extends ActiveRecord {

    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'baños', 'estacionamientos', 'creado', 'vendedor_id'];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $baños;
    public $estacionamientos;
    public $creado;
    public $vendedor_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->baños = $args['baños'] ?? '';
        $this->estacionamientos = $args['estacionamientos'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedor_id = $args['vendedor_id'] ?? '';
    }

    public function validar() {

        if(!$this->titulo) {
            self::$errores[] = "Debes añadir un título";
        }
        if(!$this->precio) {
            self::$errores[] = "Debes añadir un precio";
        }
        if(strlen($this->descripcion) <50 ) {
            self::$errores[] = "Debes añadir una escripción mayor a 50 caracteres";
        }
        if(!$this->habitaciones) {
            self::$errores[] = "Debes añadir la cantidad de habitaciones";
        }
        if(!$this->baños) {
            self::$errores[] = "Debes añadir la cantidad de baños";
        }
        if(!$this->estacionamientos) {
            self::$errores[] = "Debes añadir la cantidad de estacionamientos";
        }
        if(!$this->vendedor_id) {
            self::$errores[] = "Debes seleccionar un vendedor";
        }
        if(!$this->imagen) {
            self::$errores[] = "Debes seleccionar una imágen de la propiedad";
        }

        return self::$errores;
    }

    

}