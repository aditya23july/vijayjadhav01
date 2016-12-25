<?php

$userid =   $this->session->userdata('user_id');
$cartresult= $this->db->query("select * from tbl_cart_master where user_id='$userid' and order_id is not null")->result();
?>

<div id="content" class="site-content" tabindex="-1" style="padding-bottom:50px">

    <div class="container">



        <nav class="woocommerce-breadcrumb" >

            <a href="index.html">Home</a>

            <span class="delimiter"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
            <a href="<?php echo base_url()?>index.php/customer">My Account</a> <span class="delimiter"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span><a href="my_order.html"> My Order List </a>

        </nav><!-- .woocommerce-breadcrumb -->
        <div class="myorder">
            <div class="tab-content">

                <div id="home" class="tab-pane fade in active">

                    <div class="body-data">

                        <h4>Order List</h4>

                       

                        <table style="border-left: 1px solid #ccc;">

                            <tr class="headings">
                                <th>Sno</th>
                                <th>Order Id</th>
                                <th>Order Date</th>
                                <th>Status</th>
                                <th>Shipping Status</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            $i=1;
                             foreach($cartresult as $cartrecord){
                            ?>
                            <tr class="headings">
                                <th><?php echo $i++ ?></th>
                                <th><?php echo $cartrecord->order_id ?></th>
                                <th><?php echo Date('d-M-Y H:i:s',strtotime($cartrecord->order_date)); ?></th>
                                 <th>
                                <?php 
                                    if(strlen($cartrecord->order_status)<=0){
                                        echo 'Pending';
                                    }else{
                                       echo $cartrecord->order_status; 
                                    }
                                ?>
                                </th>
                                <th>
                                <?php 
                                    if($cartrecord->shipping_status=='O'){
                                        echo 'Out For Delivery';
                                    }else if($cartrecord->shipping_status=='D'){
                                        echo 'Delievered';
                                    }else{
                                        echo 'Pending';
                                    }
                                ?>
                                </th>
                                <th>
                                     <?php 
                                        $total_amount=$cartrecord->total_cost;
                                        $taxresult = $this->db->query("SELECT * FROM `tbl_cart_tax_map` where cart_id='$cartrecord->cart_id'  ")->result();
                                        foreach($taxresult as $taxrecord){
                                        $total_amount=($total_amount*$taxrecord->tax_value)/100+$total_amount;
                                        }
                                        $shippingrecord = $this->db->query("select * from tbl_shipping_rule_master where currency_id=1")->row();
                                        if(isset($shippingrecord->min_value)){
                                            if($cartrecord->total_cost>$shippingrecord->min_value){
                                                
                                            }else{
                                                $total_amount=$total_amount+$shippingrecord->shipping_charge;
                                                
                                            }
                                        }
                                       echo round($total_amount,2);
                                       ?>
                                </th>
                                <th>
                                    <?php
                                    $encrypted_string = $this->encrypt->encode($cartrecord->cart_id);
                                    $find = array("+", "-", "/", "=");
                                    $replace = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
                                    $encrypted_string = str_replace($find, $replace, $encrypted_string);
                                    ?>
                                    <a href="<?php echo base_url() . 'index.php/customer/viewOrder/' . $encrypted_string?>" class="btn btn-default">View Order</a>
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

