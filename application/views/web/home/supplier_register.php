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

		company_address: {

                required: true,

				minlength:15,

				maxlength:250

                }

				, 

		company_name: {

                required: true,

				minlength:2,

				maxlength:100

                }, 
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
		company_person: {

                            required: true,

				minlength:2,

				maxlength:50

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

              company_address: {

                required: "Address is missing."



              },

              company_name: {

                required: "Company Name is missing."



              },

              company_person: {

                required: "Contact Person is missing."



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



              }
        }

      });



});

</script>
<div id="content" class="site-content" tabindex="-1">
    <div class="container">


        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <article id="post-8" class="hentry">

                    <div class="entry-content">
                        <div class="woocommerce">
                            <div class="customer-login-form">

                                <div class="col-sm-6 sidelinks2">
                                    <h2>Welcome to Reseller Account</h2>
                                    <img src="<?php echo base_url() ?>asset/web/images/Reseller.png" class="img-responsive">
                                    <h5>Let's grow your business - Together</h5>
                                    <p class="reseller-info">With us, you can reach every product in the country who buys online.
                                        With us, you can reach every product in the country who buys online.<br>
                                        With us, you can reach every product in the country who buys online.
                                        With us, you can reach every product in the country who buys online.<br>
                                        With us, you can reach every product in the country who buys online.With us, you can reach every product in the country who buys online.With us, you can reach every product in the country who buys online.
                                    </p><br>
                                    <div>
                                        <p>Terms & Conditions</p>
                                    </div>
                                </div>

                                <div class="col-2 reseller col-sm-6">

                                    <h2>Reseller Enquiry Form</h2>
                                    <?php 
                                    if($msg==null){
                                    ?>
                                    <?php echo form_open_multipart('web/registersupplier',array('role'=>'form','id'=>'register')) ?>
                                    <?php echo validation_errors('<div class="error" style="color: red;font-weight: 700;font-size:12px;">', '</div>'); ?>

                                        <p class="before-register-text">
                                            Register your own account
                                        </p>
                                        <p class="form-row form-row-wide">
                                            <label for="reg_email">Full Name
                                                <span class="required">*</span></label>
                                            <input type="text" class="input-text" name="name" id="name" value="" />
                                        </p>

                                        <p class="form-row form-row-wide">
                                            <label for="reg_email">Email address
                                                <span class="required">*</span></label>
                                            <input type="email" class="input-text" name="email" id="reg_email" value="" />
                                        </p>

                                        <p class="form-row form-row-wide">
                                            <label for="reg_email">Mobile Number
                                                <span class="required">*</span></label>
                                            <input type="text" class="input-text" name="mobile" id="mobile" value="" />
                                        </p>
                                        <p class="form-row form-row-wide">
                                            <label for="reg_email">Company Name
                                                <span class="required">*</span></label>
                                            <input type="text" class="input-text" name="company_name" id="company_name" value="" />
                                        </p>

                                        <p class="form-row form-row-wide">
                                            <label for="reg_email">Company Address
                                                <span class="required">*</span></label>
                                            <textarea name="company_address" id="company_address" cols="40" rows="10" class="wpcf7-form-control input-text wpcf7-textarea" aria-invalid="false"></textarea>
                                        </p>
                                        <p class="form-row form-row-wide">
                                            <label for="reg_email">Contact Person Name
                                                <span class="required">*</span></label>
                                            <input type="text" name="company_person" id="company_person" class="input-text" name="email" id="reg_city" value="" />
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
                                        <p class="form-row">
                                            <input type="submit" class="button" name="register" value="Register" />
                                        </p>


                                    </form>
                                    <?php 
                                    }else{
                                        ?>
                                    <div class="alert alert-success">
                                           <h4><?php echo $msg ?></h4>
                                        </div>
                                    <?php
                                    }
                                    ?>
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