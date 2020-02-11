<?php
include_once "DB.php";

class m_Catalog
{
    public function getGoods($status)
    {// показываем товары, где статус равен
        return DB::getRows('SELECT g.id, g.name, g.price, g.img, c.name cat_name
                                FROM goods g
                                INNER JOIN categories c ON c.id_category = g.category
                                WHERE g.status =:status', ['status' => $status]);

    }

    public function addToOrder($name, $phone, $goods)
    {// показываем товары, где статус равен
        $idOrders = '';
        foreach ($goods as $good) {
            $idOrders .= $good . ',';
        }
        return DB::insert('INSERT INTO orders(name_user, phone_user, goods_user) VALUES (:name,:phone,:goods)',
            ['name' => $name, 'phone' => $phone, 'goods' => $idOrders]);

    }


    public function addGoodToBasket($id)//добавляем товар по id в массив из сессии
    {
        if ($id != null) {
            $items = array();
            if ($_SESSION['items'] != null) {
                $items = $_SESSION['items'];
            }
            $items[] = $id;
            $_SESSION['items'] = $items;
        }
        $this->refresh('?c=catalog');
    }

    //показываем 1 товар по id

    public function refresh($url)
    {// редирект
        echo '<meta http-equiv="refresh" content="0; url=' . $url . '">';

    }

    public function getItemsToId($mas)//получаем из сессии массив с id, заполняем новый массив товарами из бд
    {
        $items = $mas;
        $args = array();
        if ($items != null) {
            foreach ($items as $item) {
                $args[] = $this->getGood($item);
            }
        }
        return $args;

    }

    public function getGood($id)//получаем 1 товар по id
    {
        return DB::getRow('SELECT g.id, g.name, g.price, g.img, c.name cat_name
                                FROM goods g
                                INNER JOIN categories c ON c.id_category = g.category
                                WHERE g.id =:id', ['id' => $id]);
    }

    public function getTotalAmount($mas)//считаем общую стоимость, принимаем на вход массив с товарами
    {
        $totalSum = 0;
        foreach ($mas as $ma) {
            $totalSum += $ma['price'];
        }
        return $totalSum;
    }
}
