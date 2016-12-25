                 
                    <div class="row">
                    	<div class="col-md-12 zero-margin">
                            <div class="row  page-head">
                                <div class="col-md-6 zero-margin left-padding">
                                    <h1 class="">Manage Order <span class="pull-right search-span"></h1>
                                </div>
                                <div class="col-md-3 zero-margin">
                                	<div class="row margin-p-row">
                                    
                                    	<div class="col-md-5 text-right right-padding zero-margin">
                                            <p><strong>Search</strong></p>
                                        </div>
                                       
                                    
                                    
                                    </div>
                                </div>
                                <div class="col-md-3 zero-margin right-padding">
                                    <input type="text" class="form-control searchbox search-exel">
                                   
                                </div>
                                <!-- /.col-lg-12 -->
                            </div>
                            <!-- /.row -->
						</div>
                  </div>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="table-responsive">

                                <table class="table table-bordered" id ="table">
                                    <tr class="bg-gray">
                                        <th width="8%">Sr No</th>
                                        <th width="18%">Order Id</th>
                                        <th width="17%">Customer Name</th>
                                        <th width="17%">Status</th>
                                        <th width="12%">Total Item</th>
                                        <th width="12%">Total Cost</th>
                                        <th width="14%">Order Date</th>
                                        <th width="14%">Action </th>
                                        
                                    </tr>
                                    <?php
                                    if($userid == null){
                                        $record=$this->db->query('select * from tbl_cart_master where order_id is not null order by cart_id desc')->result();
                                    }else{
                                        $replace=array("+","-","/","=");
                                        $find=array("__ADD__","__DASH__","__SLASH__","__EQUAL__");
                                        $encrypted_string=str_replace($find,$replace,$userid);
                                        $userid = (int)$this->encrypt->decode($encrypted_string);
                                         $record=$this->db->query("select * from tbl_cart_master where order_id is not null and user_id ='$userid' order by cart_id desc")->result();
                                    }
                                     
                                     $i=1;
                                     foreach($record as $row){
        
                                        
                                    ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo ucfirst($row->order_id); ?></td>
                                        <td>
                                            <?php 
                                                $customerrecord=$this->db->query("select customer_name from tbl_customer_address_master where user_id='$row->user_id'")->row();
                                                echo ucfirst($customerrecord->customer_name)
                                            ?>
                                        </td>
                                        <td> 
                                            <?php 
                                                if($row->order_status==null){
                                                    echo 'PENDING';
                                                }else{
                                                    echo $row->order_status;
                                                }
                                            ?>
                                            
                                        </td>
                                       <td><?php echo ucfirst($row->total_item); ?></td>
                                       <td>
                                           <?php 
                                        $total_amount=$row->total_cost;
                                        $taxresult = $this->db->query("SELECT * FROM `tbl_cart_tax_map` where cart_id='$row->cart_id'  ")->result();
                                        foreach($taxresult as $taxrecord){
                                        $total_amount=($total_amount*$taxrecord->tax_value)/100+$total_amount;
                                        }
                                        $shippingrecord = $this->db->query("select * from tbl_shipping_rule_master where currency_id=1")->row();
                                        if(isset($shippingrecord->min_value)){
                                            if($row->total_cost>$shippingrecord->min_value){
                                                
                                            }else{
                                                $total_amount=$total_amount+$shippingrecord->shipping_charge;
                                                
                                            }
                                        }
                                       echo round($total_amount,2);
                                       ?></td>
                                       <td><?php echo Date('d-M-Y H:i:s',strtotime($row->order_date)); ?></td>
                                        <td>
                                            <?php 
                                            $encrypted_string = $this->encrypt->encode($row->cart_id);
                                            $find=array("+","-","/","=");
                                            $replace=array("__ADD__","__DASH__","__SLASH__","__EQUAL__");
                                            $encrypted_string=str_replace($find,$replace,$encrypted_string);
                                            ?>
                                            <a class="btn btn-primary" href="<?php echo base_url()?>index.php/manageorder/view/<?php echo $encrypted_string?>">
                                            View Order
                                            </a>
                                        </td>
                                       
                                    </tr>
                                    <?php
                                        $i++;
                                     }
                                     ?>
                                </table>
                            </div>

                        </div>
                    </div>