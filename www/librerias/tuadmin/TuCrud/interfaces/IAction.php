<?php
namespace TuCrud\interfaces;
interface IAction{
    function setFields();
    function onSubmit();
    function setData();
    function addButton($id,$text,\Closure $callback,\Closure $condition = null);
}