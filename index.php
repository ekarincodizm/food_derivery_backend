
<?php

ini_set('display_errors', 1); // display errors
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/router.php';

$router = new Router();
$router->add('', array('controller' => 'Home', 'action' => 'index'));
$router->add('admin', array('controller' => 'Admin', 'action' => 'index'));

$router->add('admin/menu/create', array('controller' => 'Admin', 'action' => 'create_menu'));
$router->add('admin/menu/update', array('controller' => 'Admin', 'action' => 'update_menu'));
$router->add('admin/menu/delete', array('controller' => 'Admin', 'action' => 'delete_menu'));
$router->add('admin/menu', array('controller' => 'Admin', 'action' => 'get_menu'));

$router->add('admin/category/create', array('controller' => 'Admin', 'action' => 'create_category'));
$router->add('admin/category/update', array('controller' => 'Admin', 'action' => 'update_category'));
$router->add('admin/category/delete', array('controller' => 'Admin', 'action' => 'delete_category'));
$router->add('admin/category', array('controller' => 'Admin', 'action' => 'get_category'));

$router->add('admin/shop/create', array('controller' => 'Admin', 'action' => 'create_shop'));
$router->add('admin/shop/update', array('controller' => 'Admin', 'action' => 'update_shop'));
$router->add('admin/shop/{id:\w+}', array('controller' => 'Admin', 'action' => 'get_shop_by_id'));
$router->add('admin/shop', array('controller' => 'Admin', 'action' => 'get_shop'));

$router->add('admin/shop_category/{id:\w+}', array('controller' => 'Admin', 'action' => 'get_shop_category'));

$router->add('admin/top_shop/update', array('controller' => 'Admin', 'action' => 'update_top_shop'));
$router->add('admin/top_shop', array('controller' => 'Admin', 'action' => 'get_top_shop'));

$router->add('admin/shop_menu/update', array('controller' => 'Admin', 'action' => 'update_shop_menu'));
$router->add('admin/shop_menu/{id:\w+}', array('controller' => 'Admin', 'action' => 'get_shop_menu'));

$router->add('admin/search', array('controller' => 'Admin', 'action' => 'get_search'));

$router->dispatch($_SERVER['QUERY_STRING']);
