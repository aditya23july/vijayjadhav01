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
class ManageCategory extends CI_Controller {
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
        if($this->session->userdata('id')){
            switch($method){

                case "index"   :    $this->viewIndex($param);
                                    break;
                case "new"   :      $this->addNewCategory($param);
                                    break; 
                case "update"   :   $this->updateOldCategory($param[0]);
                                    break;                
                default : $this->error();
                                   break; 
            }
        }else{
            redirect('admin');
        }
        
    }
    private function updateOldCategory($param){
        $replace=array("+","-","/","=");
        $find=array("__ADD__","__DASH__","__SLASH__","__EQUAL__");
        $encrypted_string=str_replace($find,$replace,$param);
        $id = (int)$this->encrypt->decode($encrypted_string);
        $this->form_validation->set_rules('name', 'Category Name', 'required');
        $this->form_validation->set_rules('parent', 'Parent Category', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        if(isset($_POST['add'])){
             if ($this->form_validation->run() == TRUE){
                  $name     =   $this->security->xss_clean($this->input->post('name'));
                  $parent   =   $this->security->xss_clean($this->input->post('parent'));
                  $status   =   $this->security->xss_clean($this->input->post('status'));
                  if($parent==0){
                      $level=1;
                  }else{
                      $level=2;
                  }
                  try{
                  $data = array(
                                'category_name' => $name ,
                                'catogory_level' => $level,
                                'status' => $status,
                                'parent_category_id'=>$parent,
                                'updated_date'=>Date('Y-m-d H:i:s'),
                                'updated_by'=>$this->session->userdata('id')
                                );
                  $this->db->where('category_id', $id);
                  $this->db->update('tbl_category_master', $data); 
                  redirect('managecategory/index');
                  }catch(Exception $ex){
                      print_r($ex);
                  }
                  
             }
        }
        $record=$this->db->query('select * from tbl_category_master where `category_id`= "'.$id.'"')->row();
        $this->load->view('admin/include/header');
        $this->load->view('admin/category/update',array('data'=>$record));
        $this->load->view('admin/include/footer');
    }
    private function viewIndex(){
        $this->load->view('admin/include/header');
        $this->load->view('admin/category/index');
        $this->load->view('admin/include/footer');
    }
    private function addNewCategory(){
        $this->load->view('admin/include/header');
        $this->form_validation->set_rules('name', 'Category Name', 'required|callback_category_check');
        $this->form_validation->set_rules('parent', 'Parent Category', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        if(isset($_POST['add'])){
             if ($this->form_validation->run() == TRUE){
                  $name     =   $this->security->xss_clean($this->input->post('name'));
                  $parent   =   $this->security->xss_clean($this->input->post('parent'));
                  $status   =   $this->security->xss_clean($this->input->post('status'));
                  if($parent==0){
                      $level=1;
                  }else{
                      $level=2;
                  }
                  try{
                  $data = array(
                                'category_name' => $name ,
                                'catogory_level' => $level,
                                'status' => $status,
                                'parent_category_id'=>$parent,
                                'created_date'=>Date('Y-m-d H:i:s'),
                                'created_by'=>$this->session->userdata('id')
                                );
                  $this->db->insert('tbl_category_master', $data); 
                  redirect('managecategory/index');
                  }catch(Exception $ex){
                      print_r($ex);
                  }
                  
             }
        }
        $this->load->view('admin/category/add');
        $this->load->view('admin/include/footer');
    }
      public function category_check($str)
        {
                $record=$this->db->query('select * from tbl_category_master where `category_name`like "'.$str.'"')->row();
                  if(count($record)>0)
                {
                        $this->form_validation->set_message('category_check', 'The Category is already Exist');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }
      
}

?>
