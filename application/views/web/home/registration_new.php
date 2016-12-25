   <script src="<?php echo base_url() ?>asset/admin/js/jquery-2.1.1.min.js"></script>
  <script src="<?php echo base_url() ?>asset/admin/js/jquery.validate.js"></script>
 <script>
$(document).ready(function(){
    $("#register").validate({
        errorClass: "alert alert-warning",
            rules: {
              name: {
                required: true,
				minlength:1,
				maxlength:80
              },
               email: {
                required: true,
				minlength:5,
				maxlength:80
                }
				,
               mobile: {
                required: true,
				minlength:4,
				maxlength:15
                }, 
			address: {
                required: true,
				minlength:15,
				maxlength:250
                }
				, 
			city: {
                required: true,
				minlength:2,
				maxlength:20
                }, 
			state: {
                required: true,
				minlength:2,
				maxlength:20
                }, 
			country: {
                required: true,
				minlength:2,
				maxlength:15
                }, 
			pincode: {
                required: true,
				minlength:4,
				maxlength:10
                }, 
			password: {
                required: true,
				minlength:4,
				maxlength:10
                }
               
            },
            messages: {
             name: {
                required: "Name is missing."
              },
              email: {
                required: "Email is missing."

              },
              mobile: {
                required: "Mobile No is missing."

              }
			  ,
              address: {
                required: "Address is missing."

              },
              city: {
                required: "City is missing."

              },
              state: {
                required: "State is missing."

              },
              country: {
                required: "Country is missing."

              },
              pincode: {
                required: "Pincode is missing."

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
            <a href="home.html">Home</a>
            <span class="delimiter"><i class="fa fa-angle-right"></i></span><a href="my_account.html">
            My Account</a> <span class="delimiter"><i class="fa fa-angle-right"></i></span><a href="register.html">Register</a>
        </nav><!-- .woocommerce-breadcrumb -->

        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <article id="post-8" class="hentry">

                    <div class="entry-content">
                        <div class="woocommerce">
                                <div class="col-sm-3 sidelinks">
                                  <?php $this->load->view('web/home/sidelink',array('param'=>$param));?>
                                </div>

    <div class="col-2 register col-sm-9 reg">

      <h2>Register</h2>
		 <?php echo form_open_multipart('web/register/'.$param,array('role'=>'form','id'=>'register')) ?>
       <?php echo validation_errors('<div class="error" style="color: red;font-weight: 700;font-size:12px;">', '</div>'); ?>
        <p class="form-row form-row-wide">
            <label for="reg_email">Full Name
                <span class="required">*</span></label>
                <input type="text" class="input-text" name="name" id="name" value="" />
            </p>

            <p class="form-row form-row-wide">
                <label for="reg_email">Email address
                    <span class="required">*</span></label>
                    <input type="email" class="input-text" name="email" id="email" value="" />
                </p>

                <p class="form-row form-row-wide">
                    <label for="reg_email">Mobile Number
                        <span class="required">*</span></label>
                        <input type="text" class="input-text" name="mobile" id="mobile" value="" />
                    </p>
                    <p class="form-row form-row-wide">
                        <label for="reg_email">Address
                            <span class="required">*</span></label>
                            <textarea name="address" cols="40" rows="10" id="address" class="wpcf7-form-control input-text wpcf7-textarea" aria-invalid="false"></textarea>
                        </p>
                        <p class="form-row form-row-wide">
                            <label for="reg_email">Country
                                <span class="required">*</span></label>
                                <input type="text" class="input-text" name="country" id="country" value="" />
                            </p>
                            <p class="form-row form-row-wide">
                                <label for="reg_email">State
                                    <span class="required">*</span></label>
                                    <input type="text" class="input-text" name="state" id="state" value="" />
                                </p>
                                <p class="form-row form-row-wide">
                                    <label for="reg_email">City
                                        <span class="required">*</span></label>
                                        <input type="text" class="input-text" name="city" id="city" value="" />
                                    </p>
                                    <p class="form-row form-row-wide">
                                        <label for="reg_email">Pincode
                                            <span class="required">*</span></label>
                                            <input type="text" class="input-text" name="pincode" id="pinocde" value="" />
                                        </p>
                                        <p class="form-row form-row-wide">
                                            <label for="reg_email">Password
                                                <span class="required">*</span></label>
                                                <input type="password" class="input-text" name="password" id="passowrd" value="" />
                                            </p>
                                         
                                                
                                             </p>
                                             <p class="form-row">
                                                <input type="submit" class="button" name="register" value="Register" />
                                            </p>

		<!-- 	<div class="register-benefits">
				<h3>Sign up today and you will be able to :</h3>
				<ul>
					<li>Speed your way through checkout</li>
					<li>Track your orders easily</li>
					<li>Keep a record of all your purchases</li>
				</ul>
			</div> -->

		</form>

	</div><!-- .col-2
--><!-- 
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
<br/>