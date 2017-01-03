<br/>
<br/>

   
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
<div class="container">
<div class="row">
    <nav class="woocommerce-breadcrumb" >
            <a href="home.html">Home</a>
            <span class="delimiter"><i class="fa fa-angle-right"></i></span>
            Category<span class="delimiter"><i class="fa fa-angle-right"></i></span> Western 
        </nav><!-- .woocommerce-breadcrumb -->
        
        <div class="filter col-md-2">
            
            <input type="submit" name="" class="add_cart_button" value="Apply Filter"><br/>
            <div class="sidehead">
                <h4>Price</h4>
                <input type="checkbox" name=""> 00-500   <br>
                <input type="checkbox" name=""> 500-1000 <br>
                <input type="checkbox" name=""> 1500-2000<br>
                <input type="checkbox" name=""> 2500-3000<br>
                <input type="checkbox" name=""> 3500-4000<br>
                <input type="checkbox" name=""> 4500-5000<br>
                
            </div><br>
            <div class="sidehead">
                <h4>Discount</h4>


                <input type="checkbox" name="">  Upto 10%<br>
                <input type="checkbox" name=""> 10% - 20%<br>
                <input type="checkbox" name=""> 20% - 30%<br>
                <input type="checkbox" name=""> 30% - 40%<br>
                <input type="checkbox" name=""> 40% - 50%<br>
                <input type="checkbox" name=""> More than 50%<br>
            </div>
            
        </div>

        <div class="category col-md-10">
            <h4><?php echo $category_name = $this->db->query("select category_name from tbl_category_master where category_id=?",array($category_id))->row()->category_name; ?></h4>
            <label>Sort By-</label><label> Personalise</label><label>What's New</label>
            <label>Price</label> 
                <?php
                
                $session_data =$this->session->userdata;
                $currency_id=$session_data['currency_id'];
                $condition = '';
                if($search!=null){
                     $productrecord = $this->db->query("SELECT *,(select i_class from tbl_currency_master where id=pcm.currency_id) as i_class FROM `tbl_product_master` pm inner join tbl_product_currency_map pcm on pm.id = pcm.product_id where pcm.currency_id='$currency_id' and pm.subcategory_id='$category_id' and pm.status='ACTIVE' and pm.product_name like ? group by pcm.product_id",array('%'.$search.'%'))->result();
                }else{
                 $productrecord = $this->db->query("SELECT *,(select i_class from tbl_currency_master where id=pcm.currency_id) as i_class FROM `tbl_product_master` pm inner join tbl_product_currency_map pcm on pm.id = pcm.product_id where pcm.currency_id='$currency_id' and pm.subcategory_id='$category_id' and pm.status='ACTIVE' group by pcm.product_id")->result();
                } 
                 foreach($productrecord as $productrow){
                 ?>
				 <?php
							$encrypted_string = $this->encrypt->encode($productrow->product_id);
							$find=array("+","-","/","=");
							$replace=array("__ADD__","__DASH__","__SLASH__","__EQUAL__");
							$encrypted_string=str_replace($find,$replace,$encrypted_string);
					?>
           
					<form id="<?php echo $encrypted_string.'add_cart'?>" class='form' action="<?php echo base_url()?>index.php/web/addtocart/<?php echo $encrypted_string?>">
				  
				 
               <div class="col-md-4 productview">
					
                   <div>
                       <a href="<?php echo base_url()?>index.php/web/viewProduct/<?php echo $encrypted_string?>" >
                        <?php
                            $productimagerow=$this->db->query("SELECT * FROM tbl_product_image_map where product_id='$productrow->product_id' and image_type='THUMBNAIL' order by id desc limit 0,1")->row();
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
                       </a>
                        <p> Product name - <span><?php echo $productrow->product_name?></span></p>
                        <?php 
                        
                        if($this->session->userdata('user_type')=='SUPPLIER') { 
                        ?>
                        <p>Price- <span>
                                <?php echo $productrow->special_price;?> <i class="fa <?php echo $productrow->i_class?>" aria-hidden="true"></i>
                            </span>
                        
                        </p>
                        <?php
                        }else{
                        ?>
                        
                        <p>Price- <span>
                                <?php echo $productrow->selling_price;?> <i class="fa <?php echo $productrow->i_class?>" aria-hidden="true"></i>
                            </span>
                        
                        </p>
                        <p>Discount Price -
                            <span>
                            <?php
                            if(strlen($productrow->discount_per)>0){
                                echo $productrow->selling_price-(($productrow->discount_per/100)*$productrow->selling_price)                                                                 ;
                            }else{
                                echo $productrow->selling_price;
                            }
                            
                             ?> <i class="fa <?php echo $productrow->i_class?>" aria-hidden="true"></i>
                            </span></p>
                         <?php
                        }
                        ?>
							<?php
							if($productrow->min_qty<$productrow->qty){
							?>
							<p>Quantity -
                            <span>
							<input type="number" min="1" name="<?php echo $encrypted_string?>qty" id="<?php echo $encrypted_string?>qty"/>
                            </span></p>
							<?php
								}
							?>
							<?php
							if($productrow->min_qty>=$productrow->qty){
							?>
							<p>
                            <span>
								Out Of Stock
                            </span></p>
							<?php
								}
							?>
                        <!-- <p>Rating-****</p> !-->
                        <div>
                             <a href="<?php echo base_url()?>index.php/web/viewProduct/<?php echo $encrypted_string?>" class="btn btn-default">More Detail</a>
							<?php
							if($productrow->min_qty<$productrow->qty){
							?>
                           
                            <input type="button"  class="add_cart_button" name="cart" value="ADD to Cart" class=add-cart" onclick="cart1(this,'<?php echo $encrypted_string?>')">
							<?php
								}
							?>
                             <a href="<?php echo base_url()?>index.php/customer/addwishlist/<?php echo $encrypted_string?>" class="btn btn-default">WishList</a>
                           
                            
                        </div>
                   </div>
               </div> 
			   </form>
          
               <?php }
               ?>
                
              
             </label>
        </div>
</div>
    
</div>
<!-- Success Modal -->
                                <div class="modal fade" id="errorModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                  <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-cloud-download" aria-hidden="true"></i> Error Message</h4>
                                      </div>
                                      <div class="modal-body">
                                          <div class="row image-error">
                                              <div class="col-md-12">
                                                  <div class="alert alert-warning error_msg">
                                                      <h5 class="success_msg">Data is Successfully Added</h5>
                                                  </div>
                                              </div>
                                          </div>
                                       
                                        
                                      </div>
                                      <div class="modal-footer">
                                        
                                       
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>

<!-- Success Modal  -->