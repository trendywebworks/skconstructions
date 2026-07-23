<?php
$userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height:47px;
    }
</style>
<div class="row">                
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="statbox widget box box-shadow">

            <form action="<?php echo base_url($action); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo (isset($de_details))?$de_details['id']:'0'; ?>">
                <input type="hidden" name="reference_id" value="<?php echo (isset($de_details))?$de_details['reference_id']:'0'; ?>">
                <div class="row">
                    <div class="col-4 mb-4">
                        <label for="date">Date <span class="text-danger">*</span></label>
                        <div id="datepickerx" class="input-group datex" data-date-format="dd-mm-yyyy">
                            <input class="form-control" type="date" name="date" value="<?php echo (isset($details) && isset($details['entry_date']))?date('d-m-Y', strtotime($details['entry_date'])):date('d-m-Y'); ?>"  required/>
                            <span class="input-group-addon"></span>
                        </div>
                    </div>
                    <div class="col-4 mb-4">
                        <label for="exampleFormControlSelect1">Site <span class="text-danger">*</span></label>
                        <select class="form-select" id="exampleFormControlSelect1" name="site" required>
                            <?php echo $sites; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 mb-4">
                        <label for="exampleFormControlSelect2">Expense Type <span class="text-danger">*</span></label>
                        <select class="form-control" id="expense_type" name="expense_type" required>
                            <?php echo $expense_types; ?>
                        </select>
                    </div>
                    <div class="col-4 mb-4">
                        <label for="exampleFormControlSelect2">Expense/Income Options <span class="text-danger">*</span></label>
                        <select class="form-control" id="option" name="option" required>
                            <?php
                            if(isset($expense_options))
                            {
                                foreach($expense_options as $eo)
                                {
                                    if(isset($de_details) && $de_details['expense_id']==$eo['id'])
                                    {
                                        $selected = 'selected';
                                    }
                                    else
                                    {
                                        $selected = '';
                                    }
                                    echo '<option value="'.$eo['id'].'" '.$selected.'>'.$eo['expense_type'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row" id="divForm">
                    <?php echo (isset($divForm))?$divForm:''; ?>
                </div>

                <div class="row">
                    <div class="form-group mb-4 col-4">
                        <label for="exampleFormControlTextarea1">Remarks</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="remarks"><?php echo (isset($de_details) && isset($de_details['remarks']))?$de_details['remarks']:''; ?></textarea>
                    </div>
                </div>

                <?php if($userdata['role_id'] == 1 ) { ?>
                <div class="row">
	                    <div class="form-group mb-4 col-4" >
	                        <label for="exampleFormControlTextarea1">Status</label>
	                        <div class="form-check form-switch sk-status-toggle">
	                            <input type="hidden" name="status" value="inactive">
	                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="active" <?php echo (isset($de_details) && $de_details['status'] == 'active')?'checked':''; ?>>
	                            <span class="sk-status-text"></span>
	                        </div>
	                    </div>
	                </div>
                <?php } ?>
                
                <input type="submit" name="time" class="mt-4 mb-4 btn btn-primary">
            </form>

        </div>
    </div>
</div>
