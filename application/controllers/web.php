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
class Web extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('encrypt');
        $this->load->library('session');
        $this->load->helper('cookie');
        $session_data =$this->session->userdata;
        
        if(!isset($session_data['currency_id'])){
           $this->session->set_userdata('currency_id',1);
        }
    }

    public function _remap($method, $param = array()) {
        switch ($method) {

            case "index" : $this->viewIndex($param);
                break;
            case "registersupplier" : $this->reg_sup();
                break;
            case "viewcategory" : if (isset($param[0])) {
                    if (isset($param[1])) {
                    $this->viewCategoryList($param[0],$param[1]);
                    }else{
                        $this->viewCategoryList($param[0]);
                    }
                } else {
                    redirect(base_url());
                }
                break;
            case "addtocart" :
                
                if (isset($param[0])) {
                    
                    $this->cart_additem($param[0]);
                } else {
                    redirect(base_url());
                }
                break;
            case "setCurrency" : if (isset($param[0])) {
                    $this->setCurrency($param[0]);
                } else {
                    redirect(base_url());
                }
                break;    
            case "managecart" : $this->viewCart();
                break;
            case "removeItem" : $this->removeProductCart();
                break;
            case "login" : if (isset($param[0])) {
                    $this->userCustomerLogin($param[0]);
                } else {
                    $this->userCustomerLogin();
                }
                break;
            case "register" : if (isset($param[0])) {
                    $this->registerCustomerUser($param[0]);
                } else {
                    $this->registerCustomerUser();
                }
                break;
            case "viewProduct" :    if (isset($param[0])) {
                                    $this->viewProductDetail($param[0]);
                                    } else {
                                    $this->viewIndex();
                                    }
                                    break;
             case "search" :   
                                    $this->search();
                                   
                                    break;
            case "ratingProduct":$this->productRatingDetail();
                                 break;
            case "logout" : $this->viewlogout($param);
                break;
            case "viewContent" : if (isset($param[0])) {
                                    $this->viewContent($param[0]);
                                    } else {
                                    $this->viewIndex();
                                    }
                                    break;
           
            default : $this->viewIndex();
                break;
        }
    }
   
    private function search(){
        if(isset($_POST['product_cat']) && isset($_POST['search']) ){
            $category = $_POST['product_cat'];
           
            $id =  $this->encrypt->encode($category);
            $search = $_POST['search_value'];
            $replace = array("+", "-", "/", "=");
            $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
            $encrypted_string = str_replace( $replace,$find, $id);
            redirect(base_url()."index.php/web/viewcategory/".$encrypted_string."/$search");
        }
    }
    private function setCurrency($id){
        $replace = array("+", "-", "/", "=");
        $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
        $encrypted_string = str_replace($find, $replace, $id);
        $id = (int) $this->encrypt->decode($encrypted_string);
        $this->session->set_userdata('currency_id',$id);
        $this->session->unset_userdata('cart_id',$id);
        $session_data =$this->session->userdata;
        $session_id = $session_data['session_id'];
        $this->db->query("delete from tbl_cart_master where session_id=? ",array($session_id));
         if(isset($_SERVER['HTTP_REFERER'])){
             redirect($_SERVER['HTTP_REFERER']);
         }else{
             redirect(base_url());
         }
    }
    private function viewContent($id){
        $replace = array("+", "-", "/", "=");
        $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
        $encrypted_string = str_replace($find, $replace, $id);
        $id = (int) $this->encrypt->decode($encrypted_string);
        $this->load->view('web/include/header');
        $this->load->view('web/home/content',array('id'=>$id));
        $this->load->view('web/include/footer');
    }
    private function productRatingDetail(){
       
        $id = $this->input->post('product_id');
        $replace = array("+", "-", "/", "=");
        $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
        $encrypted_string = str_replace($find, $replace, $id);
         $id = (int) $this->encrypt->decode($encrypted_string);
        $this->load->view('web/include/header');
        $this->load->view('web/home/viewProduct',array('id'=>$id));
        $this->load->view('web/include/footer');
    }
    private function viewProductDetail($id){
        $replace = array("+", "-", "/", "=");
        $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
        $encrypted_string = str_replace($find, $replace, $id);
        $id = (int) $this->encrypt->decode($encrypted_string);
         if (isset($_POST['submit_rating'])) {
             $this->form_validation->set_rules('rating', 'Rating', 'required');
            $this->form_validation->set_rules('comment', 'Comment', 'required');
            if ($this->form_validation->run() == TRUE) {
                $rating = $this->security->xss_clean($this->input->post('rating'));
                $comment = $this->security->xss_clean($this->input->post('comment'));
                $status = $this->security->xss_clean($this->input->post('status'));

                try {
                    $data = array(
                        'rating' => $rating,
                        'comment' => $comment,
                        'created_date' => Date('Y-m-d H:i:s'),
                        'user_id'=>$this->session->userdata('user_id'),
                        'product_id' => $id
                    );
                    $this->db->insert('tbl_product_review', $data);
                
                } catch (Exception $ex) {
                    print_r($ex);
                }
            }
        }
        
        $this->load->view('web/include/header');
        $this->load->view('web/home/viewProduct',array('id'=>$id));
        $this->load->view('web/include/footer');
    }
    private function reg_sup() {
        $this->load->view('web/include/header');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|callback_email_check');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('company_address', 'Company Address', 'required');
        $this->form_validation->set_rules('company_name', 'Company Name', 'required');
        $this->form_validation->set_rules('company_person', 'Contact Person', 'required');
        $msg=null;
        if (isset($_POST['register'])) {
            if ($this->form_validation->run() == TRUE) {
                $name = $this->security->xss_clean($this->input->post('name'));
                $email = $this->security->xss_clean($this->input->post('email'));
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                $company_address = $this->security->xss_clean($this->input->post('company_address'));
                $company_name = $this->security->xss_clean($this->input->post('company_name'));
                $company_address = $this->security->xss_clean($this->input->post('company_address'));
                $company_person = $this->security->xss_clean($this->input->post('company_person'));
                $city = $this->security->xss_clean($this->input->post('city'));
                $state = $this->security->xss_clean($this->input->post('state'));
                $country = $this->security->xss_clean($this->input->post('country'));
                $pincode = $this->security->xss_clean($this->input->post('pincode'));
                $this->form_validation->set_rules('city', 'City', 'required');
                $this->form_validation->set_rules('state', 'State', 'required');
                $this->form_validation->set_rules('country', 'Country', 'required');
                $this->form_validation->set_rules('pincode', 'Pincode', 'required');
                $data = array(
                    'username' => $email,
                    'name' => $company_person,
                    'company_name' => $company_name,
                    'address1' => $company_address,
                    'role_id' => 2,
                    'user_type' => 'SUPPLIER',
                    'city' => $city,
                    'state' => $state,
                    'country' => $country,
                    'pincode' => $pincode,
                    'email' => $email,
                    'mobile1' => $mobile,
                    'status' => 'INACTIVE',
                    'created_date' => Date('Y-m-d H:i:s'),
                );
                $this->db->insert('tbl_user_master', $data);
                $user_id = $this->db->insert_id();
                $data = array(
                    'user_id' => $user_id,
                    'customer_name' => $company_person,
                    'address' => $company_address,
                    'city' => $city,
                    'state' => $state,
                    'country' => $country,
                    'pincode' => $pincode,
                    'email' => $email,
                    'mobile' => $mobile,
                    'status' => 'ACTIVE',
                    'created_date' => Date('Y-m-d H:i:s'),
                );
                $this->db->insert('tbl_customer_address_master', $data);
                $msg="Thank You , For Registering us . We will Contact Soon.";
            }
        }
        $this->load->view('web/home/supplier_register',array('msg'=>$msg));
        $this->load->view('web/include/footer');
    }

    private function registerCustomerUser($param = null) {
        $this->load->view('web/include/header');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|callback_email_check');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('pincode', 'Pincode', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if (isset($_POST['register'])) {
            if ($this->form_validation->run() == TRUE) {
                $name = $this->security->xss_clean($this->input->post('name'));
                $email = $this->security->xss_clean($this->input->post('email'));
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                $address = $this->security->xss_clean($this->input->post('address'));
                $city = $this->security->xss_clean($this->input->post('city'));
                $state = $this->security->xss_clean($this->input->post('state'));
                $country = $this->security->xss_clean($this->input->post('country'));
                $pincode = $this->security->xss_clean($this->input->post('pincode'));
                $password = md5($this->security->xss_clean($this->input->post('password')));
                $data = array(
                    'username' => $email,
                    'name' => $name,
                    'password' => $password,
                    'address1' => $address,
                    'role_id' => 1,
                    'user_type' => 'CUSTOMER',
                    'city' => $city,
                    'state' => $state,
                    'country' => $country,
                    'pincode' => $pincode,
                    'email' => $email,
                    'mobile1' => $mobile,
                    'created_date' => Date('Y-m-d H:i:s'),
                );
                $this->db->insert('tbl_user_master', $data);
                $user_id = $this->db->insert_id();
                $data = array(
                    'user_id' => $user_id,
                    'customer_name' => $name,
                    'address' => $address,
                    'city' => $city,
                    'state' => $state,
                    'country' => $country,
                    'pincode' => $pincode,
                    'email' => $email,
                    'mobile' => $mobile,
                    'status' => 'ACTIVE',
                    'created_date' => Date('Y-m-d H:i:s'),
                );
                $this->db->insert('tbl_customer_address_master', $data);
                $session_data = $this->session->userdata;
                $this->session->set_userdata("user_id", $user_id);
                $this->session->set_userdata("name", $name);
                $this->session->set_userdata("role_id", 1);
                $this->session->set_userdata("user_type", 'CUSTOMER');
                if ($param == 'cart') {
                    $cart_id = $session_data['cart_id'];
                    $this->session->set_userdata("cart_id", $cart_id);
                    redirect('customer/checkout');
                } else {
                    redirect('customer/index');
                }
            }
        }
        $this->load->view('web/home/registration_new', array('param' => $param));
        $this->load->view('web/include/footer');
    }

    public function email_check($str) {

        $record = $this->db->query('select * from tbl_user_master where `username`=? ', array($str))->row();

        if (count($record) > 0) {
            $this->form_validation->set_message('email_check', 'Email is already Exist');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    private function userCustomerLogin($param = null) {
        $this->load->view('web/include/header');
        $this->form_validation->set_rules('username', 'UserName', 'required|callback_user_check');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if (isset($_POST['login'])) {
            if ($this->form_validation->run() == TRUE) {
                $username = $this->security->xss_clean($this->input->post('username'));
                $password = $this->security->xss_clean($this->input->post('password'));
                $record = $this->db->query('select * from tbl_user_master where `username`=? and password=?', array($username, md5($password)))->row();
                $session_data = $this->session->userdata;
                $this->session->set_userdata("user_id", $record->id);
                $this->session->set_userdata("name", $record->name);
                $this->session->set_userdata("role_id", 1);
                $this->session->set_userdata("user_type", $record->user_type);
                if ($param == 'cart') {
                    $cart_id = $session_data['cart_id'];
                    $this->session->set_userdata("cart_id", $cart_id);
                    redirect('customer/checkout');
                } else {

                    redirect(base_url() . 'index.php/customer/index');
                }
            }
        }
        $this->load->view('web/home/login', array('param' => $param));
        $this->load->view('web/include/footer');
    }

    public function user_check($str) {
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));
        $record = $this->db->query('select * from tbl_user_master where `username`=? and password=?', array($username, md5($password)))->row();

        if (count($record) <= 0) {
            $this->form_validation->set_message('user_check', 'The User Name and Password is not Matched');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    private function removeProductCart() {
        if (isset($_POST['item_id'])) {
            $session_data = $this->session->userdata;
            $replace = array("+", "-", "/", "=");
            $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
            $encrypted_string = str_replace($find, $replace, $_POST['item_id']);
            $id = (int) $this->encrypt->decode($encrypted_string);
            $cart_id = $session_data['cart_id'];
            $productrecord = $this->db->query("SELECT * FROM `tbl_product_master` pm inner join tbl_product_currency_map pcm on pm.id = pcm.product_id where pm.id='$id' group by pcm.product_id")->row();
            $cartrecord = $this->db->query("SELECT * FROM `tbl_cart_master` where cart_id=?", array($cart_id))->row();
            $cartitem = $this->db->query("SELECT * FROM `tbl_cart_item` where cart_id=? and item_id=?", array($cart_id, $id))->row();
            $data = array(
                'total_item' => $cartrecord->total_item - 1,
                'total_cost' => $cartrecord->total_cost - $cartitem->total_price,
                'updated_date' => Date('Y-m-d H:i:s'),
            );
            $this->db->where('cart_id', $cart_id);
            $this->db->update('tbl_cart_master', $data);
            $data = array(
                'qty' => $productrecord->qty + $cartitem->qty,
            );
            //$this->db->where('id', $productrecord->product_id);
            //$this->db->update('tbl_product_master', $data);
            $this->db->where('item_id', $productrecord->product_id);
            $this->db->where('cart_id', $cart_id);
            $this->db->delete('tbl_cart_item');
            echo 'Item is Successfully Removed';
        } else {
            echo 'Unable to Remove Item Please, Try Again';
        }
    }

    private function cart_additem($param) {



        if (isset($_REQUEST[$param . 'qty'])) {
            $session_data =$this->session->userdata;
                $currency_id=$session_data['currency_id'];
            $replace = array("+", "-", "/", "=");
            $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
            $encrypted_string = str_replace($find, $replace, $param);
            $id = (int) $this->encrypt->decode($encrypted_string);
            $qty = $_REQUEST[$param . 'qty'];
            $productrecord = $this->db->query("SELECT * FROM `tbl_product_master` pm inner join tbl_product_currency_map pcm on pm.id = pcm.product_id where  pcm.currency_id='$currency_id' and pm.id='$id' group by pcm.product_id")->row();
            $session_data = $this->session->userdata;
            $session_id = $session_data['session_id'];
            $flag=false;
            if($this->session->userdata('user_type')){
                if($this->session->userdata('user_type')=='SUPPLIER'){
                    $flag=true;
                }
            }
            if($flag==false) {
                    if (strlen($productrecord->discount_per) > 0) {
                        $price = $productrecord->selling_price - (($productrecord->discount_per / 100) * $productrecord->selling_price);
                    } else {
                        $price = $productrecord->selling_price;
                    }
                    if (!isset($session_data['cart_id'])) {
                       
                        $cartrecord = $this->db->query("SELECT * FROM `tbl_cart_master` where session_id=?", array($session_id))->row();
                        if (count($cartrecord) > 0) {
                             $this->session->set_userdata("cart_id", $cartrecord->cart_id);
                        } else {
                               $session_data =$this->session->userdata;
                               $currency_id=$session_data['currency_id'];
                            $data = array(
                                'session_id' => $session_id,
                                'total_item' => 1,
                                'total_cost' => $qty * $price,
                                'created_date' => Date('Y-m-d H:i:s'),
                                'currency_id' => $currency_id,
                            );
                            $this->db->insert('tbl_cart_master', $data);
                            $cart_id = $this->db->insert_id();
                            $data = array(
                                'cart_id' => $cart_id,
                                'item_id' => $productrecord->product_id,
                                'item_desc' => $productrecord->product_name,
                                'qty' => $qty,
                                'selling_price' => $productrecord->selling_price,
                                'discount_price' => $price,
                                'purchase_price' => $productrecord->cost_price,
                                'special_price' => $productrecord->special_price,
                                'cart_type' => Date('Y-m-d H:i:s'),
                                'total_price' => $qty * $price,
                                'total_gross_price' => $qty * $price,
                                'created_date' => Date('Y-m-d H:i:s'),
                            );
                            $this->db->insert('tbl_cart_item', $data);
                            $data = array(
                                'qty' => $productrecord->qty - $qty,
                            );
                            //$this->db->where('id', $productrecord->product_id);
                            //$this->db->update('tbl_product_master', $data);
                            $this->session->set_userdata("cart_id", $cart_id);
                            $session_data = $this->session->userdata;
                            
                            $encrypted_string = $this->encrypt->encode($cart_id);
                            $find = array("+", "-", "/", "=");
                            $replace = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
                            $encrypted_string = str_replace($find, $replace, $encrypted_string);
                            $cookie = array('name' => 'token', 'value' => $encrypted_string, 'expire' => '86500', 'secure' => TRUE);
                            $this->input->set_cookie($cookie);
                        }
                        
                    } else {

                        $cart_id = $session_data['cart_id'];
                        $cartrecord = $this->db->query("SELECT * FROM `tbl_cart_master` where cart_id=?", array($cart_id))->row();
                        $cartitem = $this->db->query("SELECT * FROM `tbl_cart_item` where cart_id=? and item_id=?", array($cart_id, $id))->row();
                        $itemcount = $cartrecord->total_item;
                        $totalcost = $cartrecord->total_cost;
                        $data = array(
                            'qty' => $productrecord->qty - $qty,
                        );
                        $this->db->where('id', $productrecord->product_id);
                        $this->db->update('tbl_product_master', $data);
                        if (count($cartitem) <= 0) {
                            $itemcount = $itemcount + 1;
                            $totalcost = $totalcost + $qty * $price;
                            $data = array(
                                'cart_id' => $cart_id,
                                'item_id' => $productrecord->product_id,
                                'item_desc' => $productrecord->product_name,
                                'qty' => $qty,
                                'selling_price' => $productrecord->selling_price,
                                'discount_price' => $price,
                                'purchase_price' => $productrecord->cost_price,
                                'special_price' => $productrecord->special_price,
                                'cart_type' => 'CUSTOMER',
                                'total_price' => $qty * $price,
                                'total_gross_price' => $qty * $price,
                                'created_date' => Date('Y-m-d H:i:s'),
                            );
                            $this->db->insert('tbl_cart_item', $data);
                        } else {
                            $totalcost = $totalcost + $qty * $price;
                            $qty = $cartitem->qty + $qty;

                            $data = array(
                                'item_id' => $productrecord->product_id,
                                'item_desc' => $productrecord->product_name,
                                'qty' => $qty,
                                'selling_price' => $productrecord->selling_price,
                                'discount_price' => $price,
                                'purchase_price' => $productrecord->cost_price,
                                'special_price' => $productrecord->special_price,
                                'cart_type' => 'CUSTOMER',
                                'total_price' => $qty * $price,
                                'total_gross_price' => $qty * $price,
                                'updated_date' => Date('Y-m-d H:i:s'),
                            );
                            $this->db->where('cart_id', $cart_id);
                            $this->db->where('item_id', $productrecord->product_id);
                            $this->db->update('tbl_cart_item', $data);
                        }
                        $data = array(
                            'total_cost' => $totalcost,
                            'total_item' => $itemcount,
                            'updated_date' => Date('Y-m-d H:i:s'),
                        );
                        $this->db->where('cart_id', $cart_id);
                        $this->db->update('tbl_cart_master', $data);
                    }
            }else{
                    
                    $price = $productrecord->special_price;
                    
                    if (!isset($session_data['cart_id'])) {
                        $cartrecord = $this->db->query("SELECT * FROM `tbl_cart_master` where session_id=?", array($session_id))->row();
                        if (count($cartrecord) > 0) {
                             $this->session->set_userdata("cart_id", $cartrecord->cart_id);
                        } else {

                            $data = array(
                                'session_id' => $session_id,
                                'total_item' => 1,
                                'total_cost' => $qty * $price,
                                'created_date' => Date('Y-m-d H:i:s'),
                            );
                            $this->db->insert('tbl_cart_master', $data);
                            $cart_id = $this->db->insert_id();
                            $data = array(
                                'cart_id' => $cart_id,
                                'item_id' => $productrecord->product_id,
                                'item_desc' => $productrecord->product_name,
                                'qty' => $qty,
                                'selling_price' => $productrecord->selling_price,
                                'discount_price' => $price,
                                'purchase_price' => $productrecord->cost_price,
                                'special_price' => $productrecord->special_price,
                                'cart_type' => Date('Y-m-d H:i:s'),
                                'total_price' => $qty * $price,
                                'total_gross_price' => $qty * $price,
                                'created_date' => Date('Y-m-d H:i:s'),
                            );
                            $this->db->insert('tbl_cart_item', $data);
                            $data = array(
                                'qty' => $productrecord->qty - $qty,
                            );
                            //$this->db->where('id', $productrecord->product_id);
                            //$this->db->update('tbl_product_master', $data);
                            $this->session->set_userdata("cart_id", $cart_id);
                            $encrypted_string = $this->encrypt->encode($cart_id);
                            $find = array("+", "-", "/", "=");
                            $replace = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
                            $encrypted_string = str_replace($find, $replace, $encrypted_string);
                            $cookie = array('name' => 'token', 'value' => $encrypted_string, 'expire' => '86500', 'secure' => TRUE);
                            $this->input->set_cookie($cookie);
                        }
                    } else {

                        $cart_id = $session_data['cart_id'];
                        $cartrecord = $this->db->query("SELECT * FROM `tbl_cart_master` where cart_id=?", array($cart_id))->row();
                        $cartitem = $this->db->query("SELECT * FROM `tbl_cart_item` where cart_id=? and item_id=?", array($cart_id, $id))->row();
                        $itemcount = $cartrecord->total_item;
                        $totalcost = $cartrecord->total_cost;
                        $data = array(
                            'qty' => $productrecord->qty - $qty,
                        );
                        $this->db->where('id', $productrecord->product_id);
                        $this->db->update('tbl_product_master', $data);
                        if (count($cartitem) <= 0) {
                            $itemcount = $itemcount + 1;
                            $totalcost = $totalcost + $qty * $price;
                            $data = array(
                                'cart_id' => $cart_id,
                                'item_id' => $productrecord->product_id,
                                'item_desc' => $productrecord->product_name,
                                'qty' => $qty,
                                'selling_price' => $productrecord->selling_price,
                                'discount_price' => $price,
                                'purchase_price' => $productrecord->cost_price,
                                'special_price' => $productrecord->special_price,
                                'cart_type' => 'CUSTOMER',
                                'total_price' => $qty * $price,
                                'total_gross_price' => $qty * $price,
                                'created_date' => Date('Y-m-d H:i:s'),
                            );
                            $this->db->insert('tbl_cart_item', $data);
                        } else {
                            $totalcost = $totalcost + $qty * $price;
                            $qty = $cartitem->qty + $qty;

                            $data = array(
                                'item_id' => $productrecord->product_id,
                                'item_desc' => $productrecord->product_name,
                                'qty' => $qty,
                                'selling_price' => $productrecord->selling_price,
                                'discount_price' => $price,
                                'purchase_price' => $productrecord->cost_price,
                                'special_price' => $productrecord->special_price,
                                'cart_type' => 'CUSTOMER',
                                'total_price' => $qty * $price,
                                'total_gross_price' => $qty * $price,
                                'updated_date' => Date('Y-m-d H:i:s'),
                            );
                            $this->db->where('cart_id', $cart_id);
                            $this->db->where('item_id', $productrecord->product_id);
                            $this->db->update('tbl_cart_item', $data);
                        }
                        $data = array(
                            'total_cost' => $totalcost,
                            'total_item' => $itemcount,
                            'updated_date' => Date('Y-m-d H:i:s'),
                        );
                        $this->db->where('cart_id', $cart_id);
                        $this->db->update('tbl_cart_master', $data);
                    }
                
            }

            redirect(base_url() . "index.php/web/managecart");
        }
    }

    private function viewCart() {

        $session_data = $this->session->userdata;
        
        if (isset($session_data['cart_id'])) {
            $this->load->view('web/include/header');
            $this->load->view('web/home/cart', array('cart_id' => $session_data['cart_id']));
            $this->load->view('web/include/home_footer');
        } else {
            redirect(base_url());
        }
    }

    private function viewIndex() {
        $this->load->view('web/include/home_header');
        $this->load->view('web/home/index');
        $this->load->view('web/include/home_footer');
    }

    private function viewCategoryList($param,$search=null) {
        $replace = array("+", "-", "/", "=");
        $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
        $encrypted_string = str_replace($find, $replace, $param);
        $id = (int) $this->encrypt->decode($encrypted_string);
        $this->load->view('web/include/header');
        $this->load->view('web/home/category', array('category_id' => $id,'search'=>$search));
        $this->load->view('web/include/footer');
    }

    private function viewlogout() {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('user_type');
        $this->session->unset_userdata('logged_in');
        $this->session->set_flashdata('user_id ', NULL);
        $this->session->set_flashdata('name', NULL);
        $this->session->set_flashdata('role_id', NULL);
        $this->session->set_flashdata('user_type', NULL);
        $this->session->set_flashdata('logged_in', NULL);
        $this->session->sess_destroy();
        redirect(base_url());
    }

}

?>
