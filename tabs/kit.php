<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 *   Author: Ananya sinha
 *   Description: KIT controller class
 */
class Kit extends MY_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $userLoggedIn = $this->session->userdata("is_loggedin");
        if ($userLoggedIn == FALSE) {
            $this->session->set_flashdata("message", "Invalid Request");
            redirect("login", "refresh");
        }
        
        $this->load->model('kitmodel');
        $this->load->model("logsmodel");
        $this->load->model('m_product');
        $this->load->model('m_adminkit');
    }
    
    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_ids');
        $this->data['product_list'] = $this->m_product->list_product();
        $this->data["kit_details"]  = $this->kitmodel->kit_list($company_id);
        $this->data["content"]      = 'companymodule/kitlist';
        $this->data["title"]        = 'KIT DETAILS | CRM';
        $this->load->view("companyhome", $this->data);
    }
    
    public function add()
    {
        $company_id = $this->session->userdata('company_ids');
        $this->data["title"]        = 'ADD KIT | CRM';
        $this->data['product_list'] = $this->kitmodel->companyproduct_list($company_id);
        $this->data['unit_list']    = $this->kitmodel->list_unit();
        $this->data['account_list'] = $this->kitmodel->account_list();
        $this->data['tax_details']  = $this->kitmodel->list_tax();
        $this->data["content"]      = 'companymodule/add_kit';
        $this->load->view("companyhome", $this->data);
    }
    
    public function save_kit()
    {
        $file_new_name = "";
        $filename      = $_FILES['uploadfile']['name'];
        if ($filename != "" || $filename != null) {
            $temp          = $_FILES['uploadfile']['tmp_name'];
            $file_size     = $_FILES['uploadfile']['size'];
            $ext           = pathinfo($filename, PATHINFO_EXTENSION);
            $base_path     = realpath(dirname(__FILE__) . '/../../');
            $path          = $base_path . "/assets/kitImage/";
            $file_new_name = $this->input->post('kit_name') . date("his") . '.' . $ext;
            $allowed       = array('jpg','jpeg','bmp','gif','png');
            
            if (!in_array(strtolower($ext), $allowed)) {
                $this->session->set_flashdata('danger', 'Image Uploading failed.<br/>Image should be  jpg, jpeg, bmp, gif or png');
                redirect('kit/add', 'refresh');
            } elseif (($_FILES['uploadfile']['size'] > 5120000)) {
                $this->session->set_flashdata('danger', 'Image Uploading failed.<br/>Image should be less than or equal to 5mb.');
                redirect('kit/add', 'refresh');
            }
            move_uploaded_file($temp, $path . $file_new_name);
        }
        // die();
        $id               = $this->input->post('kit_id');
        $type             = $this->input->post('optype');
        $kit_name         = $this->input->post('kit_name');
        $sku              = $this->input->post('sku');
        // $unit             = $this->input->post('unit');
        $hsn              = $this->input->post('hsn');
        $selling_price    = $this->input->post('selling_price');
        $sales_account    = $this->input->post('sales_account');
        $sales_desc       = $this->input->post('sales_desc');
        $purchase_price   = $this->input->post('purchase_price');
        $purchase_account = $this->input->post('purchase_account');
        $purchase_desc    = $this->input->post('purchase_desc');
        $taxpref          = $this->input->post('taxpref');
        $tax_id           = $this->input->post('tax_id');
        $company_id       = $this->session->userdata('company_ids');

        $product_ids = $this->input->post('item_details');
        $basicunit = $this->input->post('basicunit');
        $quantity = $this->input->post('quantity');
        $unit = $this->input->post('unitid');
        $sell_prices = $this->input->post('sell_price');
        $pur_prices = $this->input->post('pur_price');

        $kit_details = array(
            'kit_id' => $id,
            'type' => $type,
            'kit_name' => $kit_name,
            'sku' => $sku,
            // 'unit_id' => $unit,
            'hsn' => $hsn,
            // 'product_id' => $product_ids,
            'total_selling_price' => $selling_price,
            'sales_account' => $sales_account,
            'sales_desc' => $sales_desc,
            'total_purchase_price' => $purchase_price,
            'purchase_account' => $purchase_account,
            'purchase_desc' => $purchase_desc,
            'kit_image' => $file_new_name,
            'user_id' => $this->session->userdata['user_id'],
            'company_id' => $company_id,
            'taxpreference' => $taxpref,
            'tax_id' => $tax_id,
            'created_on' => date('Y-m-d')
        );

        if(count($product_ids)!=0){
            for($i=0; $i< count($product_ids); $i++){
            
            $kitpdt_details[] = array(
                 'product_id' => $product_ids[$i],
                 'basicproductunit'=>$basicunit[$i],
                 'quantity' => $quantity[$i],
                 'unit_id' => $unit[$i],
                 'sell_prices'=> $sell_prices[$i],
                 'pur_prices'=> $pur_prices[$i]
            );
        }}

       /* print '<pre>';
        print_r($kit_details);
        print_r($kitpdt_details);die();
        print '</pre>';
        */

        $status = $this->kitmodel->save_kit($kit_details,$kitpdt_details);
        if ($status) {
            $details = $this->session->userdata('username') . " Created new kit details.";
            $this->logsmodel->savelog($details);
            $this->session->set_flashdata("Success", "Kit Created Successfully....!");
            redirect(base_url() . "kit", "refresh");
        } else {
            $this->session->set_flashdata("danger", "Oops Some thing wrong...!");
            redirect(base_url() . "kit", "refresh");
        }
    }
    
     //to get basic uint
    public function ajax_setrate()
    {
        $id         = mysql_real_escape_string($this->input->post('id'));
        $item_id    = mysql_real_escape_string($this->input->post('item_id'));
        $sellRate   = $this->kitmodel->get_sellrate($item_id);
        $purRate    = $this->kitmodel->get_purrate($item_id);
        $unit_id    = $this->kitmodel->unitlist($item_id);
        $basicproDetails = $this->kitmodel->prodetails($item_id);
        echo json_encode(array('status' => true,'sellRate' => $sellRate, 'purRate'=>$purRate,'unit_id'=>$unit_id,
            'basicproductunit'=>$basicproDetails,'rate_id' => $id));
    }
    
    

    public function edit()
    {
        if ($this->input->post('id') == '' && $this->input->post('id') == null) {
            redirect('kit', 'refresh');
        }
        
        $id                         = $this->input->post('id');
        $company_id                 = $this->session->userdata('company_ids');
        $this->data['id']           = $id;
        $this->data['title']        = 'EDIT KIT | CRM';
        $this->data['product_list'] = $this->kitmodel->companyproduct_list($company_id);
        $this->data['kitpdt_details'] = $this->kitmodel->kit_productdetails($id);
        $this->data['kit_details']  = $this->kitmodel->edit_kit($id);
        $this->data['unit_list']    = $this->kitmodel->list_unit();
        $this->data['tax_details']  = $this->kitmodel->list_tax();
        $this->data['account_list'] = $this->kitmodel->account_list();
        $this->data["content"]      = 'companymodule/editkit';
        $this->load->view("companyhome", $this->data);

    }
    
    public function update_kit()
    {
        
        $user_id          = $this->session->userdata('user_id');
        $company_id       = $this->session->userdata('company_ids');
        $id               = $this->input->post('id');
        $type             = $this->input->post('optype');
        $kit_name         = $this->input->post('kit_name');
        $sku              = $this->input->post('sku');
        $unit             = $this->input->post('unit');
        $hsn              = $this->input->post('hsn');
        $product_ids      = $this->input->post('item_details');
        $selling_price    = $this->input->post('selling_price');
        $sales_account    = $this->input->post('sales_account');
        $sales_desc       = $this->input->post('sales_desc');
        $purchase_price   = $this->input->post('purchase_price');
        $purchase_account = $this->input->post('purchase_account');
        $purchase_desc    = $this->input->post('purchase_desc');
        $taxpref          = $this->input->post('taxpref');
        $tax_id           = $this->input->post('tax_id');
        
        $kit_ids = $this->input->post('kit_ids');
        $product_ids = $this->input->post('item_details');
         $basicunit = $this->input->post('basicunit');
        $quantity = $this->input->post('quantity');
        $sell_prices = $this->input->post('sell_price');
        $pur_prices = $this->input->post('pur_price');

        $kit_details = array(
            'kit_id' => $id,
            'type' => $type,
            'kit_name' => $kit_name,
            'sku' => $sku,
            'unit_id' => $unit,
            'hsn' => $hsn,
            //'product_id' => $product,
            'total_selling_price' => $selling_price,
            'sales_account' => $sales_account,
            'sales_desc' => $sales_desc,
            'total_purchase_price' => $purchase_price,
            'purchase_account' => $purchase_account,
            'purchase_desc' => $purchase_desc,
            'taxpreference' => $taxpref,
            'tax_id' => $tax_id,
            'user_id' => $user_id,
            'company_id' => $company_id,
            'created_on' => date('Y-m-d')
        );

        if(count($product_ids)!=0){
            for($i=0; $i< count($product_ids); $i++){
            
            $kitpdt_details[] = array(
                 'kit_id' => $kit_ids,
                 'product_id' => $product_ids[$i],
                 'basicproductunit'=>$basicunit[$i],
                 'quantity' => $quantity[$i],
                 'sell_prices'=> $sell_prices[$i],
                 'pur_prices'=> $pur_prices[$i]
            );
        }}
        
        /*echo '<pre>';
         print_r($kit_details);
         print_r($kitpdt_details);die();
         echo '</pre>';*/
        
        $status  = $this->kitmodel->update_kit($kit_details, $kitpdt_details,$id,$kit_ids);
        $action  = 'Kit ' . $kit_name . 'Is Updated Successfully';
        $user_id = $this->session->userdata('user_id');
        $this->logsmodel->savelog($action);
        $this->session->set_flashdata("Success", "Kit Updated Successfully..!");
        redirect('kit', 'refresh');
    }
    
    public function view()
    {
        if ($this->input->post('id') == '' && $this->input->post('id') == null) {
            redirect('kit', 'refresh');
        }
        
        $id = $this->input->post('id');
        $this->data["id"] = $id;
        $this->data["title"] = 'View KIT | CRM';
        $this->data['product_list'] = $this->kitmodel->list_product($id);
        $this->data["kit_details"] = $this->kitmodel->view_kit($id);
        $this->data["content"] = 'companymodule/view_kit';
        $this->load->view("companyhome", $this->data);

       /* echo '<pre>';
        print_r($this->data["kit_details"]);die();
        echo '</pre>';*/

    }
    
    public function delete()
    {
        $id = $this->input->post('id');
        $kit_ids =$this->input->post('kit_ids');

        $this->kitmodel->delete_kit($id,$kit_ids);
        $this->session->set_flashdata("Success", "Kit Deleted Successfully..!");
        redirect('kit', 'refresh');
    }
    
}
?>
