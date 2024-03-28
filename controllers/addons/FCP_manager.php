<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FCP_manager extends CI_Controller
{ 
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->database();
        $this->load->library('session');
        $this->load->model('addons/FCP_model');
        // $this->load->library('stripe');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');

        if(!$this->session->userdata('user_id')){
            $this->session->set_flashdata('error_message', get_phrase('please_login_first'));
            redirect('home/login', 'refresh');
        }
    }

    public function all_FCPs(){
        $page_data['page_title'] = 'FCP list';
        if($this->session->userdata('user_login')){
            $page_data['FCPs'] = $this->FCP_model->get_FCPs_by_user_id();
        }else{
            $page_data['FCPs'] = $this->FCP_model->get_all_FCPs();
        }
        $page_data['page_name'] = 'all_FCPs';
        $this->load->view('backend/index',$page_data);
    }
    
    public function add_FCP()
    {
        $page_data['page_title'] = 'Add FCP';
        $page_data['page_name'] = 'add_FCP';
        $this->load->view('backend/index',$page_data);
    }

   

    //FCP category management

    public function FCP_category($param1 = "", $param2 = "")
    {
        if($param1 == "add"){
            $status = $this->FCP_model->add_FCP_category();
            if($status){
                $this->session->set_flashdata('flash_message', get_phrase('FCP_category_added_successfully'));
            }else{
                $this->session->set_flashdata('error_message', get_phrase('there_is_already_a_FCP_category_with_this_name'));
            }
        redirect(site_url('addons/FCP_manager/FCP_category'), 'refresh');

        }
        if($param1 == "delete"){
            $response = $this->FCP_model->delete_FCP_category($param2);
            $this->session->set_flashdata('flash_message', get_phrase('FCP_category_deleted_successfully'));
            redirect(site_url('addons/FCP_manager/FCP_category'), 'refresh');
        }
        if($param1 == "update")
        {
            $response = $this->FCP_model->update_FCP_category($param2);
            if($response == true){
                $this->session->set_flashdata('flash_message', get_phrase('FCP_category_updated_successfully'));
            }else{
                $this->session->set_flashdata('error_message', get_phrase('there_is_already_a_FCP_with_this_name'));
            }
            redirect(site_url('addons/FCP_manager/FCP_category'), 'refresh');
        }

        $page_data['categories'] = $this->FCP_model->get_FCP_categories();
        $page_data['page_title'] = 'FCP Category';
        $page_data['page_name'] = 'FCP_category';
        $this->load->view('backend/index', $page_data);
    }

    public function add_FCP_category(){
        $this->load->view("backend/admin/FCP_category_add");
    }
    
    
    public function edit_FCP_category($category_id = ""){
        $data['FCP_category'] = $this->FCP_model->get_FCP_categories($category_id)->row_array();
        $this->load->view('backend/admin/FCP_category_edit', $data);
    }
    //coupon management
    public function coupon_FCP_show($coupon = ""){
        $data['Coupon']=$coupon;
        $this->load->view("FCP_view/FCP_Coupon",$data);
    }

    //Publisher
    public function add_FCP_Publisher(){
        $this->load->view("backend/admin/FCP_Publisher_add");
    }
    public function edit_FCP_Publisher($Publisher_id = ""){
        $data['FCP_Publisher'] = $this->FCP_model->get_FCP_Publishers($Publisher_id)->row_array();
        $this->load->view('backend/admin/FCP_Publisher_edit', $data);
    }
    public function FCP_Publisher($param1 = "", $param2 = "")
    {
        if($param1 == "add"){
            $status = $this->FCP_model->add_FCP_Publisher();
            if($status){
                $this->session->set_flashdata('flash_message', get_phrase('FCP_Publisher_added_successfully'));
            }else{
                $this->session->set_flashdata('error_message', get_phrase('there_is_already_a_FCP_Publisher_with_this_name'));
            }
        redirect(site_url('addons/FCP_manager/FCP_Publisher'), 'refresh');

        }
        if($param1 == "delete"){
            $response = $this->FCP_model->delete_FCP_Publisher($param2);
            $this->session->set_flashdata('flash_message', get_phrase('FCP_Publisher_deleted_successfully'));
            redirect(site_url('addons/FCP_manager/FCP_Publisher'), 'refresh');
        }
        if($param1 == "update")
        {
            $response = $this->FCP_model->update_FCP_Publisher($param2);
            if($response == true){
                $this->session->set_flashdata('flash_message', get_phrase('FCP_Publisher_updated_successfully'));
            }else{
                $this->session->set_flashdata('error_message', get_phrase('there_is_already_a_FCP_with_this_name'));
            }
            redirect(site_url('addons/FCP_manager/FCP_Publisher'), 'refresh');
        }

        $page_data['Publishers'] = $this->FCP_model->get_FCP_Publishers();
        $page_data['page_title'] = 'FCP Publisher';
        $page_data['page_name'] = 'FCP_Publisher';
        $this->load->view('backend/index', $page_data);
    }
    //FCP management
    public function edit_FCP($FCP_id = " ")
    {
       
        $page_data['FCP'] = $this->FCP_model->get_FCPs_list($FCP_id)->row_array();
        $page_data['page_title'] = get_phrase('edit_FCP');
        $page_data['page_name'] = 'FCP_edit';
        $this->load->view('backend/index', $page_data);
    }
    public function FCP($param1 = "", $param2 = "")
    {
        if($param1 == "add"){
            $response = $this->FCP_model->add_FCP();
            if($response){
                $this->session->set_flashdata('flash_message', get_phrase('FCP_added_successfully'));
            }else{
                $this->session->set_flashdata('error_message', get_phrase('FCP_add_unccessfull'));

            }
            redirect(site_url("addons/FCP_manager/FCP"), 'refresh');
        }
        if($param1 == "update"){
            $response = $this->FCP_model->update_FCP($param2);
            if($response){
                $this->session->set_flashdata('flash_message', get_phrase('FCP_updated_successfully'));
            }else{
                $this->session->set_flashdata('error_message', get_phrase('FCP_update_unsuccessfull'));

            }
            redirect(site_url("addons/FCP_manager/FCP"), 'refresh');
        }
        if($param1 == "status" && $this->session->userdata('admin_login')){
            $response = $this->FCP_model->update_FCP_status($param2);
            if($response){
                $this->session->set_flashdata('flash_message', get_phrase('FCP_activate_successfully'));
            }else{
                $this->session->set_flashdata('flash_message', get_phrase('FCP_deactivate_successfully'));

            }
            redirect(site_url("addons/FCP_manager/FCP"), 'refresh');

        }
        if($param1 == "delete"){
            $response = $this->FCP_model->delete_FCP($param2);
            if($response){
                $this->session->set_flashdata('error_message', get_phrase('FCP_deleted_successfully'));
            }else{
                $this->session->set_flashdata('error_message', get_phrase('FCP_delete_unsuccessfull'));

            }
            redirect(site_url("addons/FCP_manager/FCP"), 'refresh');
        }

        if($this->session->userdata('user_login')){
            $page_data['FCPs'] = $this->FCP_model->get_FCPs_by_user_id()->result_array();
        }else{
            $page_data['FCPs'] = $this->FCP_model->get_all_FCPs();
        }
        $page_data['page_name'] = 'all_FCPs';
        $page_data['page_title'] = "FCP_list";
        $this->load->view('backend/index', $page_data);
    }
    /*
    public function payment_history($revenue_type = "", $param1 = "")
    {
        if ($param1 != "") {
            $date_range                   = $this->input->get('date_range');
            $date_range                   = explode(" - ", $date_range);
            $page_data['timestamp_start'] = strtotime($date_range[0] . ' 00:00:00');
            $page_data['timestamp_end']   = strtotime($date_range[1] . ' 23:59:59');
        } else {
            $page_data['timestamp_start'] = strtotime(date("m/01/Y 00:00:00"));
            $page_data['timestamp_end']   = strtotime(date("m/t/Y 23:59:59"));
        }

        if($revenue_type == "admin_revenue" && $this->session->userdata('admin_login')){
            $page_data['payment_history'] = $this->FCP_model->get_revenue_by_user_type($page_data['timestamp_start'], $page_data['timestamp_end'], 'admin_revenue');
            $page_data['page_title'] = "FCP_admin_revenue";
            $page_data['page_name'] = "FCP_admin_revenue";
            $this->load->view('backend/index', $page_data);
        }else{
            $page_data['payment_history'] = $this->FCP_model->get_revenue_by_user_type($page_data['timestamp_start'], $page_data['timestamp_end'], 'instructor_revenue');
            $page_data['page_title'] = "FCP_instructor_revenue";
            $page_data['page_name'] = "FCP_instructor_revenue";
            $this->load->view('backend/index', $page_data);

        }

    }
    */

    
}