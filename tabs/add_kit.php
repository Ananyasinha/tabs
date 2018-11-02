<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/dist/css/select2.min.css" />
<style>


body .width-add-kit-152 .select2-container--default .select2-selection--single .select2-selection__rendered { width: 115px;}
	
	
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

<!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Create New Kit</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="<?php echo base_url();?>maindashboard">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url();?>adminkit">KIT Details</a></li>
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
            <div id="add_new_service" class="page-body">
                <div class="row">
                    <div class="col-lg-12 col-xl-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-block">
                                <form id="product_form" class="form-horizontal" action="<?php echo base_url();?>adminkit/save_kit" method="POST" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label"><b> Type </b></label>
                                            <div class="col-sm-1 col-lg-1 m-l-10" data-tooltip="Product">
                                                <div class="radio radio-inline">
                                                    <label class="m-l-5" style="margin-top:2px">
                                                        <input type="radio" name="optype" value="Product"  checked="checked" style="display:none;">
                                                        <i class="helper"></i>Product
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><b> Uplode Image </b></label>
                                            <div class="col-sm-6" data-tooltip="Uplode Image">
                                                <input type="file" id="uploadfile" name="uploadfile" class="form-control" size="20" />
                                            </div>
                                            <div class="col-sm-3 kit-uploadimg-mview">
                                                <?php if(!empty($file_new_name)){ ?>
                                                    <img src="<?php echo base_url();?>assets/kitImage/<?php echo $file_new_name;?>" class="user-img img-circle" alt="uplode Image" width="100" height="100"/>
                                                <?php }else{ ?>
                                                     <img id="uplodeimg" src="<?php echo base_url();?>assets/kitImage/no-img.jpg" alt="your image" width="180" height="110" style="margin-top:-36px;" />
                                                <?php } ?>    
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><b> Company Name <span style="color:red">*</span></b></label>
                                            <div class="col-sm-6" data-tooltip="Select Company">
                                            <select name="companyid" id="companyid" class="js-example-data-array col-sm-12" required="true">
                                                <option value="0">Select Company</option>
                                                <?php foreach($company_details as $values){ ?>
                                                <option value="<?php echo $values['id'];?>"><?php echo $values['company_name'];?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <?php echo validation_errors(); ?>
                                                <label class="col-sm-3 col-form-label"><b> Kit Name <span style="color:red">*</span></b></label>
                                                <div class="col-sm-6" data-tooltip="Kit Name">
                                                    <input type="text" id="kit_name" name="kit_name" value="" placeholder="Kit Name" class="form-control" required>
                                                </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><b> SKU <span style="color:red">*</span></b></label>
                                            <div class="col-sm-6" data-tooltip="SKU">
                                                <input type="number" id="sku" name="sku" value="" placeholder="SKU" class="form-control" required>
                                            </div>
                                        </div>
                                       <!--  <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><b>  Unit <span style="color:red">*</span></b></label>
                                            <div class="col-sm-6">
                                                <select name="unit" id="unit" class="js-example-data-array col-sm-12">
                                                    <option value="">Select Unit</option>
                                                    <?php foreach($unit_list as $row)
                                                    { 
                                                    ?>
                                                        <option value="<?php echo $row['unit_id'];?>">
                                                            <?php echo $row['unit_name'];?>
                                                        </option>
                                                        <?php 
                                                    } 
                                                    ?>
                                                </select>
                                            </div>
                                        </div> -->
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><b> HSN </b></label>
                                            <div class="col-sm-6" data-tooltip="HSN">
                                                <input type="text" id="hsn" name="hsn" value="" placeholder="HSN" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><b> Tax Preference <span style="color:red">*</span></b></label>
                                            <label class="radio-inline" style="margin-left:10px">
                                                <div class="col-sm-1 col-lg-1  m-l-10" data-tooltip="Taxable">
                                                    <div class="radio radio-inline" style="width:150px">
                                                        <label class="m-l-5">
                                                            <input type="radio" name="taxpref" id="taxable" value="Yes" onclick="javascript:yesnoCheck();" style="display:none;">
                                                            <i class="helper"></i>Taxable
                                                        </label>
                                                    </div>
                                                    
                                                </div>
                                            </label>
                                            <label class="radio-inline" style="margin-left:10px">
                                                <div class="col-sm-1 col-lg-1  m-l-10" data-tooltip="Non-Taxable">
                                                    <div class="radio radio-inline" style="width:200px">
                                                        <label class="m-l-5">
                                                            <input type="radio" name="taxpref" id="non_tax" value="No" onclick="javascript:yesnoCheck();" style="display:none;">
                                                            <i class="helper"></i>Non-Taxable
                                                        </label>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="form-group row" id="tax_type" style="display:none">
                                            <label class="col-sm-3 col-form-label"><b>  Tax Type </b></label>
                                            <div class="col-sm-6" data-tooltip="Select Tax Type">
                                                <select name="tax_id" id="tax_id" class="js-example-data-array col-sm-12">
                                                    <option value="">Select Tax</option>
                                                    <?php foreach($tax_details as $values) { ?>
                                                        <option value="<?php echo $values['tax_id'];?>">
                                                            <?php echo $values['taxname'].' ['.$values['taxdeduction'].'%]';?>
                                                        </option>
                                                        <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-1 add-kit-padding-mview">
                                                <label class="col-form-label">
                                                    <p style="padding-top:50px;font-size:22px;">
                                                        <b>Associate Product</b>
                                                    </p>
                                                </label>    
                                            </div>
                                            <div class="col-sm-11">
                                                <div class="table-responsive1 add-group-scroll-mview">
                                                    <table id="myTable" class="table order-list associate_pro">
                                                        <thead>
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>Basic Unit </th>
                                                                <th style="width:100px">Quantity </th>
                                                                <th>Unit </th>
                                                                <th>Selling Price</th>
                                                                <th>Purchase Price</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="associate_product">
                                                            <tr data-id="0">
                                                                <td>
                                                                    <select class="product_select js-example-data-array col-sm-12" name="item_details[]" id="item_details0" data-id="0" required>
                                                                        <option value="">First Select Company</option>
                                                                        <!-- <?php foreach($product_list as $value)
                                                                        { 
                                                                        ?>
                                                                            <option value="<?php echo $value['product_id'];?>">
                                                                                <?php echo $value['product_name'];?>
                                                                            </option>
                                                                            <?php 
                                                                        } 
                                                                        ?> -->
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                  <input type="text" readonly class="form-control basic_unit" id="basicunit0" name="basicunit[]" value=""> 
                                                                </td>

                                                                <td>
                                                                    <input type="number" min="1" class="form-control quantity" name="quantity[]" value="1">
                                                                </td>
                                                              
                                                                <td class="width-add-kit-152">
																
                                                                    <select class="unit_select js-example-data-array col-sm-12" name="unitid[]" id="unit0">
                                                                        <option value="">Select Unit</option>
                                                                      <?php foreach($unit_list as $row)

                                                                        { 
                                                                        ?>
                                                                            <option value="<?php echo $row['unit_id'];?>">
                                                                                <?php echo $row['unit_name'];?>
                                                                            </option>
                                                                            <?php 
                                                                        } 
                                                                        ?>
                                                                    </select>
                                                                </td>

                                                                <td>
                                                                    <div id="rating0">
                                                                        <input type="number" placeholder="Rs." id="ratesell0" name="sell_price[]" value="0.00" class="form-control sell_price" disabled="disabled" />
                                                                        <input type="hidden" name="sell_price[]" id="hidden_sell0" class='hidden_sell' />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div id="totalamount0">
                                                                        <input type="number" placeholder="Rs." id="ratepur0" name="pur_price[]" class="form-control pur_price" value="0.00" disabled="disabled"/>
                                                                        <input type="hidden" name="pur_price[]" id="hidden_price0" class='hidden_price' />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input id="delete_product1" type="button" class="btn btn-sm btn-danger" value="Delete" title="delete">
                                                                </td>
                                                                <td>
                                                                    <a class="deleteRow"></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td  data-tooltip="Add More Product" style="padding-left:0">
                                                                    <a class="btn btn-primary btn-add-task waves-effect waves-light" id="addrow" href="javascript:void(0);" title="Add More"><i class="icofont icofont-plus"></i> Add More Product </a>
                                                                </td>
                                                                <td></td>
                                                                <td></td>
                                                                 <td>TOTAL (₹) :</td>
                                                                <td>
                                                                    <input type="number" placeholder="Rs." class="form-control" id="subTotal" name="selling_price" disabled="disabled">
                                                                </td>
                                                                <td>
                                                                    <input type="number" placeholder="Rs." class="form-control"  id="ppsubTotal" name="rate[]" disabled="disabled">
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
                                                    <div class="col-sm-9" data-tooltip="Selling Price(INR)">
                                                        <input type="text" id="selling_price" name="selling_price" value="" placeholder="Selling Price" class="form-control" required>
                                                        <div  style="margin:-30px 0 0 230px;" class="font-sm text-open cursor-pointer copy-mview-total" onclick="copytotalsp()">Copy from total</div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label"><b> Account  </b></label>
                                                    <div class="col-sm-9" data-tooltip="Select Account">
                                                        <select name="sales_account" id="sales_account" class="js-example-data-array col-sm-12">
                                                            <option value="">Select Account</option>
                                                            <?php foreach($account_list as $row)
                                                            { 
                                                            ?>
                                                                <option value="<?php echo $row['account_id'];?>">
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
                                                    <div class="col-sm-9" data-tooltip=" Description">
                                                        <textarea rows="5" cols="5" id="sales_desc" name="sales_desc" class="form-control" placeholder="Description" required style="resize:none"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- col-6 -->
                                            <div class="col-md-6">
                                                <h5>Purchase Information</h5>
                                                  <br><br>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label"><b> Purchase Price (INR) </b></label>
                                                    <div class="col-sm-9" data-tooltip=" Purchase Price (INR)">
                                                        <input type="text" id="purchase_price" name="purchase_price" value="" placeholder="Purchase Price" class="form-control" required>
                                                         <div style="margin:-30px 0 0 230px;" class="font-sm text-open cursor-pointer copy-mview-total" onclick="copytotalpp()">Copy from total</div>
                                                    </div>
													
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label"><b> Account  </b></label>
                                                    <div class="col-sm-9" data-tooltip=" Select Account">
                                                        <select name="purchase_account" id="purchase_account" class="js-example-data-array col-sm-12">
                                                            <option value="">Select Account</option>
                                                            <?php foreach($account_list as $row)
                                                            { 
                                                            ?>
                                                                <option value="<?php echo $row['account_id'];?>">
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
                                                    <div class="col-sm-9" data-tooltip=" Description ">
                                                        <textarea rows="5" cols="5" id="purchase_desc" name="purchase_desc" class="form-control" placeholder="Description" required style="resize:none"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end -->

                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-sm-12 text-center" style="margin-top:10px">
                                                    <button  data-tooltip="Save" type="submit" id="submit_kit" class="btn btn-primary">Save</button>
													
                                                    <button  data-tooltip="Reset " type="reset" class="btn btn-default">Reset</button>
                                                </div>
                                            </div>
                                        </div>     
                                        <!-- row end -->
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
    </div> <!-- page-wrapper end -->
    <!-- Main-body end -->
</div><!-- boby end -->
<!-- Select 2 js -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.quicksearch.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/pages/advance-elements/select2-custom.js"></script>

<script type="text/javascript">
    function yesnoCheck() {
        if (document.getElementById('taxable').checked) {
            document.getElementById('tax_type').style.display = 'flex';
        } else document.getElementById('tax_type').style.display = 'none';
    }
</script>

<script type="text/javascript">

    //function to show image preview 
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#uplodeimg').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#uploadfile").change(function() {
      readURL(this);
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
</script>

<script type="text/javascript">

$(function (){
    // function to change the selling and purchase price of the product onchange of quantity
    $("#associate_product").on('change keyup','.quantity',function(){
        var quant      = parseInt($(this).val());
        var sell_price = parseInt($(this).parents('tr').find('td:eq(4) .hidden_sell').val());
        var pur_price  = parseInt($(this).parents('tr').find('td:eq(5) .hidden_price').val());
        var mul_data   = quant * sell_price;
        var mul_datap  = quant * pur_price;
        
        $(this).parents('tr').find('td:eq(4) .sell_price').val(mul_data);
        $(this).parents('tr').find('td:eq(5) .pur_price').val(mul_datap);
        calcPrice();
    });

    // function to select or fetch the selling price of product for selected product from db
    $("#associate_product").on('change keyup','.product_select',function(){
        $(this).find(":selected").parents('tr').find('td:eq(1) .quantity').val('1');
        var item_value  = $(this).find(":selected").val();    
        var id          = $(this).data('id');
        var sell_prices = 0;
        var pur_price = 0;

        $.ajax({
            url: "<?php echo base_url();?>adminkit/ajax_setunit",
            type: 'POST',
            dataType: 'JSON',
            data: {
                'id': id,
                'item_id':item_value,
            },
        }).done(function(res){
            console.log(res);
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
        var compId = $("#companyid").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>adminkit/company_product",
            dataType : "JSON",
            data: {
                compId : compId,
            },
        }).done(function(res){
            var productOptions = '';
            $.each(res,function(index,value){
                productOptions = productOptions + '<option value='+value['product_id']+'>'+value['product_name']+'</option>';
            });
                
            var lasTRow  = parseInt($('#associate_product tr:last').data('id')) + 1;
            var counter  = lasTRow;
            $('#associate_product').append('<tr data-id="'+counter+'"><td><select class="product_select js-example-data-array col-sm-12" name="item_details[]" id="item_details'+counter+'" data-id="'+counter+'" required><option value="">Select Product</option>'+productOptions+'</select></td> <td><input type="text" class="form-control basic_unit" id="basicunit'+counter+'" name="basicunit[]" value="" readonly></td> <td><input type="number" min="1" class="form-control quantity" name="quantity[]" value="1"></td> <td><select class="unit_select js-example-data-array col-sm-12" name="unitid[]" id="unit'+counter+'" required><option value="">Select Unit</option><?php foreach($unit_list as $row){ ?><option value="<?php echo $row['unit_id'];?>"><?php echo $row['unit_name'];?></option><?php } ?></select></td><td><div id="rating'+counter+'"><input type="number" placeholder="Rs." id="ratesell'+counter+'" name="sell_price[]" value="0.00" class="form-control sell_price" disabled="disabled" /><input type="hidden" class="hidden_sell" name="sell_price[]" id="hidden_sell'+counter+'" /></div></td><td><div id="totalamount'+counter+'"><input type="number" placeholder="Rs." id="ratepur'+counter+'" name="pur_price[]" class="form-control pur_price" value="0.00" disabled="disabled" /><input type="hidden" class="hidden_price" name="pur_price[]" id="hidden_price'+counter+'" /></div></td><td><input type="button" id="delete_product" class="btn btn-sm btn-danger" value="Delete"></td><td><a class="deleteRow"></a></td></tr>');
                $('.js-example-data-array').select2();
        });
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


$("#add_new_service").on('change','#companyid',function(){
    var compId = $(this).val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>adminkit/company_product",
        dataType : "JSON",
        data: {
            compId : compId,
        },
    }).done(function(res){
        $(".basic_unit").val("");
        $(".unit_select").val("");
        $(".unit_select").trigger('change');
        if(res.length == 0){
            $(".product_select").html("<option value=''>First Select Company Name</option>");
        }else {
            $(".product_select").html("<option value=''>Select Product</option>");
        }
        $.each(res,function(index,value){
            $('.product_select').append('<option value='+value['product_id']+'>'+value['product_name']+'</option>');
        });
    });
});



</script>
