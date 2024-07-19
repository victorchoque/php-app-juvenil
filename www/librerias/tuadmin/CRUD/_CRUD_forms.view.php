<?php
require_once __DIR__ .'/CRUD_types.class.php';
require_once __DIR__ .'/_CRUD_field.class.php';
$CRUD;
/**
 * @var _CRUD_action;
 */
$ACTION;
echo "<h2>" . $CRUD->title . "</h2>";
if($CRUD->_isMultipart){
    echo "<form method='post' enctype='multipart/form-data'>";
}else{
    echo "<form method='post'>";
}
if(isset($ERROR)){
    if(is_string($ERROR) || is_array($ERROR)){
        echo "<div class='alert alert-danger'>";
        if(is_array($ERROR)){
            echo "<ul>";
            foreach($ERROR as $err){
                echo "<li>".$err."</li>";
            }
            echo "</ul>";
        }else{
            echo $ERROR;
        }
        echo "</div>";
    }else if($ERROR === true){
        echo "<div class='alert alert-success'>Registro Guardado Exitosamente</div>";
    }
}
foreach($ACTION->getColumns()->fields as $field){
    if($field->visible) continue;    
    echo '<input type="hidden" name="'.$field->key.'" value="'.$field->getDefaultData().'" />';
}
echo "<table border='1' class='table'>";

foreach($ACTION->getColumns()->fields as $field){
    if(!$field->visible) continue;    
    echo "<tr>";
    echo "<th>"; //var_dump($field->name);var_dump($field);
    echo $field->name;
    echo "</th>";
    echo "<td>";
    render_field($field,$ACTION->getColumns()->fields);
    echo "</td>";
    echo "</tr>";

}
echo "<tfoot>";
echo "<tr><td colspan=3>";
    //echo "<a href='?' class='btn btn-secondary'>Volver a la Lista </a>";
    echo $CRUD->renderButton("list");
    echo " | ";
    echo "<button class='btn btn-primary'> Guardar </button>";
echo "</td></tr>";
echo "</tfoot>";
echo "</table>";
echo "</form>";

function render_field(_CRUD_field $field,$row){
    $class = 'class="form-control"';
    //var_dump($field->type);
    switch($field->type){
        case CRUD_types::NUMBER:                        
            echo "<input type='number' name='{$field->key}' value='{$field->default_value}'  $class/>";
            break;
        case CRUD_types::TEXT:
            echo "<input type='text' name='{$field->key}' value='{$field->default_value}'  $class/>";
            break;
        case CRUD_types::DATE:
            $default = $field->default_value instanceof DateTime ? $field->default_value->format("Y-m-d") : $field->default_value;
            echo "<input type='date' name='{$field->key}' value='{$default}'  $class/>";
            break;
        case CRUD_types::FILE:
            echo "<input type='file' name='{$field->key}' value='{$field->default_value}' $class is='crud-input-file'/>";
            break;
        case CRUD_types::IMAGE:
            echo "<input type='file' name='{$field->key}' value='{$field->default_value}' $class is='crud-input-image'/>";
            break;
        case CRUD_types::TEXTAREA:
            echo "<textarea name='{$field->key}' $class>{$field->default_value}</textarea>";
            break;
        case CRUD_types::JSON_SCHEMA:
                echo "<textarea name='{$field->key}' $class is='textarea-json-schema'>{$field->default_value}</textarea>";
            break;
        case CRUD_types::JSON:            
                if(!$field->json_config) throw new Exception("Para usar el tipo CRUD_types::JSON debe brindar un JSON_SCHEMA");
                $test = $field->json_config;                
                if(is_string($field->json_config)){
                    $test = json_decode($field->json_config,true);                    
                }                
                if(!isset($test['$schema'])) throw new Exception("Para usar el tipo CRUD_types::JSON debe brindar un JSON_SCHEMA valido");
                echo "<textarea name='{$field->key}' $class base64-json-schema='".base64_encode(json_encode($test))."' is='textarea-json'>{$field->default_value}</textarea>";
            break;
                        
        case CRUD_types::SELECT:
            echo "<select name='{$field->key}' $class>";
            foreach($field->getOptions() as $key => $value){
                echo "<option value='{$key}'";
                if($key == $field->default_value){
                    echo " selected";
                }
                echo ">{$value}</option>";
            }
            echo "</select>";
            break;
        /*case CRUD_types::CHECKBOX:
            echo "<input type='checkbox' name='{$field->key}' value='1'";
            
            if($key == $field->default_value){
                echo " checked";
            }
            echo " />";
            break;/* */
        case CRUD_types::RADIO:
            foreach($field->getOptions() as $key => $value){
                echo "<input type='radio' name='{$field->key}' value='{$key}'";
                if($key == $field->default_value){
                    echo " checked";
                }
                echo " />{$value}";
            }
            break;
        case CRUD_types::CHECKBOX_MULTIPLE:
            $checkeds = is_array($field->default_value) ? $field->default_value : explode(",","".$field->default_value);
            foreach($field->getOptions() as $key => $value){
                echo "<label>";
                echo "<input type='checkbox' name='{$field->key}[]' value='{$key}'";
                if(in_array($key,$checkeds)){
                    echo " checked";
                }
                echo " />{$value}";
                echo "</label> ";
            }
            break;
    }
}