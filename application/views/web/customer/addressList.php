<?php

$userid =   $this->session->userdata('user_id');
$cartresult= $this->db->query("select * from tbl_customer_address_master where user_id='$userid' and status='ACTIVE' ")->result();
?>

<div id="content" class="site-content" tabindex="-1" style="padding-bottom:50px">

    <div class="container">



        <nav class="woocommerce-breadcrumb" >

            <a href="index.html">Home</a>

            <span class="delimiter"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
            <a href="<?php echo base_url()?>index.php/customer">My Account</a> <span class="delimiter"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span><a href="my_order.html"> My Address Book List </a>

        </nav><!-- .woocommerce-breadcrumb -->
        <div class="myorder">
            <div class="tab-content">

                <div id="home" class="tab-pane fade in active">

                    <div class="body-data">

                        <h4>Address Book List</h4>

                       

                        <table style="border-left: 1px solid #ccc;">

                            <tr class="headings">
                                <th>Sno</th>
                                <th>Name</th>
                                <th>Address</th>
                                
                                <th>Pincode</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            $i=1;
                             foreach($cartresult as $cartrecord){
                            ?>
                            <tr class="headings">
                                <th><?php echo $i++ ?></th>
                                <th><?php echo $cartrecord->customer_name ?></th>
                                <th><?php 
                                echo $cartrecord->address."<br/>". $cartrecord->city.",<br/>".$cartrecord->state.",<br/>".$cartrecord->country.",<br/>".$cartrecord->pincode;
                                        ?>
                                </th>
                                <th><?php echo $cartrecord->pincode ?></th>
                                <th>
                                    <?php echo $cartrecord->email ?>
                                </th>
                                <th>
                                    <?php echo $cartrecord->mobile ?>
                                </th>
                                <th><?php
                                    $encrypted_string = $this->encrypt->encode($cartrecord->id);
                                    $find = array("+", "-", "/", "=");
                                    $replace = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
                                    $encrypted_string = str_replace($find, $replace, $encrypted_string);
                                    ?>
                                    <a href="<?php echo base_url() . 'index.php/customer/removeCustomerAddress/' . $encrypted_string?>" class="btn btn-default">Remove Address</a>
                                </th>
                            </tr>
                            <?php
                             }
                            ?>
                           

                        </table>


                    </div><!-- class-body -->

                </div>

            

            </div>

        </div>



    </div><!-- container -->

</div><!-- Content -->

