<div id="content" class="site-content" tabindex="-1" style="margin-top:20px !important">
    <div class="container">
        <div id="primary" class="content-area">  
            <main id="main" class="site-main">
                <div class="home-v1-slider">
                    <!-- ========================================== SECTION – HERO : END========================================= -->

                    <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">

                        <div class="item" style="background-image: url(<?php echo base_url() ?>asset/web/images/slider/banner-2.jpg);">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-5">
                                        <div class="caption vertical-center text-left">
                                            <div class="hero-1 fadeInDown-1">
                                                The New
                                                <br> Standard
                                            </div>

                                            <div class="hero-subtitle fadeInDown-2">
                                                under favorable smartwatches
                                            </div>
                                            <div class="hero-v2-price fadeInDown-3">
                                                from
                                                <br><span>$749</span>
                                            </div>
                                            <div class="hero-action-btn fadeInDown-4">
                                                <a href="single-product.html" class="big le-button ">Start Buying</a>
                                            </div>
                                        </div>
                                        <!-- /.caption -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.container -->
                        </div>
                        <!-- /.item -->

                        <div class="item" style="background-image: url(<?php echo base_url() ?>asset/web/images/slider/banner-1.jpg);">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-5">
                                        <div class="caption vertical-center text-left">
                                            <div class="hero-subtitle-v2 fadeInDown-1">
                                                shop to get what you loves
                                            </div>

                                            <div class="hero-2 fadeInDown-2">
                                                Timepieces that make a statement up to <strong>40% Off</strong>
                                            </div>

                                            <div class="hero-action-btn fadeInDown-3">
                                                <a href="single-product.html" class="big le-button ">Start Buying</a>
                                            </div>
                                        </div>
                                        <!-- /.caption -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.container -->
                        </div>
                        <!-- /.item -->

                        <div class="item" style="background-image: url(<?php echo base_url() ?>asset/web/images/slider/banner-3.jpg);">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-5">
                                        <div class="caption vertical-center text-left">
                                            <div class="hero-subtitle-v2 fadeInLeft-1">
                                                shop to get what you loves
                                            </div>

                                            <div class="hero-2 fadeInRight-1">
                                                Timepieces that make a statement up to <strong>40% Off</strong>
                                            </div>

                                            <div class="hero-action-btn fadeInLeft-2">
                                                <a href="single-product.html" class="big le-button ">Start Buying</a>
                                            </div>
                                        </div>
                                        <!-- /.caption -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.container -->
                        </div>
                        <div class="item" style="background-image: url(<?php echo base_url() ?>asset/web/images/slider/banner-4.jpg);">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-5">
                                        <div class="caption vertical-center text-left">
                                            <div class="hero-subtitle-v2 fadeInLeft-1">
                                                shop to get what you loves
                                            </div>

                                            <div class="hero-2 fadeInRight-1">
                                                Timepieces that make a statement up to <strong>40% Off</strong>
                                            </div>

                                            <div class="hero-action-btn fadeInLeft-2">
                                                <a href="single-product.html" class="big le-button ">Start Buying</a>
                                            </div>
                                        </div>
                                        <!-- /.caption -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.container -->
                        </div>
                        <div class="item" style="background-image: url(<?php echo base_url() ?>asset/web/images/slider/banner-5.jpg);">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-5">
                                        <div class="caption vertical-center text-left">
                                            <div class="hero-subtitle-v2 fadeInLeft-1">
                                                shop to get what you loves
                                            </div>

                                            <div class="hero-2 fadeInRight-1">
                                                Timepieces that make a statement up to <strong>40% Off</strong>
                                            </div>

                                            <div class="hero-action-btn fadeInLeft-2">
                                                <a href="single-product.html" class="big le-button ">Start Buying</a>
                                            </div>
                                        </div>
                                        <!-- /.caption -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.container -->
                        </div>
                        <!-- /.item -->

                    </div>
                    <!-- /.owl-carousel -->

                    <!-- ========================================= SECTION – HERO : END ========================================= -->

                </div>
               
                <div class="home-v1-deals-and-tabs deals-and-tabs row animate-in-view fadeIn animated" data-animation="fadeIn">
                    <div class="tabs-block col-lg-12">
                        <div class="products-carousel-tabs">
                            <ul class="nav nav-inline">
                                <li class="nav-item"><a class="nav-link active" href="#tab-products-1" data-toggle="tab">Latest</a></li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-products-1" role="tabpanel">
                                    <div class="woocommerce columns-3">

                                        <ul class="products columns-3">
                                            <?php 
                                            $session_data =$this->session->userdata;
                                            $currency_id=$session_data['currency_id'];
                                                $categoryresult=$this->db->query("select * from tbl_category_master where parent_category_id!='0' and status='ACTIVE'")->result();
                                                foreach($categoryresult as $categoryrow){
                                                     $productrecord = $this->db->query("SELECT *,(select i_class from tbl_currency_master where id=pcm.currency_id) as i_class FROM `tbl_product_master` pm inner join tbl_product_currency_map pcm on pm.id = pcm.product_id where pcm.currency_id='$currency_id' and pm.subcategory_id='$categoryrow->category_id' and pm.status='ACTIVE' order by pm.id desc limit 0,1")->row();
                                                     if(isset($productrecord->product_name)){
                                                         $encrypted_string = $this->encrypt->encode($productrecord->product_id);
							$find=array("+","-","/","=");
							$replace=array("__ADD__","__DASH__","__SLASH__","__EQUAL__");
							$encrypted_string=str_replace($find,$replace,$encrypted_string);
                                                  ?>
                                            <li class="product ">
                                                <div class="product-outer">
                                                    <div class="product-inner">
                                                        <span class="loop-product-categories"><a href="product-category.html" rel="tag"><?php echo ucfirst($categoryrow->category_name)?></a></span>
                                                        <a href="<?php echo base_url()?>index.php/web/viewProduct/<?php echo $encrypted_string?>">
                                                            <h3><?php echo ucfirst($productrecord->product_name)?></h3>
                                                            <div class="product-thumbnail">
                                                            <?php
                                                                $productimagerow=$this->db->query("SELECT * FROM tbl_product_image_map where product_id='$productrecord->product_id' and image_type='THUMBNAIL' order by id desc limit 0,1")->row();
                                                                if(isset($productimagerow->image_name)){
                                                            ?>
                                                            <img src="<?php echo base_url() ?>upload/<?php echo $productimagerow->image_name?>" class="img-responsive" style="width:252px;height:232px">
                                                            <?php 
                                                                }else{
                                                                    ?>
                                                             <img src="<?php echo base_url() ?>asset/web/images/no_product.png" class="img-responsive" style="width:252px;height:232px">
                                                             <?php       
                                                                }
                                                                ?>
                                                            </div>
                                                        </a>

                                                        <div class="price-add-to-cart">
                                                            <span class="price">
                                                                <span class="electro-price">
                                                                    <ins><span class="amount"> </span></ins>
                                                                    <span class="amount">Rs. <?php echo $productrecord->selling_price ?></span>
                                                                </span>
                                                            </span>
                                                            <a rel="nofollow" href="single-product.html" class="button add_to_cart_button">Add to cart</a>
                                                        </div>
                                                        <!-- /.price-add-to-cart -->

                                                        <div class="hover-area">
                                                            <div class="action-buttons">

                                                                <a href="#" rel="nofollow" class="add_to_wishlist"> Wishlist</a>

                                                                <a href="compare.html" class="add-to-compare-link"> Compare</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.product-inner -->
                                                </div>
                                                <!-- /.product-outer -->
                                            </li>
                                            <?php
                                                     }
                                                }
                                                ?>
                                            <!-- /.products -->

                                        </ul>



                                        </main><!-- #main -->
                                    </div><!-- #primary -->
                                </div><!-- .col-full -->
                            </div><!-- #content -->