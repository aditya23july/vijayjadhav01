<?php
$userid=$this->session->userdata('user_id');
$customerrow = $this->db->query("select * from tbl_user_master where id='$userid'")->row();
?>
<div id="content" class="site-content" tabindex="-1" style="margin-top:0px">

    <div class="container">



        <nav class="woocommerce-breadcrumb" >

            <a href="index.html">Home</a>

            <span class="delimiter"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>

            <a href="my_account.html"> My Account </a>

        </nav><!-- .woocommerce-breadcrumb -->



        <div id="primary" class="content-area">

            <main id="main" class="site-main">

                <article id="post-8" class="hentry">



                    <div class="entry-content">

                        <div class="woocommerce">

                            <div class="customer-wishlist">

                                <h2>My Account</h2>
                                <?php 
                                 $this->load->view('web/customer/side-page');
                                ?>
                              <div class="tab-content tabpro">

                                    <div id="home" class="tab-pane fade in active">

                                      <h3>My Profile</h3>

                                      <p><label>Name-</label> <?php echo $customerrow->name ?></p>

                                      <p><label>Email-</label>   <?php echo $customerrow->email ?></p>
                                      <p><label>Address-</label>  <?php 
                                      echo $customerrow->address1 
                                              ?></p>
                                       <p><label>City-</label>  <?php 
                                      echo $customerrow->city 
                                              ?></p>
                                        <p><label>State-</label>  <?php 
                                      echo $customerrow->state 
                                              ?></p>
                                        <p><label>Country-</label>  <?php 
                                      echo $customerrow->country 
                                              ?></p>
                                         <p><label>Pincode-</label>  <?php 
                                      echo $customerrow->pincode 
                                              ?></p>
                                      <p><label> Mobile No</label> <?php 
                                      echo $customerrow->mobile1 
                                              ?></p>

                                    </div>
                                 </div>



                                </div><!-- .col2-set -->



                            </div><!-- /.customer-login-form -->

                        </div><!-- .woocommerce -->

                    </article><!-- #post-## -->



                </main><!-- #main -->

            </div><!-- #primary -->

 

     </div><!-- .entry-content -->





</div><!-- .col-full -->