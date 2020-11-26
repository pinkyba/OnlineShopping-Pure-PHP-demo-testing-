$(document).ready(function(){

	cartNoti();
	showdata();

	$('.addtocartBtn').on('click',function(){
		var id = $(this).data('id');
		var name = $(this).data('name');
		var price = $(this).data('price');
		var discount = $(this).data('discount');
		var photo = $(this).data('photo');
		var codeno = $(this).data('codeno');
		var qty = 1;

		var mylist = {
			id: id,
			name: name,
			codeno: codeno,
			qty: qty,
			price: price,
			discount: discount,
			photo: photo

		}
		

		var cart = localStorage.getItem('cart');
		var cartArray;

		if(cart == null){
			cartArray = [];
		}else{
			cartArray = JSON.parse(cart);
		}

		var status = false;

		$.each(cartArray, function(i,v){
			if(id == v.id){
				v.qty ++;
				status = true;
			}
		})

		if(!status){
			cartArray.push(mylist);
		}

		var cartData = JSON.stringify(cartArray);
		localStorage.setItem('cart', cartData);

		cartNoti();
	})




	//cartNoti
	function cartNoti(){
		var cart = localStorage.getItem('cart');

		if(cart){
			var cartArray = JSON.parse(cart);
			var totalAmount = 0;
			var notiCount = 0;

			$.each(cartArray, function(i,v){
				var unitprice = v.price;
				var discount = v.discount;
				var qty = v.qty;

				if(discount){
					var price = discount*qty;
				}else{
					var price = unitprice*qty;
				}

				totalAmount += price;
				notiCount += qty;
			})

			$('.cartNoti').html(notiCount);
			$('.cartAmount').html(totalAmount+' Ks');
		}
		else{
			$('.cartNoti').html(0);
			$('.cartAmount').html(0+' Ks');
		}
	}



	//cart detail (cart.php)
	function showdata(){		
		var cart = localStorage.getItem('cart');
		var html = '';
		if(cart){
			var cartArray = JSON.parse(cart);
			var subtotal = 0;
			var total = 0;
			

			$.each(cartArray,function(i,v){
				var id = v.id;
				var name = v.name;
				var codeno = v.codeno;
				var qty = v.qty;
				var unitprice = v.price;
				var discount = v.discount;
				var photo = v.photo;
				var d_subtotal = discount*qty;
				var u_subtotal = unitprice*qty;
				
				html += `<tr>
							<td>
								<button class="btn btn-outline-danger remove btn-sm" id="btndelete" data-key=${i} style="border-radius: 50%"> 
									<i class="icofont-close-line"></i> 
								</button> 
							</td>
							<td> 
								<img src="${photo}" class="cartImg">						
							</td>
							<td> 
								<p> ${name} </p>
								<p> ${codeno} </p>
							</td>
							<td>
								<button class="btn btn-outline-secondary plus_btn" id="btnincrease" data-key=${i}> 
									<i class="icofont-plus"></i> 
								</button>
							</td>
							<td>
								<p> ${qty} </p>
							</td>
							<td>
								<button class="btn btn-outline-secondary minus_btn" id="btndecrease" data-key=${i}> 
									<i class="icofont-minus"></i>
								</button>
							</td>`;

				if(discount){
					html += `<td>
								<p class="text-danger"> 
									${discount} Ks
								</p>
								<p class="font-weight-lighter"> 
								<del> ${unitprice} Ks</del> </p>
							</td>
							<td>
							<p> ${d_subtotal} Ks </p>
							<td>`;
					total += d_subtotal;

				}
				else {
					html += `<td>
								<p class="text-danger"> 
									${unitprice} Ks
								</p>
							</td>
							<td>
							<p> ${u_subtotal} Ks </p>
							<td>`;
					total += u_subtotal;
				}							
			
			})
			$('.total').html(total+' Ks');		

		}
		$('#shoppingcart_table').html(html);
	}


	//increase qty button
	$('#shoppingcart_table').on('click', '#btnincrease', function(){
		var key = $(this).data('key');

		var cart = localStorage.getItem('cart');
		var cartArray = JSON.parse(cart);
		$.each(cartArray,function(i,v){
			if(key==i){
				v.qty++;
			}
		})

		var cartData = JSON.stringify(cartArray);
		localStorage.setItem('cart', cartData);

		showdata();
		cartNoti();
	})


	// decrease quantity button
	$('#shoppingcart_table').on('click', '#btndecrease', function(){
		var key = $(this).data('key');

		var cart = localStorage.getItem('cart');
		var cartArray = JSON.parse(cart);
		$.each(cartArray,function(i,v){
			if(key==i){				
				v.qty--;
				if(v.qty == 0){
					alert("Your item count is zero.");
					cartArray.splice(i,1);

				}
			}
		})

		var cartData = JSON.stringify(cartArray);
		localStorage.setItem('cart', cartData);

		showdata();
		cartNoti();
	})

	// delete button
	$('#shoppingcart_table').on('click', '#btndelete', function() {
		var key = $(this).data('key');

		var cart = localStorage.getItem('cart');
		var cartArray = JSON.parse(cart);
		$.each(cartArray,function(i,v){
			if(key==i){								
				cartArray.splice(i,1);
			}
		})

		var cartData = JSON.stringify(cartArray);
		localStorage.setItem('cart', cartData);

		showdata();
		cartNoti();
		
	})


	// checkout button
	$('.checkoutbtn').on('click',function(){
		
		var cart = localStorage.getItem('cart');
		var cartArray = JSON.parse(cart);

		var notes = $('#notes').val();
		console.log(notes);

		var totalAmount = 0;

		$.each(cartArray, function(i,v){
			var unitprice = v.price;
			var discount = v.discount;
			var qty = v.qty;

			if(discount){
				var price = discount*qty;
			}else{
				var price = unitprice*qty;
			}

			totalAmount += price;
		})

		// carry data with ajax (background agent)
		// for not to get browser reload
		$.post('storeorder.php',{
			value1: cartArray,
			value2: notes,
			value3: totalAmount
		},function(response){
			localStorage.clear();
			location.href = "ordersuccess.php";
		})
	})

})
