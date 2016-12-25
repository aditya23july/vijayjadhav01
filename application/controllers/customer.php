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
class Customer extends CI_Controller {

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
        $this->load->library('email');
        $this->load->model('mail');
        
       // $currentTimeoutInSecs = ini_get('session.gc_maxlifetime');
       //         echo $currentTimeoutInSecs;exit;
        if (!$this->session->userdata('user_id')) {
            redirect(base_url());
        }
        $session_data =$this->session->userdata;
        if(!isset($session_data['currency_id'])){
           $this->session->set_userdata('currency_id',1);
        }
    }

    public function _remap($method, $param = array()) {
        switch ($method) {

            case "index" : $this->viewIndex($param);
                break;
            case "checkout" : $this->customerCheckOut();
                break;
            case "addAddress" : $this->addCustomerAddress();
                break;
            case "viewaddress" : $this->viewaddressCustomer();
                break;
            case "addPayment" : $this->addCustomerPayment();
                break;
            case "removeItem" : $this->removeProductCart();
                break;
            case "order" : $this->generateOrderDetail();
                break;
            case "viewOrder" : if (isset($param[0])) {
                    $this->viewOrder($param[0]);
                }

                break;
            case "removeCustomerAddress" : if (isset($param[0])) {
                    $this->removeCustomerAddressDetail($param[0]);
                }

                break;
            case "viewOrderList" : $this->viewOrderListDetail();
                                break;
            case "logout" : $this->viewlogout($param);
                break;
             case "viewwishlist" :    $this->wishlist();
                                    break;   
            case "addwishlist" :     if (isset($param[0])) {
                                    $this->addwishlist($param[0]);
                                    }
                                    break;    
            case "removewishlist" :     if (isset($param[0])) {
                                    $this->removewishlist($param[0]);
                                    }
                                    break;  
                                    
            default : $this->error();
                break;
        }
    }
    private function removewishlist($product_id){
        $replace = array("+", "-", "/", "=");
        $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
        $encrypted_string = str_replace($find, $replace, $product_id);
        $id = (int) $this->encrypt->decode($encrypted_string);
       $this->db->query("delete from tbl_wishlist_master where item_id='$id' and user_id=?",array('user_id'=>$this->session->userdata('user_id')));
        
        redirect(base_url()."index.php/customer/viewwishlist");
    }
    private function addwishlist($product_id){
        $replace = array("+", "-", "/", "=");
        $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
        $encrypted_string = str_replace($find, $replace, $product_id);
        $id = (int) $this->encrypt->decode($encrypted_string);
        $count=$this->db->query("select count(*) as count from tbl_wishlist_master where item_id='$id' and user_id=?",array('user_id'=>$this->session->userdata('user_id')))->row()->count;
        if($count<=0){
        $data = array(
                        'item_id'=>$id,
                        'user_id'=>$this->session->userdata('user_id'),
                        'created_date'=>Date('Y-m-d H:i:s'), 
                    );
        $this->db->insert('tbl_wishlist_master',$data);
        }
        redirect(base_url()."index.php/customer/viewwishlist");
    }
     private function wishlist(){
        $this->load->view('web/include/header');
        $this->load->view('web/customer/wishlist');
        $this->load->view('web/include/footer');
    }
    private function removeCustomerAddressDetail($id){ 
        $replace = array("+", "-", "/", "=");
        $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
        $encrypted_string = str_replace($find, $replace, $id);
        $id = (int) $this->encrypt->decode($encrypted_string);
        $data = array(
                    'status'=>'INACTIVE'
                );
        $this->db->where('id', $id);
        $this->db->update('tbl_customer_address_master', $data);
        redirect(base_url().'index.php/customer/viewaddress');
    }  
    private function viewaddressCustomer(){
        $this->load->view('web/include/header');
        $this->load->view('web/customer/addressList');
        $this->load->view('web/include/footer');
    }
    private function viewOrderListDetail(){
        $this->load->view('web/include/header');
        $this->load->view('web/customer/orderList');
        $this->load->view('web/include/footer');
    }
    private function generateOrderDetail() {
        
        $session_data = $this->session->userdata;
        $user_id = $session_data['user_id'];
        $cart_id = $session_data['cart_id'];
       
                $currency_id=$session_data['currency_id'];
        if (isset($session_data['cart_id'])) {
            $cartrecord = $this->db->query("SELECT * FROM `tbl_cart_master` where cart_id=?", array($cart_id))->row();
            if (strlen($cartrecord->billing_address_id) > 0 && strlen($cartrecord->payment_type) > 0) {
                $digit = rand(10, 99);
                $orderid = "#" . Date('Ymd') . $digit . $cart_id;
                $data = array(
                    'order_id' => $orderid,
                    'order_by' => $user_id,
                    'updated_date' => Date('Y-m-d H:i:s'),
                    'order_date' => Date('Y-m-d H:i:s')
                );
                $this->db->where('cart_id', $cart_id);
                $this->db->update('tbl_cart_master', $data);
                $cartitemresult = $this->db->query("SELECT * FROM `tbl_cart_item` where cart_id=?", array($cart_id))->result();
                foreach ($cartitemresult as $cartitemrow) {
                     $productrecord = $this->db->query("SELECT * FROM `tbl_product_master` pm inner join tbl_product_currency_map pcm on pm.id = pcm.product_id where pcm.currency_id='$currency_id' and pm.id='$cartitemrow->item_id' group by pcm.product_id")->row();
                    $data = array(
                        'qty' => $productrecord->qty-$cartitemrow->qty,
                    );
                    $this->db->where('id', $cartitemrow->item_id);
                    $this->db->update('tbl_product_master', $data);
                }
                $taxrecord = $this->db->query("SELECT * FROM `tbl_tax_master` where currency_id=? and status='ACTIVE'", array($currency_id))->result();
                foreach ($taxrecord as $taxrow) {
                     
                    $data = array(
                        'tax_id' => $taxrow->id,
                        'tax_title' => $taxrow->title,
                        'tax_value' => $taxrow->tax_value,
                        'cart_id' => $cart_id
                    );
                   
                    $this->db->insert('tbl_cart_tax_map', $data);
                }
                 $this->mail->generateOrderMail($cart_id); 
                $encrypted_string = $this->encrypt->encode($cart_id);
                $find = array("+", "-", "/", "=");
                $replace = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
                $encrypted_string = str_replace($find, $replace, $encrypted_string);
                $this->session->unset_userdata('cart_id');
               
                redirect(base_url() . 'index.php/customer/viewOrder/' . $encrypted_string);
            }
        }
    }

    private function viewOrder($param) {
        $replace = array("+", "-", "/", "=");
        $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
        $encrypted_string = str_replace($find, $replace, $param);
        $id = (int) $this->encrypt->decode($encrypted_string);
        $data['id'] = $id;
        $this->load->view('web/include/header');
        $this->load->view('web/customer/order', $data);
        $this->load->view('web/include/footer');
    }

    private function addCustomerPayment() {
        if (isset($_POST['comment']) && isset($_POST['payment_type'])) {
            $session_data = $this->session->userdata;
            $user_id = $session_data['user_id'];
            $cart_id = $session_data['cart_id'];
            if (isset($session_data['cart_id'])) {

                if ($_POST['payment_type'] == "BANKTRANSFER") {

                    $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
                    $comment = $this->security->xss_clean($this->input->post('comment'));
                    $data = array(
                        'order_comment' => $comment,
                        'payment_type' => $payment_type,
                        'user_id' => $user_id,
                        'updated_date' => Date('Y-m-d H:i:s')
                    );
                    $this->db->where('cart_id', $cart_id);
                    $this->db->update('tbl_cart_master', $data);
                    echo true;
                } else {
                    echo '<li>Please Enter Correct Payment Type </li>';
                }
            } else {
                echo '<li>Session is Timed Out,PLease Try Again </li>';
            }
        } else {
            echo '<li>Please Select Payment Type or Enter Comment</li>';
        }
    }

    private function addCustomerAddress() {

        if (isset($_POST['address_type'])) {
            $session_data = $this->session->userdata;
            $user_id = $session_data['user_id'];
            $cart_id = $session_data['cart_id'];
            if (isset($session_data['cart_id'])) {

                if ($_POST['address_type'] == '1') {
                    if (isset($_POST['existing_address_id'])) {
                        if (strlen($_POST['existing_address_id']) > 0) {
                            $address_id = (int) $_POST['existing_address_id'];
                            $data = array(
                                'billing_address_id' => $address_id,
                                'user_id' => $user_id,
                                'updated_date' => Date('Y-m-d H:i:s')
                            );
                            $this->db->where('cart_id', $cart_id);
                            $this->db->update('tbl_cart_master', $data);
                            echo true;
                        } else {
                            echo"<li>Please Select Address</li>";
                        }
                    } else {
                        echo"<li>Please Select Address</li>";
                    }
                } else if ($_POST['address_type'] == '0') {
                    $error = null;
                    if (strlen($this->security->xss_clean($this->input->post('name'))) > 0) {
                        $name = $this->security->xss_clean($this->input->post('name'));
                    } else {
                        $error.="<li>Please Enter Name</li>";
                    }
                    if (strlen($this->security->xss_clean($this->input->post('address'))) > 0) {
                        $address = $this->security->xss_clean($this->input->post('address'));
                    } else {
                        $error.="<li>Please Enter Address</li>";
                    }
                    if (strlen($this->security->xss_clean($this->input->post('country'))) > 0) {
                        $country = $this->security->xss_clean($this->input->post('country'));
                    } else {
                        $error.="<li>Please Enter Country</li>";
                    }
                    if (strlen($this->security->xss_clean($this->input->post('state'))) > 0) {
                        $state = $this->security->xss_clean($this->input->post('state'));
                    } else {
                        $error.="<li>Please Enter State</li>";
                    }
                    if (strlen($this->security->xss_clean($this->input->post('city'))) > 0) {
                        $city = $this->security->xss_clean($this->input->post('city'));
                    } else {
                        $error.="<li>Please Enter City</li>";
                    } 
                    if (strlen($this->security->xss_clean($this->input->post('pincode'))) > 0) {
                        $pincode = $this->security->xss_clean($this->input->post('pincode'));
                    } else {
                        $error.="<li>Please Enter Pincode</li>";
                    }
                    if (strlen($this->security->xss_clean($this->input->post('mobile'))) > 0) {
                        $mobile = $this->security->xss_clean($this->input->post('mobile'));
                    } else {
                        $error.="<li>Please Enter Mobile</li>";
                    }
                    if (strlen($this->security->xss_clean($this->input->post('email'))) > 0) {
                        $email = $this->security->xss_clean($this->input->post('email'));
                    } else {
                        $error.="<li>Please Enter City</li>";
                    }
                    if (strlen($error) <= 0) {
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
                        $customer_address_id = $this->db->insert_id();
                        $data = array(
                            'billing_address_id' => $customer_address_id,
                            'user_id' => $user_id,
                            'updated_date' => Date('Y-m-d H:i:s')
                        );
                        $this->db->where('cart_id', $cart_id);
                        $this->db->update('tbl_cart_master', $data);
                        echo true;
                    } else {
                        echo $error;
                    }
                } else {
                    echo"<li>Please Select Correct Address Type";
                }
            } else {
                echo"<li>Session id is null</li>";
            }
        }
    }

    private function customerCheckOut() {
        $session_data = $this->session->userdata;
        $this->load->view('web/include/header');
        $this->load->view('web/customer/checkout');
        $this->load->view('web/include/footer');
    }

    private function registerCustomerUser($param = null) {
        $this->load->view('web/include/header');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
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
                    'mobile1' => $mobile1,
                    'created_date' => Date('Y-m-d H:i:s'),
                );
                $this->db->insert('tbl_user_master', $data);
                if ($param == 'cart') {
                    redirect('customer/checkout');
                } else {
                    redirect('customer/index');
                }
            }
        }
        $this->load->view('web/home/registration_new', array('param' => $param));
        $this->load->view('web/include/footer');
    }

    private function userCustomerLogin($param = null) {
        $this->load->view('web/include/header');

        $this->load->view('web/home/login', array('param' => $param));
        $this->load->view('web/include/footer');
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
            $replace = array("+", "-", "/", "=");
            $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
            $encrypted_string = str_replace($find, $replace, $param);
            $id = (int) $this->encrypt->decode($encrypted_string);
            $qty = $_REQUEST[$param . 'qty'];
            $productrecord = $this->db->query("SELECT * FROM `tbl_product_master` pm inner join tbl_product_currency_map pcm on pm.id = pcm.product_id where pm.id='$id' group by pcm.product_id")->row();
            $session_data = $this->session->userdata;
            $session_id = $session_data['session_id'];
            if (strlen($productrecord->discount_per) > 0) {
                $price = $productrecord->selling_price - (($productrecord->discount_per / 100) * $productrecord->selling_price);
            } else {
                $price = $productrecord->selling_price;
            }
            if (!isset($session_data['cart_id'])) {
                $cartrecord = $this->db->query("SELECT * FROM `tbl_cart_master` where session_id=?", array($session_id))->row();
                if (count($cartrecord) > 0) {
                    
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

            redirect(base_url() . "index.php/web/managecart");
        }
    }

    private function viewCart() {

        $session_data = $this->session->userdata;
        if (isset($session_data['cart_id'])) {
            $this->load->view('web/include/home_header');
            $this->load->view('web/home/cart', array('cart_id' => $session_data['cart_id']));
            $this->load->view('web/include/home_footer');
        } else {
            redirect(base_url());
        }
    }

    private function viewIndex() {
        $this->load->view('web/include/home_header');
        $this->load->view('web/customer/index');
        $this->load->view('web/include/home_footer');
    }

    private function viewCategoryList($param) {
        $replace = array("+", "-", "/", "=");
        $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
        $encrypted_string = str_replace($find, $replace, $param);
        $id = (int) $this->encrypt->decode($encrypted_string);
        $this->load->view('web/include/header');
        $this->load->view('web/home/category', array('category_id' => $id));
        $this->load->view('web/include/footer');
    }

    private function viewlogout() {
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('logged_in');
        $this->session->set_flashdata('id ', NULL);
        $this->session->set_flashdata('username', NULL);
        $this->session->set_flashdata('role', NULL);
        $this->session->set_flashdata('logged_in', NULL);
        $this->session->sess_destroy();
        redirect("admin");
    }

}

?>
