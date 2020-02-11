function AddToBusket(index)
{
	$.ajax({ 	 
	  url: "m/toBusket.php",
	  method: 'post', 
	  data: {itemId:index} 
	}).done(function(data){ 
	  // Успешное получение ответа 	  
	  $("#busket").html(data);
		var str="<span>добавлено в корзину</span>";
		$("#butsel").html(str);
	});
}	

function DelBusket()
{
	$.ajax({ 	 
	  url: "m/CleanBusket.php",
	  method: 'post', 
	  data: {
			 	
			} 
	}).done(function(data){ 
	    $("#OrderList").html(data); 
		var str="&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Корзина &nbsp&nbsp&nbsp";
		$("#busket").html(str);
	});
}

function DelBusketItem(index,NumItems)
{
	$.ajax({ 	 
	  url: "../models/fromBusket.php", 
	  method: 'post', 
	  data: {
			 itemId:index,	
			} 
	}).done(function(data){ 
	  // Успешное получение ответа 	  
	    $("#OrderList").html(data); 
		var str="&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Корзина &nbsp&nbsp&nbsp"+(NumItems-1);
		$("#busket").html(str);
		var strA="<div class='ButtSend' onclick='SendOrder("+(NumItems-1)+");' type='button' name='submit' value=''>Заказать</div>";
		$("#ButtOrder").html(strA);
	});
}

function SendOrder(ind)
{
	if (ind==0)
	{	

	}
		else
	{
		$.ajax({ 	 
		  url: "../models/sendOrder.php", 
		  method: 'post', 
		  data: {
				 nameUser:$("#nameUser").val(), 
				 phoneUser:$("#phoneUser").val()
				} 
		}).done(function(data){ 
		  // Успешное получение ответа 	  
			$("#OrderStatus").html(data); 
			$("#OrderList").html(); 
			var str="&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Корзина &nbsp&nbsp&nbsp";
			$("#busket").html(str);
		});
	}
}	
