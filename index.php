<?php
function __autoload($classname){
    include_once("c/$classname.php");
}

$action = 'action_';
$action .= (isset($_GET['act'])) ? $_GET['act'] : 'index';

switch ($_GET['c'])
{
    case 'articles':
        $controller = new c_Page();
        break;
    case 'users':
        $controller = new c_User();
        break;
    case 'catalog':
        $controller = new c_Catalog();
        break;
    default:
        $controller = new c_Page();
}

$controller->Request($action);
//каталог товаров ?c=catalog
