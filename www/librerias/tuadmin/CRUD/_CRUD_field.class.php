<?php
class _CRUD_field{
    public $key;
    public $name;
    //public $title;
    public $type = CRUD_types::TEXT; // text,textarea,select,checkbox,radio
    public $json_config = null; // Si tiene alguna configuracion para el tipo de dato
    public $default_value;
    public $default_value_callback;
    public $visible = true;
    public $options = array();
    public function __construct($idName,$name=null){
        $this->key = $idName;
        $this->name = $name==null ? ucfirst($idName) : $name;        
    }
    public function setName($name){
        $this->name= $name;
        return $this;
    }
    public function setType($type,$json_config=null){
        $this->type= $type;        
        $this->json_config = $json_config;
        return $this;
    }
    public function toDate($default_value=null){
        $this->type = CRUD_types::DATE;
        if($default_value!==null){
            $this->default_value = $default_value;
        }
        return $this;
    }
    public function setVisible($bool){
        $this->visible= $bool;
        return $this;
    }
    public function setOptions($options){
        if($this->type == CRUD_types::TEXT){
            $this->type = CRUD_types::SELECT;
        }
        $this->options = $options;
        return $this;
    }
    public function getOptions(){
        if(is_callable($this->options)){
            return call_user_func($this->options);
        }
        return $this->options;
    }
    public function setDefaultData($data_or_callback){
        if($data_or_callback && is_callable($data_or_callback )){
            $this->default_value_callback = $data_or_callback;
        }else{
            $this->default_value = $data_or_callback;
        }
    }
    public function getDefaultData(){
        if($this->default_value_callback){
            return call_user_func($this->default_value_callback);
        }
        return $this->default_value;
    }
}