<?php
session_start();
//Обработка данных сессии
$Num=(int)$_POST['itemId'];	
$Items=explode("/", $_SESSION['busket']);
$t=count($Items);
$ItemsA=[];
for ($i=0;$i<$t;$i++)
	{
	if ($i!=$Num)	
		array_push($ItemsA,$Items[$i]);
	}
$_SESSION[busket]=implode('/',$ItemsA);
if ((int)$_SESSION[colvo]>0)
{
	$_SESSION[colvo]=(int)$_SESSION[colvo]-1;
	//обработка списка товаров заказа
	$contentA=$_SESSION['ItemList'];
	$contentB=[];
	echo    "<tr>".	
				"<td>№</td>".	
				"<td>Название товара</td>".	
				"<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>".	
				"<td>Цена</td>".
			"</tr>";
	$t=count($contentA);	
    $m=0;	
    $g=1;	
	for ($i=0;$i<$t;$i++) 
		{
			if ($i!=$Num)	
			{	
				$item=$contentB[]=$contentA[$i];
				echo    "<tr>".
						"<td>$g</td>".
						"<td><a href='index.php?path=product/show/{$item[id]}'>{$item[title]}</a></td>".	
						"<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>".
						"<td>$item[price] руб</td>".
						"<td><p onclick='DelBusketItem($m,{$_SESSION[colvo]});' class='DelItem'>Удалить товар из корзины</p></td>".	
					"	</tr>";	
				$m++;			
				$g++;			
			}
		}
	$_SESSION['ItemList']=$contentB;
}
?>	
