<?php

session_start();
include_once "m/m_Catalog.php";

class c_Catalog extends Controller
{
    const MAIN_TMPL = 'catalog.tmpl';// Внешний шаблон

    private $mCatalog;


    public function __construct()
    {
        $this->mCatalog = $this->modelCatalog();
    }

    public function modelCatalog()
    {
        return new m_Catalog();
    }

    public function action_index()// СТРАНИЦА ТОВАРОВ - ГЛАВНАЯ
    {
        $args = $this->mCatalog->getGoods(1);
        $this->title = 'Каталог игровых товаров';
        $text = '<h2>Игры экшен в каталоге Steampay.com</h2>
            <p>В нашем каталоге всегда публикуются и дата выхода игры, и ее краткое описание. Просмотрите его &ndash; у
                нас есть actionы на любой вкус! Ну а фильтр справа поможет быстрее найти те игры, которые
                соответствуют вашим вкусам.</p>';
        $count = count($args);
        $this->content = $this->TemplatePage('v_catalog.tmpl', array('count' => $count, 'goods' => $args, 'title' => $this->title, 'text' => $text));

    }

    public function action_good()// СТРАНИЦА ТОВАРА
    {
        $id = $_GET['id'];
        $args = $this->mCatalog->getGood($id);
        $this->title = $args['name'];
        $text = '<h2>Вперед, приключения ждут</h2><p>В нашем ярком приключении для одного или двух игроков вы играете за нового работника корпорации «Родной Космос». Вас выбросили на неизведанной планете почти без оборудования, и теперь ваша задача – определить, подходит ли планета для заселения людьми. Но, возможно, не ваша нога ступила на нее первой...</p>';
        $this->content = $this->TemplatePage('v_good.tmpl', array('good' => $args, 'title' => $this->title, 'text' => $text));

    }

//    public function action_add()// добавить товар в корзину функция не нужна, добавил js
//            {
//        $id = $_GET['id'];
//        $this->mCatalog->addGoodToBasket($id);
//
//    }

    public function action_basket()// СТРАНИЦА КОРЗИНЫ
    {
        $this->title = 'Корзина товаров';
        $args = $this->mCatalog->getItemsToId($_SESSION['items']); //передаем массив с id товарами и получаем массив с товарами
        $this->content = $this->TemplatePage('v_nbasket.tmpl', array('goods' => $args, 'title' => $this->title, 'totalSum' => $_SESSION['sumGoods']));

        if (isset($_POST['cleanBasket'])) {//чистим корзину и перезагружаем страницу
            unset($_SESSION['items']);
            unset($_SESSION['countGoods']);
            unset($_SESSION['sumGoods']);
            $this->mCatalog->refresh('?act=basket&c=catalog');
        }
        if (isset($_POST['orderGood'])) {

            $this->action_order();
        }

    }

    public function action_order()// Написать функцию отправки заказа, добавить кнопки удаления товара из корзины
    {
        $name = $_POST['nameOrder'];
        $phone = $_POST['phoneOrder'];
        $sumOrder = $_SESSION['sumGoods'];
        $this->mCatalog->addToOrder($name,$phone,$_SESSION['items']);
        $_SESSION = array();
        $this->title = 'Корзина товаров';
        $this->content = $this->TemplatePage('v_order.tmpl', array('name' => $name, 'phone' => $phone, 'title' => $this->title, 'totalSum' => $sumOrder));

    }

    public function render()
    {// генерация внешнего шаблона
        $vars = array('title' => $this->title, 'content' => $this->content, 'countGoods' => $_SESSION['countGoods'], 'sumGoods' => $_SESSION['sumGoods']);
        $page = $this->TemplatePage(self::MAIN_TMPL, $vars);
        echo $page;
    }
}