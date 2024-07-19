prototipo de categoria
una categorias sera un esquema JSON basico, 
clave:string valor:string|int

zapatos 
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
      "minItems": 1,
      "items": {
        "type": "string",
        "pattern": "^[0-9]+[.,][0-9]+(?:CHN|KOR|USA|EUR|\\b[A-Z]{3,}\\b)$"
      }
    }
  },
}
```



