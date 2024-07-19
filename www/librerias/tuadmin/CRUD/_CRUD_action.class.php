<?php
require_once __DIR__ .'/CRUD_types.class.php';
require_once __DIR__ .'/_CRUD_fields.class.php';
class _CRUD_action{
    private $crud = null;
    private $action = "";
    private $name = "";
    private $title = "";
    private $opts = array(
      //  "types" => array(),
        //"fields" => array(),
        "columns" => null,
       // "default_fields" => array(),
        //"callback_fields" => null
    );
    public $callback_data = null;
    public $callback_submit = null;
    public $callback_upload = null;
    public $callback_on_render_fields = array();
    public $custom_buttons = array();
    public $condition_custom_buttons = array();
    public function __construct($crud,$action){
        $this->crud = $crud;
        $this->action = $action;
        $this->opts["columns"] = new _CRUD_fields();
    }
    public function setCustomButton($name,$link,$callback_condition=null){
        $this->custom_buttons[$name] = $link;
        if(is_callable($callback_condition)){
            $this->condition_custom_buttons[$name] = $callback_condition;
        }
        return $this;
    }
    public function getName(){
        return  $this->name;
    }
    public function setName($name){
        $this->name = $name;
        return $this;
    }
    /**
     * @return _CRUD_fields
     */
    public function getColumns(){        
        return $this->opts["columns"];
    }
    public function setData($callback){
        //$this->crud->opts["actions"][$this->action] = $callback;
        if(!is_callable($callback)){
            throw new Exception("Debe ser una funcion anonima que devuelve un array asociativo o un string");
        }
        $this->callback_data = $callback;
        return $this;

    }
    public function onUpload($callback){
        if(!is_callable($callback)){
            throw new Exception("Debe ser una funcion anonima que devuelve bool si se subio correctamente o un string en caso de error");
        }
        $this->crud->_isMultipart=true;
        $this->callback_upload = $callback;
        return $this;
    }
    public function onSubmit($callback){
        if(!is_callable($callback)){
            throw new Exception("Debe ser una funcion anonima que un String en caso de error");
        }
        $this->callback_submit = $callback;
        return $this;
    }
    /**
     * @param string $fieldName Nombre del campo
     * @param callable $callback function($fieldName,array $row):string Funcion anonima que recibe el nombre del campo y un array asociativo y devuelve un string
     * 
     */
    public function onRenderField($fieldName,$callback){
        if(!is_callable($callback)){
            throw new Exception("Debe ser una funcion anonima que devuelve un array asociativo o un string");
        }
        $this->callback_on_render_fields[$fieldName] = $callback;
        return $this;
    }
    public function setFields($columns){
        if(is_string($columns )){
            $args = func_get_args();
            $old =  $this->opts["columns"];
            $this->opts["columns"] = new _CRUD_fields();
            foreach($args as $arg){
                
                $this->opts["columns"]->{$arg} = $old->$arg;
            }            
        }else{
            $this->opts["columns"] = _CRUD_fields::newInstance($columns);
        }        
        return $this;

    }
    /*
    public function fieldsTypes($types){
        $this->opts["types"] = $types;
        return $this;
    }/* */
    /*public function fields($fields){
        $this->opts["fields"] = $fields;
        return $this;
    }*/
    /*
    public function defaultFields($fields){
        //$this->opts["default_fields"] = $fields;
        foreach($fields as $field){
            if($fields && $field instanceof Closure){
                $this->opts["callback_fields"] = $field;
            }
            else{
                $this->opts["default_fields"][$field] = $field;
            }
            //$this->opts["default_fields"][$field] = $field;
        }
        return $this;
    }/* */
}
