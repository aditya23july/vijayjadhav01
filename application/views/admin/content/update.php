<script>
$(document).ready(function(){
     var editor = CKEDITOR.replace( 'editor1', {
    filebrowserBrowseUrl : '<?php echo base_url() ?>asset/vendors/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl : '<?php echo base_url() ?>asset/vendors/ckfinder/ckfinder.html?type=Images',
    filebrowserFlashBrowseUrl : '<?php echo base_url() ?>asset/vendors/ckfinder/ckfinder.html?type=Flash',
    filebrowserUploadUrl : '<?php echo base_url() ?>asset/vendors/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl : '<?php echo base_url() ?>asset/vendors/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl : '<?php echo base_url() ?>asset/vendors/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
});
    $("#field_create").validate({
        errorClass: "alert alert-warning",
            rules: {
              title: {
                required: true
              },
               
                status: {
                required: true
                }
            },
            messages: {
             title: {
                required: "Please Enter Field Title."
              },
              
              status: {
                required: "Please Select Status."

              }
          }
      });

});
</script>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Field Updation</h1>
    </div>
    <?php 
        $encrypted_string = $this->encrypt->encode($data->id);
        $find=array("+","-","/","=");
        $replace=array("__ADD__","__DASH__","__SLASH__","__EQUAL__");
        $encrypted_string=str_replace($find,$replace,$encrypted_string);
    
    echo form_open_multipart('managecontent/update/'.$encrypted_string,array('role'=>'form','id'=>'field_create')) ?>
    <?php echo validation_errors('<div class="error" style="color: red;font-weight: 700;font-size:12px;">', '</div>'); ?>
    <div class="row">
        <div class="col-md-12 zero-margin">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                 <i class="fa fa-info-circle" aria-hidden="true"></i> Content Details
                            </a>
                        </h4>
                    </div>
             
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p>Title <i class="fa fa-asterisk mandatory" aria-hidden="true"></i></p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <input type="text" class="form-control" name="title" id="title" value="<?php echo $data->title?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p> Data <i class="fa fa-asterisk mandatory" aria-hidden="true"></i></p>
                            </div>
                            <div class="col-sm-8 col-md-8">
                               <textarea id="editor1" name="editor1"><?php echo $data->data?></textarea>
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
                            <div class="col-md-12 text-center bottom-btns zero-margin">
                                <button class="btn btn-primary" type="submit" name="add"><i class="fa fa-check" aria-hidden="true"></i> Submit</button>

                            </div>
                        </div>
                    </div>
                </div>
                  </div>      
            </div>
        </div>
    </div>                  
</div>