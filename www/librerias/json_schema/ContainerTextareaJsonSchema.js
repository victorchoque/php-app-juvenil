export class ContainerTextareaJsonSchema extends HTMLElement {    
    static TAG = 'container-textarea-json-schema';
    constructor() {
        super();
        this.attachShadow({ mode: 'open' });                               
        this._textarea = null;
        this._jsonSchema = {
            "$schema": "http://json-schema.org/draft-07/schema#",
            "type": "object",
            "properties": {}
        };
        //this.shadowRoot = 
    }
    setLinkTextarea(textarea) {
        this._textarea = textarea;
        //load json
        if(textarea.value) {
            try {
                const check = JSON.parse(textarea.value);
                this._jsonSchema = check;
            } catch (error) {}
        }
    }
    render() {
        this.shadowRoot.innerHTML = `
            <style>
                h5{margin: 0;padding: 0 0 5px 0;     }
                .hidden { display: none; }
                .crud-container { border: 1px solid #ccc; padding: 10px; margin-top: 10px; background: #f9f9f9; }
                .crud-container .inputs { display: flex; justify-content: space-between; gap: 10px; }
                .crud-container input, .crud-container textarea { margin-bottom: 10px; width: 100%; }
                .crud-container button { margin-right: 5px; }
                .property-list { margin-top: 10px; }
                .property-item { margin-bottom: 5px; }
            </style>
            <div class="crud-container">
                <h3>JSON Schema Properties</h3>
                <div class="inputs">
                    <select id="type">
                        <option value="string">string</option>
                        <option value="number">number</option>
                        <option value="boolean">boolean</option>
                        <option value="integer">integer</option>    
                    </select>
                    <input type="text" id="id" placeholder="...Id">
                    <input type="text" id="description" placeholder="...Nombre">                            
                </div>                        
                <button id="addBtn">Agregar Propiedad</button>
                <div class="property-list" id="propertyList"></div>
            </div>
        `;

        this.shadowRoot.querySelector('#addBtn').addEventListener('click', () => this.addProperty());
        this.renderProperties();
    }

    addProperty() {
        const id = this.shadowRoot.querySelector('#id').value;
        const description = this.shadowRoot.querySelector('#description').value;
        const type = this.shadowRoot.querySelector('#type').value;

        if (!id || !type) {
            alert('ID and Type are required.');
            return;
        }

        const propertyList = this.shadowRoot.querySelector('#propertyList');
        const propertyItem = document.createElement('div');
        propertyItem.classList.add('property-item');
        propertyItem.innerHTML = `
            <strong>ID:</strong> ${id} <br>
            <strong>Description:</strong> ${description} <br>
            <strong>Type:</strong> ${type}
            <button class="removeBtn">Remove</button>
        `;
        propertyItem.querySelector('.removeBtn').addEventListener('click', () => {                    
            delete this._jsonSchema.properties[id];
            this.updateTextarea();
        });
        propertyList.appendChild(propertyItem);
        this._jsonSchema.properties[id] = { type, description };
        this.updateTextarea();
    }

    updateTextarea() {
        // const properties = [];
        // this.shadowRoot.querySelectorAll('.property-item').forEach(item => {
        //     const id = item.innerHTML.match(/ID:<\/strong> (.*?) <br>/)[1];
        //     const description = item.innerHTML.match(/Description:<\/strong> (.*?) <br>/)[1];
        //     const type = item.innerHTML.match(/Type:<\/strong> (.*?)<\/button>/)[1];
        //     properties.push({ id, description, type });
        // });

        // // Convert the properties array to a JSON string
        // const jsonContent = JSON.stringify(properties, null, 2);

        // // Update the original textarea with the JSON content
        // const originalTextarea = this._textarea;
        this._textarea.value = JSON.stringify(this._jsonSchema, null, 2);
        //originalTextarea.value = jsonContent;
    }

    renderProperties() {
        // const originalTextarea = this._textarea;
        // const content = originalTextarea.value;
        try {
            const properties = this._jsonSchema.properties;
            properties.forEach(property => {
                const propertyList = this.shadowRoot.querySelector('#propertyList');
                const propertyItem = document.createElement('div');
                propertyItem.classList.add('property-item');
                propertyItem.innerHTML = `
                    <strong>ID:</strong> ${property.id} <br>
                    <strong>Description:</strong> ${property.description} <br>
                    <strong>Type:</strong> ${property.type}
                    <button class="removeBtn">Remove</button>
                `;
                propertyItem.querySelector('.removeBtn').addEventListener('click', () => propertyItem.remove());
                propertyList.appendChild(propertyItem);
            });
        } catch (e) {
            // Handle JSON parsing error if necessary
        }
    }
    static create(){
        return document.createElement(ContainerTextareaJsonSchema.TAG);
    }
}    
customElements.define(ContainerTextareaJsonSchema.TAG, ContainerTextareaJsonSchema);