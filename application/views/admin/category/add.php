 <script>
$(document).ready(function(){
    $("#category_create").validate({
        errorClass: "alert alert-warning",
            rules: {
              name: {
                required: true
              },
               parent: {
                required: true
                },
                status: {
                required: true
                }
            },
            messages: {
             name: {
                required: "Please Enter Category Name."
              },
              parent: {
                required: "Please Select Parent Category."

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
        <h1 class="page-header">Category Creation</h1>
    </div>
    <?php echo form_open_multipart('managecategory/new',array('role'=>'form','id'=>'category_create')) ?>
    <?php echo validation_errors('<div class="error" style="color: red;font-weight: 700;font-size:12px;">', '</div>'); ?>
    <div class="row">
        <div class="col-md-12 zero-margin">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                 <i class="fa fa-info-circle" aria-hidden="true"></i> Category Details
                            </a>
                        </h4>
                    </div>
             
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p>Category Title <i class="fa fa-asterisk mandatory" aria-hidden="true"></i></p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p>Parent Category <i class="fa fa-asterisk mandatory" aria-hidden="true"></i></p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <select class="form-control" name="parent" id="parent">
                                    <option value="">Select Parent Category</option>
                                    <option value="0">None</option>
                                    <?php
                                    $record = $this->db->query("select * from tbl_category_master where parent_category_id='0' and status='ACTIVE'")->result();
                                    foreach($record as $row){
                                    ?>
                                    <option value="<?php echo $row->category_id?>"><?php echo $row->category_name?></option>
                                    <?php
                                    }
                                    ?>
                               </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p>Status <i class="fa fa-asterisk mandatory" aria-hidden="true"></i></p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <select class="form-control" name="status" id="status">
                                    <option value="">Select Status</option>
                                    <option value='ACTIVE'>Active</option>
                                    <option value="INACTIVE">InActive</option>
                                   
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