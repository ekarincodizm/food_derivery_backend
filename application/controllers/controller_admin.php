<?php


class Menu
{
    public $id;
    public $name;
    public $url;
}

class controller_admin extends Controller
{
    public $model;
    public $param;
    function __construct($param)
    {
        parent::__construct($param);
        $this->model = new model_admin();
        $this->param = $param;
    }

    function index() {
        $this->view->generate('admin/admin_view.php', 'template_view.php');
    }

    function get_menu() {
        header('Content-Type: application/json');
        echo json_encode($this->model->get_menu());
    }

    function create_menu() {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->create_new_menu($data);
    }

    function update_menu() {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->update_menu($data);
    }

    function delete_menu() {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->delete_menu($data);
    }

    function get_category() {
        header('Content-Type: application/json');
        echo json_encode($this->model->get_category());
    }

    function create_category() {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->create_category($data);
    }

    function update_category() {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->update_category($data);
    }

    function delete_category() {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->delete_category($data);
    }

    function create_shop() {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->create_shop($data);
    }

    function get_shop_by_id() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode($this->model->get_shop_by_id($this->param['id']));
    }

    function get_shop() {
        header('Content-Type: application/json');
        echo json_encode($this->model->get_shop());
    }

    function update_shop() {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->update_shop($data);
    }

    function get_shop_category() {
        header('Content-Type: application/json');
        echo json_encode($this->model->get_shop_category($this->param['id']));
    }

    function get_top_shop() {
        header('Content-Type: application/json');
        echo json_encode($this->model->get_top_shop());
    }

    function update_top_shop() {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->update_top_shop($data);
    }

    function get_shop_menu() {
        header('Content-Type: application/json');
        echo json_encode($this->model->get_shop_menu($this->param['id']));
    }

    function update_shop_menu() {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->update_shop_menu($data);
    }

    function get_search() {
        echo json_encode($this->model->get_search($this->param));
    }
}
