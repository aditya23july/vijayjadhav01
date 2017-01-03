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
class Admin extends CI_Controller {
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
            
            case "index"   :   $this->viewIndex($param);
                               break;
            case "dashboard"   :   $this->viewdashboard($param);
                               break; 
            case "logout"   :   $this->viewlogout($param);
                               break;                
            default : $this->error();
                               break; 
        }
    }
    private function viewIndex(){
        $this->load->view('admin/login/login_header');
        $data['error_message']='';
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('username', 'UserName', 'required');
        if(isset($_POST['submit'])){
            if ($this->form_validation->run() == TRUE){
             $username   =   $this->security->xss_clean($this->input->post('username'));
             $password   =   md5($this->security->xss_clean($this->input->post('password')));
             $login=$this->db->query('select * from tbl_user_master where `username`="'.$username.'" and `password`="'.$password.'"')->row();
             if(count($login)){
                 $session_data = array(
                                    'id'     => $login->id,
                                    'username'  => $username,
                                    'name'  => $login->name,
                                    'role'     => $login->role_id,
                                    'logged_in' => TRUE
                                    );
                $this->session->set_userdata($session_data);
                redirect("admin/dashboard");
             }else{
                  $data['error_message']='Authentication Failed';
             }
             
            }
        }
        $this->load->view('admin/login/login',$data);
        $this->load->view('admin/login/login_footer');
    }
    public function viewdashboard(){
        if($this->session->userdata('id')){
             $this->load->view('admin/include/header');
             $this->load->view('admin/dashboard');
             $this->load->view('admin/include/footer');
        }else{
            redirect("admin");
        }
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
