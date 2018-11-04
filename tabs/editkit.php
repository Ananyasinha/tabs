<?php 
    foreach ($kit_details as $row) {
        $unit =$row['unit_id'];
        $tax_id =$row['tax_id'];
        $company_name =$row['company_id'];
   
    }
?>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/dist/css/select2.min.css" />
<style>
    .select2-container .select2-selection--single {
        height: auto!important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 22px!important;
        color: #444!important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 6px!important;
    }
    
    .invoice-detail-table th:first-child {
        text-align: left;
        width: 230px;
    }
    
    .tax-row-head {
        width: 180px;
    }
    
    .card.invoice-detail-bot-section {
        border-top: medium none;
    }
    
    .table.table-responsive.invoice-table.invoice-total th {
        color: #464a4c;
        font-size: 15px;
    }
    .text-open {
        color: #1093de;
    }
    .cursor-pointer {
    cursor: pointer;
    }
    .font-sm {
        font-size: 13px;
    }

</style>
<script type="text/javascript">
    function yesnoCheck() {
        if (document.getElementById('taxable').checked) {
            document.getElementById('tax_type').style.display = 'flex';
        } else document.getElementById('tax_type').style.display = 'none';
    }
</script>

<!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>EDIT KIT</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?php echo base_url();?>companydashboard">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url();?>kit">KIT Details</a>

                </ul>
            </div>
        </div>
        <?php 
        $success = $this->session->flashdata("Success");
        $damger = $this->session->flashdata("danger");
        if($success!=""){?>
        <div class="alert alert-success background-primary">
        <button aria-label="Close" data-dismiss="alert" class="close" type="button">
        <i class="icofont icofont-close-line-circled text-white"></i>
        </button>
        <strong> <?php echo $this->session->flashdata('Success');?> </strong>
        </div>
        <?Php }
        if($damger!=""){?>  
        <div class="alert alert-danger background-danger">
        <button aria-label="Close" data-dismiss="alert" class="close" type="button">
        <i class="icofont icofont-close-line-circled text-white"></i>
        </button>
        <strong><?php echo $this->session->flashdata('danger');?></strong> 
        </div>
        <?php }?>
            <div class="page-body">
                <div class="row">
                    <div class="col-lg-12 col-xl-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-block">
                                <form class="form-horizontal edit-kit" action="<?php echo base_url();?>adminkit/update_kit" method="POST" onsubmit="return validateForm()" enctype="multipart/form-data">
                                   <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><b> Type </b></label>
                                            <div class="col-sm-1 col-lg-1  m-l-10">
                                                <div class="radio radio-inline">
                                                    <label class="m-l-5" style="margin-top:2px">
                                                        <input type="radio" name="optype" value="Product"<?php echo ($kit_details[0]['type']=='Product')?'checked':'' ?> style="display:none;">
                                                        <i class="helper"></i>Product
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><b> Company Name </b></label>
                                            <div class="col-sm-6">
                                            <select name="companyid" id="companyid" class="js-example-data-array col-sm-12" required="true">
                                                <option value="0">Select Company</option>
                                                <?php foreach($company_details as $values){ ?>
                                                <option value="<?php echo $values['id'];?>"<?= $values['id'] == $company_name?"selected='selected'":"" ?>><?php echo $values['company_name'];?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <?php echo validation_errors(); ?>
                                            <label class="col-sm-3 col-form-label"><b> Kit Name </b></label>
                                            <div class="col-sm-6">
                                                <input type="text" id="kit_name" name="kit_name" value="<?php echo $kit_details[0]['kit_name'];?>" placeholder="Kit Name" class="form-control" required>
                                                <input type="hidden" name="id" id="kit_id" class="form-control" value="<?php echo $id?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><b> SKU </b></label>
                                            <div class="col-sm-6">
                                                <input type="text" id="sku" name="sku" value="<?php echo $kit_details[0]['sku'];?>" placeholder="SKU" class="form-control" required>
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><b> HSN </b></label>
                                            <div class="col-sm-6">
                                                <input type="text" id="hsn" name="hsn" value="<?php echo $kit_details[0]['hsn'];?>" placeholder="HSN" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><b> Tax Preference </b></label>
                                               <label class="radio-inline" style="margin-left:10px">
                                                <div class="col-sm-1 col-lg-1  m-l-10 edit-kit-radio">
												
												
                                                    <div class="radio radio-inline" style="width:150px">
                                                        <label class="m-l-5">
                                                            <input type="radio" name="taxpref" id="taxable" value="Yes" <?php echo ($kit_details[0]['taxpreference'] =='Yes')?'checked':'' ?> onclick="javascript:yesnoCheck();" style="display:none;" >
                                                            <i class="helper"></i>Taxable
                                                        </label>
                                                    </div>
                                                    
                                                </div>
                                            </label>
                                            <label class="radio-inline" style="margin-left:10px">
                                                <div class="col-sm-1 col-lg-1  m-l-10">
                                                    <div class="radio radio-inline" style="width:200px">
                                                        <label class="m-l-5">
                                                            <input type="radio" name="taxpref" id="non_tax" value="No"<?php echo ($kit_details[0]['taxpreference'] =='No')?'checked':'' ?>  onclick="javascript:yesnoCheck();" style="display:none;">
                                                            <i class="helper"></i>Non-Taxable
                                                        </label>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="form-group row" id="tax_type" style="display:none">
                                            <label class="col-sm-3 col-form-label"><b>  Tax Type </b></label>
                                            <div class="col-sm-6">
                                                <select name="tax_id" id="tax_id" class="js-example-data-array col-sm-12">
                                                    <option value="">Select Tax</option>
                                                    <?php foreach($tax_details as $values) { ?>
                                                        <option value="<?php echo $values['tax_id'];?>"
                                                        <?= $values['tax_id'] == $tax_id?"selected='selected'":"" ?>>
                                                        <?php echo $values['taxname'].' ['.$values['taxdeduction'].'%]';?>
                                                        </option>
                                                        <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                         <div class="form-group row">
                                            <div class="col-sm-1">
                                                <label class="col-form-label">
                                                    <p style="padding-top: 50px;font-size: 22px">
                                                        <b>Associate Product</b>
                                                    </p>
                                                </label>    
                                            </div>
                                            <div class="col-sm-11">
                                                <div class="table-responsive">
                                                    <table id="myTable" class="table order-list associate_pro">
                                                        <thead>
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>Basic Unit </th>
                                                                <th>Quantity </th>
                                                                <th>Unit </th>
                                                                <th>Selling Price</th>
                                                                <th>Purchase Price</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                            <tbody id="associate_product">
                                                        <?php 
                                                            foreach ($kitpdt_details as $key => $val) { 
                                                        ?>
                                                                 <input type="hidden" name="kit_ids" value="<?php echo $val['kit_id'];?>">
                                                                    <tr data-id="<?php echo $key;?>">
                                                                        <td>
                                                                            <select class="product_select js-example-data-array col-sm-12" name="item_details[]" id="item_details0" data-id="<?php echo $key;?>" required>
                                                                                <option value="">Select Product</option>
                                                                                <?php 
                                                                                foreach($product_list as $value)
                                                                                {  
                                                                                ?>  
                                                                                    <option value="<?php echo $value['product_id'];?>" <?php if($value['product_id'] == $val['product_id']){echo 'selected="selected"';} ?>" >
                                                                                        <?php echo $value['product_name'];?>
                                                                                    </option>
                                                                                    <?php 
                                                                                } 
                                                                                ?>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                          <input type="text" readonly class="form-control" id="basicunit0" name="basicunit[]" value="<?php echo $val['basicproductunit'];?>"> 
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" min="1" placeholder="1" class="form-control quantity" name="quantity[]" value="<?php echo $val['quantity']; ?>">
                                                                        </td>
                                                                        <td>
                                                                            <select class="unit_select js-example-data-array col-sm-12" readonly name="unitid[]" id="unit0" data-id="<?php echo $key;?>">
                                                                                <option value="">Select Unit</option>
                                                                              <?php foreach($unit_list as $row){ ?>
                                                                                    <option value="<?php echo $row['unit_id'];?>"<?php if($row['unit_id'] == $val['unit_id']){echo 'selected="selected"';} ?>">
                                                                                        <?php echo $row['unit_name'];?>
                                                                                    </option>
                                                                                    <?php } ?>
                                                                            </select>
                                                                        </td>

                                                                        <td>
                                                                            <div id="rating<?php echo $key; ?>">
                                                                                <input type="number" placeholder="Rs." id="ratesell<?php echo $key; ?>" name="sell_price[]" value="<?php echo $val['sell_prices']; ?>" class="form-control sell_price" disabled="disabled" />
                                                                                <input type="hidden" name="sell_price[]" id="hidden_sell<?php echo $key; ?>" value="<?php echo $val['sell_prices'];?>" class='hidden_sell' />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div id="totalamount<?php echo $key; ?>">
                                                                                <input type="number" placeholder="Rs." id="ratepur<?php echo $key; ?>" name="pur_price[]" class="form-control pur_price" value="<?php echo $val['pur_prices']; ?>" disabled="disabled"/>
                                                                                <input type="hidden" name="pur_price[]" id="hidden_price<?php echo $key;?>" value="<?php echo $val['pur_prices']; ?>" class='hidden_price' />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <input id="delete_product1" type="button" class="btn btn-sm btn-danger" value="Delete">
                                                                        </td>
                                                                        <td>
                                                                            <a class="deleteRow"></a>
                                                                        </td>
                                                                    </tr>
                                                        <?php } ?>
                                                            </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td>
                                                                    <a class="btn btn-primary btn-add-task waves-effect waves-light" id="addrow" href="javascript:void(0);" title="Add More"><i class="icofont icofont-plus"></i> Add More Product </a>
                                                                </td>
                                                                <td> </td>
                                                                <td> </td>
                                                                <td>TOTAL (₹) :</td>
                                                                <td>
                                                                    <input type="number" placeholder="Rs." class="form-control" id="subTotal" name="selling_price" disabled="disabled" value="<?php  echo $kit_details[0]['total_selling_price'];?>">
                                                                </td>
                                                                <td>
                                                                    <input type="number" placeholder="Rs." class="form-control"  id="ppsubTotal" name="rate[]" disabled="disabled" value="<?php  echo $kit_details[0]['total_purchase_price'];?>">
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>



                                                <div class="clearfix"></div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h5> Sales Information</h5>
                                                        <br><br>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label"><b> Selling Price (INR) </b></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" id="selling_price" name="selling_price" placeholder="Selling Price" class="form-control" value="<?php echo $kit_details[0]['total_selling_price'];?>" required>
                                                                <div style="margin:-30px 0 0 230px;" class="font-sm text-open cursor-pointer" onclick="copytotalsp()">Copy from total</div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label"><b> Account  </b></label>
                                                            <div class="col-sm-9">
                                                                <select name="sales_account" id="sales_account" class="js-example-data-array col-sm-12">
                                                                    <option value="">Select Account</option>
                                                                    <?php foreach($account_list as $row)
                                                                    { 
                                                                    ?>
                                                                        <option value="<?php echo $row['account_id'];?>"<?= $row['account_id'] == $kit_details[0]['sales_account']?"selected='selected'":"" ?>>
                                                                            <?php echo $row['account_name'];?>
                                                                        </option>
                                                                        <?php 
                                                                    } 
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label"><b> Description </b></label>
                                                        <div class="col-sm-9">
                                                            <textarea rows="5" cols="5" id="sales_desc" name="sales_desc" class="form-control" placeholder="Description" required><?php echo $kit_details[0]['sales_desc'];?></textarea>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <!-- col-6 -->
                                                    <div class="col-md-6">
                                                        <h5>Purchase Information</h5>
                                                        <br><br>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label"><b> Purchase Price (INR) </b></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" id="purchase_price" name="purchase_price" placeholder="Purchase Price" class="form-control" value="<?php echo $kit_details[0]['total_purchase_price'];?>" required>
                                                                 <div style="margin:-30px 0 0 230px;" class="font-sm text-open cursor-pointer" onclick="copytotalpp()">Copy from total</div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label"><b> Account  </b></label>
                                                            <div class="col-sm-9">
                                                                <select name="purchase_account" id="purchase_account" class="js-example-data-array col-sm-12">
                                                                   <option value="">Select Account</option>
                                                                    <?php foreach($account_list as $row)
                                                                    { 
                                                                    ?>
                                                                        <option value="<?php echo $row['account_id'];?>"<?= $row['account_id'] == $kit_details[0]['purchase_account']?"selected='selected'":"" ?>>
                                                                            <?php echo $row['account_name'];?>
                                                                        </option>
                                                                        <?php 
                                                                    } 
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label"><b> Description </b></label>
                                                            <div class="col-sm-9">
                                                                <textarea rows="5" cols="5" id="purchase_desc" name="purchase_desc" class="form-control" placeholder="Description" required><?php echo $kit_details[0]['purchase_desc'];?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end -->
                                                </div>

                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-sm-12 text-center" style="margin-top:10px">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                            <!-- Flying Word card end -->
                        </div>
                        <!-- Left column end -->

                    </div>
                </div>
                <!-- Page body end -->
            </div>
    </div>
    <!-- Main-body end -->
</div>
<!-- Select 2 js -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.quicksearch.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/pages/advance-elements/select2-custom.js"></script>
<!-- Date-range picker js -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- Date-dropper js -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datedropper/datedropper.min.js"></script>

<script type="text/javascript">

$(function (){
    $("#associate_product").on('click','#delete_product1',function(){
        var rowCount = $("#associate_product tr").length;
        
        if(rowCount > 1){
            $(this).parents('tr').remove(); 
            calcPrice();
        }else{
            alert("Associate Product can't be empty");
        }
    });

    // function to change the selling and purchase price of the product onchange of quantity
    $("#associate_product").on('change keyup','.quantity',function(){
        var quant      = setToMin(parseInt($(this).val()));
        var sell_price = parseInt($(this).parents('tr').find('td:eq(4) .hidden_sell').val());
        var pur_price  = parseInt($(this).parents('tr').find('td:eq(5) .hidden_price').val());
        var mul_dataS  = quant * sell_price;
        var mul_dataP  = quant * pur_price;

        $(this).parents('tr').find('td:eq(4) .sell_price').val(mul_dataS);
        $(this).parents('tr').find('td:eq(5) .pur_price').val(mul_dataP);
         
        calcPrice();
    });

    $("#associate_product").on('blur','.quantity',function(){
        var quant      = setToMin(parseInt($(this).val()));
        if(quant == 1){
          $(this).val(1);  
        }
        var sell_price = parseInt($(this).parents('tr').find('td:eq(4) .hidden_sell').val());
        var pur_price  = parseInt($(this).parents('tr').find('td:eq(5) .hidden_price').val());
        var mul_dataS  = quant * sell_price;
        var mul_dataP  = quant * pur_price;

        $(this).parents('tr').find('td:eq(4) .sell_price').val(mul_dataS);
        $(this).parents('tr').find('td:eq(5) .pur_price').val(mul_dataP);
         
        calcPrice();
    });

    // function to select or fetch the selling price of product for selected product from db
    $("#associate_product").on('change keyup','.product_select',function(){
        $(this).find(":selected").parents('tr').find('td:eq(1) .quantity').val('1');
        var item_value  = $(this).find(":selected").val();    
        var id          = $(this).data('id');
        var sell_prices = 0;
        var pur_price   = 0;

        $.ajax({
            url: "<?php echo base_url();?>adminkit/ajax_setunit",
            type: 'POST',
            dataType: 'JSON',
            data: {
                'id': id,
                'item_id':item_value
            },
        }).done(function(res){
            if(res.status){
                $("#ratesell"+res.rate_id).val(res.sellRate);
                $("#ratepur"+res.rate_id).val(res.purRate);
                $("#basicunit"+res.rate_id).val(res.basicproductunit);
                $("#unit"+res.rate_id).val(res.unit_id);
                $("#unit"+res.rate_id).trigger('change');
                $("#hidden_sell"+res.rate_id).val(res.sellRate);
                $("#hidden_price"+res.rate_id).val(res.purRate);
                calcPrice();
           }else {
                alert('Oops Something went wrong.!!!');
           }
        });
    });

    //function to add more product into the table
    $("#addrow").on("click", function () {
        var lasTRow  = parseInt($('#associate_product tr:last').data('id')) + 1;
        var counter  = lasTRow;
        $('#associate_product').append('<tr data-id="'+counter+'"><td><select class="product_select js-example-data-array col-sm-12" name="item_details[]" id="item_details'+counter+'" data-id="'+counter+'" required><option value="">Select Product</option><?php foreach($product_list as $value){?><option value="<?php echo $value['product_id'];?>"><?php echo $value['product_name'];?></option><?php }?></select></td><td><input type="text" class="form-control" id="basicunit'+counter+'" name="basicunit[]" value="" readonly></td> <td><input type="number" min="1" name="quantity[]" class="form-control quantity" value="1"></td><td><select class="unit_select js-example-data-array col-sm-12" name="unitid[]" id="unit'+counter+'" required><option value="">Select Unit</option><?php foreach($unit_list as $row){ ?><option value="<?php echo $row['unit_id'];?>"><?php echo $row['unit_name'];?></option><?php } ?></select></td><td><div id="rating'+counter+'"><input type="number" placeholder="Rs." id="ratesell'+counter+'" name="sell_price[]" value="0.00" class="form-control sell_price" disabled="disabled" /><input type="hidden" class="hidden_sell" name="sell_price[]" id="hidden_sell'+counter+'" value="" /></div></td><td><div id="totalamount'+counter+'"><input type="number" placeholder="Rs." id="ratepur'+counter+'" name="pur_price[]" class="form-control pur_price" value="0.00" disabled="disabled" /><input type="hidden" class="hidden_price" name="pur_price[]" value="" id="hidden_price'+counter+'" value="" /></div></td><td><input type="button" id="delete_product" class="btn btn-sm btn-danger" value="Delete"></td><td><a class="deleteRow"></a></td></tr>');
        
            $('.js-example-data-array').select2();
    });

    // function to delete product row from table
    $("#associate_product").on('click','#delete_product',function(){
        $(this).parents('tr').remove(); 
        calcPrice();
    });


    // function to calculate selling and purchase price
    function calcPrice(){
        var sell_prices = [];
        $("#associate_product .sell_price").each(function() {
            var sell_price = parseInt($(this).val());
            sell_prices.push(sell_price);
        });
        
        var sell_total = 0;
        for (var i = 0; i < sell_prices.length; i++) {
            sell_total += sell_prices[i] << 0;
        }   
    
        var pur_prices = [];    
        $("#associate_product .pur_price").each(function() {
            var pur_price = parseInt($(this).val());
            pur_prices.push(pur_price);
        });
        
        var pur_total = 0;
        for (var i = 0; i < pur_prices.length; i++) {
            pur_total += pur_prices[i] << 0;
        }
        $("#subTotal").val(sell_total);
        $("#ppsubTotal").val(pur_total);
    }
});


 //function to copy total pp val.
    function copytotalpp()
    {
        var ppsubTotal =  $('#ppsubTotal').val();
        $('#purchase_price').val(ppsubTotal);
    }

    function copytotalsp()
    {
        var subTotal =  $('#subTotal').val();
         // if(subTotal){
        $('#selling_price').val(subTotal);
         // }
    }

function setToMin(quant){
    if((quant <= 1) || (quant == undefined) || isNaN(quant) || (quant == "")){
        return 1;
    }else {
        return quant;
    }
}
</script>