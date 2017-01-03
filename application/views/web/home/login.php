     <meta name="google-signin-client_id" content="883416317442-qkvcmogbvhdjbl418abkkasoo8deee8q.apps.googleusercontent.com">
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
function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
 // console.log('Name: ' + profile.getName());
  //console.log('Image URL: ' + profile.getImageUrl());
  //console.log('Email: ' + profile.getEmail());
  //var id_token = googleUser.getAuthResponse().id_token;
     //   console.log("ID Token: " + id_token);
		sendData(profile,'GOOGLE');
}

</script>
<script src="https://apis.google.com/js/platform.js" async defer></script>

<div id="fb-root"></div>
<script>

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.8&appId=614547435399258";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
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
                                                <div class="logsoc" style="top:0px">

                                                  <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
<a class="waves-effect waves-light btn btn-block facebook"><i class="fa fa-facebook-official left" aria-hidden="true" ></i>Sign in with Facebook</a>
	</fb:login-button><br>
                                                    <script>
	  
// This is called with the results from from FB.getLoginStatus().
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
	} else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
		getaccesstoken(response);
      statusChangeCallback(response);
    });
  }
function getaccesstoken(response){;
var accesstoken=response.authResponse.accessToken;
}
  window.fbAsyncInit = function() {
  FB.init({
    appId      : '614547435399258',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.7' // use graph api version 2.5
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
 
    
    FB.api('/me', { locale: 'en_US', fields: 'name, email,id' }, function(response) {
		
		sendData(response,'FACEBOOK');
	});
	
  }
  function sendData(response,type){

		
		$.post("<?php echo base_url() ?>index.php/web/socialLogin",{response:response,type:type},
				function(data){
					if(data=='SUCCESS'){
					window.location.href = "<?php echo base_url()?>index.php/customer/index";
					}else{
					alert('error');
					}
				});
  }
</script>
													<p>OR</p>
                                                    <div class="g-signin2" data-onsuccess="onSignIn"></div>

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