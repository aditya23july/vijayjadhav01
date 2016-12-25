 
<?php
    $cart_record = $this->db->query("select * from tbl_cart_master where cart_id='$cart_id'")->row();
    $customer_master  = $this->db->query("select * from tbl_customer_address_master where id='$cart_record->billing_address_id'")->row();
?>
 <script>
 
$(document).ready(function(){
   <?php
   if(strlen($cart_record->shipping_status)>0){
   ?>
    $("#category_create").validate({
        errorClass: "alert alert-warning",
            rules: {
              shipping_status: {
                required: true
              },
               cc_name: {
                required: true
                },
                awb: {
                required: true
                }
            },
            messages: {
             shipping_status: {
                required: "Please Select Status."
              },
              cc_name: {
                required: "Please Enter Courier Company Name."

              },
              awb: {
                required: "Please Enter  AWB No."

              }
          }
      });
      <?php
   }
   ?>
});
</script>
<script>
     
      
     function remove_price(obj,currency_title,currency_add_value){
         var tr=$(obj).closest('tr');
          var price_count=parseInt($("#price_count").val());
            price_count=price_count-1;
            $("#price_count").val(price_count);
            $('#currency_add').append("<option value='"+currency_add_value+"'>"+currency_title+"</option>");
            $.post("<?php echo base_url()?>index.php/manageproduct/removePrice",{product_id:$('#product_id').val(),currency_id:currency_add_value,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},function(data){
                 $('.success_msg').html('Data is Successfully Updated');
                $('#successModal').modal('show');
            });
         $(tr).remove();
     }
     function remove_image(obj,image_name){
         var tr=$(obj).closest('tr');
          $.post("<?php echo base_url()?>index.php/manageproduct/removeImage",{product_id:$('#product_id').val(),image_name:image_name,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},function(data){
                 $('.success_msg').html('Data is Successfully Updated');
                $('#successModal').modal('show');
            });
         $(tr).remove();
     }
     function remove_field(obj,currency_title,currency_add_value){
         var tr=$(obj).closest('tr');
          $.post("<?php echo base_url()?>index.php/manageproduct/removeField",{product_id:$('#product_id').val(),field_id:currency_add_value,'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},function(data){
                 $('.success_msg').html('Data is Successfully Updated');
                $('#successModal').modal('show');
            });
         $('#field_title_add').append("<option value='"+currency_add_value+"'>"+currency_title+"</option>");
         $(tr).remove();
     }
$(document).ready(function(){
    $('#category').change(function(){
     
       $.post("<?php echo base_url() ?>index.php/manageproduct/getSubCategory",{id:$(this).val(),'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},function(data){
           $('#subcategory').html(data);
         
       });
    });
    $('#save_product').click(function(){
        var product_id=$('#product_id').val();
        var name=$('#title').val();
        var category=$('#category').val();
        var subcategory=$('#subcategory').val();
        var min_qty=$('#min_qty').val();
        var qty=$('#qty').val();
        var status=$('#status').val();
        var error=0;
        var msg='Please Remove all the below Error :- <br/>';
        if(name.trim().length<=0){
            error=1;
            msg+="Product Name is not Entered<br/>"
        }
        if(category.trim().length<=0){
            error=1;
            msg+="Category is not Selected<br/>"
        }
        if(subcategory.trim().length<=0){
            error=1;
             msg+="Sub Category is not Selected<br/>"
        }
        if(min_qty.trim().length<=0){
            error=1;
            msg+="Mininum Qty  is not Entered<br/>"
        }
        if(qty.trim().length<=0){
            error=1;
            msg+="Quantity is not Entered<br/>"
        }
         if(status.trim().length<=0){
            error=1;
            msg+="Status  is not Selected<br/>"
        }
        if(error>0){
           
            $('.product_error').html(msg);
            $('.product_error').show();
        }else{
            $(this).val('Progress');
            $('.product_error').hide();
             $.post("<?php echo base_url() ?>index.php/manageproduct/updateProduct",{ 
                                    product_id:product_id,
                                    name:name,
                                    category:category,
                                    subcategory:subcategory,
                                    min_qty:min_qty,
                                    qty:qty,
                                    status:status,
                                    '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
             function(data){
               //$('#product_id').val(data);
             });
            $('.price_main_div').show();
            $('.success_msg').html('Data is Successfully Updated');
            $('#successModal').modal('show');
            $('#collapseTwo').addClass('in');
           
        }
      
       
    });
    $('#image_add').click(function(){
        var product_id=$('#product_id').val();
        var image=$('#field_image_add').val();
        var file_data=$('#file').prop("files")[0];
        var form_data = new FormData();
        form_data.append("file",file_data);
        form_data.append("product",product_id);
        form_data.append("image_type",image);
        form_data.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
         
        $.ajax({
           url:'<?php echo base_url() ?>index.php/manageproduct/saveProductImage',
           cache:false,
           contentType:false,
           processData:false,
           data:form_data,
           type:'post',
           success:function(data){
                var data1="'"+data+"'";
              var tr="<tr> ";
              tr+="<td>";
               tr+=$('#field_image_add :selected').text();
              tr+="</td>";
              tr+="<td>";
              tr+="<img src='<?php echo base_url()?>/upload/"+data+"' width='100'/>";
              tr+="</td>";
              tr+="<td>";
             
              tr+='<button type="button" class="btn btn-danger"  onclick="remove_image(this,'+data1+')">Remove</button>';
              tr+="</td>";
              tr+="</tr>";
              $('#image').append(tr);
               $('#imageModal').modal('hide');
           }
        });
    });
    $('#price_add').click(function(){
        var currency_add=$('#currency_add').val();
        var mrp=$('#mrp_add').val();
        var pp=$('#pp_add').val();
        var sp=$('#sp_add').val();
       
        var sup=$('#sup_add').val();
        var error=0;
        var msg='Please Remove all the below Error :- <br/><br/>';
        if(currency_add.trim().length<=0){
            error=1;
            msg+="Currency is not Selected<br/>"
        }
        if(mrp.trim().length<=0){
            error=1;
            msg+="MRP is not Filled<br/>"
        }
        if(pp.trim().length<=0){
            error=1;
            msg+="Purchase Price is not Filled<br/>"
        }
        if(sp.trim().length<=0){
            error=1;
            msg+="Selling Price is not Filled<br/>"
        }
        if(sup.trim().length<=0){
            error=1;
            msg+="Supplier Price is not Filled<br/>"
        }
        if(error>0){
            $('.error_msg').html(msg);
            $('.price-error').show();
        }else{
            $('.price-error').hide();
            var product_id=$('#product_id').val();
            $.post("<?php echo base_url() ?>index.php/manageproduct/saveProductPrice",{  product_id:product_id,
                                    currency_id:currency_add,
                                    mrp:mrp,
                                    pp:pp,
                                    sp:sp,
                                    sup:sup,
                                    disc:$('#dis_add').val(),
                                    '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
             function(data){
               
             });
            var currency_add_value="'"+currency_add+"'";
            var price_count=parseInt($("#price_count").val());
            price_count=price_count+1;
            $("#price_count").val(price_count);
            var currency_val="'"+$('#currency_add :selected').text()+"'";
            var tr="<tr> ";
             tr+="<td class='currency_title'><input type='hidden' name='currency_name[]' value='"+currency_add+"'>";
             tr+=$('#currency_add :selected').text();
             tr+="</td>";
              tr+="<td><input type='hidden' name='mrp[]' value='"+mrp+"'>";
             tr+=mrp;
             tr+="</td>";
             tr+="<td><input type='hidden' name='sp[]' value='"+sp+"'>";
             tr+=sp;
             tr+="</td><input type='hidden' name='pp[]' value='"+pp+"'>";
               tr+="<td>";
             tr+=pp;
             tr+="</td>";
               tr+="<td><input type='hidden' name='sup[]' value='"+sup+"'>";
             tr+=sup;
             tr+="</td>";
              tr+="<td><input type='hidden' name='sup[]' value='"+$('#dis_add').val()+"'>";
             tr+=$('#dis_add').val();
             tr+="</td>";
              tr+="<td>";
             tr+='<button type="button" class="btn btn-danger"  onclick="remove_price(this,'+currency_val+','+currency_add_value+')">Remove</button>';
             tr+="</td>";
             tr+="</tr>";
             $('#price').append(tr);
             $('#currency_add :selected').remove();
            $('#mrp_add').val(null);
            $('#pp_add').val(null);
            $('#sp_add').val(null);
            $('#sup_add').val(null);
            $('#dis_add').val(null);
             $('#myModal').modal('hide');
              
            $('.field_main_div').show();
            $('#collapseThree').addClass('in');
        }
    });
    $('#field_add').click(function(){
        var field_type=$('#field_type_add').val();
        var field_title=$('#field_title_add').val();
        
        var error=0;
        var msg='Please Remove all the below Error :- <br/><br/>';
        if(field_title.length<=0){
            error=1;
            msg+="Please Select Field";
        }
        if(field_type.trim().length>0){
           
           if(field_type=='TINYTEXT'){
               var value=$('#tiny_text_add').val();
               
               if(value.trim().length<=0){
                   error=1;
                   msg+="Please Enter the field Value";
               }
           }else if(field_type=='MEDIUMTEXT'){
               var value=$('#medium_text_add').val();
               if(value.trim().length<=0){
                   error=1;
                   msg+="Please Enter the field Value";
               }
           }else{
               var value=$('#long_text_add').val();
               if(value.trim().length<=0){
                   error=1;
                   msg+="Please Enter the field Value";
               }
           }
           
        }
        if(error==1){
            $('.error_msg').html(msg);
            $('.field-error').show();
        }else{
            var product_id=$('#product_id').val();
            $.post("<?php echo base_url() ?>index.php/manageproduct/saveProductField",{  product_id:product_id,
                                    field_id:field_title,
                                    field_value:value,
                                  
                                    '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
             function(data){
               
             });
                var field_title_add="'"+field_title+"'";
                var field_title_val="'"+$('#field_title_add :selected').text()+"'";
                var tr="<tr> ";
                tr+="<td>";
                tr+=$('#field_title_add :selected').text();
                tr+="</td>";
                tr+="<td>";
                tr+=value;
                tr+="</td>";
                 tr+="<td>";
                tr+='<button type="button" class="btn btn-danger"  onclick="remove_field(this,'+field_title_val+','+field_title_add+')">Remove</button>';
                tr+="</td>";
                tr+="</tr>";
                $('#field_title_add :selected').remove();
                $('#field_type_add').val(null);
                if(field_type=='TINYTEXT'){
                    $('#tiny_text_add').val(null);
                }else if(field_type=='MEDIUMTEXT'){
                    $('#medium_text_add').val(null);
                    
                }else{
                    $('#long_text_add').val(null);
                    
                }
                 $('#myModal').modal('hide');
                $('#field').append(tr);
            $('.field-error').hide();
             $('.image_main_div').show();
            $('#collapseFourth').addClass('in');
           
        }
        
    });
    $('#field_title_add').change(function(){
       $.post("gettype",{id:$(this).val(),'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},function(data){
           $('#field_type_add').val(data);
           if(data=='TINYTEXT'){
               $('#tiny_text_add').show();
               $('#medium_text_add').hide();
               $('#long_text_add').hide();
           }else if(data=='MEDIUMTEXT'){
               $('#tiny_text_add').hide();
               $('#medium_text_add').show();
               $('#long_text_add').hide();
           }else{
                $('#tiny_text_add').hide();
               $('#medium_text_add').hide();
               $('#long_text_add').show();
           }
       });
    });
});
</script>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">Order Id : <?php echo $cart_record->order_id?></h3>
    </div>
    
    
    <?php echo validation_errors('<div class="error" style="color: red;font-weight: 700;font-size:12px;">', '</div>'); ?>
    <div class="row">
        <div class="col-md-12 zero-margin">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                 <i class="fa fa-info-circle" aria-hidden="true"></i>Order  Details
                            </a>
                        </h4>
                    </div>
             
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="row">
                          
                            <div class="col-sm-12 col-md-12">
                                <div class="alert alert-warning product_error" style="display:none">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p> Order Id </p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                               <p> <?php echo $cart_record->order_id?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                 <p> Order Status </p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <p><?php 
                                if(strlen($cart_record->order_status)>0){
                                    echo $cart_record->order_status;
                                }else{
                                    echo"Pending";
                                }
                                ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                 <p> Order Date </p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <p><?php 
                                if(strlen($cart_record->order_date)>0){
                                    echo Date('d-M-Y H:i:s',strtotime($cart_record->order_date));
                                }else{
                                    echo"Pending";
                                }
                                ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                 <p> Total Amount (Including All Taxes)</p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <p>
                                <?php 
                                        $total_amount=$cart_record->total_cost;
                                        $taxresult = $this->db->query("SELECT * FROM `tbl_tax_master` where currency_id='1' and status='ACTIVE' ")->result();
                                        foreach($taxresult as $taxrecord){
                                        $total_amount=($total_amount*$taxrecord->tax_value)/100+$total_amount;
                                        }
                                        $shippingrecord = $this->db->query("select * from tbl_shipping_rule_master where currency_id=1")->row();
                                        if(isset($shippingrecord->min_value)){
                                           
                                            if($cart_record->total_cost>$shippingrecord->min_value){
                                                
                                            }else{
                                                 if($cart_record->order_status!='Canceled'){
                                                $total_amount=$total_amount+$shippingrecord->shipping_charge;
                                                 }
                                            }
                                        }
                                       echo round($total_amount,2);
                                       
                                ?></p>
                            </div>
                        </div>
                      </div>
                </div>
                  </div>   
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                 <i class="fa fa-info-circle" aria-hidden="true"></i>Customer  Details
                            </a>
                        </h4>
                    </div>
             
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="row">
                          
                            <div class="col-sm-12 col-md-12">
                                <div class="alert alert-warning product_error" style="display:none">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p> Customer Type</p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                               <p> Customer</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p> Name </p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <p><?php echo $customer_master->customer_name?></p>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p> Address</p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                               <p> <?php echo $customer_master->address?>,
                               <br/>
                               <?php echo $customer_master->city?>,
                               
                                <?php echo $customer_master->state?>,
                                <br/>
                               <?php echo $customer_master->country?>,<?php echo $customer_master->pincode?>
                               </p>
                            </div>
                        </div>
                        
                         <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p> Mobile</p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                               <p> <?php echo $customer_master->mobile?></p>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p> Email</p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                               <p> <?php echo $customer_master->email?></p>
                            </div>
                        </div>
                    </div>
                </div>
                  </div>      
            </div>
        </div>
    </div> 
        <?php
    if(strlen($cart_record->order_status)>0){
    ?>
    <div class="row field_main_div" >
        <div class="col-md-12 zero-margin">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseTwo">
                                 <i class="fa fa-info-circle" aria-hidden="true"></i>Shipping Detail 
                            </a>
                        </h4>
                    </div>
             
                <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                           <div class="row">
                                
                                <div class="col-sm-8 col-md-4">
                                    
                                
                                </div>
                                
                           </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php 
                                    $encrypted_string = $this->encrypt->encode($cart_id);
                                    $find=array("+","-","/","=");
                                    $replace=array("__ADD__","__DASH__","__SLASH__","__EQUAL__");
                                    $encrypted_string=str_replace($find,$replace,$encrypted_string);
                                    echo form_open_multipart('manageorder/shipping/'.$encrypted_string,array('role'=>'form','id'=>'category_create')); 
                                ?>
                                <?php echo validation_errors('<div class="error" style="color: red;font-weight: 700;font-size:12px;">', '</div>'); ?>
                                <div class="table-responsive" >
                                         <table class="table table-bordered" id="price">
                                            <tr>
                                                <th width="12.5%">Shipping Status</th>
                                                <th width="12.5%">
                                                    <?php
                                                    if($cart_record->shipping_status=='D'){
                                                        echo 'Delievered';
                                                    }else{
                                                    ?>
                                                    
                                                     <select class="form-control" id="shipping_status" name="shipping_status">
                                                        <?php
                                                        if($cart_record->shipping_status!='O'){
                                                        ?>
                                                        <option value="O">Out For Delivery</option>
                                                        <?php
                                                        }else{
                                                        ?>
                                                        <option value="D">Delievered</option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php
                                                    }
                                                    ?>
                                                </th>
                                              
                                            </tr>
                                            <tr>
                                                <th width="12.5%">Courier Company Name</th>
                                                <th width="12.5%">
                                                    <?php 
                                                    if(strlen($cart_record->shipping_status)>0){
                                                        echo $cart_record->cc_name;
                                                    }else{
                                                        echo '<input type="text" name="cc_name" id="cc_name" class="form-control">';
                                                    }
                                                    ?>
                                                   
                                                </th>
                                              
                                            </tr>
                                            <tr>
                                                <th width="12.5%">AWB No</th>
                                                <th width="12.5%">
                                                    <?php 
                                                    if(strlen($cart_record->shipping_status)>0){
                                                        echo $cart_record->awb_no;
                                                    }else{
                                                        echo '<input type="text" name="awb" id="awb" class="form-control">';
                                                    }
                                                    ?>
                                                    
                                                </th>
                                              
                                            </tr>
                                            <tr>
                                                <th width="12.5%"></th>
                                                <th width="12.5%">
                                                    <?php
                                                    if($cart_record->shipping_status!='D'){
                                                    echo '<input type="submit" name="shipping_submit" class="btn btn-success" value="Update">';
                                                    }
                                                    ?>
                                                </th>
                                              
                                            </tr>
                                        </table>
                                    </div>
                            </form>
                            </div>
                        </div>  
                    </div>
                </div>
                  </div>      
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div class="row price_main_div" >
        <div class="col-md-12 zero-margin">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                 <i class="fa fa-info-circle" aria-hidden="true"></i>Product Status 
                            </a>
                        </h4>
                    </div>
             
                <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                      <?php 
                                                $encrypted_string = $this->encrypt->encode($cart_record->cart_id);
                                                $find=array("+","-","/","=");
                                                $replace=array("__ADD__","__DASH__","__SLASH__","__EQUAL__");
                                                $encrypted_string=str_replace($find,$replace,$encrypted_string);
                                            ?>
                                            <form action="<?php echo base_url()?>index.php/manageorder/view/<?php echo $encrypted_string?>" method="post">     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" >
                                        <input type="hidden" name="price_count" value="0" id="price_count">
                                        <table class="table table-bordered" id="price">
                                            <tr class="bg-gray">
                                                <th width="12.5%">Sr No.</th>
                                                <th width="12.5%">Item Name</th>
                                                <th width="12.5%">Qty</th>
                                                <th width="12.5%">Total Price</th>
                                                <th width="10%">Status</th>
                                            </tr>
                                           
                                            <?php
                                            $i=0;
                                            $record = $this->db->query("select * from tbl_cart_item where cart_id='$cart_record->cart_id'")->result();
                                                foreach($record as $row){
                                                    $i++;
                                                    ?>
                                            <tr>
                                                    <td>
                                                        <?php echo $i++ ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row->item_desc ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row->qty ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row->total_gross_price ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if(strlen($row->status)>0){
                                                            echo $row->status;
                                                          
                                                        ?>
                                                       
                                                        <?php
                                                        }else{
                                                        ?>
                                                         <select name="product_status<?php echo $row->item_id?>" class="form-control">
                                                           
                                                             <option value="confirm">Confirm</option>
                                                              <option value="cancel">Cancel</option>
                                                        </select>
                                                        <?php } ?>
                                                       
                                                    </td>
                                                    
                                                    
                                            </tr>
                                            <?php 
                                                }
                                            ?>
                                           
                                            
                                        </table>
                                    </div>
                            </div>
                        </div>  
                         <div class="row">
                              
                                <div class="col-sm-8 col-md-4">
                                    <?php
                                     if(strlen($cart_record->order_status)<=0){
                                    ?>
                                    <button class="btn btn-primary btn-sm" type="submit" name="btn_status_item"><i class="fa fa-cloud-download" aria-hidden="true"></i> Update Order</button>
                                    <?php
                                     }
                                     ?>
                                </div>
                                
                           </div>
                     </form>
                    </div>

                </div>
                  </div>      
            </div>
        </div>
    </div>
    <?php
    if(strlen($cart_record->order_status)>0){
    ?>
    <div class="row field_main_div" >
        <div class="col-md-12 zero-margin">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseTwo">
                                 <i class="fa fa-info-circle" aria-hidden="true"></i>Order Detail 
                            </a>
                        </h4>
                    </div>
             
                <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                           <div class="row">
                                
                                <div class="col-sm-8 col-md-4">
                                    <?php if($cart_record->order_status=='Confirm' || $cart_record->order_status=='Parial Confirmed'){
                                     ?>
                                        <button class="btn btn-warning btn-md" type="button" data-toggle="modal" data-target="#fieldModal"><i class="fa fa-cloud-download" aria-hidden="true"></i> Generate Invoice</button>
                                    <?php
                                    }
                                    ?>
                                
                                </div>
                                
                           </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" >
                                         <table class="table table-bordered" id="price">
                                            <tr class="bg-gray">
                                                <th width="12.5%">Sr No.</th>
                                                <th width="12.5%">Item Name</th>
                                                <th width="12.5%">Qty</th>
                                                <th width="12.5%">Total Price</th>
                                                <th width="10%">Status</th>
                                            </tr>
                                           
                                            <?php
                                            $i=0;
                                            $record = $this->db->query("select * from tbl_cart_item where cart_id='$cart_record->cart_id'")->result();
                                                foreach($record as $row){
                                                    $i++;
                                                    ?>
                                            <tr>
                                                    <td>
                                                        <?php echo $i++ ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row->item_desc ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row->qty ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row->total_gross_price ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if(strlen($row->status)>0){
                                                            echo $row->status;
                                                          
                                                        ?>
                                                       
                                                        <?php
                                                        }else{
                                                        ?>
                                                         <select name="product_status<?php echo $row->item_id?>" class="form-control">
                                                           
                                                             <option value="confirm">Confirm</option>
                                                              <option value="cancel">Cancel</option>
                                                        </select>
                                                        <?php } ?>
                                                       
                                                    </td>
                                                    
                                                    
                                            </tr>
                                            <?php 
                                                }
                                            ?>
                                           <tr>
                                               <td>
                                                       
                                                    </td>
                                                    
                                                   <td>
                                                       
                                                    </td>
                                                    <td>
                                                      Sub-Total Amount
                                                    </td>
                                                    <td>
                                                       <?php 
                                                       if(strlen($cart_record->total_cost)>0){
                                                            echo $cart_record->total_cost;
                                                       }else{
                                                           echo $cart_record->total_cost=0;
                                                       }
                                                      
                                                               ?> 
                                                    </td>
                                                    <td>
                                                       
                                                    </td>
                                           </tr>
                                                <?php
                                $total_amount = $cart_record->total_cost;
                                $taxresult = $this->db->query("SELECT * FROM `tbl_cart_tax_map` where cart_id='$cart_record->cart_id'")->result();
                                foreach ($taxresult as $taxrecord) {
                                    $total_amount = ($total_amount * $taxrecord->tax_value) / 100 + $total_amount;
                                    ?>
                                    <tr>
                                        <td>
                                                       
                                                    </td>
                                                    
                                                   <td>
                                                       
                                                    </td>
                                        <td class="sum"><?php echo $taxrecord->tax_title ?></td>
                                        <td><?php echo $taxrecord->tax_value ?>%</td>
                                        <td>
                                                       
                                                    </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                      <td>
                                                       
                                                    </td>
                                                    
                                                   <td>
                                                       
                                                    </td>
                                    <td class="sum">Shipping Charges</td>
                                    
                                    <td>
                                        <?php
                                        $shippingrecord = $this->db->query("select * from tbl_shipping_rule_master where currency_id=1")->row();
                                        if (isset($shippingrecord->min_value)) {
                                            if ($cart_record->total_cost > $shippingrecord->min_value) {
                                                echo 'NA';
                                            } else {
                                                 if($cart_record->order_status!='Canceled'){
                                                $total_amount = $total_amount + $shippingrecord->shipping_charge;
                                                echo $shippingrecord->shipping_charge;
                                                 }else{
                                                    echo $shippingrecord->shipping_charge; 
                                                 }
                                                 
                                            }
                                        }
                                        ?>
                                    </td>
                                      <td>
                                                       
                                                    </td>
                                                    
                                                   
                                </tr>

                                <tr>
                                     <td>
                                                       
                                                    </td>
                                                     <td>
                                                       
                                                    </td>
                                    <td class="sum">Total Amount</td>

                                    <td><?php echo round($total_amount, 2) ?></td>
                                     <td>
                                                       
                                                    </td>
                                </tr>
                                        </table>
                                    </div>
                            </div>
                        </div>  
                    </div>
                </div>
                  </div>      
            </div>
        </div>
    </div>
    <?php
    }
    ?>


