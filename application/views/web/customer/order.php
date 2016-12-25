<?php

$cart_id = $id;
$cart_record = $this->db->query("select * from tbl_cart_master where cart_id='$id'")->row();
?>

<div id="content" class="site-content" tabindex="-1" style="padding-bottom:50px">

    <div class="container">



       <nav class="woocommerce-breadcrumb" >

            <a href="index.html">Home</a>

            <span class="delimiter"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
            <a href="<?php echo base_url()?>index.php/customer">My Account</a> 
            <span class="delimiter">
                <i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
            <a href="<?php echo base_url() ?>index.php/customer/viewOrderList"> My Order List </a>

        </nav><!-- .woocommerce-breadcrumb -->
        


        <div class="myorder">
             <div class="tab-content">

                <div id="home" class="tab-pane fade in active">

                    <div class="body-data">

                        <h4>Your  order</h4>

                        <p>Date - <?php echo Date('d-M-Y', strtotime($cart_record->order_date)) ?></p>

                        <p> Order no - <?php echo $cart_record->order_id ?></p>

                        <p>Payment Option- <?php echo $cart_record->payment_type ?></p>

                        <table style="border-left: 1px solid #ccc;">

                            <tr class="headings">

                                <th>Product Name</th>

                                <th>Quantity</th>



                                <th>Total Price</th>



                            </tr>

                            <?php
                            $productresult = $this->db->query("select ci.*,pm.product_name from tbl_cart_item ci inner join tbl_product_master pm on ci.item_id=pm.id where ci.cart_id='$cart_id' ")->result();

                            foreach ($productresult as $productrecord) {
                                ?>

                                <tr class="detail">

                                    <td>

                                        <?php echo $productrecord->product_name; ?>

                                        <?php
                                        $productimagerow = $this->db->query("SELECT * FROM tbl_product_image_map where product_id='$productrecord->item_id' and image_type='THUMBNAIL' order by id desc limit 0,1")->row();

                                        if (isset($productimagerow->image_name)) {
                                            ?>

                                            <img src="<?php echo base_url() ?>upload/<?php echo $productimagerow->image_name ?>" class="img-responsive">

                                            <?php
                                        } else {
                                            ?>

                                            <img src="<?php echo base_url() ?>asset/web/images/no_product.png" class="img-responsive">

                                            <?php
                                        }
                                        ?>



                                    </td>

                                    <td>

                                        <?php echo $productrecord->qty ?>

                                    </td>



                                    <td >

                                        <?php echo $productrecord->total_price ?>





                                    </td>



                                </tr>

                                <?php
                            }
                            ?>

                        </table>

                        <div class="col-md-6">
                            <?php
                            $customeraddressrow = $this->db->query("select * from tbl_customer_address_master where id='$cart_record->billing_address_id'")->row();
                            ?>
                            <table style="border: 1px solid #ccc;">

                                <th>Shipping address</th>
                                <tr>

                                    <td class="sum"><?php echo $customeraddressrow->customer_name ?>, </td>

                                </tr>
                                <tr>

                                    <td class="sum"><?php echo $customeraddressrow->address ?>, </td>

                                </tr>

                                <tr>

                                    <td><?php echo $customeraddressrow->city ?>
                                        , <?php echo $customeraddressrow->state ?></td></tr>

                                <tr>

                                    <td> <?php echo $customeraddressrow->country ?>, <?php echo $customeraddressrow->pincode ?></td>

                                </tr>

                            </table>

                        </div><!-- col-md-6 -->

                        <div class="col-md-6">

                            <table style="border: 1px solid #ccc;">

                                <tr>

                                    <td class="sum">COD Charges</td>

                                    <td><?php echo $cart_record->total_cost ?></td>

                                </tr>
                                <?php
                                $total_amount = $cart_record->total_cost;
                                $taxresult = $this->db->query("SELECT * FROM `tbl_cart_tax_map` where cart_id='$cart_record->cart_id' ")->result();
                                foreach ($taxresult as $taxrecord) {
                                    $total_amount = ($total_amount * $taxrecord->tax_value) / 100 + $total_amount;
                                    ?>
                                    <tr>
                                        <td class="sum"><?php echo $taxrecord->tax_title ?></td>
                                        <td><?php echo $taxrecord->tax_value ?>%</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>

                                    <td class="sum">Shipping Charges</td>

                                    <td>
                                        <?php
                                        $shippingrecord = $this->db->query("select * from tbl_shipping_rule_master where currency_id=1")->row();
                                        if (isset($shippingrecord->min_value)) {
                                            if ($cart_record->total_cost > $shippingrecord->min_value) {
                                                echo 'NA';
                                            } else {
                                                $total_amount = $total_amount + $shippingrecord->shipping_charge;
                                                echo $shippingrecord->shipping_charge;
                                            }
                                        }
                                        ?>
                                    </td>

                                </tr>

                                <tr>

                                    <td class="sum">Total Amount</td>

                                    <td><?php echo round($total_amount, 2) ?></td>

                                </tr>

                            </table>

                        </div><!-- col-md-6 -->

                    </div><!-- class-body -->

                </div>

                <div id="menu1" class="tab-pane fade">

                    <div class="body-data">

                        <h4>Open orders</h4>

                        <div class="col-md-6">

                            <img src="images/products/4.jpg" class="img-responsive">

                        </div>

                        <div class="col-md-6">

                            <p>Asus Zphone</p>

                            <p>Date-12th Oct 2016</p>

                            <p>Price-8999</p>

                            <p>Product Description</p>

                        </div>

                    </div><!-- class-body -->

                </div>

                <div id="menu2" class="tab-pane fade">

                    <div class="body-data">

                        <h4>Open orders</h4>

                        <div class="col-md-6">

                            <img src="images/products/4.jpg" class="img-responsive">

                        </div>

                        <div class="col-md-6">

                            <p>Asus Zphone</p>

                            <p>Date-12th Oct 2016</p>

                            <p>Price-8999</p>

                            <p>Product Description</p>

                        </div>

                    </div><!-- class-body -->

                </div>

                <div id="menu3" class="tab-pane fade">

                    <div class="body-data">

                        <h4>Open orders</h4>

                        <div class="col-md-6">

                            <img src="images/products/4.jpg" class="img-responsive">

                        </div>

                        <div class="col-md-6">

                            <p>Asus Zphone</p>

                            <p>Date-12th Oct 2016</p>

                            <p>Price-8999</p>

                            <p>Product Description</p>

                        </div>

                    </div><!-- class-body -->

                </div>

            </div>

        </div>



    </div><!-- container -->

</div><!-- Content -->

