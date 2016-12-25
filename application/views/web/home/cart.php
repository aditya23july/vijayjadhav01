<?php
 $session_data =$this->session->userdata;
                $currency_id=$session_data['currency_id'];
?>
<div id="content" class="site-content" tabindex="-1">

    <div class="container">

       
        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <article id="post-8" class="hentry">

                    <div class="entry-content">
                        <div class="woocommerce">
                            <div class="customer-cart">
                                <!-- <span class="or-text">or</span> -->



                                <div class="col-1 col-sm-8 addtocart">


                                    <h3>Welcome to your Shopping Cart</h3>
                                    <div>
                                        <table style="border-left: 1px solid #ccc;">
                                            <tr class="headings">
                                                <th>Product details </th>
												<th>Qty </th>

                                                <th>Price</th>

                                                <th>Action</th>

                                            </tr>
											<?php
												$productresult = $this->db->query("select ci.*,pm.product_name from tbl_cart_item ci inner join tbl_product_master pm 
																on ci.item_id=pm.id where ci.cart_id='$cart_id'")->result();
												foreach($productresult as $productrecord){
											?>
											 <?php
													$encrypted_string = $this->encrypt->encode($productrecord->item_id);
													$find=array("+","-","/","=");
													$replace=array("__ADD__","__DASH__","__SLASH__","__EQUAL__");
													$encrypted_string=str_replace($find,$replace,$encrypted_string);
											?>
                                            <tr class="detail">
                                                <td>
                                                    <?php echo $productrecord->product_name?>
													<?php
														$productimagerow=$this->db->query("SELECT * FROM tbl_product_image_map where product_id='$productrecord->item_id' and image_type='THUMBNAIL' order by id desc limit 0,1")->row();
														if(isset($productimagerow->image_name)){
														?>
														<img src="<?php echo base_url() ?>upload/<?php echo $productimagerow->image_name?>" class="img-responsive">
														<?php
														}else{
														?>
														<img src="<?php echo base_url() ?>asset/web/images/no_product.png" class="img-responsive">		
														<?php	
														}
														?>
                                                </td>
												<td>
                                                    <?php echo $productrecord->qty ?> 
                                                </td>
                                                <td>
                                                    <?php echo $productrecord->total_price ?> 
                                                </td>
                                                <td class="shop">
                                                   <input type="button" value="Remove Item" onclick="remove_item(this,'<?php echo $encrypted_string ?>')">

                                                   
                                                </td>

                                            </tr>
											<?php
											}
											?>


                                        </table>
                                        <div class="action">
                                            <a href="<?php echo base_url()?>" class="btn btn-default">Continue Shopping</a>
                                        </div>

                                    </div>
                                   
                                    </div><!-- .col-1 -->
									<?php 
                                                                        $flag=false;
                                                                        if($this->session->userdata('user_type')){
                                                                            if($this->session->userdata('user_type')=='SUPPLIER'){
                                                                                $flag=true;
                                                                            }
                                                                        }
                                                                        if($flag==true){
                                                                            $cartrecord = $this->db->query("SELECT sum(special_price*qty) as total_price,sum(total_price) as total_selling_price FROM `tbl_cart_item` where cart_id =$cart_id")->row();
                                                                            $total_amount=$cartrecord->total_selling_price;
                                                                        }else{
                                                                            $cartrecord = $this->db->query("SELECT sum(selling_price*qty) as total_price,sum(total_price) as total_selling_price FROM `tbl_cart_item` where cart_id =$cart_id")->row();
                                                                            $total_amount=$cartrecord->total_selling_price;
                                                                        }
									
									?>
                                    <div class="col-sm-4 ">
                                        <table style="border: 1px solid #ccc;">
                                            <th class="text-center">ORDER SUMMERY</th>
											<tr>
                                                <td class="sum">Subtotal</td>
                                                <td><?php  echo $cartrecord->total_price ?></td>
                                            </tr>
											<tr>
                                                <td class="sum">Discount</td>
                                                <td>
                                                    <?php  
                                                     
                                                   
                                                    if($flag==true){
                                                        echo '0';
                                                    }else{
                                                    echo $cartrecord->total_price-$cartrecord->total_selling_price ;
                                                    }
                                                     ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="sum">Total Amount</td>
                                                <td><?php  echo $cartrecord->total_selling_price ?></td>
                                            </tr>
											<?php
												$taxresult = $this->db->query("SELECT * FROM `tbl_tax_master` where currency_id='$currency_id' and status='ACTIVE' ")->result();
												foreach($taxresult as $taxrecord){
													$total_amount=($total_amount*$taxrecord->tax_value)/100+$total_amount;
											?>
											<tr>
												<td class="sum"><?php echo $taxrecord->title?></td>
                                                                                                 <td><?php  echo $taxrecord->tax_value ?>%</td>
											</tr>
											<?php
											}
											?>
											
											<?php
												$shippingrecord = $this->db->query("SELECT * FROM `tbl_shipping_rule_master` where currency_id='$currency_id'")->row();
												if(isset($shippingrecord->min_value)){
											?>
											<tr>
												<td class="sum">Shipping Charges</td>
                                                <td>
												<?php  
												if( $shippingrecord->min_value>=$cartrecord->total_selling_price ){
													$total_amount=$total_amount+$shippingrecord->shipping_charge;
													echo $shippingrecord->shipping_charge;
												}else{
													echo '0';
												}
												?>
												</td>
											</tr>
											<?php
												}
											?>
											<tr>
											<td class="sum">Payable Amount</td>
                                                <td>
												<?php  

													echo round($total_amount,2);
													
												?>
												</td>
											</tr>
                                        </table>
										<?php
											if($this->session->userdata('user_id')){
										?>
										<a href="<?php echo base_url()?>index.php/customer/checkout" class="btn btn-default">Place Order</a>
										<?php
											}else{
										?>
										<a href="<?php echo base_url()?>index.php/web/login/cart" class="btn btn-default">Place Order</a>
										<?php
											}
										?>
                                        
                                    </div>
                                </div><!-- .col2-set -->
                </article><!-- #post-## -->

            </main><!-- #main -->
        </div><!-- #primary -->

      
</div>  <!-- container -->
</div>  <!-- content -->