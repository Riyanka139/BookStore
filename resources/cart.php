<?php require_once("config.php"); ?>



<?php

if(isset($_GET['add']) && isset($_SESSION['username'])){
	$query = query("select * from products where product_id= " . escape_string($_GET['add'] . " "));
	confirm($query);

	while($row = fetch_array($query)){
	if($row['product_quantity'] != $_SESSION["product_" . $_GET['add']]){
		$_SESSION["product_" . $_GET['add']] +=1;
		redirect("../public/checkout.php");
	} else{
		set_message("We only have " . $row['product_quantity'] . " " . $row['product_title'] . "s available");
		redirect("../public/checkout.php");
	}
	}
	
}else{
  //header("Location: ../public/login.php");
}


if(isset($_GET['remove'])){
	$_SESSION["product_" . $_GET['remove']]-- ;
	if($_SESSION["product_" . $_GET['remove']] < 1){
		unset($_SESSION['item_total']);
		unset($_SESSION['item_quantity']);

		redirect("../public/checkout.php");
	} else{
		redirect("../public/checkout.php");
	}
}

if(isset($_GET['delete'])){
	$_SESSION["product_" . $_GET['delete']] = '0';
	unset($_SESSION['item_total']);
	unset($_SESSION['item_quantity']);

	redirect("../public/checkout.php");
}

function cart(){
$total = 0;
$item = 0;
//for paypal
$item_name = 1;
$item_number = 1;
$amount = 1;
$quantity = 1;

foreach($_SESSION as $name => $value){
	if($value > 0){
		if(substr($name,0,8) == "product_"){
			$length = strlen($name);
			$id = substr($name,8,$length);
			
			$query = query("select * from products where product_id = " . escape_string($id) . " ");
			confirm($query);

			while($row = fetch_array($query)){
				$sub = $row['product_price'] * $value;
				$item+=$value;
				$total+=$sub;

				$products = <<<DELIMETER
				<tr>
                <td>{$row['product_title']} <br/>
                <img height='100' width='100' src="../resources/uploads/{$row['product_image']}" alt=""/>
                </td>
                <td>₹{$row['product_price']}</td>
                <td>{$value}</td>
                <td>₹{$sub}</td>
                <td>
                  <a class="btn btn-warning" href="../resources/cart.php?remove={$row['product_id']}"><span class="glyphicon glyphicon-minus"></span></a>
                  <a class="btn btn-success" href="../resources/cart.php?add={$row['product_id']}"><span class="glyphicon glyphicon-plus"></span></a>
				          <a class="btn btn-danger" href="../resources/cart.php?delete={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a>
                </td>
            </tr>
            
            <!-- for paypal -->
            <input type="hidden" name="item_name_{$item_name}" value={$row['product_title']}/>
            <input type="hidden" name="item_number_{$item_number}" value={$row['product_id']}/>
            <input type="hidden" name="amount_{$amount}" value={$row['product_price']}/>
            <input type="hidden" name="quantity_{$quantity}" value={$value}/>
            
DELIMETER;

			echo $products;
      
      //for paypal
      $item_name++ ;
      $item_number++ ;
      $amount++ ;
      $quantity++ ;

			}
			$_SESSION['item_total'] = $total ;
			$_SESSION['item_quantity'] = $item;
		}
	}
}

}

function show_paypal(){
if(isset($_SESSION['item_quantity']) && $_SESSION['item_quantity'] >= 1){
  $paypal_button = <<<DELIMETER
    <input type="image" name="submit" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online"/>
DELIMETER;

  return $paypal_button;
}
}

function transaction_process(){
if(isset($_GET['tx'])){
	$amount = $_GET['amt'];
	$transaction = $_GET['tx'];
	$status = $_GET['st'];
  
  $total = 0;
  $item = 0;

  foreach($_SESSION as $name => $value){
	  if($value > 0){
		  if(substr($name,0,8) == "product_"){
			  $length = strlen($name) - 8;
			  $id = substr($name,8,$length);
			
			  $query = query("select * from products where product_id = " . escape_string($id) . " ");
			  confirm($query);

			  while($row = fetch_array($query)){
          $product_title = $row['product_title'];
          $product_price = $row['product_price'];
				  $sub = $row['product_price'] * $value;
				  $item+=$value;
				  $total+=$sub;
          
          $insert_order = query("insert into orders (order_amount, order_transaction, order_status) values('{$amount}', '{$transaction}', '{$status}')");
	        confirm($insert_order);
          $order_id = last_id();
  
          $insert_report = query("insert into reports (product_id,order_id ,product_title, product_price, product_quantity) values('{$id}', '{$order_id}' , '{$product_title}' , '{$product_price}', '{$value}')");
	        confirm($insert_report);
			  }
		  }
	  }
  }
  //session_destroy();
}else{
	redirect(index.php);
}

}


?>