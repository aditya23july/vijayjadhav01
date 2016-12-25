<?php

$userid =   $this->session->userdata('user_id');
$wishresult= $this->db->query("select * from tbl_wishlist_master where user_id='$userid' ")->result();
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
<div id="content" class="site-content" tabindex="-1" style="padding-bottom:50px">

    <div class="container">



        <nav class="woocommerce-breadcrumb" >

            <a href="index.html">Home</a>

            <span class="delimiter"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
            <a href="<?php echo base_url()?>index.php/customer">My Account</a> <span class="delimiter"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span><a href="my_order.html"> My Wish List </a>

        </nav><!-- .woocommerce-breadcrumb -->
        <div class="myorder">
            <div class="tab-content">

                <div id="home" class="tab-pane fade in active">

                    <div class="body-data">

                          <div class="col-1 col-sm-8 login">


                                    <h3>My Wishlist</h3>
                                    <div>
                                        <table>
                                            <tr class="headings">
                                                <th>Product details </th>


                                                <th>Price</th>

                                                <th>Action</th>

                                            </tr>
                                            <?php
                                             $session_data =$this->session->userdata;
                                             $currency_id=$session_data['currency_id'];
                                             foreach($wishresult as $wishrecord){
                                                  $productrecord = $this->db->query("SELECT *,(select i_class from tbl_currency_master where id=pcm.currency_id) as i_class FROM `tbl_product_master` pm inner join tbl_product_currency_map pcm on pm.id = pcm.product_id where pcm.currency_id='$currency_id' and pcm.product_id='$wishrecord->item_id' and pm.status='ACTIVE' group by pcm.product_id")->row();
                                                  if(isset($productrecord->product_name)){
                                                       
							$encrypted_string = $this->encrypt->encode($productrecord->product_id);
							$find=array("+","-","/","=");
							$replace=array("__ADD__","__DASH__","__SLASH__","__EQUAL__");
							$encrypted_string=str_replace($find,$replace,$encrypted_string);
					
                                                      $productimagerow=$this->db->query("SELECT * FROM tbl_product_image_map where product_id='$productrecord->product_id' and image_type='THUMBNAIL' order by id desc limit 0,1")->row();
                                             ?>
                                            <tr class="detail">
                                                <td>
                                                    <?php echo $productrecord->product_name; ?>
                                                    <?php
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
                                                </td>
                                                <td>
                                                   <?php echo $productrecord->selling_price;?>
                                                </td>
                                                <td class="shop">
                                                    <form id="<?php echo $encrypted_string.'add_cart'?>" class='form' action="<?php echo base_url()?>index.php/web/addtocart/<?php echo $encrypted_string?>">
                                                   <input type="hidden" min="1" value="1" name="<?php echo $encrypted_string?>qty" id="<?php echo $encrypted_string?>qty"/>
                                                        <?php
							if($productrecord->min_qty<$productrecord->qty){
							?>
                           
                            <input type="button"  class="add_cart_button" name="cart" value="ADD to Cart" class=add-cart" onclick="cart1(this,'<?php echo $encrypted_string?>')">
							<?php
								}
							?>
                                                    <a href="<?php echo base_url()?>index.php/customer/removewishlist/<?php echo $encrypted_string?>">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </a>
                                                    </form>
                                                </td>

                                            </tr>
                                            <?php
                                                  }
                                             }
                                             ?>

                                        </table>
                                        
                                    </div>

                                </div><!-- .col-1 -->
                    </div><!-- class-body -->

                </div>

            

            </div>

        </div>



    </div><!-- container -->

</div><!-- Content -->

