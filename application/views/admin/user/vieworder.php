                 
                    <div class="row">
                    	<div class="col-md-12 zero-margin">
                            <div class="row  page-head">
                                <div class="col-md-6 zero-margin left-padding">
                                    <h1 class="">Manage Order<span class="pull-right search-span"></h1>
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
                                        <th width="18%">Order ID</th>
                                        <th width="17%">Total Item</th>
                                        <th width="12%">Total Cost</th>
                                        <th width="14%">Order Date</th>
                                        <th width="14%">Action </th>
                                        
                                    </tr>
                                    <?php
                                     $record=$this->db->query('select * from tbl_cart_master where user_id='.$id.'')->result();
                                     $i=1;
                                     foreach($record as $row){
        
                                        
                                    ?>
                                            <?php 
                                            $encrypted_string = $this->encrypt->encode($row->order_id);
                                            $find=array("+","-","/","=");
                                            $replace=array("__ADD__","__DASH__","__SLASH__","__EQUAL__");
                                            $encrypted_string=str_replace($find,$replace,$encrypted_string);
                                            ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
<td><?php echo ucfirst($row->order_id); ?></td>
                                        <td><?php echo ucfirst($row->total_item); ?></td>

                                        <td> 
                                            <?php 
                                              
                                                echo ucfirst($row->total_cost)
                                            ?>
                                            
                                        </td>

                                       <td><?php echo Date('d-M-Y H:i:s',strtotime($row->created_date)); ?></td>
                                        <td>


                                            <a class="btn btn-primary" href="<?php echo base_url()?>index.php/manageuser/vieworders/<?php echo $encrypted_string?>">
                                            View
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