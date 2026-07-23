<div class="row">                
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="statbox widget box box-shadow">

            <form action="<?php echo base_url().$action; ?>" method="post" id="purchaseAddEditForm">
                <div class="row">
                    <div class="col-4 mb-4">
                        <label for="date">Date</label>
                        <div id="datepickerx" class="input-group datex" data-date-format="dd-mm-yyyy">
                            <input class="form-control" type="date" name="date" value="<?php echo (isset($details) && isset($details[0]['entry_date']))?date('Y-m-d', strtotime($details[0]['entry_date'])):date('Y-m-d'); ?>" />
                            <span class="input-group-addon"></span>
                            <?php echo form_error('date','<p class="field-error">','</p>'); ?>
                        </div>
                    </div>
                    <div class="col-4 mb-4">
                        <label for="exampleFormControlSelect1">Role</label>
                        <input type="text" class="form-control" name="name" value="<?php echo (isset($details) && isset($details[0]['name']))?$details[0]['name']:''; ?>" required>
                        <?php echo form_error('name','<p class="field-error">','</p>'); ?>
                    </div>
                </div>
                <div class="row">
                    <label>Permissions</label>
                    <div class="float-right"><input type="checkbox" id="toggleCheckbox" onchange="toggleCheckboxes()">Select/Deselect All</div>
                    <hr>
                <?php 
                if(isset($permissions)) 
                {
                    $permited = (isset($details))?array_column($details, 'permission_id'):[];

                    $detKey = 0;
                    foreach($permissions as  $det)
                    {
                        $detKey++;
                        $role_label = ucwords(str_replace('-', ' ', $det['name']));
                    ?>
                        <div class="col-3 mb-4">
                            <input type="checkbox" class="form-controlx permission_checkboxes" name="permission_id[]" value="<?php echo ($det['id']!='')?$det['id']:''; ?>" <?php echo (isset($permited) && in_array($det['id'], $permited))?'checked':''; ?>> <label for="particular"><?php echo $role_label; ?></label>
                            <?php echo form_error('permission_id','<p class="field-error">','</p>'); ?>
                        </div>
                    <?php
                    }
                }
                ?>
                </div>


                <input type="submit" name="time" class="mt-4 mb-4 btn btn-primary">
            </form>

        </div>
    </div>
</div>