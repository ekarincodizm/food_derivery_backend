<?php

class controller_home extends Controller
{
    public $model;
    function __construct($param)
    {
        parent::__construct($param);
        // $this->model = new model_home();
    }

    function index() {
        // $data = $this->model->get_data();
        $this->view->generate('home/home_view.php', 'template_view.php', $data);
    }
}
