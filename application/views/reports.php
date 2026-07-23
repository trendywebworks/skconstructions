<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-4">
        <div class="form widget-content-area br-8">
            <form action="<?php echo base_url('reports'); ?>" method="post" id="reportFilter">
                <div class="row mb-4">
                    <div class="col-md-3 d-none" id="allsites">
                        <div class="form-group">
                            <label for="fullName">All Sites</label>
                            <select class="form-select mb-3" id="state" onchange="allsites(this)" onclick="enafun()" >
                                <option value="selct">Select</option>
                                <option value="marketl">All Sites</option>
                                <option value="marketl">Kondagaon</option>
                                <option value="purchase">Lohandiguda</option>
                                <option value="gstbill">Kumarpara</option>
                                <option value="ccaccount">Kondagaon</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3" id="reportype">
                        <div class="form-group">
                            <label for="fullName">Report Types</label>
                            <select class="form-select mb-3" id="report_type" name="report_type" required="required" onchange="reporttype(this)" onclick="enafun()">
                                <option value="">Select</option>
                                <option value="marketl" <?php echo (isset($report_type) && $report_type=='marketl')?'selected':''; ?>>Market Loan</option>
                                <option value="purchase" <?php echo (isset($report_type) && $report_type=='purchase')?'selected':''; ?>>Purchase</option>
                                <option value="gstbill" <?php echo (isset($report_type) && $report_type=='gstbill')?'selected':''; ?>>GST Bill</option>
                                <option value="ccaccount" <?php echo (isset($report_type) && $report_type=='ccaccount')?'selected':''; ?>>CC Account</option>
                                <option value="products" <?php echo (isset($report_type) && $report_type=='products')?'selected':''; ?>>Products</option>
                                <option value="officeex" <?php echo (isset($report_type) && $report_type=='officeex')?'selected':''; ?>>Office Expense</option>
                                <option value="staffl" <?php echo (isset($report_type) && $report_type=='staffl')?'selected':''; ?>>Staff Loan</option>
                                <option value="partn" <?php echo (isset($report_type) && $report_type=='partn')?'selected':''; ?>>Partners</option>
                                <option value="paypartn" <?php echo (isset($report_type) && $report_type=='paypartn')?'selected':''; ?>>Partner Payments</option>
                                <option value="vehicls" <?php echo (isset($report_type) && $report_type=='vehicls')?'selected':''; ?>>Vehicles</option>
                            </select>
                            <?php echo form_error('report_type','<p class="field-error">','</p>'); ?>
                        </div>
                    </div>

                    <div class="col-md-3 d-none" id="reportfor">
                        <div class="form-group">
                        <label for="reportforena">Report For</label>
                            <select class="form-select mb-3" 
                            onchange="reportforf(this)" id="reportforena" disabled>
                                <option selected="">Select</option>
                                <option value="site">Site</option>
                                <option value="officestaff"  >Office Staff</option>
                                <option value="vehicles"  >Vehicles</option>
                                <option value="loanparty"  >Loan Party</option>
                                <option value="supplier"  >Supplier</option>
                                <option value="employee"  >Employee</option>
                                <option value="bank"  >Bank</option>
                            </select>
                        </div>
                    </div>
                
                    <div class="col-md-3 <?php echo (isset($report_type) && ($report_type=='partn' || $report_type=='paypartn'))?'':'d-none'; ?>" id="partnersname">
                        <div class="form-group">
                            <label for="partnernena">Partners Name</label>
                            <select class="form-select mb-3" id="partnernena" name="partner_name">
                                <option value="">Select</option>
                                <?php
                                if(isset($partners))
                                {
                                    foreach($partners as $part)
                                    { ?>
                                        <option value="<?php echo $part['id']; ?>" <?php echo (isset($partner_name) && $partner_name!='' && $partner_name==$part['id'])?'selected':''; ?>><?php echo $part['full_name']; ?></option>
                                    <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 d-none" id="sitename">
                        <div class="form-group">
                            <label for="sitenena">Site Name</label>
                            <select class="form-select mb-3" id="sitenena" disabled>
                                <option selected="">Select</option>
                                <option>Kondagon Site</option>
                                <option >Kumarpara Site</option>
                                <option>Rohan Traders</option>
                                <option>Rohit</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 <?php echo (isset($report_type) && $report_type=='vehicls')?'':'d-none'; ?>" id="vehiclneno">
                        <div class="form-group" >
                        <label for="vehiclnena">Vehicle Name</label>
                            <select class="form-select mb-3" id="vehiclnena" name="vehicle_name">
                                <option value="">Select</option>
                                <?php
                                if(isset($vehicles))
                                {
                                    foreach($vehicles as $vn)
                                    { ?>
                                        <option value="<?php echo $vn['id']; ?>" <?php echo (isset($vehicle_name) && $vehicle_name!='' && $vehicle_name==$vn['id'])?'selected':''; ?>><?php echo $vn['vehicle_name']; ?></option>
                                    <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 <?php echo (isset($report_type) && $report_type=='vehicls')?'':'d-none'; ?>" id="vehicleno">
                        <div class="form-group" >
                        <label for="vehiclena">Vehicle No</label>
                            <select class="form-select mb-3" id="vehiclena" name="vehicle_no">
                                <option value="">Select</option>
                                <?php
                                if(isset($vehicles))
                                {
                                    foreach($vehicles as $vno)
                                    { ?>
                                        <option value="<?php echo $vno['id']; ?>" <?php echo (isset($vehicle_no) && $vehicle_no!='' && $vehicle_no==$vno['id'])?'selected':''; ?>><?php echo $vno['vehicle_no']; ?></option>
                                    <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 <?php echo (isset($report_type) && $report_type=='staffl')?'':'d-none'; ?>" id="staffn">
                        <div class="form-group" >
                            <label for="staffena">Staff Name</label>
                            <select class="form-select mb-3" id="staffena" name="staffname">
                                <option value="">Select</option>
                                <?php
                                if(isset($staffs))
                                {
                                    foreach($staffs as $st)
                                    { ?>
                                        <option value="<?php echo $st['id']; ?>" <?php echo (isset($staffname) && $staffname!='' && $staffname==$st['id'])?'selected':''; ?>><?php echo $st['name']; ?></option>
                                    <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 <?php echo (isset($report_type) && $report_type=='marketl')?'':'d-none'; ?>" id="lpartyname">
                        <div class="form-group" >
                            <label for="loanpena">Loan Party Name</label>
                            <select class="form-select mb-3" name="loan_party_name" id="loanpena">
                                <option value="">Select</option>
                                <?php
                                if(isset($loan_party))
                                {
                                    foreach($loan_party as $lp)
                                    { ?>
                                        <option value="<?php echo $lp['id']; ?>" <?php echo (isset($loan_party_name) && $loan_party_name!='' && $loan_party_name==$lp['id'])?'selected':''; ?>><?php echo $lp['party_name']; ?></option>
                                    <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 <?php echo (isset($report_type) && $report_type=='ccaccount')?'':'d-none'; ?>" id="partyname">
                        <div class="form-group" >
                            <label for="partynena">Bank Name</label>
                            <select class="form-select mb-3" id="partynena" name="bankname">
                                <option value="">Select</option>
                                <?php
                                if(isset($banks))
                                {
                                    foreach($banks as $bk)
                                    { ?>
                                        <option value="<?php echo $bk['id']; ?>" <?php echo (isset($bankname) && $bankname!='' && $bankname==$bk['id'])?'selected':''; ?>><?php echo $bk['bank_name']; ?></option>
                                    <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 <?php echo (isset($report_type) && ($report_type=='purchase' || $report_type=='gstbill'))?'':'d-none'; ?>" id="suppliern">
                        <div class="form-group">
                            <label for="supplierena">Supplier Name</label>
                            <select class="form-select mb-3" id="supplierena" name="supplierename">
                                <option value="">Select</option>
                                <?php
                                if(isset($suppliers))
                                {
                                    foreach($suppliers as $sp)
                                    { ?>
                                        <option value="<?php echo $sp['id']; ?>" <?php echo (isset($supplierename) && $supplierename!='' && $supplierename==$sp['id'])?'selected':''; ?>><?php echo $sp['firm_name']; ?></option>
                                    <?php } } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3 <?php echo (isset($report_type) && $report_type=='officeex')?'':'d-none'; ?>" id="officeexpentypeopt">
                        <div class="form-group" >
                            <label for="state">Cashflow</label>
                            <select class="form-select" id="officeexenabletypeopt" name="office_expense_name_type_opt">
                                <option value="">Select</option>
                                <?php
                                if(isset($office_expense_type_options))
                                {
                                    foreach($office_expense_type_options as $oetno)
                                    { ?>
                                        <option value="<?php echo $oetno['id']; ?>" <?php echo (isset($office_expense_name_type_opt) && $office_expense_name_type_opt!='' && $office_expense_name_type_opt==$oetno['id'])?'selected':''; ?>><?php echo $oetno['title']; ?></option>
                                    <?php } } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3 <?php echo (isset($report_type) && $report_type=='officeex')?'':'d-none'; ?>" id="officeexpen">
                        <div class="form-group" >
                            <label for="state">Office Expenses</label>
                            <select class="form-select" id="officeexenable" name="office_expense_name">
                                <option value="">Select</option>
                                <?php
                                if(isset($office_expense_name) && isset($office_expense_types))
                                {
                                    foreach($office_expense_types as $oet)
                                    { ?>
                                        <option value="<?php echo $oet['id']; ?>" <?php echo (isset($office_expense_name) && $office_expense_name!='' && $office_expense_name==$oet['id'])?'selected':''; ?>><?php echo $oet['expense_type']; ?></option>
                                    <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 <?php echo (isset($report_type) && $report_type=='products')?'':'d-none'; ?>" id="productname">
                        <div class="form-group" >
                            <label for="state">Product name</label>
                            <select class="form-select" id="prodnenable" name="product_name">
                                <option value="">Select</option>
                                <?php
                                if(isset($products))
                                {
                                    foreach($products as $pr)
                                    { ?>
                                        <option value="<?php echo $pr['id']; ?>" <?php echo (isset($product_name) && $product_name!='' && $product_name==$pr['id'])?'selected':''; ?>><?php echo $pr['product_name']; ?></option>
                                    <?php } } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3" id="particu">
                        <div class="form-group" >
                            <label for="state">Search Term</label>
                            <input type="text" class="form-control" name="search_term" value="<?php echo (isset($search_term) && $search_term!='')?$search_term:''; ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label for="date">Start Date</label>
                            <div id="datepickerx" 
                                class="input-groupx datex" 
                                data-date-format="dd-mm-yyyy">
                                <input class="form-control" style="" 
                                    type="date" name="start_date" value="<?php echo (isset($start_date) && $start_date!='')?date('d-m-Y', strtotime($start_date)):''; ?>" />
                                <span class="input-group-addon">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label for="date">End Date</label>
                            <div id="datepicker2x" 
                                class="input-groupx datex" 
                                data-date-format="dd-mm-yyyy">
                                <input class="form-control" 
                                    type="date" name="end_date" value="<?php echo (isset($end_date) && $end_date!='')?date('d-m-Y', strtotime($end_date)):''; ?>" />
                                <span class="input-group-addon">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-1">
                    <div class="form-group text-start">
                        <button class="btn btn-primary _effect--ripple waves-effect waves-light" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
  
 
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <?php if(isset($list) && isset($list[0])) { ?> 
                    <table id="html5-extension" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <?php if (isset($list[0]) && array_key_exists('created_at', $list[0])) { ?>
                                <th>Date</th>
                                <?php 
                                }
                                $lk = 0;
                                if(isset($list[0]))
                                {
                                    foreach($list[0] as $liheadKey => $lihead) 
                                    { 
                                        if(in_array($liheadKey, array('id', 'created_at')))
                                        { continue; } ?>
                                        <th><?php echo toHeading($liheadKey); ?></th>
                                <?php $lk++; } } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach($list as $li)
                            {
                                ?>
                                <tr>
                                    <?php if (array_key_exists('created_at', $list[0])) { ?>
                                    <td>
                                        <span class="inv-date"><?php echo dayDateFormat($li['created_at']); ?></span>
                                    </td>
                                    <?php
                                    } 
                                    foreach($li as $key => $value) 
                                    { 
                                        if(in_array($key, array('id', 'created_at')))
                                        { continue; }
                                    ?>
                                        <td><?php echo $value; ?></td>
                                    <?php
                                    }
                                    ?>
                                </tr>
                            <?php } ?>
                        </tbody>

                        <?php if(isset($tfooter)) { ?>
                        <tfoot>
                            <tr>
                                <?php 
                                echo '<th colspan="'.$tfooter['colspan'].'">'.$tfooter['title'].'</th>';
                                foreach($tfooter['sum_cols'] as $sc)
                                {
                                    echo '<th class="sumcol" data-id="'.$sc.'"></th>';
                                }
                                for($lf =1; $lf <= $tfooter['empty']; $lf++)
                                {
                                    echo '<th></th>';
                                }
                                
                                ?>
                            </tr>
                        </tfoot>
                    <?php } ?>
                </table>
            <?php } else { echo 'No results to show.'; } ?>
        </div>
    </div>
</div>
<?php //} ?>
<!-- For report filter -->


</div>
