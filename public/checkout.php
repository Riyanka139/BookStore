<?php require_once("../resources/config.php"); ?>

<?php include '../resources/templates/front/riheader.php' ; ?>

<?php
if(!isset($_SESSION['username'])){
	redirect("index.php");
 }
?>

    <!-- Page Content -->
    <div class="container">


<!-- /.row --> 

<div class="row">

      <h4 class="text-center bg-danger"><?php display_message(); ?></h4>
      <h1>Checkout</h1>

<!--<form action="">-->
  <!--for paypal-->
  <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart"/>
    <input type="hidden" name="business" value="student@gmail.com"/>
    <input type="hidden" name="currency_code" value="US"/>
    <!--ending paypal-->
    <table class="table table-striped">
        <thead>
          <tr>
           <th>Product</th>
           <th>Price</th>
           <th>Quantity</th>
           <th>Sub-total</th>
     
          </tr>
        </thead>
        <tbody>
           <?php cart(); ?>
        </tbody>
    </table>
    <!--for paypal-->
  <?php echo show_paypal(); ?>
</form>



<!--  ***********CART TOTALS*************-->
            
<div class="col-xs-4 pull-right ">
<h2>Cart Totals</h2>

<table class="table table-bordered" cellspacing="0">
  <tbody>
<tr class="cart-subtotal">
<th>Items:</th>
<td><span class="amount"><?php
    echo isset($_SESSION['item_quantity']) ? $_SESSION['item_quantity'] : $_SESSION['item_quantity'] = "0";
  ?>
</span></td>
</tr>
<tr class="shipping">
<th>Shipping and Handling</th>
<td>Free Shipping</td>
</tr>

<tr class="order-total">
<th>Order Total</th>
<td><strong><span class="amount">₹<?php
    echo isset($_SESSION['item_total']) ? $_SESSION['item_total'] : $_SESSION['item_total'] = "0";
  ?>
</span></strong> </td>
</tr>


</tbody>

</table>

</div><!-- CART TOTALS-->


 </div><!--Main Content-->

           <hr/>
        <!-- Footer -->
         <?php include'../resources/templates/front/footer.php' ; ?>

</div>
    <!-- /.container -->