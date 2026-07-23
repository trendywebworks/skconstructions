<?php
$userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
$isPayPartnerForm = (isset($formLayout) && $formLayout == 'pay_partner');
$isMarketLoansForm = (isset($formLayout) && $formLayout == 'market_loans');
$isVehicleRunningForm = (isset($formLayout) && $formLayout == 'vehicle_running');
$isGstBillForm = (isset($formLayout) && $formLayout == 'gst_bill');
$isFdrForm = (isset($formLayout) && $formLayout == 'fdr');
$isCcAccountForm = (isset($formLayout) && $formLayout == 'cc_account');
$isOfficeExpenseForm = (isset($formLayout) && $formLayout == 'office_expense');
$isStaffLoanForm = (isset($formLayout) && $formLayout == 'staff_loan');
$isSiteForm = (isset($formLayout) && $formLayout == 'site');
$isPartnerForm = (isset($formLayout) && $formLayout == 'partner');
$isOfficeStaffForm = (isset($formLayout) && $formLayout == 'office_staff');
$isLoanPartyForm = (isset($formLayout) && $formLayout == 'loan_party');
$isExpenseTypeForm = (isset($formLayout) && $formLayout == 'expense_type');
$isSupplierForm = (isset($formLayout) && $formLayout == 'supplier');
$isBankForm = (isset($formLayout) && $formLayout == 'bank');
$isUserForm = (isset($formLayout) && $formLayout == 'user');
$isWideDynamicForm = ($isPayPartnerForm || $isMarketLoansForm || $isVehicleRunningForm || $isGstBillForm || $isFdrForm || $isCcAccountForm || $isOfficeExpenseForm || $isStaffLoanForm || $isSiteForm || $isPartnerForm || $isOfficeStaffForm || $isLoanPartyForm || $isExpenseTypeForm || $isSupplierForm || $isBankForm || $isUserForm);
$dateColumn = ($isGstBillForm || $isBankForm)?'col-12':($isWideDynamicForm?'col-md-6':'');
?>

<div class="row">                
    <div class="<?php echo $isWideDynamicForm?'col-xl-8 col-lg-9 col-sm-12':'col-xl-5 col-lg-5 col-sm-5'; ?> layout-spacing">
        <div class="statbox widget box box-shadow">

            <form method="post" action="<?php echo base_url($action); ?>" enctype="multipart/form-data">
                <?php if($isWideDynamicForm) { ?><div class="row"><?php } ?>
                <div class="form-group mb-4 <?php echo $dateColumn; ?>">
                    <label for="date">Date <span class="text-danger">*</span></label>
                    <div id="datepickerx" class="input-group datex" data-date-format="dd-mm-yyyy">
                        <input class="form-control" type="date" <?php echo (isset($formCustomization) && in_array('entry_date', $formCustomization['fields']) && $formCustomization['entry_date']['readonly']==1)?'':''; ?> name="date" value="<?php echo (isset($details) && isset($details['entry_date']))?date('d-m-Y', strtotime($details['entry_date'])):date('d-m-Y'); ?>" />
                        <span class="input-group-addon"></span>
                    </div>
                </div>
                <?php if(!$isWideDynamicForm) { ?><div class="row"><?php } ?>
                <?php //echo '<pre>';print_r($fields);
                if(isset($fields))
                {
                    if($isMarketLoansForm)
                    {
                        $fieldOrder = array_flip(array('party_id', 'loan_amount', 'interest', 'total_installments', 'total_amount', 'remarks'));
                        usort($fields, function($a, $b) use ($fieldOrder) {
                            $aOrder = isset($fieldOrder[$a->name])?$fieldOrder[$a->name]:99;
                            $bOrder = isset($fieldOrder[$b->name])?$fieldOrder[$b->name]:99;

                            if($aOrder == $bOrder)
                            {
                                return 0;
                            }

                            return ($aOrder < $bOrder)?-1:1;
                        });
                    }

                    if($isGstBillForm)
                    {
                        $fieldOrder = array_flip(array('supplier_id', 'particular', 'quantity', 'amount', 'gst', 'total_amount', 'remarks'));
                        usort($fields, function($a, $b) use ($fieldOrder) {
                            $aOrder = isset($fieldOrder[$a->name])?$fieldOrder[$a->name]:99;
                            $bOrder = isset($fieldOrder[$b->name])?$fieldOrder[$b->name]:99;

                            if($aOrder == $bOrder)
                            {
                                return 0;
                            }

                            return ($aOrder < $bOrder)?-1:1;
                        });
                    }

                    if($isFdrForm)
                    {
                        $fieldOrder = array_flip(array('name', 'description', 'amount', 'released_amount', 'remarks'));
                        usort($fields, function($a, $b) use ($fieldOrder) {
                            $aOrder = isset($fieldOrder[$a->name])?$fieldOrder[$a->name]:99;
                            $bOrder = isset($fieldOrder[$b->name])?$fieldOrder[$b->name]:99;

                            if($aOrder == $bOrder)
                            {
                                return 0;
                            }

                            return ($aOrder < $bOrder)?-1:1;
                        });
                    }

                    if($isCcAccountForm)
                    {
                        $fieldOrder = array_flip(array('bank_id', 'loan_amount', 'interest', 'total_amount', 'remarks'));
                        usort($fields, function($a, $b) use ($fieldOrder) {
                            $aOrder = isset($fieldOrder[$a->name])?$fieldOrder[$a->name]:99;
                            $bOrder = isset($fieldOrder[$b->name])?$fieldOrder[$b->name]:99;

                            if($aOrder == $bOrder)
                            {
                                return 0;
                            }

                            return ($aOrder < $bOrder)?-1:1;
                        });
                    }

                    if($isOfficeExpenseForm)
                    {
                        $fieldOrder = array_flip(array('expense_type_id', 'staff_id', 'amount', 'remarks'));
                        usort($fields, function($a, $b) use ($fieldOrder) {
                            $aOrder = isset($fieldOrder[$a->name])?$fieldOrder[$a->name]:99;
                            $bOrder = isset($fieldOrder[$b->name])?$fieldOrder[$b->name]:99;

                            if($aOrder == $bOrder)
                            {
                                return 0;
                            }

                            return ($aOrder < $bOrder)?-1:1;
                        });
                    }

                    if($isStaffLoanForm)
                    {
                        $fieldOrder = array_flip(array('employee_id', 'loan_amount', 'loan_tenure', 'loan_last_date', 'remarks'));
                        usort($fields, function($a, $b) use ($fieldOrder) {
                            $aOrder = isset($fieldOrder[$a->name])?$fieldOrder[$a->name]:99;
                            $bOrder = isset($fieldOrder[$b->name])?$fieldOrder[$b->name]:99;

                            if($aOrder == $bOrder)
                            {
                                return 0;
                            }

                            return ($aOrder < $bOrder)?-1:1;
                        });
                    }

                    if($isSiteForm)
                    {
                        $fieldOrder = array_flip(array('site_name', 'site_address', 'remarks'));
                        usort($fields, function($a, $b) use ($fieldOrder) {
                            $aOrder = isset($fieldOrder[$a->name])?$fieldOrder[$a->name]:99;
                            $bOrder = isset($fieldOrder[$b->name])?$fieldOrder[$b->name]:99;

                            if($aOrder == $bOrder)
                            {
                                return 0;
                            }

                            return ($aOrder < $bOrder)?-1:1;
                        });
                    }

                    if($isPartnerForm)
                    {
                        $fieldOrder = array_flip(array('full_name', 'phone_number', 'email_address', 'id_proof', 'remarks'));
                        usort($fields, function($a, $b) use ($fieldOrder) {
                            $aOrder = isset($fieldOrder[$a->name])?$fieldOrder[$a->name]:99;
                            $bOrder = isset($fieldOrder[$b->name])?$fieldOrder[$b->name]:99;

                            if($aOrder == $bOrder)
                            {
                                return 0;
                            }

                            return ($aOrder < $bOrder)?-1:1;
                        });
                    }

                    if($isOfficeStaffForm)
                    {
                        $fieldOrder = array_flip(array('name', 'phone_number', 'email_address', 'position', 'joining_date', 'id_proof', 'remarks'));
                        usort($fields, function($a, $b) use ($fieldOrder) {
                            $aOrder = isset($fieldOrder[$a->name])?$fieldOrder[$a->name]:99;
                            $bOrder = isset($fieldOrder[$b->name])?$fieldOrder[$b->name]:99;

                            if($aOrder == $bOrder)
                            {
                                return 0;
                            }

                            return ($aOrder < $bOrder)?-1:1;
                        });
                    }

                    if($isLoanPartyForm)
                    {
                        $fieldOrder = array_flip(array('party_name', 'phone', 'address', 'remarks'));
                        usort($fields, function($a, $b) use ($fieldOrder) {
                            $aOrder = isset($fieldOrder[$a->name])?$fieldOrder[$a->name]:99;
                            $bOrder = isset($fieldOrder[$b->name])?$fieldOrder[$b->name]:99;

                            if($aOrder == $bOrder)
                            {
                                return 0;
                            }

                            return ($aOrder < $bOrder)?-1:1;
                        });
                    }

	                    if($isExpenseTypeForm)
	                    {
	                        $fieldOrder = array_flip(array('expense_type', 'expense_title', 'remarks'));
	                        usort($fields, function($a, $b) use ($fieldOrder) {
	                            $aOrder = isset($fieldOrder[$a->name])?$fieldOrder[$a->name]:99;
                            $bOrder = isset($fieldOrder[$b->name])?$fieldOrder[$b->name]:99;

                            if($aOrder == $bOrder)
                            {
                                return 0;
                            }

                            return ($aOrder < $bOrder)?-1:1;
	                        });
	                    }

	                    if($isSupplierForm)
	                    {
	                        $fieldOrder = array_flip(array('firm_name', 'contact_person', 'phone_number', 'email_address', 'address', 'remarks'));
	                        usort($fields, function($a, $b) use ($fieldOrder) {
	                            $aOrder = isset($fieldOrder[$a->name])?$fieldOrder[$a->name]:99;
	                            $bOrder = isset($fieldOrder[$b->name])?$fieldOrder[$b->name]:99;

	                            if($aOrder == $bOrder)
	                            {
	                                return 0;
	                            }

	                            return ($aOrder < $bOrder)?-1:1;
	                        });
	                    }

	                    if($isBankForm)
	                    {
	                        $fieldOrder = array_flip(array('bank_name', 'bank_branch', 'remarks'));
	                        usort($fields, function($a, $b) use ($fieldOrder) {
	                            $aOrder = isset($fieldOrder[$a->name])?$fieldOrder[$a->name]:99;
	                            $bOrder = isset($fieldOrder[$b->name])?$fieldOrder[$b->name]:99;

	                            if($aOrder == $bOrder)
	                            {
	                                return 0;
	                            }

	                            return ($aOrder < $bOrder)?-1:1;
	                        });
	                    }

	                    if($isUserForm)
	                    {
	                        $fieldOrder = array_flip(array('username', 'first_name', 'last_name', 'email', 'phone', 'password', 'cpassword', 'city', 'state', 'address', 'remarks', 'role'));
	                        usort($fields, function($a, $b) use ($fieldOrder) {
	                            $aOrder = isset($fieldOrder[$a->name])?$fieldOrder[$a->name]:99;
	                            $bOrder = isset($fieldOrder[$b->name])?$fieldOrder[$b->name]:99;

	                            if($aOrder == $bOrder)
	                            {
	                                return 0;
	                            }

	                            return ($aOrder < $bOrder)?-1:1;
	                        });
	                    }

			                    if($isVehicleRunningForm)
                    {
                        $fieldOrder = array_flip(array('vehicle_id', 'vehicle_no', 'party_name', 'start_km', 'end_km', 'total_km', 'amount', 'diesel_amount', 'particular', 'income', 'balance', 'remarks'));
                        usort($fields, function($a, $b) use ($fieldOrder) {
                            $aOrder = isset($fieldOrder[$a->name])?$fieldOrder[$a->name]:99;
                            $bOrder = isset($fieldOrder[$b->name])?$fieldOrder[$b->name]:99;

                            if($aOrder == $bOrder)
                            {
                                return 0;
                            }

                            return ($aOrder < $bOrder)?-1:1;
                        });
                    }

                    if($isPayPartnerForm)
                    {
                        $fieldOrder = array_flip(array('p_id', 'amount', 'pay_type', 'pay_for', 'remarks'));
                        usort($fields, function($a, $b) use ($fieldOrder) {
                            $aOrder = isset($fieldOrder[$a->name])?$fieldOrder[$a->name]:99;
                            $bOrder = isset($fieldOrder[$b->name])?$fieldOrder[$b->name]:99;

                            if($aOrder == $bOrder)
                            {
                                return 0;
                            }

                            return ($aOrder < $bOrder)?-1:1;
                        });
                    }

                    foreach($fields as $field)
                    {
                        if(in_array($field->name, array('id', 'created_at', 'updated_at', 'status', 'company_id', 'remember_token', 'last_logged_in', 'last_ip', 'entry_date')))
                        {
                            continue;
                        }

                        $readonly = '';
                        $name = '';
                        $custom = array();

                        $col = '';
                        if(isset($formCustomization) && in_array($field->name, $formCustomization['fields']))
                        {
                            $custom = $formCustomization[$field->name];
                            $col = (isset($custom['column']))?$custom['column']:'';
                        } 

                        $setValue = !empty($postData[$field->name])?$postData[$field->name]:'';
                        if(isset($formCustomization) && isset($custom['value']))
                        {
                            $setValue = $custom['value'];
                        }
                        $fieldValue =  (isset($details) && isset($details[$field->name]))?$details[$field->name]:$setValue; 
                        if($field->type == 'date' || (isset($custom['type']) && $custom['type'] == 'date'))
                        {
                            if($fieldValue != '')
                            {
                                $fieldValue = date('d-m-Y', strtotime($fieldValue));
                            }
                            else if(!isset($details))
                            {
                                $fieldValue = date('d-m-Y');
                            }
                        }
                        
                        //only for expense page - starts
                        if(isset($details) && isset($details[$field->name]) && $field->name=='expense_type'){
                            $details['expense_title'] = $fieldValue;
                        }
                        if(isset($details) && isset($details[$field->name]) && $field->name=='expense'){
                            $details['expense_type'] = $fieldValue;
                        }
                        //only for expense page - ends
                        
                        if(isset($custom['exclude']) && $custom['exclude']==1)
                        {}
                        else{
                    ?>
                        <div class="form-group mb-4 <?php echo $col; ?>">
                            <?php if($field->type == 'datetime') { ?>
                                <label for="date"><?php echo toHeading($field->name); ?> <span class="text-danger">*</span></label>
                                <div id="datepicker" class="input-group date" data-date-format="dd-mm-yyyy">
                                    <input class="form-control" type="text" readonly name="<?php echo $field->name; ?>"/>
                                    <span class="input-group-addon"></span>
                                </div> 
                            <?php } else if(in_array($field->type, array('int','varchar','enum','date','password','double','float', 'select'))) {
                                if(isset($formCustomization) && in_array($field->name, $formCustomization['fields']))
                                {

                                    $readonly = (isset($custom['readonly']))?'readonly':'';
                                    $name = (isset($custom['name']))?$custom['name']:'';
                                    // echo '<pre>';print_r($formCustomization[$field->name]);
                                    if($custom['type'] == 'select')
                                    { 
                                    ?>
                                        <label for="date"><?php echo toHeading($name); ?> <span class="text-danger">*</span></label>
                                        <select class="form-control" name="<?php echo $field->name; ?>" id="<?php echo $field->name; ?>">
                                            <?php
                                            if(isset($custom['values']))
                                            {
                                                echo $custom['values'];
                                            }?>
                                        </select>
                                    <?php
                                    }
                                    else if($custom['type'] == 'file')
                                    {
                                        $fileValue = '';
                                        if(isset($fieldValue))
                                        {
                                            $fileValue = '<br><a href="'.base_url('uploads/').$folder.'/'.$fieldValue.'" target="_blank" class="text-info">'.$fieldValue.'</a><br>';
                                        }
                                    ?>
                                        <label for="date"><?php echo toHeading($name); ?> <span class="text-danger">*</span></label>
                                        <?php echo $fileValue; ?>
                                        <input type="file" class="form-control" name="<?php echo $field->name; ?>" id="<?php echo $field->name; ?>" value="" <?php echo $readonly; ?>>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <label for="date"><?php echo toHeading($name); ?> <span class="text-danger">*</span></label>
                                        <input type="<?php echo $custom['type']; ?>" class="form-control" name="<?php echo $field->name; ?>" id="<?php echo $field->name; ?>" value="<?php echo $fieldValue; ?>" <?php echo $readonly; ?>>
                                    <?php }
                                }
                                else
                                    {
                                    ?>
                                        <label for="date"><?php echo toHeading($field->name); ?> <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="<?php echo $field->name; ?>" id="<?php echo $field->name; ?>" value="<?php echo $fieldValue; ?>">
                                    <?php } ?>
                                
                            <?php } else if($field->type == 'text') { ?>
                                <label for="date"><?php echo toHeading($field->name); ?>
                                 <!-- <span class="text-danger">*</span> -->
                                </label>
                                <textarea class="form-control" rows="3" name="<?php echo $field->name; ?>"><?php echo $fieldValue; ?></textarea>
                            <?php } ?>
                            <?php echo form_error($field->name,'<p class="field-error">','</p>'); ?>
                                
                        </div>
                    <?php }
                    }
                }?></div>

                <?php if($userdata['role_id'] == 1 ) { ?>
                    <div class="form-group mb-4 col-12" >
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <div class="form-check form-switch sk-status-toggle">
                            <input type="hidden" name="status" value="inactive">
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="active" <?php echo (!isset($details) || $details['status'] == 'active')?'checked':''; ?>>
                            <span class="sk-status-text"></span>
                        </div>
                        <?php echo form_error('status','<p class="field-error">','</p>'); ?>
                    </div>
                <?php } ?>

                <input type="submit" name="time" class="mt-4 mb-4 btn btn-primary <?php echo isset($submitButtonClass)?$submitButtonClass:''; ?>">
            </form>

        </div>
    </div>
</div>
