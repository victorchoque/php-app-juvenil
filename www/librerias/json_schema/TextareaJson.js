export class TextareaJson extends HTMLTextAreaElement {
    static TAG = 'textarea-json';
    constructor() {
        super();                
    }

    connectedCallback() {
        const contenedor = document.createElement("div");
        const schema = this.getSchemaFrom();
        const baseName = this.getAttribute("name");
        this.buildFormElements(contenedor, schema.properties, baseName);

        //this.parentNode.replaceChild(contenedor, this);
        this.parentNode.replaceChild(contenedor, this);            
        
        console.log("test connected");
    }
    static create(){
        return document.createElement("textarea",{is: TextareaJson.TAG});
    }

    createInputElement(key, schema, baseName) {
            const name = `${baseName}[${key}]`;
            let input;
            switch (schema.type) {
                case 'string':
                    input = document.createElement('input');
                    input.type = 'text';
                    break;
                case 'number':
                    input = document.createElement('input');
                    input.type = 'number';
                    break;
                case 'boolean':
                    input = document.createElement('input');
                    input.type = 'checkbox';
                    break;
                default:
                    console.log(schema);
                    console.warn('Unsupported schema type:', schema.type);
                    return null;
            }
            input.name = name;
            const label = document.createElement('label');
            label.textContent = schema.description? schema.description : key;
            label.appendChild(input);                
            return label;
        }
        buildFormElements(container, properties, baseName) {
            for (const [key, value] of Object.entries(properties)) {
                const input = this.createInputElement(key, value, baseName);
                if (input) {
                    container.appendChild(input);
                    container.appendChild(document.createElement('br'));
                }
            }
        }
        getSchemaFrom() {
            try {
                const base64Schema = this.getAttribute('base64-json-schema');
                const jsonSchemaString = atob(base64Schema);
                //console.log(JSON.parse(jsonSchemaString));
                return JSON.parse(jsonSchemaString);
            } catch (error) {
                console.error('Invalid JSON schema:', error);
                return null;
            }
        }
}
customElements.define(TextareaJson.TAG, TextareaJson,{extends: 'textarea'});