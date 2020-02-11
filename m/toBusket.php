<?php
include_once "m_Catalog.php";

session_start();
	$as = new m_Catalog();
	$items = array();
	if ($_SESSION['items'] != null) {
		$items = $_SESSION['items'];
	}
	$items[] = (int)$_POST[itemId];
	$_SESSION['items'] = $items;
	$_SESSION['countGoods'] = count($_SESSION['items']);
	$args = $as->getItemsToId($_SESSION['items']);
	$_SESSION['sumGoods'] = $as->getTotalAmount($args);

echo '<div>Корзина: ' . $_SESSION['countGoods'] . '</div>' . $_SESSION['sumGoods'] . '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 440 440" height="24">
       <path d="M232.5 242.4c63.9 0 115.9-54.4 115.9-121.2C348.4 54.4 296.4 0 232.5 0H120.6v282.4h-29v30h29V440h30V312.4h102v-30H150.6v-40H232.5zM150.6 30h82c47.4 0 85.9 40.9 85.9 91.2 0 50.3-38.5 91.2-85.9 91.2h-82V30z"/></svg>';

?>	
