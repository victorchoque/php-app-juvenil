<?php
$CRUD;
/**
 * @var _CRUD_action $ACTION
 */
echo "<h2>" . $CRUD->title ."</h2>";
echo "<table border='1' class='table'>";
echo "<tr>";

/**
 * @var _CRUD_field $field
 */
$visible_columns = array();
foreach($ACTION->getColumns()->fields as $field){
    if(!$field->visible) continue;
    echo "<th>";
    echo $field->name;
    echo "</th>";
    $visible_columns[] = $field->key;
}
if($CRUD->hasCreate){
    echo "<th>".$CRUD->renderButton("create")."</th>";
}
echo "</tr>";
foreach(call_user_func_array($ACTION->callback_data,[]) as $row){    
    echo "<tr>";
    foreach($visible_columns as $key){
        echo "<td>";
        if(is_callable( $ACTION->getColumns()->fields[$key]->default_value_callback)){
            echo call_user_func_array(
                $ACTION->getColumns()->fields[$key]->default_value_callback,[$row]
            );
        }
        else if(isset($ACTION->callback_on_render_fields[$key])){
            echo call_user_func_array(
                $ACTION->callback_on_render_fields[$key],[$key, $row[$key]   ]
            );
        }
        else{
            echo $row[$key];
        }
        echo "</td>";
                    
    }
    echo "<td>";
    if($CRUD->hasUpdate){
        echo $CRUD->renderButton("update",$row)        ;
    }
    if($CRUD->hasDelete){
        echo $CRUD->renderButton("delete",$row)        ;
    }
    if(is_array($ACTION->custom_buttons)){
        foreach($ACTION->custom_buttons as $name=>$url){
            if(isset($ACTION->condition_custom_buttons[$name])){
                if(!call_user_func_array($ACTION->condition_custom_buttons[$name],[$row])){
                    continue;
                }
            }
            echo " ";
            echo $CRUD->renderCustomButton($name,$url,$row);
        }
    }
    echo "</td>";
    echo "</tr>";
}
echo "</table>";