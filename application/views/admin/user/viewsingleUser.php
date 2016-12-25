 <script>
$(document).ready(function(){
    $("#category_create").validate({
        errorClass: "alert alert-warning",
            rules: {
              name: {
                required: true
              },
              taxvalue: {
                required: true,
number:true
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
                required: "Please Enter Tax Name."
              },
             taxvalue: {
                required: "Please Enter Tax Value.",
number: "Please Enter Number."
              },
              parent: {
                required: "Please Select Currency."

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
        <h1 class="page-header">&nbsp;</h1>
    </div>

    <div class="row">
        <div class="col-md-12 zero-margin">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                 <i class="fa fa-info-circle" aria-hidden="true"></i> User Details
                            </a>
                        </h4>
                    </div>
             
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p>User Name </p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <?php echo $data->name;?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p>Address </p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <?php echo $data->address1;?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p>State</p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <?php echo $data->state;?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p>City</p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <?php echo $data->city;?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p>Pin Code</p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <?php echo $data->pincode;?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p>E-Mail</p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <?php echo $data->email;?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 col-md-2 right-padding">
                                <p>Mobile</p>
                            </div>
                            <div class="col-sm-8 col-md-4">
                                <?php echo $data->mobile1;?>
                            </div>
                        </div>








                        <div class="row">
                            <?php
                            if($data->user_type=='SUPPLIER' && $data->status=='INACTIVE'){
                            ?>
                            <div class="col-md-2 text-center bottom-btns zero-margin">
                                <?php echo form_open_multipart('manageuser/viewuser/'.$param) ?>
                                <button class="btn btn-success" type="submit" name="submit"> Confirm Reseller</button>
                            </form>
                            </div>
                            <?php
                            }
                            ?>
                            <div class="col-md-2 text-center bottom-btns zero-margin">
                                
                                <a href="<?php echo base_url()?>index.php/manageuser/view"><button class="btn btn-primary" type="button" name="add"> Back</button>
</a>
                            </div>
                        </div>
                    </div>
                </div>
                  </div>      
            </div>
        </div>
    </div>                  
</div>