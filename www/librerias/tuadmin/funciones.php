<?php
function mostrarTabla($dataRows,$fields,$callback = null,$callback_cols = array()){
    echo "<table border='1'>";
    echo "<tr>";
    foreach($fields as $field => $alias){
        if(is_numeric($field)){
            echo "<th>".$alias."</th>";
        }else{
            if($alias != "" && $alias != null){
                echo "<th>".$alias."</th>";
            }else{
                echo "<th>".$field."</th>";
            }
        }
    }
    if($callback != null){
        echo "<th>Acciones</th>";
    }
    echo "</tr>";
    foreach($dataRows as $row){
        echo "<tr>";
        foreach($row as $key=> $field){
            if($callback_cols != null && in_array($field,$callback_cols)){
                echo "<td>";
                call_user_func_array($callback,array($row));
                echo "</td>";
            }else{
                echo "<td>".$field."</td>";
            }            
        }
        if($callback != null){
            echo "<td>";
            call_user_func_array($callback,array($row));
            echo "</td>";
        }
        echo "</tr>";
    }
}