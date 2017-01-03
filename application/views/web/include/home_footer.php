<footer id="colophon" class="site-footer">
    <!--
            <div class="footer-newsletter">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom-widgets">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-7 col-md-push-5">

                            <div class="columns">
                                <aside id="nav_menu-3" class="widget clearfix widget_nav_menu">
                                    <div class="body">
                                        <h4 class="widget-title">Follow Us</h4>
                                        <div class="menu-footer-menu-2-container">
                                            <div class="footer-social-icons">
                                
                                                <div>
                                                    <ul class="social-icons list-unstyled">
                                                        <li class="face-footer">
                                                            <a class="fa fa-facebook" href="#"></a>
                                                        </li>
                                                        <li  class="twit-footer">
                                                            <a class="fa fa-twitter" href="#"></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                
                                                <div>
                                                    <ul class="social-icons list-unstyled">
                                                        <li class="link-footer">
                                                            <a class="fa fa-linkedin" href="#"></a>
                                                        </li>
                                                        <li class="google-footer">
                                                            <a class="fa fa-google-plus" href="#"></a>
                                                        </li>
                                                    </ul>
                                                    
                                                </div>
                                
                                            </div>
                                        </div>
                                    </div>
                                </aside>
                            </div>

                            <!-- /.columns -->
<!--
                            <div class="columns">
                                <aside id="nav_menu-2" class="widget clearfix widget_nav_menu">
                                    <div class="body">
                                        <h4 class="widget-title">Quick Find</h4>
                                        <div class="menu-footer-menu-1-container">
                                            <ul id="menu-footer-menu-1" class="menu">
                                                <li class="menu-item"><a href="index.html">Home</a></li>
                                                <li class="menu-item"><a href="contact.html">Contact Us</a></li>
                                                <li class="menu-item"><a href="about.html">About Us</a></li>
                                                <li class="menu-item"><a href="reseller-log-in.html">Enquiry For reseller Account</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </aside>
                            </div>
                            <!-- /.columns -->
<!--

                            <div class="columns">
                                <aside id="nav_menu-4" class="widget clearfix widget_nav_menu">
                                    <div class="body">
                                        <h4 class="widget-title">Customer Care</h4>
                                        <div class="menu-footer-menu-3-container">
                                            <ul id="menu-footer-menu-3" class="menu">
                                                <li class="menu-item"><a href="login.html">My Account</a></li>
                                                <li class="menu-item"><a href="login.html">Wishlist</a></li>
                                                <li class="menu-item"><a href="login.html">Returns</a></li>
                                                <li class="menu-item"><a href="bulk_order.html">Order in Bulk</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </aside>
                            </div>
                            <!-- /.columns -->
<!--
                        </div>
                        <!-- /.col -->
<!--
                        <div class="footer-contact col-xs-12 col-sm-12 col-md-5 col-md-pull-7">
                            <div class="footer-logo">
                                <a href="index.html" class="header-logo-link">
                                    <img src="<?php echo base_url() ?>asset/web/images/logo.png">
                                </a>
                            </div>
                            <!-- /.footer-contact -->
<!--
                            <div class="footer-call-us">
                                <div class="media">
                                    <span class="media-left call-us-icon media-middle"><i class="ec ec-support"></i></span>
                                    <div class="media-body">
                                        <span class="call-us-text">Got Questions ? Call us 24/7!</span>
                                        <span class="call-us-number">(800) 8001-8588, (0600) 874 548</span>
                                    </div>
                                </div>
                            </div>
                            <!-- /.footer-call-us -->
<!--
                            <div class="footer-address">
                                <strong class="footer-address-title">Contact Info</strong>
                                <address>17 Princess Road, London, Greater London NW1 8JR, UK</address>
                            </div>
                            <!-- /.footer-address -->
<!--
                            
                        </div>

                    </div>
                </div>
            </div>

            <div class="copyright-bar">
                <div class="container">
                    <div class="pull-left flip copyright">&copy; <a href="http://demo2.transvelo.in/html/electro/">Jm Techmind</a> - All Rights Reserved</div>
                    <div class="pull-right flip payment">
                        <div class="footer-payment-logo">
                            <ul class="cash-card card-inline">
                                <li class="card-item"><img src="images/footer/payment-icon/1.png" alt="" width="52"></li>
                                <li class="card-item"><img src="images/footer/payment-icon/2.png" alt="" width="52"></li>
                                <li class="card-item"><img src="images/footer/payment-icon/3.png" alt="" width="52"></li>
                                <li class="card-item"><img src="images/footer/payment-icon/4.png" alt="" width="52"></li>
                                <li class="card-item"><img src="images/footer/payment-icon/5.png" alt="" width="52"></li>
                            </ul>
                        </div>
                        <!-- /.payment-methods -->
  <!--                  </div>
                </div>
                <!-- /.container -->
 <!--           </div>
            <!-- /.copyright-bar -->
            <?php
                $contentrow=$this->db->query("select * from tbl_content_management where id=1")->row();
                echo $contentrow->data;
            ?>
 </footer>

</body>

