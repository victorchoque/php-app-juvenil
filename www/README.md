# prototipo de categoria
una categorias sera un esquema JSON basico, 
clave:string valor:string|int

## zapatos 
```json
{
  "$schema": "http://json-schema.org/draft-07/schema#",
  "type": "object",
  "properties": {
    "genero":{
        "type":"string",
        "enum" : ["hombre","mujer","unisex"]
    },    
    "talla": {
      "type": "array",
      "$comment":"como: 27 EUR ; 25 CHN ;5,5 USA ",
      "description":"Talla o Tamaño",
      "minItems": 1,
      "items": {
        "type": "string",
        "pattern": "^[0-9]+[.,][0-9]+(?:CHN|KOR|USA|EUR|\\b[A-Z]{3,}\\b)$"
      }
    }
  },
}
```
## Bolsas y mochilas
```json
{
  "$schema": "http://json-schema.org/draft-07/schema#",
  "type": "object",
  "properties": {
    "genero":{
        "type":"string",
        "enum" : ["hombre","mujer","unisex"]
    },    
    "capacidad": {
      "type": "number",
      "$comment":"como: 27 EUR ; 25 CHN ;5,5 USA ",
      "description":"capacidad en litros",
      "min":0      
    }
  },
}
```

# descargar archivos para SKIN

```php

// descargarArchivos('/carpeta/deDescarga/',"http://dominio_raiz.com/subcarpeta",["plugins/revolution/css/settings.css","plugins/revolution/css/settings2.css"])
function descargarArchivos($directorioBase, $urlBase, $archivos) {
    foreach ($archivos as $archivo) {
        // Crear la ruta completa del archivo
        $rutaCompleta = $directorioBase . $archivo;

        // Crear la URL completa del archivo
        $urlCompleta = rtrim($urlBase, '/') . '/' . ltrim($archivo, '/');

        // Verificar si el archivo ya existe
        if (!file_exists($rutaCompleta)) {
            // Crear los directorios necesarios si no existen
            $directorio = dirname($rutaCompleta);
            if (!is_dir($directorio)) {
                mkdir($directorio, 0755, true);
            }

            // Descargar el archivo
            $contenido = file_get_contents($urlCompleta);
            if ($contenido === false) {
                echo "Error al descargar el archivo: $urlCompleta\n";
                continue;
            }

            // Guardar el archivo en la ruta especificada
            file_put_contents($rutaCompleta, $contenido);
            echo "Archivo descargado: $rutaCompleta\n";
        } else {
            echo "El archivo ya existe: $rutaCompleta\n";
        }
    }
}
```


