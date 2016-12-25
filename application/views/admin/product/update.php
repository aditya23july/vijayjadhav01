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
       $.post("<?php echo base_url() ?>index.php/manageproduct/gettype",{id:$(this).val(),'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},function(data){
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
        <h1 class="page-header">Product Updation</h1>
    </div>
    
    <input type="hidden" name="product_id" value="<?php echo $data->id?>" id="product_id"/>
    <?php echo validation_errors('<div class="error" style="color: red;font-weight: 700;font-size:12px;">', '</div>'); ?>
    <div class="row">
        <div class="col-md-12 zero-margin">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                 <i class="fa fa-info-circle" aria-hidden="true"></i>Basic Details
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
                                <p>Product Name <i class="fa fa-asterisk mandatory" aria-hidden="true"></i></p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <input type="text" class="form-control" name="name" id="title" value="<?php echo $data->product_name?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p>Category <i class="fa fa-asterisk mandatory" aria-hidden="true"></i></p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <select class="form-control" name="category" id="category">
                                    <option value="">Select Category</option>
                                    <?php
                                    $record = $this->db->query("select * from tbl_category_master where (parent_category_id='0' and status='ACTIVE') or category_id='$data->category_id'")->result();
                                    foreach($record as $row){
                                        if($row->category_id==$data->category_id){
                                            $selected='selected';
                                        }else{
                                            $selected=null;
                                        }
                                    ?>
                                    <option value="<?php echo $row->category_id?>" <?php echo $selected ?>><?php echo $row->category_name?></option>
                                    <?php
                                    }
                                    ?>
                                   
                               </select> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p>Sub Category <i class="fa fa-asterisk mandatory" aria-hidden="true"></i></p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <select class="form-control" name="subcategory" id="subcategory">
                                    <option value="">Select Sub Category</option>
                                    <?php
                                    $record = $this->db->query("select * from tbl_category_master where (parent_category_id='$data->category_id' and status='ACTIVE') or category_id='$data->subcategory_id'")->result();
                                    foreach($record as $row){
                                        if($row->category_id==$data->subcategory_id){
                                            $selected='selected';
                                        }
                                    ?>
                                    <option value="<?php echo $row->category_id?>" <?php echo $selected ?>><?php echo $row->category_name?></option>
                                    <?php
                                    }
                                    ?>
                               </select> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p> Min Qty <i class="fa fa-asterisk mandatory" aria-hidden="true"></i></p>
                            </div>
                             <div class="col-sm-4 col-md-2">
                                <input type="number" class="form-control" name="min_qty" id="min_qty" value="<?php echo $data->min_qty?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p>  Qty <i class="fa fa-asterisk mandatory" aria-hidden="true"></i></p>
                            </div>
                             <div class="col-sm-4 col-md-2">
                                <input type="number" class="form-control" name="qty" id="qty" value="<?php echo $data->qty?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p>Status <i class="fa fa-asterisk mandatory" aria-hidden="true"></i></p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <select class="form-control" name="status" id="status">
                                    <option value="">Select Status</option>
                                       <?php 
                                    if($data->status=='ACTIVE'){
                                        $selected='selected';
                                    }else{
                                        $selected=null;
                                    }
                                    ?>
                                    <option value='ACTIVE' <?php echo $selected ?>>Active</option>
                                    <?php 
                                    if($data->status=='INACTIVE'){
                                        $selected='selected';
                                    }else{
                                        $selected=null;
                                    }
                                    ?>
                                    <option value="INACTIVE" <?php echo $selected ?>>InActive</option>
                                   
                               </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <button type="button" class="btn btn-primary" id="save_product"><i class="fa fa-plus" aria-hidden="true" ></i> Update Product</button>
                               
                            </div>
                        </div>
                    </div>
                </div>
                  </div>      
            </div>
        </div>
    </div>            
    <div class="row price_main_div" >
        <div class="col-md-12 zero-margin">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                 <i class="fa fa-info-circle" aria-hidden="true"></i>Price Details
                            </a>
                        </h4>
                    </div>
             
                <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                           <div class="row">
                                <div class="col-sm-4 col-md-2 right-padding">
                                    <p> Currency Price </p>
                                </div>
                                <div class="col-sm-8 col-md-4">
                                    <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#myModal"><i class="fa fa-cloud-download" aria-hidden="true"></i> Add New Currency Price</button>
                                </div>
                                
                           </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" >
                                        <input type="hidden" name="price_count" value="0" id="price_count">
                                        <table class="table table-bordered" id="price">
                                            <tr class="bg-gray">
                                                <th width="12.5%">Currency</th>
                                                <th width="12.5%">MRP</th>
                                                <th width="12.5%">Selling Price</th>
                                                <th width="12.5%">Purchase Price</th>
                                                <th width="12.5%">Supplier Price</th>
                                                <th width="12.5%">Discount (in %)</th>
                                                <th width="10%"></th>
                                            </tr>
                                            <?php
                                                $record = $this->db->query("select *,(select tittle from tbl_currency_master where id=currency_id) as currency_name from tbl_product_currency_map where product_id='$data->id'")->result();
                                                foreach($record as $row){
                                            ?>
                                            <tr>
                                                    <td>
                                                        <?php echo $row->currency_name ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row->mrp ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row->selling_price ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row->cost_price ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row->special_price ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row->discount_per ?>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info" id="remove_price" onclick="remove_price(this,'<?php echo $row->currency_name?>','<?php echo $row->currency_id?>')">Remove</button>
                                                    </td>
                                            </tr>
                                            <?php 
                                                }
                                            ?>
                                            
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
    <div class="row field_main_div" >
        <div class="col-md-12 zero-margin">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseTwo">
                                 <i class="fa fa-info-circle" aria-hidden="true"></i>Custom Fields 
                            </a>
                        </h4>
                    </div>
             
                <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                           <div class="row">
                                <div class="col-sm-4 col-md-2 right-padding">
                                    <p> Fields  </p>
                                </div>
                                <div class="col-sm-8 col-md-4">
                                    <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#fieldModal"><i class="fa fa-cloud-download" aria-hidden="true"></i> Add New Field</button>
                                </div>
                                
                           </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" >
                                        
                                        <table class="table table-bordered" id="field">
                                            <tr class="bg-gray">
                                                <th width="22.5%">Field Title </th>
                                                <th width="50.5%">Field Value</th>
                                              
                                                <th width="10%"></th>
                                            </tr>
                                            <?php
                                                $record = $this->db->query("select  *,(select field_title from tbl_field_master where id=field_id) as field_title from tbl_product_field_map where product_id='$data->id'")->result();
                                                foreach($record as $row){
                                            ?>
                                            <tr>
                                                    <td>
                                                        <?php echo $row->field_title ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row->value ?>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info" id="remove_field" onclick="remove_field(this,'<?php echo $row->field_title?>','<?php echo $row->field_id?>')">Remove</button>
                                                    </td>
                                            </tr>
                                            <?php 
                                                }
                                            ?>
                                            
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
    <div class="row image_main_div"  >
        <div class="col-md-12 zero-margin">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFourth">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFourth" aria-expanded="true" aria-controls="collapseTwo">
                                 <i class="fa fa-info-circle" aria-hidden="true"></i>Images
                            </a>
                        </h4>
                    </div>
             
                <div id="collapseFourth" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                           <div class="row">
                                <div class="col-sm-4 col-md-2 right-padding">
                                    
                                </div>
                                <div class="col-sm-8 col-md-4">
                                    <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#imageModal"><i class="fa fa-cloud-download" aria-hidden="true"></i> Add New Image</button>
                                </div>
                                
                           </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" >
                                        
                                        <table class="table table-bordered" id="image">
                                            <tr class="bg-gray">
                                                <th width="22.5%">Image Type </th>
                                                <th width="50.5%">Image Preview</th>
                                              
                                                <th width="10%"></th>
                                            </tr>
                                            <?php
                                                $record = $this->db->query("select  * from tbl_product_image_map where product_id='$data->id'")->result();
                                                foreach($record as $row){
                                            ?>
                                            <tr>
                                                    <td>
                                                        <?php echo $row->image_type ?>
                                                    </td>
                                                    <td>
                                                        <img src="<?php echo base_url().'upload/'.$row->image_name ?>" width="100"/>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info" id="remove_field" onclick="remove_image(this,'<?php echo $row->image_name?>')">Remove</button>
                                                    </td>
                                            </tr>
                                            <?php 
                                                }
                                            ?>
                                            
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
</div>



<!-- Model Pop up--!>
<!-- Price Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                  <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-cloud-download" aria-hidden="true"></i> Add New Price</h4>
                                      </div>
                                      <div class="modal-body">
                                          <div class="row price-error" style="display:none">
                                              <div class="col-md-12">
                                                  <div class="alert alert-warning error_msg">
                                                      
                                                  </div>
                                              </div>
                                          </div>
                                        <table class="table table-bordered">
                                            <tr>
                                            	<th width="35%"  class="bg-gray">Currency </th>
                                                <td width="65%">
                                                    <select class="form-control"  id="currency_add">
                                                        <option value="">Select Currency</option>
                                                       <?php
                                                         $record = $this->db->query("select * from tbl_currency_master where id not in (select currency_id from tbl_product_currency_map where product_id='$data->id')")->result();
                                                         foreach($record as $row){
                                                       ?>
                                                        <option value="<?php echo $row->id?>"><?php echo $row->tittle?></option>
                                                        <?php
                                                         }
                                                        ?> 
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th width="35%"  class="bg-gray">MRP </th>
                                                <td width="65%"><input type="number" class="form-control" id="mrp_add" /></td>
                                            </tr>
                                            <tr>
                                            	<th width="35%"  class="bg-gray">Purchase Price </th>
                                                <td width="65%"><input type="number" class="form-control" id="pp_add" /></td>
                                            </tr>
                                            <tr>
                                            	<th width="35%"  class="bg-gray">Selling Price </th>
                                                <td width="65%"><input type="number" class="form-control" id="sp_add"/></td>
                                            </tr>
                                             <tr>
                                            	<th width="35%"  class="bg-gray">Supplier Price </th>
                                                <td width="65%"><input type="number" class="form-control" id="sup_add"/></td>
                                            </tr>
                                            <tr>
                                            	<th width="35%"  class="bg-gray">Discount (in %) </th>
                                                <td width="65%"><input type="number" class="form-control" id="dis_add"/></td>
                                            </tr>
                                        </table>
                                        
                                      </div>
                                      <div class="modal-footer">
                                        
                                        <button type="button" class="btn btn-primary" id="price_add"><i class="fa fa-plus" aria-hidden="true" ></i> Add</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>

<!-- Price Modal  -->
<!-- Field Modal -->
                                <div class="modal fade" id="fieldModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                  <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-cloud-download" aria-hidden="true"></i> Add New Field</h4>
                                      </div>
                                      <div class="modal-body">
                                          <div class="row field-error" style="display:none">
                                              <div class="col-md-12">
                                                  <div class="alert alert-warning error_msg">
                                                      
                                                  </div>
                                              </div>
                                          </div>
                                        <table class="table table-bordered">
                                            <tr>
                                            	<th width="35%"  class="bg-gray">Field Title </th>
                                                <td width="65%">
                                                    <select class="form-control"  id="field_title_add">
                                                        <option value="">Select Field Title</option>
                                                       <?php
                                                         $record = $this->db->query("SELECT * FROM `tbl_field_master` where status='ACTIVE' and id not in (select field_id from tbl_product_field_map where product_id='$data->id')")->result();
                                                         foreach($record as $row){
                                                       ?>
                                                        <option value="<?php echo $row->id?>"><?php echo $row->field_title?></option>
                                                        <?php
                                                         }
                                                        ?> 
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="35%"  class="bg-gray">Type </th>
                                                 <th width="35%"  class="bg-gray">
                                                     <input type="text" id="field_type_add" disabled/>
                                                 </th>
                                            </tr>
                                            <tr>
                                            	<th width="35%"  class="bg-gray">Value </th>
                                                <td width="65%">
                                                    <input type="text" class="form-control" id="tiny_text_add" style="display:none"/>
                                                    <textarea class="form-control" id="medium_text_add" col="20" rows="2"  >
                                                        
                                                    </textarea>
                                                     <textarea class="form-control" id="long_text_add" col="50" rows="10" style="display:none">
                                                        
                                                    </textarea>
                                                </td>
                                            </tr>
                                            
                                            
                                        </table>
                                        
                                      </div>
                                      <div class="modal-footer">
                                        
                                        <button type="button" class="btn btn-primary" id="field_add"><i class="fa fa-plus" aria-hidden="true" ></i> Add</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>

<!-- Field Modal  -->
<!-- IMage Modal -->
                                <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                  <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-cloud-download" aria-hidden="true"></i> Add New Field</h4>
                                      </div>
                                      <div class="modal-body">
                                          <div class="row image-error" style="display:none">
                                              <div class="col-md-12">
                                                  <div class="alert alert-warning error_msg">
                                                      
                                                  </div>
                                              </div>
                                          </div>
                                        <table class="table table-bordered">
                                            <tr>
                                            	<th width="35%"  class="bg-gray">Field Title </th>
                                                <td width="65%">
                                                    <select class="form-control"  id="field_image_add">
                                                        <option value="">Select Image Type</option>
                                                        <option value="THUMBNAIL">Thumbnail</option>
                                                        <option value="GALLERY">Gallery</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<th width="35%"  class="bg-gray">Image </th>
                                                <td width="65%">
                                                    <input type="file" name="file" id="file"/>
                                                </td>
                                            </tr>
                                            
                                            
                                        </table>
                                        
                                      </div>
                                      <div class="modal-footer">
                                        
                                        <button type="button" class="btn btn-primary" id="image_add"><i class="fa fa-plus" aria-hidden="true" ></i> Add</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>

<!-- Image Modal  -->
<!-- Success Modal -->
                                <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                  <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-cloud-download" aria-hidden="true"></i> Success Message</h4>
                                      </div>
                                      <div class="modal-body">
                                          <div class="row image-error">
                                              <div class="col-md-12">
                                                  <div class="alert alert-warning">
                                                      <h5 class="success_msg">Data is Successfully Updated</h5>
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