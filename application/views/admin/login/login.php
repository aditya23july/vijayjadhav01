 <script>
$(document).ready(function(){
    $("#login").validate({
        errorClass: "alert alert-warning",
            rules: {
              username: {
                required: true
              },
               password: {
                required: true
                }
            },
            messages: {
             username: {
                required: "Please Enter Username.It is compulsory"
              },
              password: {
                required: "Please Enter Password.It is compulsory"

              }
          }
      });

});
</script>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading login-heading">
                        <h3 class="panel-title login-title">BestBuy</h3>
                    </div>
                    <div class="panel-body">
                        <?php echo form_open_multipart('admin',array('role'=>'form','id'=>'login')) ?>
                        <?php echo validation_errors('<div class="error" style="color: red;font-weight: 700;font-size:12px;">', '</div>'); ?>
                          <span style="color: red;font-weight: 700;font-size: 12px;"><?php echo $error_message;?></span>   
                        <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="UserName" name="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                
                                <div class="row">
                                
                                    <div class="col-md-6">
                                    	<a class="text-right forgot-password">Forgot Password ?</a>
                                    </div>
                                
                                </div>
                                <input type="submit" name="submit" value="submit" class="btn btn-success btn-block">
                                <!-- Change this to a button or input when using this as a form -->
                                
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      
    </div>
