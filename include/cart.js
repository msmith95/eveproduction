function addToCart(typeId, name, price, corp){
	var quantity = document.getElementById(typeId + "-quantity").value;
	var items = sessionStorage.getItem(corp + '-production-items');
	var corpList = sessionStorage.getItem('corpList');
	if(corpList == null){
		corpList = "";
		corpList = corp;
		sessionStorage.setItem('corpList', corpList);
	}else{
		var corpListArray = corpList.split(";");
		if(corpListArray.indexOf(corp)<0){
			corpList += ";" + corp;
			sessionStorage.setItem('corpList', corpList);
		}
	}
	
	//var items = null;

	if(items == null){
		items = "";
		items = typeId + ":" + name + ":" + price + ":" + quantity ;
	}else{
		items += ";" + typeId + ":" + name + ":" + price + ":" + quantity ;
	}

	sessionStorage.setItem(corp + '-production-items', items);
	console.log(items);
}

function clearCart(){
	sessionStorage.clear();
	location.reload(true);
}