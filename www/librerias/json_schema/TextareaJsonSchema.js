import { ContainerTextareaJsonSchema } from "./ContainerTextareaJsonSchema.js";
export class TextareaJsonSchema extends HTMLTextAreaElement {
    static TAG = 'textarea-json-schema';
    constructor() {
        super();                
    }

    connectedCallback() {
        const contenedor = ContainerTextareaJsonSchema.create();
        contenedor.setLinkTextarea(this);
        contenedor.render();
        //this.parentNode.replaceChild(contenedor, this);
        this.parentNode.insertBefore(contenedor, this);
        this.readOnly = true;
        console.log("test connected");
    }
    static create(){
        return document.createElement("textarea",{is: TextareaJsonSchema.TAG});
    }
}
customElements.define('textarea-json-schema', TextareaJsonSchema, {extends: 'textarea'});