<?php

namespace Model;

class ActiveRecord {

    // Base de datos
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    // Errores
    protected static $errores = [];
    


    //Definir la conexión a la base de datos
    public static function setDB($database) {
        self::$db = $database;
    }
    
    public function guardar() {
        if(!is_null($this->id)) {
            //Actualizar registro
            $this->actualizar();
        } else {
            // Crear nuevo registro
            $this->crear();
        }

    }
    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarDatos();

        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key} = '{$value}'";
        }

        // Escribe el query el query
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "'";
        $query .= " LIMIT 1";

        // Insertar en base de datos
        $resultado = self::$db->query($query);

        // Redirecciona al usuario
        if($resultado) {
            // Redireccionar al usuario
            header('Location: /admin?resultado=2');
        }   
    }
    public function crear() {

        // Sanitizar los datos
        $atributos = $this->sanitizarDatos();

        // Prepara el query
        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ('";
        $query .= join("', '", array_values($atributos));
        $query .= "')";
        
        //Insertar en base de datos
        $resultado = self::$db->query($query);

        // Redirecciona
        if($resultado) {
            header('Location: /admin?resultado=1');
        }
    }
    public function eliminar() {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id . " LIMIT 1");
        $resultado = self::$db->query($query);
        
        if($resultado) {
            $this->borrarImagen();
            header('Location: /admin?resultado=3');
        }
    }
    
    // Identificar y unir los datos de la BD
    public function datos(){
        $datos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $datos[$columna] = $this->$columna;
        }
        return $datos;
    }

    // Sanitizar los datos
    public function sanitizarDatos() {
        $datos = $this->datos();
        $sanitizado = [];
        foreach($datos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Setea la imagen
    public function setImagen($imagen) {

        $this->borrarImagen();

        //Asignar al atributo de imagen el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    // Eliminar la imagen
    public function borrarImagen() {
        // Verifica si estamos editando
        if (!is_null($this->id)) {
            // Comprobar si existe el archivo
            $existearchivo = file_exists(CARPETA_IMAGENES . $this->imagen);

            // Si existe, lo borra
            if($existearchivo){
                unlink(CARPETA_IMAGENES . $this->imagen);
            }
        }
    }

    // Validación
    public static function getErrores() {
        return static::$errores;
    }

    public function validar() {
        static::$errores = [];

        return static::$errores;
    }

    // Lista todos los registros
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Lista registros con un limite
    public static function get($cantidad) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Busca los registros por su ID
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = static::crearObjeto($registro);
        }

        // Liberar la memoria
        $resultado->free();

        // Retornar resultados
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value){
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = []) {
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}