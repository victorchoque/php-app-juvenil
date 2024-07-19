<?php
namespace TuCrud\interfaces;
interface ITuCrud{
    /**
     * Para Acciones Asociados a botones y no dependan de la interfaz
     * paso 1: Crear la AcciónButton
     * paso 2: Añadir el Callback de la acción
     * paso 3: EL crud Agregara un  form post exclusivo para estas acciones
     * paso 4: el boton sera un button que apuntara al formulario si pertenecer a su DOM mediante el attributo data-action
     * paso 5: el formulario debera tener algun codigo anti-csrf, habra que saber como adaptarlo
     * paso 6: El boton al ser presionado debera enviar el action al formulario
     */
    function executeCustomAction();
    /**
     * debera renderizar el formulario o tabla 
     */
    function show();
}