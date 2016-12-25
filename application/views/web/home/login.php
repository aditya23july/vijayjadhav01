     <script src="<?php echo base_url() ?>asset/admin/js/jquery-2.1.1.min.js"></script>
  <script src="<?php echo base_url() ?>asset/admin/js/jquery.validate.js"></script>
 <script>
$(document).ready(function(){
    $("#login").validate({
        errorClass: "alert alert-warning",
            rules: {
             username: {
                required: true,
				minlength:1,
				maxlength:80
              },
             password: {
                required: true,
				minlength:4,
				maxlength:10
                }
               
            },
            messages: {
             username: {
                required: "UserName is missing."
              },
             password: {
                required: "Password is missing."

              }
          }
      });

});
</script>

<div id="content" class="site-content" tabindex="-1">
    <div class="container">

        <nav class="woocommerce-breadcrumb" >
            <a href="index.html">Home</a>
            <span class="delimiter"><i class="fa fa-angle-right"></i></span><a href="my_account.html">
            My Account</a>
        </nav><!-- .woocommerce-breadcrumb -->

        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <article id="post-8" class="hentry">

                    <div class="entry-content">
                        <div class="woocommerce">
                            <div class="customer-login-form">
                                <!-- <span class="or-text">or</span> -->


                                <div class="col-sm-3 sidelinks">
                                     <?php $this->load->view('web/home/sidelink',array('param'=>$param));?>
                                </div>

                                <div class="col-1 col-sm-5 login">


                                    <h2>Login</h2>

                                   <?php echo form_open('web/login/'.$param,array('role'=>'form','id'=>'login')) ?>
									
                                        <p class="before-login-text">
                                            Welcome! Sign in to your Account
                                        </p>
										<?php echo validation_errors('<div class="error" style="color: red;font-weight: 700;font-size:12px;">', '</div>'); ?>
                                        <p class="form-row form-row-wide">
                                            <label for="username">Username or email address
                                                <span class="required">*</span></label>
                                                <input type="text" class="input-text" name="username" id="username" value="" />
                                            </p>

                                            <p class="form-row form-row-wide">
                                                <label for="password">Password
                                                    <span class="required">*</span></label>
                                                    <input class="input-text" type="password" name="password" id="password" />
                                                </p>


                                                <p class="form-row">

                                                    <a href="login-and-register.html">Forgot password?</a>
                                                </p>
                                                <p style="float:right";>
												<input class="button" type="submit" value="Login" name="login"></p>

                                                <p class="">
                                                    New to Best Buy   <a href="<?php echo base_url()?>index.php/web/register/<?php echo $param?>">Register to continue</a>
                                                </p>

                                            </form>


                                        </div><!-- .col-1 -->
                                        <span class="or-text-2">OR</span>
                                        <div class="col2-set" id="customer_login2">

                                            <div class="col-sm-3">
                                                <label class="texttocenter">Login With</label>
                                                <div class="logsoc">

                                                    <img src="images/facebook.png"><br>
                                                    <p>OR</p>
                                                    <img src="images/google.png">
                                                </div>
                                            </div>

<!-- <div class="col-2">

<h2>Register</h2>

<form method="post" class="register">

<p class="before-register-text">
Create your very own account
</p>


<p class="form-row form-row-wide">
<label for="reg_email">Email address
<span class="required">*</span></label>
<input type="email" class="input-text" name="email" id="reg_email" value="" />
</p>


<p class="form-row">
<input type="submit" class="button" name="register" value="Register" />
</p>

<div class="register-benefits">
<h3>Sign up today and you will be able to :</h3>
<ul>
<li>Speed your way through checkout</li>
<li>Track your orders easily</li>
<li>Keep a record of all your purchases</li>
</ul>
</div>

</form>

</div><!-- .col-2 -->

</div><!-- .col2-set -->

</div><!-- /.customer-login-form -->
</div><!-- .woocommerce -->
</div><!-- .entry-content -->

</article><!-- #post-## -->

</main><!-- #main -->
</div><!-- #primary -->


</div><!-- .col-full -->
</div><!-- #content -->
<br/>
<br//>