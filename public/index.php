
<?php require_once("../resources/config.php"); ?>

<?php include '../resources/templates/front/riheader.php' ; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php include '../resources/templates/front/slide_nav.php' ; ?>

            <div class="col-md-9">

                <div class="row carousel-holder">

                    <div class="col-md-12">
                          <?php include '../resources/templates/front/slider.php' ; ?>
                    </div>

                </div>

                <div class="row">
        
                    <?php get_products(); ?>
                     
                </div>
                <!--row end here-->
            </div>

        </div>
      
       <?php include'../resources/templates/front/footer.php' ; ?>
    </div>
    <!-- /.container -->
 
    