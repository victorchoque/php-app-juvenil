<?php
class DB{
    private static $instance = null; // Única instancia de Database
    private $connection; // Conexión a la base de datos
    //private $dsn = 'mysql:host=localhost;dbname=mi_base_de_datos'; // DSN (Data Source Name)
    //private $username = 'root'; // Usuario de la base de datos
    //private $password = ''; // Contraseña de la base de datos
    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]; // Opciones para la conexión PDO

    // Constructor privado para evitar instanciación directa
    private function __construct($url_format) {
        try {
            // Obtener datos de conexión desde una Url de conexión como
            // mysql://usuario:contraseña@servidor:puerto/base_de_datos
            $parts = parse_url($url_format);
            $host_and_port = isset($parts["port"]) ? $parts["host"] . ":" . $parts["port"] : $parts["host"];
            $dbname = ltrim($parts['path'], '/');
            $dsn = sprintf('%s:host=%s;dbname=%s', $parts['scheme'], $host_and_port, $dbname);
            $username = $parts['user'];
            $password = $parts['pass'];
            $this->connection = new PDO($dsn,$username,$password  , $this->options);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    public static function init($url) {
        if (static::$instance === null) {
            static::$instance = new static($url);
        }else{
            throw new Exception("La conexión a la base de datos ya ha sido inicializada");
        }
    }
    // Método para obtener la instancia única
    public static function getInstance() {
        if (self::$instance === null) {
            throw new Exception("No se ha inicializado la conexión a la base de datos");
        }
        return self::$instance;
    }

    // Método para ejecutar una consulta
    public static function query($sql, $params = []) {
        
        $stmt = static::getInstance()->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // Método para insertar datos
    public static function insertar($table, $data) {
        $keys = array();
        $values = array();
        foreach($data as $k=>$v){
            $keys[] = $k;
            if(is_array($v)){
                $values[] = implode(",",$v);
            }else{
                $values[] =$v;
            }
        }
        $columns = implode(", ", $keys);
        $placeholders = implode(", ", array_fill(0, count($keys), "?"));
        
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        return static::query($sql, $values);
    }
    // Método para editar datos
    public static function editar($table, $data,$pk,$extra_where= null) {
        $values = array();
       
        $setters = array();
        $new_data = array();
        foreach($data as $k=>$v){
            if(is_array($v)){
                $new_data[$k] = implode(",",$v);
            }else{
                $new_data[$k] =$v;
            }
        }
        foreach($new_data as $k=>$v){
            if($k==$pk) continue;
            $setters[]= $k.'=:'.$k;
        }
        
        $sql = "UPDATE $table SET " . implode(",",$setters) ." WHERE $pk=:$pk $extra_where";                
        return static::query($sql, $new_data);
    }
    
    // Método para eliminar datos
    public static function borrar($table, $condition, $params = []) {
        $sql = "DELETE FROM $table WHERE $condition";
        return static::query($sql, $params);
    }

    // Método para obtener todos los registros de una tabla
    public static function listar($table,$colums = '*', $where='') {
        $sql = "SELECT $columns FROM $table $where";
        return static::query($sql);
    }

    // Método para obtener un registro específico
    public static function get($table, $condition, $params = []) {
        $sql = "SELECT * FROM $table WHERE $condition";
        return static::query($sql, $params);
    }

    // Método para obtener registros por clave y valor
    /**
     * 
     * @param string $table Nombre de la tabla
     * @param string $key Nombre de la columna clave
     * @param string $value Nombre de la columna valor
     * @param string $where Condición opcional Debe incluir la palabra WHERE
     */
    public static function listaSeleccion($table, $key, $value,$where = '') {
        $sql = "SELECT $key, $value FROM $table $where";
        $stmt =  static::query($sql);
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }
    public static function listaSeleccionRaw($rawQuery,array $assoc_data = array()){        
        $stmt =  static::query($rawQuery, $assoc_data);
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }
    public static function obtenerQuery($rawQuery,array $assoc_data = array()){
        $stmt =  static::query($rawQuery, $assoc_data);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}