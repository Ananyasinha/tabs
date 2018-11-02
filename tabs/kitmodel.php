<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* 
 *   Author: Ananya sinha
 *   Description: KIT model class
 */
class Kitmodel extends CI_Model
{
    
    public function save_kit($kit_details, $kitpdt_details)
    {
        $this->db->insert('crm_kit', $kit_details);
        $kit_ids = $this->db->insert_id();
        if ($kit_ids != "") {
            for ($i = 0; $i < count($kitpdt_details); $i++) {
                $kitpdt_details[$i]['kit_id'] = $kit_ids;
                $this->db->insert('crm_kit_product_relation', $kitpdt_details[$i]);
            }
            return 1;
        } else {
            return 0;
        }
    }
    
    public function list_tax()
    {
        $this->db->select('*');
        $this->db->from('crm_tax');
        return $this->db->get()->result_array();
    }
    
    public function kit_list($company_id)
    {
        $this->db->select('kd.*,' . 'pd.product_name,' . 'ul.unit_name,' . 'al.account_name,' . 'td.taxname,td.taxdeduction');
        $this->db->from('crm_kit as kd');
        $this->db->join('crm_products as pd', 'pd.product_id = kd.product_id', 'left outer');
        $this->db->join('crm_unit as ul', 'kd.unit_id = ul.unit_id', 'left outer');
        $this->db->join('crm_account as al', 'al.account_id = kd.sales_account', 'left outer');
        $this->db->join('crm_tax as td', 'td.tax_id = kd.tax_id', 'left outer');
        $this->db->where('kd.company_id', $company_id);
        $this->db->order_by('kd.kit_id','desc');
        return $this->db->get()->result_array();
    }
    
    public function get_sellrate($id)
    {
        return $this->db->query("SELECT selling_price from crm_products where product_id=$id")->row()->selling_price;
    }
    
    public function get_purrate($id)
    {
        return $this->db->query("SELECT purchase_price from crm_products where product_id=$id")->row()->purchase_price;
    }

    public function unitlist($id)
    {
        return $this->db->query("SELECT unit from crm_products where product_id=$id")->row()->unit;
    }

    public function prodetails($id)
    {
        return $this->db->query("SELECT basicproductunit from crm_products where product_id=$id")->row()->basicproductunit;
    }


    
    
    public function list_unit()
    {
        $this->db->select('*');
        $this->db->from('crm_unit');
        return $this->db->get()->result_array();
    }
    
    public function account_list()
    {
        $this->db->select('*');
        $this->db->from('crm_account');
        return $this->db->get()->result_array();
    }
    
    
    public function view_kit($id)
    {
        $this->db->select('kd.*,' . 'pd.product_name,' . 'ul.unit_name,' . 'al.account_name,' . 'td.taxname,td.taxdeduction');
        $this->db->from('crm_kit as kd');
        $this->db->join('crm_products as pd', 'pd.product_id = kd.product_id', 'left outer');
        $this->db->join('crm_unit as ul', 'kd.unit_id = ul.unit_id', 'left outer');
        $this->db->join('crm_account as al', 'al.account_id = kd.sales_account', 'left outer');
        $this->db->join('crm_tax as td', 'td.tax_id = kd.tax_id', 'left outer');
        $this->db->where('kd.kit_id', $id);
        return $this->db->get()->result_array();
    }
    
    public function list_product($id)
    {
        $this->db->select('kp.*,' . 'pd.product_id,pd.product_name,'.'ul.unit_name');
        $this->db->from('crm_kit_product_relation as kp');
        $this->db->join('crm_products as pd', 'pd.product_id = kp.product_id', 'left outer');
        $this->db->join('crm_unit as ul', 'ul.unit_id = kp.unit_id', 'left outer');
        $this->db->where('kp.kit_id', $id);
        //$this->db->order_by('kp.kit_id','desc');
        return $this->db->get()->result_array();
    }

    public function allproduct_list($company_id)
    {
        $this->db->select('*');
        $this->db->from('crm_products');
        $this->db->where('company_id',$company_id);
        $this->db->where('type','Product');
        return $this->db->get()->result_array();
    }

    public function companyproduct_list($company_id)
    {
        $this->db->select('*');
        $this->db->from('crm_products');
        $this->db->where('company_id',$company_id);
        $this->db->where('type','Product');
        return $this->db->get()->result_array();
    }


    public function edit_kit($id)
    {
        $this->db->select('*');
        $this->db->from('crm_kit');
        $this->db->where('kit_id', $id);
        return $this->db->get()->result_array();
    }
    
    public function kit_productdetails($id)
    {
        $this->db->select('*');
        $this->db->from('crm_kit_product_relation');
        $this->db->where('kit_id', $id);
        return $this->db->get()->result_array();
    }
    
    // public function update_kit($kit_details, $kitpdt_details, $id, $kit_ids)
    // {
    //     $this->db->where('kit_id', $id);
    //     $status = $this->db->update('crm_kit', $kit_details);
    //     if ($status) {
    //         $this->db->where('kit_id', $kit_ids);
    //         $this->db->delete('crm_kit_product_relation');
    //         $this->db->insert_batch('crm_kit_product_relation', $kitpdt_details);
    //     }
    // }

    
    public function update_kit($kit_details, $kitpdt_details, $id, $kit_ids)
    {
        $this->db->where('kit_id', $id);
        $status = $this->db->update('crm_kit', $kit_details);
        if ($status) {
            $this->db->where('kit_id', $kit_ids);
            $this->db->delete('crm_kit_product_relation');
            $this->db->insert_batch('crm_kit_product_relation', $kitpdt_details);
        }
    }
    
    
    public function delete_kit($id,$kit_ids)
    {
        $this->db->delete('crm_kit', array('kit_id' => $id));

        $this->db->where('kit_id',$id);
        $data = $this->db->delete('crm_kit_product_relation');
        if ($data) {
           $this->db->where('kit_id',$kit_ids);
           $data = $this->db->delete('crm_kit_product_relation');
           return 1;
        } else{
            return 0;
        }
    }
    
}
?>