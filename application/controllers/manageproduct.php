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
class ManageProduct extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('encrypt');
        $this->load->library('session');
        session_start();
    }

    public function _remap($method, $param = array()) {
        if ($this->session->userdata('id')) {
            switch ($method) {

                case "index" : $this->viewIndex($param);
                    break;
                case "new" : $this->addNewProduct($param);
                    break;
                case "update" : $this->updateOldProduct($param[0]);
                    break;
                case "gettype" : $this->getProductFieldType();
                    break;
                case "getSubCategory" : $this->getSubCategoryType();
                    break;
                case "saveProduct" : $this->saveProductNewDetail();
                    break;
                case "saveProductPrice" : $this->saveProductPriceDetail();
                    break;
                case "saveProductField" : $this->saveProductFieldDetail();
                    break;
                case "saveProductImage" : $this->saveProductImageDetail();
                    break;
                case "updateProduct" : $this->updateProductDetail();
                    break;
                case "removePrice" : $this->updatePrductPriceDetail();
                    break;
                 case "removeImage" : $this->updatePrductImageDetail();
                    break;
                 case "removeField" : $this->updatePrductFieldDetail();
                    break;
                default : $this->error();
                    break;
            }
        } else {
            redirect('admin');
        }
    }
    private function updatePrductFieldDetail(){
            $product_id = null;
            $currency_id = null;
            $product_id = (int)$this->security->xss_clean($this->input->post('product_id'));
            $field_id = (int)$this->security->xss_clean($this->input->post('field_id'));
            $this->db->where('product_id', $product_id);
            $this->db->where('field_id', $field_id);
            $this->db->delete('tbl_product_field_map');
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
        exit;
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

    private function viewIndex() {
        $this->load->view('admin/include/header');
        $this->load->view('admin/product/index');
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