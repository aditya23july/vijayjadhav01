                 
                    <div class="row">
                    	<div class="col-md-12 zero-margin">
                            <div class="row  page-head">
                                <div class="col-md-6 zero-margin left-padding">
                                    <h1 class="">Manage Field <span class="pull-right search-span"></h1>
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
                                        <th width="8%">Sr No <i class="fa fa-sort" aria-hidden="true"></i></th>
                                        <th width="18%">Field Title <i class="fa fa-sort" aria-hidden="true"></i></th>
                                        <th width="17%">Field Type<i class="fa fa-sort" aria-hidden="true"></i></th>
                                        <th width="15%">Status<i class="fa fa-sort" aria-hidden="true"></i></th>
                                      
                                        <th width="14%">Created Date <i class="fa fa-sort" aria-hidden="true"></i></th>
                                        <th width="14%">Action <i class="fa fa-sort" aria-hidden="true"></i></th>
                                        
                                    </tr>
                                    <?php
                                     $record=$this->db->query('select * from tbl_field_master')->result();
                                     $i=1;
                                     foreach($record as $row){
        
                                        
                                    ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo ucfirst($row->field_title); ?></td>
                                        <td>
                                            <?php 
                                                if($row->field_type=='TINYTEXT'){
                                                    echo 'TINY TEXT';
                                                }else if($row->field_type=='MEDIUMTEXT'){
                                                    echo 'MEDIUM TEXT';
                                                }
                                                else if($row->field_type=='LONGTEXT'){
                                                    echo 'LONG TEXT';
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo ucfirst($row->status); ?></td>
                                       <td><?php echo Date('d-M-Y H:i:s',strtotime($row->created_date)); ?></td>
                                        <td>
                                            <?php 
                                            $encrypted_string = $this->encrypt->encode($row->id);
                                            $find=array("+","-","/","=");
                                            $replace=array("__ADD__","__DASH__","__SLASH__","__EQUAL__");
                                            $encrypted_string=str_replace($find,$replace,$encrypted_string);
                                            ?>
                                            <a class="btn btn-primary" href="<?php echo base_url()?>index.php/managefield/update/<?php echo $encrypted_string?>">
                                            Edit
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