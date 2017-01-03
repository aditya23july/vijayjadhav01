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
class Manageuser extends CI_Controller {
    //put your code here
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
    public function _remap($method,$param=array()){
        switch($method){
            
            case "add"   :   $this->addTax();
                               break;
            case "view"   :   $this->viewUser();
                               break; 
            case "block"   :   $this->blockUser($param[0],$param[1]);
                               break;
            case "viewuser"   :   $this->viewsingleUser($param[0]);
                               break;   
            case "vieworder"   :   $this->viewOrder($param[0]);
                               break; 
            case "edit"   :   $this->editTax($param[0]);
                               break;                
            default : $this->error();
                               break; 
        }
    }
    public function viewOrder($param){
        $replace = array("+", "-", "/", "=");
        $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
        $encrypted_string = str_replace($find, $replace, $param);
        $id = (int) $this->encrypt->decode($encrypted_string);
        $this->load->view('admin/include/header');
        $this->load->view('admin/user/vieworder', array('id' => $id));
        $this->load->view('admin/include/footer');
}
    public function viewsingleUser($param){
        $replace = array("+", "-", "/", "=");
        $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
        $encrypted_string = str_replace($find, $replace, $param);
        $id = (int) $this->encrypt->decode($encrypted_string);
        if(isset($_POST['submit'])){
                  $data = array(
                                'password' => md5('123456'),
                                'status' => 'ACTIVE',
                                'updated_date'=>Date('Y-m-d H:i:s'),
                                'updated_by'=>$this->session->userdata('id')
                                );
                  $this->db->where('id', $id);
                  $this->db->update('tbl_user_master', $data); 
        }
        $record = $this->db->query('select * from tbl_user_master where `id`= "' . $id . '"')->row();
        $this->load->view('admin/include/header');
        $this->load->view('admin/user/viewsingleUser', array('data' => $record,'param'=>$param));
        $this->load->view('admin/include/footer');
}
    public function blockUser($param,$val){
        $replace = array("+", "-", "/", "=");
        $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
        $encrypted_string = str_replace($find, $replace, $param);
        $id = (int) $this->encrypt->decode($encrypted_string);
if($val=='Y'){
$status='N';
}else if($val=='N'){
$status='Y';
}
                  $data = array(
                                
                                'is_blocked' => $status,
                                'updated_date'=>Date('Y-m-d H:i:s'),
                                'updated_by'=>$this->session->userdata('id')
                                );
                  $this->db->where('id', $id);
                  $this->db->update('tbl_user_master', $data); 
                  redirect('manageuser/view');


}
    public function addTax(){
        if($this->session->userdata('id')){
        $this->form_validation->set_rules('name', 'Tax Name', 'required');
        $this->form_validation->set_rules('taxvalue', 'Tax Value', 'required');
        $this->form_validation->set_rules('parent', 'Currency', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        if(isset($_POST['add'])){
             if ($this->form_validation->run() == TRUE){
                  $name     =   $this->security->xss_clean($this->input->post('name'));
                  $taxvalue     =   $this->security->xss_clean($this->input->post('taxvalue'));
                  $parent   =   $this->security->xss_clean($this->input->post('parent'));
                  $status   =   $this->security->xss_clean($this->input->post('status'));

                  try{
                  $data = array(
                                'title' => $name ,
                                'currency_id' => $parent,
                                'status' => $status,
                                'tax_value	'=>$taxvalue,
                                'created_date'=>Date('Y-m-d H:i:s'),
                                'created_by'=>$this->session->userdata('id')
                                );
                  $this->db->insert('tbl_tax_master', $data); 
                  redirect('managetax/add');
                  }catch(Exception $ex){
                      print_r($ex);
                  }
                  
             }
        }
             $this->load->view('admin/include/header');
             $this->load->view('admin/tax/addtax');
             $this->load->view('admin/include/footer');
        }else{
            redirect("admin");
        }
    }
     private function viewUser() {
        $this->load->view('admin/include/header');
        $this->load->view('admin/user/viewuser');
        $this->load->view('admin/include/footer');
    }
        private function editTax($param) {
        $replace = array("+", "-", "/", "=");
        $find = array("__ADD__", "__DASH__", "__SLASH__", "__EQUAL__");
        $encrypted_string = str_replace($find, $replace, $param);
        $id = (int) $this->encrypt->decode($encrypted_string);

        $this->form_validation->set_rules('name', 'Tax Name', 'required');
        $this->form_validation->set_rules('taxvalue', 'Tax Value', 'required');
        $this->form_validation->set_rules('parent', 'Currency', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        if(isset($_POST['edit'])){
             if ($this->form_validation->run() == TRUE){
                  $name     =   $this->security->xss_clean($this->input->post('name'));
                  $taxvalue     =   $this->security->xss_clean($this->input->post('taxvalue'));
                  $parent   =   $this->security->xss_clean($this->input->post('parent'));
                  $status   =   $this->security->xss_clean($this->input->post('status'));
                  try{
                  $data = array(
                                'title' => $name ,
                                'currency_id' => $parent,
                                'status' => $status,
                                'tax_value	'=>$taxvalue,
                                'updated_date'=>Date('Y-m-d H:i:s'),
                                'updated_by'=>$this->session->userdata('id')
                                );
                  $this->db->where('id', $id);
                  $this->db->update('tbl_tax_master', $data); 
                  redirect('managetax/view');
                  }catch(Exception $ex){
                      print_r($ex);
                  }
                  
             }
        }



        $record = $this->db->query('select * from tbl_tax_master where `id`= "' . $id . '"')->row();
        $this->load->view('admin/include/header');
        $this->load->view('admin/tax/edittax', array('data' => $record,'id' => $param));
        $this->load->view('admin/include/footer');
    }
    
      
}

?>
