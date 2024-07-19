<?php
require __DIR__ .'/_CRUD_field.class.php';
class _CRUD_fields{
    public $fields = array();
    public function __call($idKey,$args){
        $field = new _CRUD_field($idKey,@$args[0]);
        //$field->name = $name;
        //$field->title = $args[0];
        //$field->type = $args[2];
        $this->fields[$idKey] = $field;
        return $this;
    }
    public function __get($name){
        if( !isset($this->fields[$name]) ){
            $this->fields[$name] = new _CRUD_field($name);
        }
        return  $this->fields[$name] ;
    }
    public function __set($name,$value){
        if($value instanceof _CRUD_field){
            $this->fields[$name] = $value;
            return;
        }
        //$this->fields[$name] = new _CRUD_field($name,$value);
    }
    public static function fromArray($fields_key_value){
        $instance = new static();
        if(isset($fields_key_value[0])){
            foreach($fields_key_value as $key){
                $instance->fields[$key] = new _CRUD_field($key);
            }
        }else{
            foreach($fields_key_value as $key => $value){
                if($value==null || $value = ''){
                    $instance->fields[$key] = new _CRUD_field($key,$value);
                }
            }
        }
        return $instance;
        
    }
    public static function newInstance($array_or_callback){
        if(is_array($array_or_callback)){
            return static::fromArray($array_or_callback);
        }else if(is_callable($array_or_callback)){
            $instance = new static();
            call_user_func_array($array_or_callback,[$instance]);
            return $instance;
        }
    }
}