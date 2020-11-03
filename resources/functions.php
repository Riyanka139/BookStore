<?php

//helper functions
function last_id(){
  global $connection;
  return mysqli_insert_id($connection);
}

function set_message($msg){
  if(!empty($msg)){
    $_SESSION['message']=$msg;
  } else{
    $msg = "";
  }
}

function display_message(){
  if(isset($_SESSION['message'])){
    echo $_SESSION['message'];
    unset($_SESSION['message']);
  }
}

 function redirect($location){
    return header("Location: $location");
}
  
  function query($sql){
    global $connection;
    return mysqli_query($connection, $sql);
  }
  
  function confirm($result){
    global $connection;
    if(!$result){
      die("Query Failed!" . mysqli.error($connection));
    }
  }
  
  function escape_string($string){
    global $connection;
    return mysqli_real_escape_string($connection, $string);
  }
  
  function fetch_array($result){
    return mysqli_fetch_array($result);
  }
  
  /*********************** FRONT END FUNCTIONS ************************/
  
  //get product 
  
  function get_products(){
    $query = query("select * from products");
    confirm($query);
    
    $rows = mysqli_num_rows($query);
    
    if(isset($_GET['page'])){
      $page = preg_replace('#[^0-9]#', '', $_GET['page']);
    }else{
      $page = 1;
    }
    
    $perpage = 6;
    $lastpage = ceil($rows/$perpage);
    if($page < 1){
      $page= 1;
    }elseif($page > $lastpage){
      $page = $lastpage;
    }
    
    $middlenumbers = '';
    
    $sub1 = $page - 1;
    $sub2 = $page - 2;
    $add1 = $page + 1;
    $add2 = $page + 2;
    
    if($page == 1){
      $middlenumbers .= '<li class="page-item active"><a>' .$page. '</a></li>';
      
     $middlenumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">' .$add1. '</a></li>';
    
    } elseif($page == $lastpage){
      $middlenumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'">' .$sub1. '</a></li>';
      
      $middlenumbers .= '<li class="page-item active"><a>' .$lastpage. '</a></li>';
      
    } elseif($page > 2 && $page <($lastpage - 1)){
      $middlenumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub2.'">' .$sub2. '</a></li>';
      
      $middlenumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'">' .$sub1. '</a></li>';
      
      $middlenumbers .= '<li class="page-item active"><a>' .$page. '</a></li>';
      
      $middlenumbers .= '<li class="page-item"><a class="page-link" src="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">' .$add1. '</a></li>';
      
      $middlenumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add2.'">' .$add2. '</a></li>';
      
    } elseif($page >1 && $page < $lastpage){
      $middlenumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$sub1.'">' .$sub1. '</a></li>';
      
      $middlenumbers .= '<li class="page-item active"><a>' .$page. '</a></li>';
      
      $middlenumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$add1.'">' .$add1. '</a></li>';
      
    }
    
    $limit = 'limit ' . ($page - 1) * $perpage . ',' . $perpage;
    
     $query2 = query("select * from products $limit");
     confirm($query2);
     
     $outputpagination = "";
     
     //if($lastpage != 1){
     //}
     
     if($page != 1){
      $prev = $page - 1;
      
      $outputpagination .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$prev.'">Back</a></li>';
     }
     
     $outputpagination .= $middlenumbers;
     
     if($page != $lastpage){
     $next = $page + 1;
     
     $outputpagination .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?page='.$next.'">Next</a></li>';
     }
    
    while($row = fetch_array($query2)){
    //DELIMETER is heredoc
      $product = <<<DELIMETER
      
       <div class="col-sm-4 col-lg-4 col-md-4">
          <div class="thumbnail">
          
             <a href="item.php?id={$row['product_id']}"><img src="../resources/uploads/{$row['product_image']}" alt="" style="height:300px"/></a>
             <div class="caption">
               <h4 class="pull-right">₹​{$row['product_price']}</h4>
               <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a></h4>
               <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
               <a class="btn btn-primary"  href="../resources/cart.php?add={$row['product_id']}">Add To Cart</a>
             </div>                  
          </div>
       </div>
       
DELIMETER;
    echo $product;
    }
    echo "<div class='text-center'><ul class='pagination'>{$outputpagination}</ul></div";
  }
  
  function get_categories(){
  	$query = query("select * from categories");
		confirm($query);

			while($row = fetch_array($query)){
				echo "<a href = 'category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>";
			}
  }
  
  function get_products_in_cat_page(){
    $query = query("select * from products where product_category_id= " . escape_string($_GET['id']) . " ");
    confirm($query);
    
    while($row = fetch_array($query)){
    //DELIMETER is heredoc
      $product = <<<DELIMETER
      
         <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                <br/>
                    <img src="../resources/uploads/{$row['product_image']}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
       
DELIMETER;
    echo $product;
    }
  }
  
  
  function get_products_in_shop_page(){
    $query = query("select * from products");
    confirm($query);
    
    while($row = fetch_array($query)){
    //DELIMETER is heredoc
      $product = <<<DELIMETER
      
         <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">

                    <img height="100" src= "../resources/uploads/{$row['product_image']}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>₹​{$row['product_price']}</p>
                        <p>
                            <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
       
DELIMETER;
    echo $product;
    }
  }
  
function login_user(){
  if(isset($_POST['submit'])){
    $username=escape_string($_POST['username']);
    $password=escape_string($_POST['password']);
    
    $query=query("select * from users where username = '{$username}' AND password = '{$password}'");
    confirm($query);
    $row = fetch_array($query);
    $user = $row['username'];
    
    if(mysqli_num_rows($query) == 0){
      set_message("Your Username or password are wrong {$user}");
      redirect("login.php");
    } else{
      $_SESSION['username'] = $username;
      //set_message("Welcome To admin {$username}");
      redirect("admin");
    }
  } 
}

function send_message(){
  if(isset($_POST['submit'])){
  
    $to = "someEmail@gmail.com";
    $from_name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    $headers = "From: {$from_name} {$email}" ;
    
    ini_set("SMTP", "riyanka139@gmail.com");
    ini_set("sendmail_from", $email);
    ini_set("smtp_port", "25");
    $result = mail($to, $subject, $message, $headers);
    
    if(!result){
      set_message("Sorry! we could not send your message");
      redirect(contact.php);
     } else{
      set_message("Your message has been sent");
      redirect(contact.php);
     }
  }
}
  
  /*********************** BACK END FUNCTIONS ************************/
  
function display_order(){
$query = query("select * from orders");
confirm($query);

while($row = fetch_array($query)){
  $order = <<<DELIMETER
        <tr>
            <td>{$row['order_id']}</td>
            <td>{$row['order_amount']}</td>
            <td>{$row['order_transaction']}</td>
            <td>{$row['order_status']}</td>
            <td><a class="btn btn-danger" href="index.php?delete_order_id={$row['order_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
DELIMETER;
  echo $order;
}

}

  /*********************** ADMIN PRODUCTS PAGE ************************/
  
function get_product_in_admin(){
    $query = query("select * from products");
    confirm($query);
    
    while($row = fetch_array($query)){
    $category = show_category_title($row['product_category_id']);
    
      $product = <<<DELIMETER
      
       <tr>
            <td>{$row['product_id']}</td>
            <td>{$row['product_title']}<br>
             <a href="index.php?edit_product&id={$row['product_id']}"> <img width='100' src="../../resources/uploads/{$row['product_image']}" alt=""></a>
            </td>
            <td>{$category}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
            <td><a class="btn btn-danger" href="index.php?delete_product_id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
      
DELIMETER;
    echo $product;
    }
    
}

function show_category_title($product_category_id){
$query = query("select cat_title from categories where cat_id='{$product_category_id}'");
confirm($query);

while($row = fetch_array($query)){
  return $row['cat_title'];
}
}

  /*********************** ADD PRODUCT IN ADMIN  ************************/

function add_product(){
if(isset($_POST['publish'])){
  $product_title = escape_string($_POST['product_title']);
  $product_category_id = escape_string($_POST['product_category_id']);
  $product_price = escape_string($_POST['product_price']);
  $product_quantity = escape_string($_POST['product_quantity']);
  $product_description = escape_string($_POST['product_description']);
  $short_desc = escape_string($_POST['short_desc']);
  $product_image = escape_string($_FILES['file']['name']);
  $image_temp_location = escape_string($_FILES['file']['tmp_name']);
  
  copy($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);
  
  $query = query("insert into products (product_title, product_category_id, product_price, product_quantity, product_description, short_desc, product_image) values ('{$product_title}', '{$product_category_id}', '{$product_price}', '{$product_quantity}', '{$product_description}', '{$short_desc}', '{$product_image}')");
  $product_id = last_id();
  confirm($query);
  set_message("New Product With Id {$product_id} was Added");
  redirect("index.php?products");
}

}

function show_categories_add_product_page(){
  	$query = query("select * from categories");
		confirm($query);

			while($row = fetch_array($query)){
				$category_options = <<<DELIMETER
        <option value="{$row['cat_id']}">{$row['cat_title']}</option>
DELIMETER;
echo $category_options;
			}
  }
  
   /*********************** UPDATING PRODUCT ************************/

function update_product(){
if(isset($_POST['update'])){
  $product_title = escape_string($_POST['product_title']);
  $product_category_id = escape_string($_POST['product_category_id']);
  $product_price = escape_string($_POST['product_price']);
  $product_quantity = escape_string($_POST['product_quantity']);
  $product_description = escape_string($_POST['product_description']);
  $short_desc = escape_string($_POST['short_desc']);
  $product_image = escape_string($_FILES['file']['name']);
  $image_temp_location = escape_string($_FILES['file']['tmp_name']);
  
  if(empty($product_image)){
  $get_pic = query("select product_image from products where product_id = " . escape_string($_GET['id']) . " ");
  confirm($get_pic);
  
  while($pic = fetch_array($get_pic)){
  $product_image = $pic['product_image'];
  }
  
  }
  
  copy($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);
  
  $query = "update products set ";
  $query .= "product_title = '{$product_title}', ";
  $query .= "product_category_id = '{$product_category_id}', ";
  $query .= "product_price = '{$product_price}', ";
  $query .= "product_quantity = '{$product_quantity}', ";
  $query .= "product_description = '{$product_description}', ";
  $query .= "short_desc = '{$short_desc}', ";
  $query .= "product_image = '{$product_image}' ";
  $query .= "where product_id= " . escape_string($_GET['id']) . " ";
  $update_query = query($query);
  
  confirm($update_query);
  set_message("Product has been updated");
  redirect("index.php?products");
}

}

  /*********************** ADD CATEGORIES IN ADMIN  ************************/
  
function add_categories_in_admin(){
$query = query("select * from categories");
confirm($query);

while($row = fetch_array($query)){
  $category = <<<DELIMETER
        <tr>
            <td>{$row['cat_id']}</td>
            <td>{$row['cat_title']}</td>
            <td><a class="btn btn-danger" href="index.php?delete_category_id={$row['cat_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
DELIMETER;

echo $category;
}

}

function add_category(){
if(isset($_POST['add_category'])){
  $cat_title = escape_string($_POST['cat_title']);
  
  if(empty($cat_title) || $cat_title==""){
    set_message("Category Empty");
  }else{
  $query = query("insert into categories (cat_title) values ('{$cat_title}')");
  confirm($query);
  set_message("Category Added");
 } 
 
}

}

  /*********************** ADMIN USER  ************************/
  
function display_user(){
$query = query("select * from users");
confirm($query);

while($row = fetch_array($query)){
  $user = <<<DELIMETER
            <tr>

               <td>{$row['user_id']}</td>
               <td>{$row['username']}</td>   
               <td>{$row['email']}</td>
               <td><a class="btn btn-danger" href="index.php?delete_user_id={$row['user_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
            </tr>
DELIMETER;

echo $user;
}

}

function add_user(){
if(isset($_POST['add_user'])){
  $username = escape_string($_POST['username']);
  $email = escape_string($_POST['email']);
  $password = escape_string($_POST['password']);
  $user_photo = escape_string($_FILES['file']['name']);
  $photo_temp = escape_string($_FILES['file']['tmp_name']);
  
  copy($photo_temp, UPLOAD_DIRECTORY . DS . $user_photo);
  
  $query = query("insert into users (username,email,password,user_photo) values ('{$username}', '{$email}', '{$password}', '{$user_photo}')");
  confirm($query);
  set_message("user Added");
  
  redirect("index.php?users");
 
}

}

 /*********************** ADMIN REPORT PAGE ************************/
  
function get_reports(){
    $query = query("select * from reports");
    confirm($query);
    
    while($row = fetch_array($query)){
    
      $report = <<<DELIMETER
      
       <tr>
            <td>{$row['report_id']}</td>
            <td>{$row['product_id']}</td>
            <td>{$row['order_id']}</td>
            <td>{$row['product_title']}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
            <td><a class="btn btn-danger" href="../../resources/templates/back/delete_report.php?id={$row['report_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
      
DELIMETER;
    echo $report;
    }
    
}

  /*********************** SLIDES FUNCTIONS ************************/
  
function add_slides(){
if(isset($_POST['add_slide'])){
  $slide_title = escape_string($_POST['slide_title']);
  $slide_image = escape_string($_FILES['file']['name']);
  $slide_image_loc = escape_string($_FILES['file']['tmp_name']);
  
  if(empty($slide_title) || empty($slide_image)){
    set_message("This filed can not be empty");
  }else{
    
    copy($slide_image_loc, UPLOAD_DIRECTORY . DS . $slide_image);
    
    $query = query("insert into slides (slide_title, slide_image) values ('{$slide_title}', '{$slide_image}')");
    confirm($query);
    
    set_message("slide added");
    redirect("index.php?slides");
  }
  
}

}

function get_current_slide_in_admin(){
$query = query("select * from slides order by slide_id desc limit 1");
confirm($query);

while($row = fetch_array($query)){
  $slides_active_admin = <<<DELIMETER
   <div class="item active">
        <img class="img-responsive" src="../resources/uploads/{$row['slide_image']}" alt="" style="height:max-content"/>
   </div>
DELIMETER;

echo $slides_active_admin;
}

}

function get_active(){
$query = query("select * from slides order by slide_id desc limit 1");
confirm($query);

while($row = fetch_array($query)){
  $slides_active = <<<DELIMETER
   <div class="item active">
        <img class="slide-image" src="../resources/uploads/{$row['slide_image']}" alt="" style="height:300px"/>
   </div>
DELIMETER;

echo $slides_active;
}

}

function get_slides(){
$query = query("select * from slides");
confirm($query);

while($row = fetch_array($query)){
  $slides = <<<DELIMETER
   <div class="item">
        <img class="slide-image" src="../resources/uploads/{$row['slide_image']}" alt="" style="height:300px"/>
   </div>
DELIMETER;

echo $slides;
}

}

function get_slides_thumbnails(){
$query = query("select * from slides order by slide_id asc");
confirm($query);

while($row = fetch_array($query)){
  $slides_thumb_admin = <<<DELIMETER
   <div class="col-xs-6 col-md-3 image-container">
    <div class="caption">
      <p>{$row['slide_title']}</p>
    </div>
    <a href="index.php?delete_slide_id={$row['slide_id']}">
      <img class="img-responsive slide-image" src="../../resources/uploads/{$row['slide_image']}" alt=""/>
    </a>
  </div>
DELIMETER;

echo $slides_thumb_admin;
}

}
  
?>