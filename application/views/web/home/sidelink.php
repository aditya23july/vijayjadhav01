 <p><a href="<?php echo base_url()?>index.php/web/login/<?php echo $param?>"><i class="fa fa-sign-in" aria-hidden="true"></i>
Login</a></p>
                                    <p><a href="<?php echo base_url()?>index.php/web/forgetpassword/<?php echo $param?>"><i class="fa fa-key" aria-hidden="true"></i>
Forgot Password</a></p>
                                    <p><a href="<?php echo base_url()?>index.php/web/register/<?php echo $param?>"><i class="fa fa-user-plus" aria-hidden="true"></i>
Register</a></p>
									<?php 
										if($this->session->userdata('user_id')){
									?>
                                    <p><a href="my_account.html"><i class="fa fa-user" aria-hidden="true"></i>
My Account</a></p>
                                    <p><a href="wishlist.html"><i class="fa fa-heart" aria-hidden="true"></i>
Wish List</a></p>
                                    <p><a href="my_order.html"><i class="fa fa-sort" aria-hidden="true"></i>
Order</a></p>
                                    <p class="rturn"><a href="returns.html"><i class="fa fa-undo" aria-hidden="true"></i>
Returns</a></p>
									<?php
										}
										?>