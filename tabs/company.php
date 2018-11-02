<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *     Author: Ananya Sinha 
 *     Description: Company controller class
 */
class Company extends MY_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $userLoggedIn = $this->session->userdata("is_loggedin");
        if ($userLoggedIn == FALSE) {
            $this->session->set_flashdata("danger", "Invalid Request");
            redirect("login", "refresh");
        }
        $this->load->model("company_model");
        $this->load->model("m_mail");
        $this->load->model("logsmodel");
        $this->load->model("login_model");
    }
    
    public function index()
    {
		$type = $this->session->userdata('usertype');
		$userid = $this->session->userdata('user_id');
        $this->data['title'] = 'Company Details | CRM';
        if($type == '2')
		{
			$this->data['records'] = $this->company_model->companylist_emp($userid);
		}
		else
		{
			$this->data['records'] = $this->company_model->companylist();
		}
		$this->data['country_details'] = $this->company_model->get_country();
        $this->data['state_list']      = $this->company_model->state_list();
		$this->data['content']         = "maindashboard/add_company";
        $this->load->view("home", $this->data);
    }
    
    
    public function add()
    {
        $this->data['title']           = 'Add Company | CRM';
        $this->data['country_details'] = $this->company_model->get_country();
        $this->data['state_list']      = $this->company_model->state_list();
        $this->data['content']         = "maindashboard/add_company";
        $this->data["records"]         = $this->company_model->companylist();
        $this->load->view("home", $this->data);
    }
    
    public function save_company()
    {
        $file_new_name = "";
        $filename      = $_FILES['uploadfile']['name'];
        if ($filename != "" || $filename != null) {
            $temp          = $_FILES['uploadfile']['tmp_name'];
            $file_size     = $_FILES['uploadfile']['size'];
            $ext           = pathinfo($filename, PATHINFO_EXTENSION);
            $base_path     = realpath(dirname(__FILE__) . '/../../');
            $path          = $base_path . "/assets/logo/";
            $file_new_name = $this->input->post('company_name') . date("his") . '.' . $ext;
            $allowed       = array('jpg','jpeg','bmp','gif','png');
            
            if (!in_array(strtolower($ext), $allowed)) {
                $this->session->set_flashdata('danger', 'Image Uploading failed.<br/>Image should be  jpg, jpeg, bmp, gif or png');
                redirect('company', 'refresh');
            } elseif (($_FILES['uploadfile']['size'] > 5120000)) {
                $this->session->set_flashdata('danger', 'Image Uploading failed.<br/>Image should be less than or equal to 5mb.');
                redirect('company', 'refresh');
            }
            move_uploaded_file($temp, $path . $file_new_name);
        }

       
        $company_name         = $this->input->post('company_name');
        $first_name           = $this->input->post('first_name');
        $last_name            = $this->input->post('last_name');
        $username             = $this->input->post('username');
        $company_location     = $this->input->post('company_location');
        $company_street       = $this->input->post('company_street');
       /* $company_serviceno    = $this->input->post('company_serviceno');*/
        /*$company_tinid        = $this->input->post('company_tinid');*/
        $company_address      = $this->input->post('company_address');
        $company_contactno    = $this->input->post('company_contactno');
        $company_abbreviation = $this->input->post('company_abbreviation');
        $email_id             = $this->input->post('email_id');
        $password             = $this->input->post('password');
        $company_city         = $this->input->post('company_city');
        $company_pincode      = $this->input->post('company_pincode');
        $company_state        = $this->input->post('company_state');
        $company_country      = $this->input->post('country_id');
        $company_tinno        = $this->input->post('company_tinno');
        $company_panno        = $this->input->post('company_panno');
       /* $service_tax_no       = $this->input->post('service_tax_no');
        $company_vatno        = $this->input->post('company_vatno');*/
        $company_gstid        = $this->input->post('company_gstid');
        
        $records = array(
            'company_name' => $company_name,
            'company_address' => $company_address,
            'company_location' => $company_location,
            'company_street' => $company_street,
            'company_city' => $company_city,
            'company_pincode' => $company_pincode,
            'company_state' => $company_state,
            'company_country' => $company_country,
            /*'company_vat_no' => $company_vatno,*/
            'company_pan_no' => $company_panno,
           /* 'company_service_no' => $company_serviceno,
            'tin_id' => strtoupper($company_tinid),*/
            'tin_no' => $company_tinno,
            'company_status' => '1',
            'company_contact_no' => $company_contactno,
            'company_abbreviation' => $company_abbreviation,
            'company_email' => $email_id,
           /* 'service_tax_no' => $service_tax_no,*/
            'gst_id' => strtoupper($company_gstid),
            'company_modifiedon' => date('Y-m-d'),
            'logo_name' => $file_new_name
        );

		$status = $this->company_model->save_company($records, $email_id);
        if ($status) {

                $config = array(
                    'smtp_secure' => 'ssl',
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.sendgrid.net',
                    'smtp_port' => '465',
                    'smtp_timeout' =>'7',  
                    'smtp_user' => 'audiotextsolutions', 
                    'smtp_pass' => 'l12e3bvyugvk', 
                    'mailpath' => '/bin/mail',
                    'newline' => "\r\n",
                    'charset' => 'utf-8',
                    'mailtype' => 'html'
                    );
                    $content = "<h4>Username: </h4>".$email_id;
                    $content .= "<h4>Password: </h4>".$password;
                    $this->load->library('email', $config);
                    $this->email->set_newline("\r\n");
                    $this->email->from('care@detailingdevils.com');
                    $this->email->to($email_id);
                    $this->email->subject('User Credentials Details');
                    $this->email->message($content);
                    $this->email->send();

            $details = $this->session->userdata('username') . " Created new contact details.";
            $this->logsmodel->savelog($details);
            $this->session->set_flashdata("Success", "Company Created Successfully....!");
            redirect(base_url() . "company", "refresh");
        } else {
            $this->session->set_flashdata("danger", "Oops Company Email already exit...!");
            redirect(base_url() . "company", "refresh");
        }
    }
    
    public function edit()
    {
        if ($this->input->post('id') == '' && $this->input->post('id') == null) {
            redirect('company', 'refresh');
        }
        
        $id                            = $this->input->post('id');
        $this->data["id"]              = $id;
        $this->data["title"]           = 'Edit Company | CRM';
        $this->data['country_details'] = $this->company_model->get_country();
        $this->data['state_list']      = $this->company_model->state_list();
        $this->data["records"]         = $this->company_model->edit_company($id);
        $this->data["content"]         = 'maindashboard/edit_company';
        $this->load->view("home", $this->data);

    }
    
    public function update_company()
    {
        
        $id                = $this->input->post('id');
        $company_name      = $this->input->post('company_name');
        $company_location  = $this->input->post('company_location');
        $company_street    = $this->input->post('company_street');
      /*  $company_serviceno = $this->input->post('company_serviceno');
        $company_tinid     = $this->input->post('company_tinid');*/
        $company_address   = $this->input->post('company_address');
        $company_contactno = $this->input->post('company_contactno');
        $company_city      = $this->input->post('company_city');
        $company_pincode   = $this->input->post('company_pincode');
        $company_state     = $this->input->post('company_state');
        $company_country   = $this->input->post('country_id');
      /*  $company_vatno     = $this->input->post('company_vatno');*/
        $company_tinno     = $this->input->post('company_tinno');
        $company_panno     = $this->input->post('company_panno');
        /*$service_tax_no    = $this->input->post('service_tax_no');*/
        $company_gstid     = $this->input->post('company_gstid');
        
        $records = array(
            'company_name' => $company_name,
            'company_address' => $company_address,
            'company_location' => $company_location,
            'company_street' => $company_street,
            'company_city' => $company_city,
            'company_pincode' => $company_pincode,
            'company_state' => $company_state,
            'company_country' => $company_country,
            //'company_vat_no' => $company_vatno,
            'company_pan_no' => $company_panno,
            //'company_service_no' => $company_serviceno,
            //'tin_id' => $company_tinid,
            'tin_no' => $company_tinno,
            'company_status' => '1',
            'company_contact_no' => $company_contactno,
            /*'service_tax_no' => $service_tax_no,*/
            'company_modifiedon' => date('Y-m-d'),
            'gst_id' => $company_gstid
        );

        $status  = $this->company_model->update_company($records, $id);
        $action  = 'company' . $company_name . 'Is Updated Successfully';
        $user_id = $this->session->userdata('user_id');
        $this->logsmodel->savelog($action);
        $this->session->set_flashdata("Success", "Details Updated Successfully..!");
        redirect('company', 'refresh');
    }
    
    public function view_company()
    {
        if ($this->input->post('id') == '' && $this->input->post('id') == null) {
            redirect('company', 'refresh');
        }

        $company_id = mysql_real_escape_string($this->input->post('id'));
        $id = $this->input->post('id');
        $this->data["id"]              = $id;
        $this->data["title"]           = 'View Company | CRM';
        $this->data['country_details'] = $this->company_model->get_country();
        $this->data["contact_details"] = $this->company_model->list_contact($company_id);
        $this->data["records"]         = $this->company_model->viewcompany($id);
        $this->data["email_record"]    = $this->company_model->email_record($company_id);
        $this->data["product_record"]  = $this->company_model->product_record($company_id);
        $this->data["content"] = 'maindashboard/view_company';
        $this->load->view("home", $this->data);
    
    }
    
    public function delete_company()
    {
        $company_id = mysql_real_escape_string($this->input->post('id'));
        $this->company_model->delete_company($company_id);
        $this->session->set_flashdata("Success", "Company Deleted Successfully..!");
        redirect('company', 'refresh');
    }
    
    public function logincompany()
    {
        $userid  = $this->input->post('id');
        //echo $userid ;
        $details = $this->login_model->getuserdetail($userid);
       // print_r($details);
        $old_user_id      = $this->session->userdata('user_id');
		$old_user_name    = $this->session->userdata('username');
        $old_user_email   = $this->session->userdata('email');
        $old_user_type    = $this->session->userdata('usertype');
		$old_userLoggedIn = $this->session->userdata('userLoggedIn');
		//echo $old_userLoggedIn;die;
        $this->session->set_userdata(array(
            'user_id' => $details[0]['user_id'], 
            'username' => $details[0]['username'],
            'usertype' => $details[0]['usertype'], 
            'email'	   => $details[0]['email'],
            'userLoggedIn' => $details[0]['username'], 
            //'company_id' => $details[0]['company_ids'],
            'company_name' => $details[0]['company_name'],
            'logo_name' => $details[0]['logo_name'],
			'company_ids' => $details[0]['company_ids'],
			'nature'=> 'login_by_admin',
            'old_admin_id' => $old_user_id,
            'old_admin_name' => $old_user_name,
            'old_admin_email' => $old_user_email,
            'old_admin_usertype' => $old_user_type,
            'old_userLoggedIn' => $old_userLoggedIn
        ));
        //print_r($this->session->userdata);die;
        redirect("companydashboard", "refresh");
    }
    
    function backtoadmin()
    {
        sleep(1);
        $this->session->set_userdata(array(
            'user_id' => $this->session->userdata('old_admin_id'),
            'userLoggedIn' => $this->session->userdata('old_userLoggedIn'),
            'username' => $this->session->userdata('old_admin_name'),
            'email' => $this->session->userdata('old_admin_email'),
            'usertype' => $this->session->userdata('old_admin_usertype')
        ));
        
        $this->session->unset_userdata('company_ids');
		$this->session->unset_userdata('nature');
        $this->session->unset_userdata('old_admin_id');
        $this->session->unset_userdata('old_admin_name');
        $this->session->unset_userdata('old_admin_email');
        $this->session->unset_userdata('old_admin_usertype');
        $this->session->unset_userdata('old_userLoggedIn');
        redirect("maindashboard", "refresh");
    }
    
    
}
?>