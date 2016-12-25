<?php
 $session_data =$this->session->userdata;
                $currency_id=$session_data['currency_id'];
$productrecord = $this->db->query("SELECT *,(select i_class from tbl_currency_master where id=pcm.currency_id) as i_class FROM `tbl_product_master` pm inner join tbl_product_currency_map pcm on pm.id = pcm.product_id where pcm.currency_id='$currency_id' and pm.id='$id' group by pcm.product_id")->row();
?>
	<script type="text/javascript">
$(document).ready(function(){
	
});
function cart1(obj,string){
	var form = $(obj).closest('.form');
	var qty = string+'qty';
	var value = $('#'+qty).val();
	if(value.trim().length>0){
		$(form).submit();
	}else{
		$('#errorModal1').modal('show');
		$('.success_msg').html('Please Enter Quantity');
	}
	//$(form).submit();
	
}
</script>

 <?php
							$encrypted_string = $this->encrypt->encode($productrecord->product_id);
							$find=array("+","-","/","=");
							$replace=array("__ADD__","__DASH__","__SLASH__","__EQUAL__");
							$encrypted_string=str_replace($find,$replace,$encrypted_string);
					?>
      <script src="<?php echo base_url() ?>asset/admin/js/jquery-2.1.1.min.js"></script>

  <script src="<?php echo base_url() ?>asset/admin/js/jquery.validate.js"></script>

 <script>
$(document).ready(function(){
    $("#rating_product").validate({
        errorClass: "alert alert-warning",
            rules: {
              comment: {
                required: true
              },
               rating: {
                required: true
                }
            },
            messages: {
             comment: {
                required: "Please Enter Comment."
              },
              rating: {
                required: "Please Enter Rating."

              }
          }
      });

});
</script>
<script type="text/javascript">
$(document).ready(function(){
	
});
function setRating(rate){
   
    $('#rating').val(rate);
}
function cart1(obj,string){
	var form = $(obj).closest('.form');
	var qty = string+'qty';
	var value = $('#'+qty).val();
	if(value.trim().length>0){
		$(form).submit();
	}else{
		$('#errorModal1').modal('show');
		$('.success_msg').html('Please Enter Quantity');
	}
	//$(form).submit();
	
}
</script>
<div id="content" class="site-content" tabindex="-1">
    <div class="container">
        <div class="col-md-6"></div>
        <div id="primary" class="content-area col-md-6">
            <main id="main" class="site-main">

                <div class="product">

                    <div class="single-product-wrapper">
                        <div class="product-images-wrapper">
                            <span class="onsale">Sale!</span>
                            <div class="images electro-gallery">
                                <div class="thumbnails-single owl-carousel">
                                    <?php
                                    $productimageresult = $this->db->query("select * from tbl_product_image_map where product_id='$id'")->result();
                                    if(count($productimageresult)>0){    
                                        foreach($productimageresult as $productimagerecord){
                                    ?>
                                        <a href="<?php echo base_url() ?>upload/<?php echo $productimagerecord->image_name?>" class="zoom" title="" data-rel="prettyPhoto[product-gallery]">
                                            <img src="<?php echo base_url() ?>upload/<?php echo $productimagerecord->image_name?>" data-echo="<?php echo base_url() ?>upload/<?php echo $productimagerecord->image_name?>" class="wp-post-image" alt="">
                                        </a>
                                    <?php
                                        }
                                    }else{
                                    ?>
                                       <img src="<?php echo base_url() ?>asset/web/images/no_product.png" class="zoom" title="" data-rel="prettyPhoto[product-gallery]">
                                    <?php
                                    }
                                    ?>
                                </div><!-- .thumbnails-single -->

                                <div class="thumbnails-all columns-5 owl-carousel">
                                    <?php
                                        foreach($productimageresult as $productimagerecord){
                                    ?>
                                    <a href="<?php echo base_url() ?>upload/<?php echo $productimagerecord->image_name?>" class="first" title="">
                                        <img src="<?php echo base_url() ?>upload/<?php echo $productimagerecord->image_name?>" data-echo="<?php echo base_url() ?>upload/<?php echo $productimagerecord->image_name?>" class="wp-post-image" alt="">
                                    </a>
                                    <?php
                                        }
                                      ?>
                                </div><!-- .thumbnails-all -->
                            </div><!-- .electro-gallery -->								</div><!-- /.product-images-wrapper -->

                            <div class="summary entry-summary">

                                <span class="loop-product-categories">
                                    <?php
                                    $categoryresult=$this->db->query("select * from tbl_category_master where category_id='$productrecord->subcategory_id'")->row();
                                    $cencrypted_string = $this->encrypt->encode($productrecord->subcategory_id);
                                    $find=array("+","-","/","=");
                                    $replace=array("__ADD__","__DASH__","__SLASH__","__EQUAL__");
                                    $cencrypted_string=str_replace($find,$replace,$cencrypted_string);
                                    ?>
                                    <a href=<?php echo base_url()?>index.php/web/viewcategory/<?php echo $cencrypted_string?>" rel="tag"><?php echo ucfirst($categoryresult->category_name);?></a>
                                </span><!-- /.loop-product-categories -->

                                <h1 itemprop="name" class="product_title entry-title"><?php echo $productrecord->product_name?></h1>

                                <div class="woocommerce-product-rating">
                                     <?php 
                                     $ratingrow = $this->db->query("select avg(rating) as avg,count(id) as count,sum(rating) as sum  from tbl_product_review pr  where pr.product_id='$id'")->row(); 
                                     //$ratingavg = $ratingrow->sum/$ratingrow
                                     ?>
                                    <div class="star-rating" title="Rated <?php echo $ratingrow->avg?> out of 5">
                                        <span style="width:86.6%">
                                            <strong itemprop="ratingValue" class="rating"><?php echo $ratingrow->avg?></strong>
                                            out of <span itemprop="bestRating">5</span>				based on
                                            <span itemprop="ratingCount" class="rating"><?php echo $ratingrow->count?></span>
                                            customer ratings
                                        </span>
                                    </div>

                                    <a href="#reviews" class="woocommerce-review-link">
                                        (<span itemprop="reviewCount" class="count"><?php echo $ratingrow->count?></span> customer reviews)
                                    </a>
                                </div><!-- .woocommerce-product-rating -->

                              

                                <div class="availability in-stock">
                                    Availablity: 
                                    
                                    <span>
                                      <?php
                                        if($productrecord->min_qty>=$productrecord->qty){
                                      ?>
                                        In stock
                                      <?php
                                        }else{
                                        ?>
                                        Out of Stock
                                      <?php
                                        }
                                        ?>
                                    </span>
                                </div><!-- .availability -->

                                <hr class="single-product-title-divider" />
                               

                                <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">

                                    <p class="price">
                                        <span class="electro-price">
                                            <?php 
                                                if($this->session->userdata('user_type')=='SUPPLIER') { 
                                                    $flag=true;
                                                    $price= $productrecord->special_price;
                                                }else{
                                                    if(strlen($productrecord->discount_per)>0){
                                                        $flag=false;
                                                        $price= $productrecord->selling_price-(($productrecord->discount_per/100)*$productrecord->selling_price);
                                                    }else{
                                                        $flag=true;
                                                        $price= $productrecord->selling_price;
                                                    }
                                                }
                                            ?>
                                            
                                            <ins><span class="amount"><?php echo $price?> <i class="fa <?php echo $productrecord->i_class?>" aria-hidden="true"></i></span></ins> 
                                            <?php 
                                            if($flag==false){
                                            ?>
                                            <del><span class="amount"><?php echo $productrecord->selling_price;?>  <i class="fa <?php echo $productrecord->i_class?>" aria-hidden="true"></i></span></del>
                                            <?php
                                            }
                                            ?>
                                            
                                        </span>
                                    </p>

                                    <meta itemprop="price" content="1215" />
                                    <meta itemprop="priceCurrency" content="USD" />
                                    <link itemprop="availability" href="http://schema.org/InStock" />

                                </div><!-- /itemprop -->

                                <form id="<?php echo $encrypted_string.'add_cart'?>" class='form' action="<?php echo base_url()?>index.php/web/addtocart/<?php echo $encrypted_string?>">
                                    <div class="single_variation_wrap">
                                        <div class="woocommerce-variation single_variation"></div>
                                        <div class="woocommerce-variation-add-to-cart variations_button">
                                             <?php
                                                if($productrecord->min_qty<$productrecord->qty){
                                              ?>
                                            <div class="quantity">
                                                <label>Quantity:</label>
                                                <input type="number" name="<?php echo $encrypted_string?>qty" id="<?php echo $encrypted_string?>qty" value="1" title="Qty" class="input-text qty text"/>
                                            </div>
                                            <input type="button"  class="add_cart_button" name="cart" value="ADD to Cart" class=add-cart" onclick="cart1(this,'<?php echo $encrypted_string?>')">
                                            <?php
                                                }
                                                ?>
                                            <div class="action-buttons">
                                                <a href="#" class="add_to_wishlist" >
                                                    Wishlist
                                                 </a>
                                                <a href="#" class="add-to-compare-link" data-product_id="2452">Compare</a>
                                            </div><!-- .action-buttons -->
                                             
                                            <input type="hidden" name="add-to-cart" value="2452" />
                                            <input type="hidden" name="product_id" value="2452" />
                                            <input type="hidden" name="variation_id" class="variation_id" value="0" />
                                        </div>
                                    </div>
                                </form>


                            </div><!-- .summary -->
                        </div><!-- /.single-product-wrapper -->


                        <div class="woocommerce-tabs wc-tabs-wrapper">
                            <ul class="nav nav-tabs electro-nav-tabs tabs wc-tabs" role="tablist">


<li class="nav-item specification_tab">
    <a href="#tab-specification" class="active" data-toggle="tab">Specification</a>
</li>

<li class="nav-item reviews_tab">
    <a href="#tab-reviews" data-toggle="tab">Reviews</a>
</li>

</ul>

<div class="tab-content">


    <div class="tab-pane panel entry-content wc-tab active" id="tab-specification">
        <h3>Technical Specifications</h3>
        <table class="table">
            <tbody>
                <?php
                    $productfieldresult=$this->db->query("SELECT * FROM `tbl_product_field_map` pfm inner join tbl_field_master fm on pfm.field_id=fm.id where pfm.product_id='$id'")->result();
                    foreach($productfieldresult as $productfieldrow){
                ?>
                <tr>
                    <td><?php echo $productfieldrow->field_title ?> </td>
                    <td><?php echo $productfieldrow->value ?> </td>
                </tr>
                <?php
                    }
                    ?>
            </tbody>
        </table>
    </div><!-- /.panel -->

    <div class="tab-pane panel entry-content wc-tab" id="tab-reviews">
        <div id="reviews" class="electro-advanced-reviews">
            <div class="advanced-review row">
                <div class="col-xs-12 col-md-6">
                    <?php $ratingresult = $this->db->query("select * from tbl_product_review pr  where pr.product_id='$id'")->result(); ?>
                    <h2 class="based-title">Based on <?php echo count($ratingresult)?> reviews</h2>
                    <div class="avg-rating">
                    <?php $ratingavg = $this->db->query("select sum(rating)/count(rating) as avg from tbl_product_review pr  where pr.product_id='$id'")->row(); ?>
                        <span class="avg-rating-number"><?php echo round($ratingavg->avg,2)?></span> overall
                    </div>

                    <div class="rating-histogram">
                        <div class="rating-bar">
                            <div class="star-rating" title="Rated 5 out of 5">
                                <span style="width:100%">5 Stars</span>
                            </div>
                            <div class="rating-percentage-bar">
                                 <?php 
                                 $ratingfive = $this->db->query("select count(id) as count from tbl_product_review pr  where pr.product_id='$id' and pr.rating='5'")->row(); 
                                 $ratingfiveper=0;
                                 if(count($ratingresult)>0){
                                 $ratingfiveper = ($ratingfive->count/count($ratingresult))*100;
                                 }
                                 ?>
                                <span style="width:<?php echo $ratingfiveper.'%'; ?>" class="rating-percentage">

                                </span>
                            </div>
                            <div class="rating-count"><?php echo $ratingfive->count?></div>
                        </div><!-- .rating-bar -->

                        <div class="rating-bar">
                            <div class="star-rating" title="Rated 4 out of 5">
                                <span style="width:80%">4 Stars</span>
                            </div>
                            <div class="rating-percentage-bar">
                                <?php 
                                 $ratingfive = $this->db->query("select count(id) as count from tbl_product_review pr  where pr.product_id='$id' and pr.rating='4'")->row(); 
                                 $ratingfiveper=0;
                                 if(count($ratingresult)>0){
                                 $ratingfiveper = ($ratingfive->count/count($ratingresult))*100;
                                 }
                                 ?>
                                <span style="width:<?php echo $ratingfiveper.'%'; ?>" class="rating-percentage">

                                </span>
                            </div>
                            <div class="rating-count"><?php echo $ratingfive->count?></div>
                        </div><!-- .rating-bar -->

                        <div class="rating-bar">
                            <div class="star-rating" title="Rated 3 out of 5">
                                <span style="width:60%">3 Stars</span>
                            </div>
                            <div class="rating-percentage-bar">
                                <?php 
                                 $ratingfive = $this->db->query("select count(id) as count from tbl_product_review pr  where pr.product_id='$id' and pr.rating='3'")->row(); 
                                 $ratingfiveper=0;
                                 if(count($ratingresult)>0){
                                 $ratingfiveper = ($ratingfive->count/count($ratingresult))*100;
                                 }
                                 ?>
                                <span style="width:<?php echo $ratingfiveper.'%'; ?>" class="rating-percentage">

                                </span>
                            </div>
                            <div class="rating-count zero"><?php echo $ratingfive->count?></div>
                        </div><!-- .rating-bar -->

                        <div class="rating-bar">
                            <div class="star-rating" title="Rated 2 out of 5">
                                <span style="width:40%">2 Stars</span>
                            </div>
                            <div class="rating-percentage-bar">
                                <?php 
                                 $ratingfive = $this->db->query("select count(id) as count from tbl_product_review pr  where pr.product_id='$id' and pr.rating='2'")->row(); 
                                 $ratingfiveper=0;
                                 if(count($ratingresult)>0){
                                 $ratingfiveper = ($ratingfive->count/count($ratingresult))*100;
                                 }
                                 ?>
                                <span style="width:<?php echo $ratingfiveper.'%'; ?>" class="rating-percentage">

                                </span>
                            </div>
                            <div class="rating-count zero"><?php echo $ratingfive->count?></div>
                        </div><!-- .rating-bar -->

                        <div class="rating-bar">
                            <div class="star-rating" title="Rated 1 out of 5">
                                <span style="width:20%">1 Stars</span>
                            </div>
                            <div class="rating-percentage-bar">
                                <?php 
                                 $ratingfive = $this->db->query("select count(id) as count from tbl_product_review pr  where pr.product_id='$id' and pr.rating='1'")->row(); 
                                 $ratingfiveper=0;
                                 if(count($ratingresult)>0){
                                 $ratingfiveper = ($ratingfive->count/count($ratingresult))*100;
                                 }
                                 ?>
                                <span style="width:<?php echo $ratingfiveper.'%'; ?>" class="rating-percentage">

                                </span>
                            </div>
                            <div class="rating-count zero"><?php echo $ratingfive->count?></div>
                        </div><!-- .rating-bar -->
                    </div>
                </div><!-- /.col -->

                <div class="col-xs-12 col-md-6">
                    <?php
                    if($this->session->userdata('user_id')) {
                    ?>
                    <div id="review_form_wrapper">
                        <div id="review_form">
                            <div id="respond" class="comment-respond">
                                <h3 id="reply-title" class="comment-reply-title">Add a review
                                    <small><a rel="nofollow" id="cancel-comment-reply-link" href="#" style="display:none;">Cancel reply</a>
                                    </small>
                                </h3>
                                 <?php
							$encrypted_string = $this->encrypt->encode($id);
							$find=array("+","-","/","=");
							$replace=array("__ADD__","__DASH__","__SLASH__","__EQUAL__");
							$encrypted_string=str_replace($find,$replace,$encrypted_string);
					?>
                               <?php echo form_open_multipart('web/viewProduct/'.$encrypted_string,array('role'=>'form','id'=>'rating_product')) ?>
                                     <?php echo validation_errors('<div class="error" style="color: red;font-weight: 700;font-size:12px;">', '</div>'); ?>
                                    <p class="comment-form-rating">
                                        <label>Your Rating</label>
                                        <span>
                                            <!--
                                            <a class="star-1" href="javascript:setRating('1')">1</a>
                                            <a class="star-2" href="javascript:setRating('2')">2</a>
                                            <a class="star-3" href="javascript:setRating('3')">3</a>
                                            <a class="star-4" href="javascript:setRating('4')">4</a>
                                            <a class="star-5" href="javascript:setRating('5')">5</a>
                                            !-->
                                            <select name="rating" id="rating" class="form-control">
                                                <option value="0">0</option>
                                                 <option value="1">1</option>
                                                  <option value="2">2</option>
                                                   <option value="3">3</option>
                                                    <option value="4">4</option>
                                                     <option value="5">5</option>
                                            </select>
                                        </span>
                                         <input type='hidden' name='rating1' id='rating1' value='0' />
                                    </p>

                                    <p class="stars">
                                        
                                    </p>

                                    <p class="comment-form-comment">
                                        <label for="comment">Your Review</label>
                                        <textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
                                    </p>

                                    <p class="form-submit">
                                        <input name="submit_rating" type="submit" id="submit" class="submit" value="Add Review" />
                                        <input type='hidden' name='product_id' value='<?php echo $encryption_string?>' />
                                       
                                    </p>

                                    <input type="hidden" id="_wp_unfiltered_html_comment_disabled" name="_wp_unfiltered_html_comment_disabled" value="c7106f1f46" />
                                    <script>(function(){if(window===window.parent){document.getElementById('_wp_unfiltered_html_comment_disabled').name='_wp_unfiltered_html_comment';}})();</script>
                                </form><!-- form -->
                            </div><!-- #respond -->
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div id="comments">

                <ol class="commentlist">
                    <?php
                    $ratingresult = $this->db->query("select * from tbl_product_review pr  where pr.product_id='$id'")->result();
                    foreach($ratingresult as $ratingrecord){
                        $usermaster = $this->db->query("select * from tbl_user_master  where id='$ratingrecord->user_id'")->row();
                        //print_r($usermaster);
                    ?>
                    <li itemprop="review" class="comment even thread-even depth-1">

                        <div id="comment-390" class="comment_container">

                            
                            <div class="comment-text">

                                <div class="star-rating" title="Rated 4 out of 5">
                                    <span style="width:<?php echo "$ratingrecord->rating*20".'%'; ?>"><strong itemprop="ratingValue"><?php echo $ratingrecord->rating?></strong> out of 5</span>
                                </div>


                                <p class="meta">
                                    <strong> <?php echo $ratingrecord->comment ?></strong> &ndash;
                                    <time itemprop="datePublished" datetime="2016-03-03T14:13:48+00:00">March 3, 2016</time>:
                                </p>



                                <div itemprop="description" class="description">
                                    <p>
                                        <?php echo $ratingrecord->comment ?>
                                    </p>
                                </div>


                                <p class="meta">
                                    <strong itemprop="author"><?php echo $usermaster->name ?></strong> &ndash; <time itemprop="datePublished" datetime="2016-03-03T14:13:48+00:00"><?php echo Date('M d-Y',strtotime($ratingrecord->created_date))?></time>
                                </p>


                            </div>
                        </div>
                    </li><!-- #comment-## -->

                    <?php
                    }
                    ?>
                </ol><!-- /.commentlist -->

            </div><!-- /#comments -->

            <div class="clear"></div>
        </div><!-- /.electro-advanced-reviews -->
    </div><!-- /.panel -->
</div>
</div><!-- /.woocommerce-tabs -->


</div><!-- /.product -->

</main><!-- /.site-main -->
</div><!-- /.content-area -->
</div><!-- /.container -->
</div><!-- /.site-content -->
