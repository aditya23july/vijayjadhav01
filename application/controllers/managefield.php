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
class ManageField extends CI_Controller {
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
        if($this->session->userdata('id')){
            switch($method){

                case "index"   :    $this->viewIndex($param);
                                    break;
                case "new"   :      $this->addNewField($param);
                                    break; 
                case "update"   :   $this->updateOldField($param[0]);
                                    break;                
                default : $this->error();
                                   break; 
            }
        }else{
            redirect('admin');
        }
        
    }
   private function addNewField(){
        $this->load->view('admin/include/header');
        $this->form_validation->set_rules('title', 'Field Title', 'required|callback_field_check');
        $this->form_validation->set_rules('type', 'Field Type', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        if(isset($_POST['add'])){
             if ($this->form_validation->run() == TRUE){
                  $title     =   $this->security->xss_clean($this->input->post('title'));
                  $type   =   $this->security->xss_clean($this->input->post('type'));
                  $status   =   $this->security->xss_clean($this->input->post('status'));
                  
                  try{
                  $data = array(
                                'field_title' => $title ,
                                'field_type' => $type,
                                'status' => $status,
                              
                                'created_date'=>Date('Y-m-d H:i:s'),
                                'created_by'=>$this->session->userdata('id')
                                );
                  $this->db->insert('tbl_field_master', $data); 
                  redirect('managefield/index');
                  }catch(Exception $ex){
                      print_r($ex);
                  }
                  
             }
        }
        $this->load->view('admin/field/add');
        $this->load->view('admin/include/footer');
    }
      public function field_check($str)
        {
                $record=$this->db->query('select * from tbl_field_master where `field_title`like "'.$str.'"')->row();
                  if(count($record)>0)
                {
                        $this->form_validation->set_message('field_check', 'The Field Title is already Exist');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }
     private function viewIndex(){
        $this->load->view('admin/include/header');
        $this->load->view('admin/field/index');
        $this->load->view('admin/include/footer');
    }
    private function updateOldField($param){
        $replace=array("+","-","/","=");
        $find=array("__ADD__","__DASH__","__SLASH__","__EQUAL__");
        $encrypted_string=str_replace($find,$replace,$param);
        $id = (int)$this->encrypt->decode($encrypted_string);
          $this->form_validation->set_rules('title', 'Field Title', 'required');
        $this->form_validation->set_rules('type', 'Field Type', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $title     =   $this->security->xss_clean($this->input->post('title'));
                  $type   =   $this->security->xss_clean($this->input->post('type'));
                  $status   =   $this->security->xss_clean($this->input->post('status'));
        if(isset($_POST['add'])){
             if ($this->form_validation->run() == TRUE){
                  $title     =   $this->security->xss_clean($this->input->post('title'));
                  $type   =   $this->security->xss_clean($this->input->post('type'));
                  $status   =   $this->security->xss_clean($this->input->post('status'));
                 
                  try{
                  $data = array(
                                'field_title' => $title ,
                                'field_type' => $type,
                                'status' => $status,
                              
                                'updated_date'=>Date('Y-m-d H:i:s'),
                                'updated_by'=>$this->session->userdata('id')
                                );
                  $this->db->where('id', $id);
                  $this->db->update('tbl_field_master', $data); 
                  redirect('managefield/index');
                  }catch(Exception $ex){
                      print_r($ex);
                  }
                  
             }
        }
        $record=$this->db->query('select * from tbl_field_master where `id`= "'.$id.'"')->row();
        $this->load->view('admin/include/header');
        $this->load->view('admin/field/update',array('data'=>$record));
        $this->load->view('admin/include/footer');
    }
}

?>