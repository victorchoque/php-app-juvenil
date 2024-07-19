<?php
require_once __DIR__ .'/CRUD/CRUD_types.class.php';
require_once __DIR__ .'/CRUD/_CRUD_fields.class.php';
require_once __DIR__ .'/CRUD/_CRUD_action.class.php';
/**
 * Clase CRUD
 * Genera un CRUD (Create, Read, Update, Delete) para una tabla de la base de datos.
 * @version 1.0.0
 */
class CRUD{
    private $table = null;
    private $title = "";
    private $hasCreate = false;
    private $hasList = false;
    private $hasDelete = false;
    private $hasUpdate = false;
    private $current_action = 'list';
    private $persist_get = array(); //Para persistir el query Url del navegador
    public $_isMultipart = false;
    private $opts = array (
        "custom_actions" => array(
            "list"=>null,
            "create"=>null,
            "update"=>null,
            "delete"=>null,
        ),
        "buttons" => array(
            "create" => "Agregar"
        ),
        "actions" =>array(
            "create"=>null,// Clousure or Anonym Function
        ),
        "pk"=>array(
            "list"  => 'id',
            "insert"=>'id',
            "update"=>'id',
            "delete"=>'id',
        )
    );
    private $_global_fields = null;
    public function __construct($titulo,$table,$pk_name='id'){
        $this->table = $table;
        $this->title = $titulo;
        $this->opts["pk"]["create"] = $pk_name;
        $this->opts["pk"]["update"] = $pk_name;
        $this->opts["pk"]["delete"] = $pk_name;
        $this->opts["pk"]["list"] = $pk_name;
        
    }
    public function setGlobalFields($global_field){
        $this->_global_fields = $global_field;
        return $this;
    }
    /**
     * Persiste los parámetros GET en acciones de CRUD
     * 
     * Este método permite mantener los valores de ciertos parámetros 
     * recibidos a través de la URL en futuras acciones del CRUD (Crear, Leer, Actualizar, Eliminar).
     * 
     * Al persistir estos parámetros, se asegura que las acciones realizadas 
     * por el usuario mantengan el contexto correcto. Por ejemplo, si un usuario 
     * está trabajando con un recurso específico identificado por un parámetro GET 
     * como `id_padre`, este método garantiza que dicho parámetro no se pierda 
     * durante la interacción con el sistema.
     * 
     * @param mixed ...$args Parâmetros GET a persistir. Se pueden pasar múltiples valores.
     * 
     * @return $this Devuelve el propio objeto para permitir encadenamiento (method chaining).
     */
    public function setPersistGet(...$args) {
        $this->persist_get = $args;
        return $this;
    }
    protected function currentAction($current_action = null){
        $this->current_action = $current_action == null?"list":$current_action;
        if(isset($_GET["_ACTION"]) &&  in_array($_GET["_ACTION"],["read","update","create","delete"])){
            $this->current_action = $_GET["_ACTION"];
        }
    }
    public function canCreate($name = "➕ Agregar"){
        $this->hasCreate = true;
        //$this->opts["buttons"]["create"] = $name;
        //$this->opts["actions"]["create"] = $callback;
        $can = new _CRUD_action($this,"create");
        $this->opts["custom_actions"]["create"] = $can;
        if($this->_global_fields!=null){
            
            $can->setFields($this->_global_fields);
        }
        $can->setName($name);
        return $can;
    }
    public function canUpdate($name = '✏️ Modificar'){
        $this->hasUpdate = true;
        $can = new _CRUD_action($this,"update");
        $this->opts["custom_actions"]["update"] = $can;
        if($this->_global_fields!=null){
            $can->setFields($this->_global_fields);
        }
        $can->setName($name);
        return $can;
    }
    public function canDelete($name = '🗑 Borrar'){
        $this->hasDelete = true;
        $can = new _CRUD_action($this,"delete");
        $this->opts["custom_actions"]["delete"] = $can;
        if($this->_global_fields!=null){
            $can->setFields($this->_global_fields);
        }
        $can->setName($name);
        return $can;
    }
    public function canList($name = '📒 Volver a la Lista'){
        $this->hasList = true;
        $can = new _CRUD_action($this,"list");
        $this->opts["custom_actions"]["list"] = $can;
        if($this->_global_fields!=null){
            $can->setFields($this->_global_fields);
        }
        $can->setName($name);
        return $can;
    }
    // public function defineColumns($colId='',$other_columns=array()){

    //     return $this;
    // }
    // public function defineFields($fieldId='',$other_fields = array()){

    //     return $this;
    // }
    protected function _noActionFound(){
        echo "<h2 style='color:red'>No se encontró la acción solicitada.</h2>";
    }
    public function show($current_action = null){
        $this->currentAction($current_action);
        switch ($this->current_action) {
            case 'create':
                if($this->hasCreate){
                    $CRUD = $this;
                    $ACTION = $this->opts["custom_actions"]["create"];
                    //$ACTION->render();
                    if (isset($_POST) && !empty($_POST)) {
                        $ERROR=true;
                        if(is_callable($ACTION->callback_upload)){                        
                            $ERROR = call_user_func_array($ACTION->callback_upload,[$_FILES]);
                            if($ERROR === null)
                                $ERROR = "Error al subir archivo";
                        }
                        if($ERROR === true && is_callable($ACTION->callback_submit)){                        
                            $ERROR = call_user_func_array($ACTION->callback_submit,[$_POST]);
                        }else{
                            $ERROR = "Error desconocido";
                        }                    
                    }
                    include __DIR__ .'/CRUD/_CRUD_forms.view.php';
                }else{
                    $this->_noActionFound();
                }
                break;

            case 'update':
                if($this->hasUpdate){
                    $CRUD = $this;
                    $ACTION = $this->opts["custom_actions"]["update"];
                    $pk = $this->opts["pk"]["update"];
                    if(is_callable($ACTION->callback_data)){
                        
                        $data = call_user_func_array($ACTION->callback_data,[$_GET[$pk]]);
                        
                        foreach($data as $k=>$v){
                            if(isset($ACTION->getColumns()->fields[$k])){
                                $ACTION->getColumns()->fields[$k]->setDefaultData($v);
                            }
                        }
                    }
                    if (isset($_POST) && !empty($_POST)) {
                        $ERROR=true;
                        if(is_callable($ACTION->callback_upload)){                        
                        $ERROR = call_user_func_array($ACTION->callback_upload,[$_FILES]);
                        if($ERROR === null)
                            $ERROR = "Error al subir archivo";
                        }
                        if($ERROR === true && is_callable($ACTION->callback_submit)){                        
                        $ERROR = call_user_func_array($ACTION->callback_submit,[$_POST,$_GET[$pk]]);
                        }else{
                            $ERROR = "Error desconocido";
                        }
                    }
                    include __DIR__ .'/CRUD/_CRUD_forms.view.php';
                }
                else{
                    $this->_noActionFound();
                }
                break;

            case 'delete':
                if($this->hasDelete){
                    $CRUD = $this;
                    $ACTION = $this->opts["custom_actions"]["delete"];
                    $pk = $this->opts["pk"]["delete"];
                    if(is_callable($ACTION->callback_data)){
                        
                        $data = call_user_func_array($ACTION->callback_data,[$_GET[$pk]]);
                        
                        foreach($data as $k=>$v){
                            if(isset($ACTION->getColumns()->fields[$k])){
                                $ACTION->getColumns()->fields[$k]->setDefaultData($v);
                            }
                        }
                    }
                    if (isset($_GET[$pk])) {
                        $ERROR = "Error desconocido";
                        if(is_callable($ACTION->callback_submit)){                        
                        $ERROR = call_user_func_array($ACTION->callback_submit,[$_POST,$_GET[$pk]]);
                        }
                        $msg = '✔︎ Eliminacion Exitosa';
                        if(is_string($ERROR) || is_array($ERROR)){
                            
                            if(is_string($ERROR)){
                                $msg = '⚠️❗️'.$ERROR;
                            }else{
                                $msg = '⚠️❗️ Error:\\n';
                                foreach($ERROR as $err){
                                    $msg .= '*'.$err.'\\n';
                                }
                            }
                        }
                        $msg = json_encode($msg);
                        $queryUrlArray = array();
                        foreach($this->persist_get as $k){
                            if(isset($_GET[$k])) $queryUrlArray[$k] = $_GET[$k];
                        }
                        $queryUrl = http_build_query($queryUrlArray);
                        echo <<<HTML
                    <script>
                        alert($msg);
                        location.href='?$queryUrl';
                    </script>
HTML;

                    }
                }
                else{
                    $this->_noActionFound();
                }
                break;

            case 'list':
                if($this->hasList){
                    $CRUD = $this;
                    $ACTION = $this->opts["custom_actions"]["list"];
                    // if(is_callable($ACTION->callback_data)){

                    // }
                    // if (isset($_POST) && !empty($_POST)) {
                    //     if(is_callable($ACTION->callback_data)){
                    //         call_user_func_array($ACTION->callback_submit,[$_POST]);
                    //     }
                    // }
                    include __DIR__ .'/CRUD/_CRUD_table.view.php';
                }else{
                    $this->_noActionFound();
                }
                break;

            default:
                echo "Acción no válida.";
                break;
            }
    }
    public function renderCustomButton($name,$url,array $row=array()){        
        foreach($row as $k=>$v){
            $url = str_replace('{'.$k.'}',$v,$url);
        }        
        return "<a href='$url' class='btn btn-sm btn-secondary'>$name</a>";
    }
    public function renderButton($actionName,array $row=array()){
        $external_args = array();
        $queryUrl = array("_ACTION" =>$actionName);
        foreach($this->persist_get as $k){
            if(isset($_GET[$k])) $queryUrl[$k] = $_GET[$k];
        }
        $queryUrl = array_merge($queryUrl,$external_args);
        $pk_id = $this->opts["pk"][$actionName];
        if(isset($row[ $pk_id ])){
            $queryUrl[ $pk_id ] = $row[ $pk_id ];
        }

        $url = http_build_query( $queryUrl );
        $name = $this->opts["custom_actions"][$actionName]->getName();
        $types = array(
            "create" => 'btn-primary',
            "update" => 'btn-warning',
            "delete" => 'btn-danger',
            "list"   => 'btn-secondary',
        );
        $type = $types[$actionName];
        return "<a href='?$url' class='btn btn-sm $type'>$name</a>";
    }
}

/*
$ejemplo  = new CRUD("Empleados","empleados","id");
$ejemplo->canList()
    ->defaultFields([
        "nombres" => function($row){
            return $row["paterno"]." ".$row["materno"]." ".$row["nombre"];
        },
    ])
    ->setData(function($table,$pk){
        //DB::list("empleados");
        return DB::query("SELECT $pk,paterno,materno,nombre FROM empleados");
    })
    ->fields(array(
        "paterno" => "Apellido Paterno",
        "materno" => "Apellido Materno",
        "nombre"   => "Nombre",
        
    ))
    ->setFields(function($define){
        $define->paterno->setDefault()
        $define->paterno("Paterno",null,CRUD_types::TEXT);
    })
    ;
/**/
