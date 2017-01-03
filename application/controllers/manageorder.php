<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of manageuser
 *
 * @author HOME
 */
class ManageOrder extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('encrypt');
        $this->load->library('session');
      
    }

    public function _remap($method, $param = array()) {
        if ($this->session->userdata('id')) {
            switch ($method) {

                case "index" :  if(isset($param[0])){
                                    $this->viewIndex($param[0]);
                                }else{
                                    $this->viewIndex();
                                }
                                break;
                case "shipping" :  if(isset($param[0])){
                                    $this->shippingDetail($param[0]);
                                }else{
                                    $this->viewIndex();
                                }
                                break;
                case "view" : if(isset($param[0])){
                                $this->getOrderDetailView($param[0]);
                }else{
                    redirect(base_url());
                }
                    break;
                
               
                default : $this->error();
                    break;
            }
        } else {
            redirect('admin');
        }
    }
    private function shippingDetail($id){
            $replace = array("+", "-", "/", "=");
            $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
            $encrypted_string = str_replace($find, $replace, $id);
            $id = (int) $this->encrypt->decode($encrypted_string);
           
            
            if(isset($_POST['shipping_submit'])){
                 $this->form_validation->set_rules('shipping_status', 'Shipping Status', 'required');
                if($this->input->post('shipping_status')=='O'){
               
                $this->form_validation->set_rules('cc_name', 'Courier Company Name', 'required');
                $this->form_validation->set_rules('awb', 'AWB nO', 'required');
                }
                if ($this->form_validation->run() == TRUE){
                        $shipping_status        =   $this->security->xss_clean($this->input->post('shipping_status'));
                        $cc_name                =   $this->security->xss_clean($this->input->post('cc_name'));
                        $awb                    =   $this->security->xss_clean($this->input->post('awb'));
                        if($this->input->post('shipping_status')=='D'){
                            $data = array(
                                    'shipping_status' => $shipping_status,
                                    'updated_date' => Date('Y-m-d H:i:s')
                                    
                                );
                        }else{
                        $data = array(
                                    'shipping_status' => $shipping_status,
                                    'cc_name' => $cc_name,
                                    'awb_no' => $awb,
                                    'updated_date' => Date('Y-m-d H:i:s')
                                    
                                );
                        }
                        $this->db->where('cart_id', $id);
                        $this->db->update('tbl_cart_master', $data);
                        $encrypted_string = $this->encrypt->encode($id);
                        $find=array("+","-","/","=");
                        $replace=array("__ADD__","__DASH__","__SLASH__","__EQUAL__");
                        $encrypted_string=str_replace($find,$replace,$encrypted_string);
                        redirect(base_url()."index.php/manageorder/view/".$encrypted_string);
                }
            }
            $this->load->view('admin/include/header');
            $this->load->view('admin/order/update',array('cart_id'=>$id));
            $this->load->view('admin/include/footer');
    }
    private function getOrderDetailView($orderid){
            $replace = array("+", "-", "/", "=");
            $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
            $encrypted_string = str_replace($find, $replace, $orderid);
            $id = (int) $this->encrypt->decode($encrypted_string);
            if(isset($_POST['btn_status_item'])){
                $confirm=0;
                $cancel=0;
                $pending=0;
                $i=0;
                $cart_record = $this->db->query("select * from tbl_cart_master where cart_id='$id'")->row();
                $record = $this->db->query("select * from tbl_cart_item where cart_id='$id'")->result();
                foreach($record as $row){
                    $i++;
                 if(strlen($row->status)<=0){
                     $item_name = "product_status".$row->item_id;
                     $product_status = $this->security->xss_clean($this->input->post($item_name));
                     $data = array(
                                    'status' => $product_status,
                                    'updated_date' => Date('Y-m-d H:i:s')
                                    
                                );
                    $this->db->where('item_id', $row->item_id);
                    $this->db->where('cart_id', $id);
                    $this->db->update('tbl_cart_item', $data);
                        if($product_status=='confirm'){
                            
                            $confirm++;
                        }else if($product_status=='cancel'){
                            $cart_record->total_cost=$cart_record->total_cost-$row->total_price;
                            $cancel++;
                        }else{
                            $pending++;
                        }
                    } else{
                        if($row->status=='confirm'){
                            $confirm++;
                        }else if($row->status=='cancel'){
                            $cancel++;
                        }else{
                            $pending++;
                        }
                    }
                }
                if($i==$confirm){
                    $order_status='Confirm';
                }else if($i==$cancel){
                    $order_status='Canceled';
                }else{
                    $order_status='Parial Confirmed';
                }
                    $data = array(
                                    'order_status' => $order_status,
                                   
                                    'total_cost'=>$cart_record->total_cost
                                );
                   
                    $this->db->where('cart_id', $id);
                    $this->db->update('tbl_cart_master', $data);
                 
            }
            $this->load->view('admin/include/header');
            $this->load->view('admin/order/update',array('cart_id'=>$id));
            $this->load->view('admin/include/footer');
    }
    private function updatePrductImageDetail(){
            $product_id = null;
            $currency_id = null;
            $product_id = (int)$this->security->xss_clean($this->input->post('product_id'));
            $image_name = (int)$this->security->xss_clean($this->input->post('image_name'));
            $this->db->where('product_id', $product_id);
            $this->db->where('image_name', $image_name);
            $this->db->delete('tbl_product_image_map');
    }
    private function updatePrductPriceDetail(){
            $product_id = null;
            $currency_id = null;
            $product_id = (int)$this->security->xss_clean($this->input->post('product_id'));
            $currency_id = (int)$this->security->xss_clean($this->input->post('currency_id'));
            $this->db->where('product_id', $product_id);
            $this->db->where('currency_id', $currency_id);
            $this->db->delete('tbl_product_currency_map');
    }
   private function updateProductDetail(){
       try{
            $name = null;
            $category = null;
            $subcategory = null;
            $min_qty = null;
            $qty = null;
            $status = null;
             $id = (int)$this->security->xss_clean($this->input->post('product_id'));
            $name = $this->security->xss_clean($this->input->post('name'));
            $category = $this->security->xss_clean($this->input->post('category'));
            $subcategory = $this->security->xss_clean($this->input->post('subcategory'));
            $min_qty = $this->security->xss_clean($this->input->post('min_qty'));
            $qty = $this->security->xss_clean($this->input->post('qty'));
            $status = $this->security->xss_clean($this->input->post('status'));
            $data = array(
                'product_name' => $name,
                'category_id' => $category,
                'subcategory_id' => $subcategory,
                'min_qty' => $min_qty,
                'qty' => $qty,
                'status' => $status,
                'updated_date' => Date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('id')
            );
             $this->db->where('id', $id);
            $this->db->update('tbl_product_master', $data);
           echo $id;
        }catch(Exception $ex){
            
        }
   }
    private function saveProductImageDetail(){
        try {
            $product_id = null;
            $image_type = null;
            $image_name = null;
            $product_id = (int)$this->security->xss_clean($this->input->post('product'));
            $image_type = $this->security->xss_clean($this->input->post('image_type'));
            $image_name = md5($this->security->xss_clean($_FILES['file']['name'])).'.jpg';
            $temp=$_FILES['file']['tmp_name'];
            $destinaton=FCPATH.'upload/'.$image_name;
            if(move_uploaded_file($temp,$destinaton)){
                 $data = array(
                                'product_id' => $product_id,
                                'image_name' => $image_name,
                                'image_path' => $image_name,
                                'image_type' => $image_type,
                                'created_date' => Date('Y-m-d H:i:s'),
                                'created_by' => $this->session->userdata('id')
                            );
                $this->db->insert('tbl_product_image_map', $data);
                echo $image_name;
            }
        } catch (Exception $ex) {
            
        }
    }
    private function saveProductFieldDetail(){
        try {
            $product_id = null;
            $field_id = null;
            $field_value = null;
            $product_id = (int)$this->security->xss_clean($this->input->post('product_id'));
            $field_id = (int)$this->security->xss_clean($this->input->post('field_id'));
            $field_value = $this->security->xss_clean($this->input->post('field_value'));
            $data = array(
                'product_id' => $product_id,
                'field_id' => $field_id,
                'value' => $field_value,
                'created_date' => Date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('id')
            );
            $this->db->insert('tbl_product_field_map', $data);
            echo $this->db->insert_id();
        } catch (Exception $ex) {
            
        }
    }
    private function saveProductPriceDetail() {
        try {
            $product_id = null;
            $currency_id = null;
            $mrp = null;
            $sp = null;
            $pp = null;
            $sup = null;
            $discount = null;
            $product_id = (int)$this->security->xss_clean($this->input->post('product_id'));
            $currency_id = (int)$this->security->xss_clean($this->input->post('currency_id'));
            $mrp = $this->security->xss_clean($this->input->post('mrp'));
            $pp = $this->security->xss_clean($this->input->post('pp'));
            $sp = $this->security->xss_clean($this->input->post('sp'));
            $sup = $this->security->xss_clean($this->input->post('sup'));
            $discount = $this->security->xss_clean($this->input->post('disc'));
            $data = array(
                'product_id' => $product_id,
                'currency_id' => $currency_id,
                'mrp' => $mrp,
                'cost_price' => $pp,
                'selling_price' => $sp,
                'special_price' => $sup,
                'discount_per' => $discount,
                'status' => 'ACTIVE',
                'created_date' => Date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('id')
            );
            $this->db->insert('tbl_product_currency_map', $data);
            echo $this->db->insert_id();
        } catch (Exception $ex) {
            
        }
    }

    private function saveProductNewDetail() {
        try {
            $name = null;
            $category = null;
            $subcategory = null;
            $min_qty = null;
            $qty = null;
            $status = null;
            $name = $this->security->xss_clean($this->input->post('name'));
            $category = $this->security->xss_clean($this->input->post('category'));
            $subcategory = $this->security->xss_clean($this->input->post('subcategory'));
            $min_qty = $this->security->xss_clean($this->input->post('min_qty'));
            $qty = $this->security->xss_clean($this->input->post('qty'));
            $status = $this->security->xss_clean($this->input->post('status'));
            $data = array(
                'product_name' => $name,
                'category_id' => $category,
                'subcategory_id' => $subcategory,
                'min_qty' => $min_qty,
                'qty' => $qty,
                'status' => $status,
                'created_date' => Date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('id')
            );
            $this->db->insert('tbl_product_master', $data);
            echo $this->db->insert_id();
        } catch (Exception $ex) {
            
        }
    }

    private function getSubCategoryType() {
        $id = (int) $this->security->xss_clean($this->input->post('id'));
        $record = $this->db->query("select * from tbl_category_master where `parent_category_id`='$id' and status='ACTIVE'")->result();
        echo '<option value="">Please Select Sub Category</option>';
        foreach ($record as $row) {
            echo "<option value='$row->category_id'>$row->category_name</option>";
        }
    }

    private function getProductFieldType() {
        $id = (int) $this->security->xss_clean($this->input->post('id'));
        $type = $this->db->query('select field_type as type from tbl_field_master where `id`="' . $id . '"')->row()->type;
        if (isset($type)) {
            echo $type;
        } else {
            echo null;
        }
    }

    private function addNewProduct() {
        $this->load->view('admin/include/header');
        $this->form_validation->set_rules('title', 'Field Title', 'required|callback_field_check');
        $this->form_validation->set_rules('type', 'Field Type', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        if (isset($_POST['add'])) {
            if ($this->form_validation->run() == TRUE) {
                $title = $this->security->xss_clean($this->input->post('title'));
                $type = $this->security->xss_clean($this->input->post('type'));
                $status = $this->security->xss_clean($this->input->post('status'));

                try {
                    $data = array(
                        'field_title' => $title,
                        'field_type' => $type,
                        'status' => $status,
                        'created_date' => Date('Y-m-d H:i:s'),
                        'created_by' => $this->session->userdata('id')
                    );
                    $this->db->insert('tbl_field_master', $data);
                    redirect('managefield/index');
                } catch (Exception $ex) {
                    print_r($ex);
                }
            }
        }
        $this->load->view('admin/product/add');
        $this->load->view('admin/include/footer');
    }

    public function field_check($str) {
        $record = $this->db->query('select * from tbl_field_master where `field_title`like "' . $str . '"')->row();
        if (count($record) > 0) {
            $this->form_validation->set_message('field_check', 'The Field Title is already Exist');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    private function viewIndex($userid=null) {
        $this->load->view('admin/include/header');
        $this->load->view('admin/order/index',array('userid'=>$userid));
        $this->load->view('admin/include/footer');
    }

    private function updateOldProduct($param) {
        $replace = array("+", "-", "/", "=");
        $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
        $encrypted_string = str_replace($find, $replace, $param);
        $id = (int) $this->encrypt->decode($encrypted_string);
     
        $record = $this->db->query('select * from tbl_product_master where `id`= "' . $id . '"')->row();
        $this->load->view('admin/include/header');
        $this->load->view('admin/product/update', array('data' => $record));
        $this->load->view('admin/include/footer');
    }

}

?>