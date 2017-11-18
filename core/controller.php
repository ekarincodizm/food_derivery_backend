<?php
/**
 * Created by PhpStorm.
 * User: boonprakit
 * Date: 7/2/2017
 * Time: 2:59 PM
 */
class Controller {

    public $model;
    public $view;
    public $param;

    function __construct($param)
    {
        $this->view = new View();
        $this->param = $param;
    }

    function index()
    {

    }
}
