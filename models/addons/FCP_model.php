<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH."libraries/razorpay-php/Razorpay.php");
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
class FCP_model extends CI_Model
{


    public function get_category_id($slug = "")
    {
        $category_details = $this->db->get_where("FCP_category", array("slug" => $slug))->row_array();
        return $category_details['category_id'];
    }
    public function get_categories($param1 = "")
    {
        if($param1 != ""){
            $this->db->where('category_id',$param1);
        }
        return $this->db->get('FCP_category');
    }

    public function get_active_FCP(){
        $this->db->where('is_active', 1);
        return $this->db->get('FCP');
    }
    public function get_active_addon_by_category_id($category_id = "", $category_id_type = "category_id"){
        $this->db->where($category_id_type, $category_id);
        $this->db->where('is_active', 1);
        return $this->db->get('FCP');
    }
    public function get_category_details_by_id($id)
    {
        return $this->db->get_where('FCP_category', array('category_id' => $id));
    }
    function filter_FCP($selected_category_id = "", $selected_price = "", $selected_rating = "", $search_text ="")
    {

        $FCP_ids = array();
        if ($selected_category_id != "all") {
            $category_id = $this->get_category_details_by_id($selected_category_id)->row('category_id');
        }

        if ($selected_rating != "all") {
            $this->db->where('is_active', 1);
            $FCPs = $this->db->get('FCP')->result_array();
            foreach ($FCPs as $key => $FCP) {
                $total_rating =  $this->get_ratings( $FCP['FCP_id'], true)->row()->rating;
                $number_of_ratings = $this->get_ratings($FCP['FCP_id'])->num_rows();
                if ($number_of_ratings > 0) {
                    $average_ceil_rating = ceil($total_rating / $number_of_ratings);
                    if ($average_ceil_rating == $selected_rating) {
                        array_push($FCP_ids, $FCP['FCP_id']);
                    }
                    
                }
                
            }
        }

        if($search_text != ""){
            $this->db->group_start();
            
            $this->db->like('title', $search_text);
            $this->db->or_like('description', $search_text)->group_end();
        }
        
        if ($selected_category_id != "all") {
            
            $this->db->where('category_id', $category_id);
        }
        
        if ($selected_price != "all") {
            if ($selected_price == "paid") {
               
                $this->db->where('is_free', 0);
            } elseif ($selected_price == "free") {
               
                $this->db->where('is_free', 1);
            }
        }

        if ($selected_rating != "all") {
            if(!empty($FCP_ids)){
                $this->db->where_in('FCP_id', $FCP_ids);

            }else{
                $this->db->where_in('FCP_id', "");
            }
        }
        $this->db->where('is_active', 1);
            
        return $this->db->get('FCP')->result_array();
        
           
        
    }

    public function get_ratings ($ratable_id = "", $is_sum = false)
    {
        if ($is_sum) {
            $this->db->select_sum('rating');
            return $this->db->get_where('FCP_reviews', array('FCP_id' => $ratable_id));
        } else {
            return $this->db->get_where('FCP_reviews', array('FCP_id' => $ratable_id));
        }
    }

    function get_user_rating($user_id = "", $FCP_id = ""){
        $this->db->where('user_id', $user_id);
        $this->db->where('FCP_id', $FCP_id);
        return $this->db->get('FCP_reviews');
    }

    public function get_FCP_thumbnail_url($FCP_id = '')
    {
        $thumb = $this->db->get_where('FCP', array('FCP_id' => $FCP_id))->row('thumbnail');
       
        if (file_exists('uploads/FCP/thumbnails/' . $thumb))
            return base_url() . 'uploads/FCP/thumbnails/' . $thumb;
        else
            return base_url() . 'uploads/FCP/thumbnails/placeholder.png';
    }

    public function get_FCP_banner_url($FCP_id = ''){
        $banner = $this->db->get_where('FCP', array('FCP_id' => $FCP_id))->row('banner');
        if(file_exists('uploads/FCP/banner/'. $banner))
            return base_url() . 'uploads/FCP/banner/' . $banner;
        else
            return base_url() . 'uploads/FCP/banner/placeholder.png';
    }

    public function get_FCP_by_id($FCP_id = "")
    {
       return $this->db->get_where("FCP", array("FCP_id" => $FCP_id));

    }
    public function get_FCPs_by_user_id($user_id = "", $FCP_id = "")
    {
        if($user_id == ""){
            $this->db->where('user_id', $this->session->userdata('user_id'));
        }
        if($FCP_id > 0){
            $this->db->where('FCP_id', $FCP_id);
        }
       return $this->db->get("FCP");

    }
    public function get_FCPs($category_id = "",  $instructor_id = 0)
    {
        if ($category_id > 0 && $instructor_id > 0) {

            $multi_instructor_course_ids = $this->multi_instructor_course_ids_for_an_instructor($instructor_id);
            $this->db->where('category_id', $category_id);
            $this->db->where('user_id', $instructor_id);

            if ($multi_instructor_course_ids && count($multi_instructor_course_ids)) {
                $this->db->or_where_in('id', $multi_instructor_course_ids);
            }

            return $this->db->get('FCP');
        } elseif ($category_id > 0  && $instructor_id == 0) {
            return $this->db->get_where('FCP', array('category_id' => $category_id));
        } else {
            return $this->db->get('FCP');
        }
    }

    public function get_percentage_of_specific_rating($rating = "", $ratable_type = "", $ratable_id = "")
    {
        $number_of_user_rated = $this->db->get_where('FCP_reviews', array(
            // 'ratable_type' => $ratable_type,
            'FCP_id'   => $ratable_id
        ))->num_rows();

        $number_of_user_rated_the_specific_rating = $this->db->get_where('FCP_reviews', array(
            // 'ratable_type' => $ratable_type,
            'FCP_id'   => $ratable_id,
            'rating'       => $rating
        ))->num_rows();

        //return $number_of_user_rated.' '.$number_of_user_rated_the_specific_rating;
        if ($number_of_user_rated_the_specific_rating > 0) {
            $percentage = ($number_of_user_rated_the_specific_rating / $number_of_user_rated) * 100;
        } else {
            $percentage = 0;
        }
        return floor($percentage);
    }
    public function get_user($user_id = 0)
    {
        if ($user_id > 0) {
            $this->db->where('id', $user_id);
        }
        // $this->db->where('role_id', 2);
        return $this->db->get('users');
    }

    //backend

    public function get_all_FCPs()
    {
        $this->db->order_by('FCP_id', 'desc');
        return $this->db->get('FCP')->result_array();
    }
    function get_FCP_categories($FCP_category_id = ""){
        if($FCP_category_id > 0){
            $this->db->where('category_id', $FCP_category_id);
        }
        return $this->db->get('FCP_category');
    }

    public function get_FCPs_list($FCP_id = " ")
    {
        if($FCP_id > 0){
            $this->db->where('FCP_id',$FCP_id);
        }
       
        $this->db->where("is_active", 1);
        $this->db->order_by('FCP_id', 'desc');
        return $this->db->get('FCP');
    }
    public function get_FCPs_by_category_id($category_id = ""){
        $this->db->where('category_id', $category_id);
        $this->db->where('is_active', 1);
        return $this->db->get('FCP');
    }

    public function add_FCP(){
        $data['title'] = htmlspecialchars($this->input->post('title'));
        $data['description'] = htmlspecialchars(remove_js($this->input->post('description', false)));
        $data['category_id'] = htmlspecialchars($this->input->post('category_id'));
        echo $_FILES['banner']['name'];
        echo $_FILES['thumbnail']['name'];
        // $ext  = (new SplFileInfo($path))->getExtension();
        if ($_FILES['thumbnail']['name'] != "") {
            $ext  = (new SplFileInfo($_FILES['thumbnail']['name']))->getExtension();
            $data['thumbnail'] = md5(rand(10000000, 20000000)) .'.'. $ext;
            move_uploaded_file($_FILES['thumbnail']['tmp_name'], 'uploads/FCP/thumbnails/' . $data['thumbnail']);
        }else{
            $data['thumbnail'] = 'placeholder.png';
        }

        if ($_FILES['banner']['name'] != "") {
            $ext  = (new SplFileInfo($_FILES['banner']['name']))->getExtension();
            $data['banner'] = md5(rand(10000000, 20000000)) .'.'. $ext;
            move_uploaded_file($_FILES['banner']['tmp_name'], 'uploads/FCP/banner/' . $data['banner']);
        }else{
            $data['banner'] = 'placeholder.png';
        }
        if ($_FILES['FCP_preview_file']['name'] != "") {
            $ext  = (new SplFileInfo($_FILES['FCP_preview_file']['name']))->getExtension();
            $data['preview'] = md5(rand(10000000, 20000000)) .'.'. $ext;
            move_uploaded_file($_FILES['FCP_preview_file']['tmp_name'], 'uploads/FCP/file/FCP_preview/' . $data['preview']);
        }
        if ($_FILES['FCP_complete_file']['name'] != "") {
            $ext  = (new SplFileInfo($_FILES['FCP_complete_file']['name']))->getExtension();
            $data['file'] = md5(rand(10000000, 20000000)) .'.'. $ext;
            move_uploaded_file($_FILES['FCP_complete_file']['tmp_name'], 'uploads/FCP/file/FCP_full/' .$data['file']);
        }
        $data['user_id'] = $this->session->userdata('user_id');
      

        $data['price'] = $this->input->post('price');
        $flag = $this->input->post('discount_flag');
        $free = $this->input->post('is_free');
        $data['publication_name'] = $this->input->post('publication_name');
        $data['edition'] = $this->input->post('edition');
        if($flag != 1){
            $flag = 0;

        }
        if($free != 1){
            $free = 0;
        }
        if($this->session->userdata('admin_login')){
            $data['is_active'] = 1;
        }
        else{
            $data['is_active'] = 0;
        }
        $data['discounted_price'] = $this->input->post('discounted_price');
        $data['is_free'] = $free;
        $data['discount_flag'] = $flag;
        $data['added_date'] = strtotime(date('D, d-M-Y'));

        $this->db->insert('FCP', $data);
        return true;
    }

    public function update_FCP($FCP_id = ""){
        $data['title'] = htmlspecialchars($this->input->post('title'));
        $data['description'] = htmlspecialchars(remove_js($this->input->post('description', false)));
        $data['category_id'] = htmlspecialchars($this->input->post('category_id'));
        $FCP = $this->get_FCP_by_id($FCP_id)->row_array();
        if ($_FILES['thumbnail']['name'] != "") {
            $ext  = (new SplFileInfo($_FILES['thumbnail']['name']))->getExtension();
            unlink('uploads/FCP/thumbnails/'.$FCP['thumbnail']);
            $data['thumbnail'] = md5(rand(10000000, 20000000)) .'.'. $ext;
            move_uploaded_file($_FILES['thumbnail']['tmp_name'], 'uploads/FCP/thumbnails/' . $data['thumbnail']);
        }
        if ($_FILES['banner']['name'] != "") {
            $ext  = (new SplFileInfo($_FILES['banner']['name']))->getExtension();
            unlink('uploads/FCP/banner/'.$FCP['banner']);
            $data['banner'] = md5(rand(10000000, 20000000)) .'.'. $ext;
            move_uploaded_file($_FILES['banner']['tmp_name'], 'uploads/FCP/banner/' . $data['banner']);
        }
        if ($_FILES['FCP_preview_file']['name'] != "") {
            $ext  = (new SplFileInfo($_FILES['FCP_preview_file']['name']))->getExtension();
            unlink('uploads/FCP/file/FCP_preview/'.$FCP['preview']);
            $data['preview'] = md5(rand(10000000, 20000000)) .'.'. $ext;
            move_uploaded_file($_FILES['FCP_preview_file']['tmp_name'], 'uploads/FCP/file/FCP_preview/' . $data['preview']);
        }
        if ($_FILES['FCP_complete_file']['name'] != "") {
            unlink('uploads/FCP/file/FCP_full/'.$FCP['file']);
            $ext  = (new SplFileInfo($_FILES['FCP_complete_file']['name']))->getExtension();
            $data['file'] = md5(rand(10000000, 20000000)) .'.'. $ext;
            move_uploaded_file($_FILES['FCP_complete_file']['tmp_name'], 'uploads/FCP/file/FCP_full/' .$data['file']);
        }
      

        $data['price'] = $this->input->post('price');
        $flag = $this->input->post('discount_flag');
        $free = $this->input->post('is_free');
        $data['publication_name'] = $this->input->post('publication_name');
        $data['edition'] = $this->input->post('edition');
        if($flag != 1){
            $flag = 0;

        }
        if($free != 1){
            $free = 0;
        }

        $data['discounted_price'] = $this->input->post('discounted_price');
        $data['is_free'] = $free;
        $data['discount_flag'] = $flag;
        $data['added_date'] = strtotime(date('D, d-M-Y'));

        if($this->session->userdata('user_login')){
            $this->db->where('user_id', $this->session->userdata('user_id'));
        }
        
        $this->db->where('FCP_id',$FCP_id);
        $this->db->update('FCP', $data);
        return true;
    }

    public function update_FCP_status($FCP_id = ""){
        $FCP = $this->get_FCP_by_id($FCP_id)->row_array();
        if($FCP['is_active'] == 0){
            $this->db->where('FCP_id', $FCP_id);
            $this->db->update('FCP', array('is_active' => 1));
            return true;
        }
        if($FCP['is_active'] == 1){
            $this->db->where('FCP_id', $FCP_id);
            $this->db->update('FCP', array('is_active' => 0));
            return false;
        }
        
    }

    public function delete_FCP($FCP_id = "")
    {
        if($this->session->userdata('user_login')){
            $this->db->where('user_id', $this->session->userdata('user_id'));
        }
        $this->db->where('FCP_id', $FCP_id);
        $this->db->delete('FCP');

        return true;

    }

    public function add_FCP_category()
    {
        $data['title'] = htmlspecialchars($this->input->post('title'));
        $data['slug'] = slugify($data['title']);
        // $data['thumbnail'] = htmlspecialchars($this->input->post('thumbnail'));
        $data['added_date'] = time();
        if (!file_exists('uploads/FCP/thumbnails/category_thumbnails')) {
            mkdir('uploads/FCP/thumbnails/category_thumbnails', 0777, true);
        }
        elseif ($_FILES['category_thumbnail']['name'] == "") {
            $data['thumbnail'] = 'category-thumbnail.png';
        } 
        else {
            $data['thumbnail'] = md5(rand(10000000, 20000000)) . '.jpg';
            move_uploaded_file($_FILES['category_thumbnail']['tmp_name'], 'uploads/FCP/thumbnails/category_thumbnails/' . $data['thumbnail']);
        }
        
        $this->db->where('slug', $data['slug']);
        $row = $this->db->get('FCP_category');

        if($row->num_rows() > 0)
        {
            return false;
        }else{
            $this->db->insert('FCP_category', $data);
            return true;
        }

    }
    function delete_FCP_category($category_id = ""){
        $this->db->where('category_id', $category_id);
        $this->db->delete('FCP_category');
    }
    function update_FCP_category($category_id = ""){
        $data['title'] = htmlspecialchars($this->input->post('title'));
        $data['slug'] = slugify($data['title']);
        // $data['thumbnail'] = htmlspecialchars($this->input->post('thumbnail'));
        $data['added_date'] = time();
        if (!file_exists('uploads/FCP/thumbnails/category_thumbnails')) {
            mkdir('uploads/FCP/thumbnails/category_thumbnails', 0777, true);
        }
        elseif ($_FILES['category_thumbnail']['name'] == "") {
            $data['thumbnail'] = 'category-thumbnail.png';
        } 
        else {
            $data['thumbnail'] = md5(rand(10000000, 20000000)) . '.jpg';
            move_uploaded_file($_FILES['category_thumbnail']['tmp_name'], 'uploads/FCP/thumbnails/category_thumbnails/' . $data['thumbnail']);
        }
        
        $this->db->where('slug', $data['slug']);
        $row = $this->db->get('FCP_category');
        if($row->num_rows() > 0 && $row->row('category_id') != $category_id){
            return false;
        }else{
            $this->db->where('category_id', $category_id);
            $this->db->update('FCP_category', $data);
            return true;
        }
    }

    public function get_instructor_wise_FCPs($instructor_id = "", $return_as = "")
    {
        
        $this->db->where('user_id', $instructor_id);

        

        $FCPs = $this->db->get('FCP');
       
        
        if ($return_as == 'simple_array') {
            $array = array();
            foreach ($FCPs->result_array() as $FCP) {
                if (!in_array($FCP['FCP_id'], $array)) {
                    array_push($array, $FCP['FCP_id']);
                }
            }
            return $array;
        } else {
            
            return $FCPs;
        }
    }
    public function get_instructor_wise_FCP_ratings($instructor_id = "", $ratable_type = "", $is_sum = false)
    {
       
        $FCP_ids = $this->get_instructor_wise_FCPs($instructor_id, 'simple_array');
        if ($is_sum) {
            $this->db->where('ratable_type', $ratable_type);
            $this->db->where_in('ratable_id', $course_ids);
            $this->db->select_sum('rating');
            return $this->db->get('rating');
        } else {
            // $this->db->where('ratable_type', $ratable_type);
            $this->db->where_in('FCP_id', $FCP_ids);
            return $this->db->get('FCP_reviews');
        }
    }

    function my_FCPs(){
        $data['user_id'] = $this->session->userdata('user_id');
        $FCP_payments = $this->db->get_where('FCP_payment', array('user_id' =>$data['user_id']))->result_array();

        $arr = array(0);
        foreach($FCP_payments as $FCP_payment):
            array_push($arr, $FCP_payment['FCP_id']);
        endforeach;
        $this->db->where('is_active', 1);
        $this->db->where_in('FCP_id', $arr);
        return $this->db->get('FCP');

    }
    
    public function courses_by_search_string_get($search_string)
	{
		$this->db->like('title', $search_string);
		$this->db->where('status', 'active');
		$courses = $this->db->get('course')->result_array();
		return $this->api_model->course_data($courses);
	}
    /*
    // VALIDATE STRIPE PAYMENT
    public function stripe_payment($user_id = "", $session_id = "") {
        $stripe_keys = get_settings('stripe_keys');
        $values = json_decode($stripe_keys);
        if ($values[0]->testmode == 'on') {
            $public_key = $values[0]->public_key;
            $secret_key = $values[0]->secret_key;
        } else {
            $public_key = $values[0]->public_live_key;
            $secret_key = $values[0]->secret_live_key;
        }


        // Stripe API configuration
        define('STRIPE_API_KEY', $secret_key);
        define('STRIPE_PUBLISHABLE_KEY', $public_key);

        $status_msg = '';
        $transaction_id = '';
        $paid_amount = '';
        $paid_currency = '';
        $payment_status = '';

        // Check whether stripe checkout session is not empty
        if($session_id != ""){
            //$session_id = $_GET['session_id'];

            // Include Stripe PHP library
            require_once APPPATH.'libraries/Stripe/init.php';

            // Set API key
            \Stripe\Stripe::setApiKey(STRIPE_API_KEY);

            // Fetch the Checkout Session to display the JSON result on the success page
            try {
                $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);
            }catch(Exception $e) {
                $api_error = $e->getMessage();
            }

            if(empty($api_error) && $checkout_session){
                // Retrieve the details of a PaymentIntent
                try {
                    $intent = \Stripe\PaymentIntent::retrieve($checkout_session->payment_intent);
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    $api_error = $e->getMessage();
                }

                // Retrieves the details of customer
                try {
                    // Create the PaymentIntent
                    $customer = \Stripe\Customer::retrieve($checkout_session->customer);
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    $api_error = $e->getMessage();
                }

                if(empty($api_error) && $intent){
                    // Check whether the charge is successful
                    if($intent->status == 'succeeded'){
                        // Customer details
                        $name = $customer->name;
                        $email = $customer->email;

                        // Transaction details
                        $transaction_id = $intent->id;
                        $paid_amount = ($intent->amount/100);
                        $paid_currency = $intent->currency;
                        $payment_status = $intent->status;

                        // If the order is successful
                        if($payment_status == 'succeeded'){
                            $status_msg = get_phrase("Your_Payment_has_been_Successful");
                        }else{
                            $status_msg = get_phrase("Your_Payment_has_failed");
                        }
                    }else{
                        $status_msg = get_phrase("Transaction_has_been_failed");;
                    }
                }else{
                    $status_msg = get_phrase("Unable_to_fetch_the_transaction_details"). ' ' .$api_error;
                }

                $status_msg = 'success';
            }else{
                $status_msg = get_phrase("Transaction_has_been_failed").' '.$api_error;
            }
        }else{
            $status_msg = get_phrase("Invalid_Request");
        }

        $response['status_msg'] = $status_msg;
        $response['transaction_id'] = $transaction_id;
        $response['paid_amount'] = $paid_amount;
        $response['paid_currency'] = $paid_currency;
        $response['payment_status'] = $payment_status;
        $response['stripe_session_id'] = $session_id;
        $response['payment_method'] = 'stripe';

        return $response;
    }

    function FCP_purchase($method = "",$FCP_id= "", $amount = "", $transaction_id = "", $session_id = ""){
     

        $FCP_details = $this->FCP_model->get_FCP_by_id($FCP_id)->row_array();
            if($FCP_details['discount_flag'] == 1)
            {
                $data['paid_amount'] =  $FCP_details['discounted_price'];
            }else{
                $data['paid_amount'] = $FCP_details['price'];
            }
            $user_id = $this->session->userdata('user_id');
            $data['FCP_id'] = $FCP_id;
            $data['user_id'] = $user_id;
            $data['payment_method'] = 'paypal';
            $data['payment_keys'] = json_encode(array('transaction_id' => $transaction_id,'session_id' => $session_id));

            if (get_user_role('role_id', $FCP_details['user_id']) == 1) {
                $data['admin_revenue'] = $data['paid_amount'];
                $data['instructor_revenue'] = 0;
                $data['instructor_payment_status'] = 1;
            } else {
                if (get_settings('allow_instructor') == 1) {
                    $instructor_revenue_percentage = get_settings('instructor_revenue');
                    $data['instructor_revenue'] = ceil(($data['paid_amount'] * $instructor_revenue_percentage) / 100);
                    $data['admin_revenue'] = $data['paid_amount'] - $data['instructor_revenue'];
                } else {
                    $data['instructor_revenue'] = 0;
                    $data['admin_revenue'] = $data['paid_amount'];
                }
                $data['instructor_payment_status'] = 0;
            }

            $data['added_date'] =  time();
            $payment = $this->db->get_where('FCP_payment', array('FCP_id' => $FCP_id, 'user_id' => $user_id));
            if($payment->num_rows() <= 0){
                $this->db->insert('FCP_payment', $data);
            }
      
    }
    */



    public function get_revenue_by_user_type($timestamp_start = "", $timestamp_end = "", $revenue_type = "")
    {
        $FCP_ids = array();
        $FCPs    = array();
        
        $admin_details = $this->user_model->get_admin_details()->row_array();
        if ($revenue_type == 'instructor_revenue') {
            if($this->session->userdata('admin_login')){
                $this->db->where('user_id !=', $admin_details['id']);
            }else{
                $this->db->where('user_id', $this->session->userdata('user_id'));
            }
            $this->db->select('FCP_id');
            $FCPs = $this->db->get('FCP')->result_array();
            foreach ($FCPs as $FCP) {
                if (!in_array($FCP['FCP_id'], $FCP_ids)) {
                    array_push($FCP_ids, $FCP['FCP_id']);
                }
            }
            if (sizeof($FCP_ids)) {
                $this->db->where_in('FCP_id', $FCP_ids);
            } else {
                return array();
            }
        }
        $this->db->where('added_date >=', $timestamp_start);
        $this->db->where('added_date <=', $timestamp_end);
        $this->db->order_by('added_date', 'desc');
        return $this->db->get('FCP_payment')->result_array();
    }

    /*
    public function razorpayPrepareData($payable_amount = "")
    {
        $user_details = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
        $razorpay_settings = json_decode(get_settings('razorpay_keys'));

        $key_id = $razorpay_settings[0]->key;
        $secret_key = $razorpay_settings[0]->secret_key;



    
      $api = new Api($key_id, $secret_key);

      $razorpayOrder = $api->order->create(array(
        'receipt'         => rand(),
        'amount'          => $payable_amount * 100, // 2000 rupees in paise
        'currency'        => get_settings('razorpay_currency'),
        'payment_capture' => 1 // auto capture
      ));
      $amount = $razorpayOrder['amount'];
      $razorpayOrderId = $razorpayOrder['id'];
      $_SESSION['razorpay_order_id'] = $razorpayOrderId;

    $data = array(
      "key" => $key_id,
      "amount" => $amount,
      "name" => get_settings('system_title'),
      "description" => get_settings('about_us'),
      "image" => base_url('uploads/system/'.get_settings('favicon')),
      "prefill" => array(
      "name"  => $user_details['first_name'].' '.$user_details['last_name'],
      "email"  => $user_details['email'],
    ),
      "notes"  => array(
      "merchant_order_id" => rand(),
    ),
      "theme"  => array(
      "color"  => $razorpay_settings[0]->theme_color
    ),
      "order_id" => $razorpayOrderId,
    );
    return $data;
  }

  public function razorpay_payment($razorpayOrderId = "", $payment_id = "", $amount = "", $signature = "")
  {
    $razorpay_keys = json_decode(get_settings('razorpay_keys'));
    $success = true;
    $error = "payment_failed";

    if (empty($payment_id) === false) {
      $api = new Api($razorpay_keys[0]->key, $razorpay_keys[0]->secret_key);
      try {
        $attributes = array(
          'razorpay_order_id' => $razorpayOrderId,
          'razorpay_payment_id' => $payment_id,
          'razorpay_signature' => $signature
        );
        $api->utility->verifyPaymentSignature($attributes);
      } catch(SignatureVerificationError $e) {
        $success = false;
        $error = 'Razorpay_Error : ' . $e->getMessage();
      }
    }
    if ($success === true) {
      return true;
    }else {
      return false;
    }
  }

    function payment_history_by_user_id($user_id = ""){
        $this->db->where('user_id', $user_id);
        return $this->db->get('FCP_payment');
    }
    */
}