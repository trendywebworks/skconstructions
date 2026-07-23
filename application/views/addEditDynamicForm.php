<?php
$userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
?>

<div class="row">                
    <div class="col-xl-5 col-lg-5 col-sm-5 layout-spacing">
        <div class="statbox widget box box-shadow">

            <form method="post" action="<?php echo base_url($action); ?>" enctype="multipart/form-data">
                <div class="form-group mb-4">
                    <label for="date">Date <span class="text-danger">*</span></label>
                    <div id="datepickerx" class="input-group datex" data-date-format="dd-mm-yyyy">
                        <input class="form-control" type="date" <?php echo (isset($formCustomization) && in_array('entry_date', $formCustomization['fields']) && $formCustomization['entry_date']['readonly']==1)?'':''; ?> name="date" value="<?php echo (isset($details) && isset($details['entry_date']))?date('Y-m-d', strtotime($details['entry_date'])):date('Y-m-d'); ?>" />
                        <span class="input-group-addon"></span>
                    </div>
                </div>
                <div class="row">
                <?php //echo '<pre>';print_r($fields);
                if(isset($fields))
                {
                    foreach($fields as $field)
                    {
                        if(in_array($field->name, array('id', 'created_at', 'updated_at', 'status', 'company_id', 'remember_token', 'last_logged_in', 'last_ip', 'entry_date')))
                        {
                            continue;
                        }

                        $readonly = '';
                        $name = '';

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
                        <select class="form-control" name="status">
                            <!-- <option value="" <?php echo (!isset($details))?'selected':'';?>>Select</option> -->
                            <option value="active" <?php echo (isset($details) && $details['status'] == 'active')?'selected':''; ?>>Active</option>
                            <option value="inactive" <?php echo (isset($details) && $details['status'] == 'inactive')?'selected':''; ?>>Inactive</option>
                        </select>
                        <?php echo form_error('status','<p class="field-error">','</p>'); ?>
                    </div>
                <?php } ?>

                <input type="submit" name="time" class="mt-4 mb-4 btn btn-primary">
            </form>

        </div>
    </div>
</div>