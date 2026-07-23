<hr>
<input type="hidden" name="table_name" value="<?php echo $table_name; ?>">
<?php //echo '<pre>';print_r($details);
if(isset($fields))
{
    foreach($fields as $field)
    {
        if(in_array($field->name, array('id', 'created_at', 'updated_at', 'status', 'company_id', 'remember_token', 'last_logged_in', 'last_ip', 'entry_date', 'remarks')))
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

        if(isset($custom['exclude']) && $custom['exclude']==1)
        {}
        else{
    ?>
        <div class="col-4 mb-4 <?php echo $col; ?>">
            <?php if($field->type == 'datetime') { ?>
                <label for="date"><?php echo toHeading($field->name); ?> <span class="text-danger">*</span></label>
                <div id="datepicker" class="input-group date" data-date-format="dd-mm-yyyy">
                    <input class="form-control" type="text" readonly name="<?php echo $field->name; ?>" required/>
                    <span class="input-group-addon"></span>
                </div> 
            <?php } else if(in_array($field->type, array('int','varchar','enum','date','password'))) { 
                if(isset($formCustomization) && in_array($field->name, $formCustomization['fields']))
                {

                    $readonly = (isset($custom['readonly']))?'readonly':'';
                    $name = (isset($custom['name']))?$custom['name']:'';
                    // echo '<pre>';print_r($custom['type']);
                    if($custom['type'] == 'select')
                    {
                    ?>
                        <label for="date"><?php echo toHeading($name); ?> <span class="text-danger">*</span></label>
                        <select class="form-control" name="<?php echo $field->name; ?>" id="<?php echo $field->name; ?>" required>
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
                        <input type="file" class="form-control" name="<?php echo $field->name; ?>" id="<?php echo $field->name; ?>" value="" <?php echo $readonly; ?> required>
                    <?php
                    }
                    else
                    {
                    ?>
                        <label for="date"><?php echo toHeading($name); ?> <span class="text-danger">*</span></label>
                        <input type="<?php echo $custom['type']; ?>" class="form-control" name="<?php echo $field->name; ?>" id="<?php echo $field->name; ?>" value="<?php echo $fieldValue; ?>" <?php echo $readonly; ?> required>
                    <?php }
                }
                else
                    {
                    ?>
                        <label for="date"><?php echo toHeading($field->name); ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="<?php echo $field->name; ?>" id="<?php echo $field->name; ?>" value="<?php echo $fieldValue; ?>" required>
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
}?>
<hr>