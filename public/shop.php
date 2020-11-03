<?php require_once("../resources/config.php"); ?>

<?php include '../resources/templates/front/riheader.php' ; ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Jumbotron Header -->
        <header>
            <h1>Shop Here!</h1>
           
        </header>

        <hr>

        
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row text-center">

          <?php get_products_in_shop_page(); ?>

        </div>
        <!-- /.row -->

        <hr/>

        <!-- Footer -->
        

    </div>
    <!-- /.container -->

   <?php include'../resources/templates/front/footer.php' ; ?>
