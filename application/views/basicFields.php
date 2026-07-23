<div class="col-4 mb-4 mt-3">	
    <label for="exampleFormControlFile1">Reference no</label>
    <input type="text" class="form-control" id="reference_no" name="reference_no" value="<?php echo (isset($de_details)&&isset($de_details['reference_no']))?$de_details['reference_no']:''; ?>">
</div>
<div class="col-4 mb-4 mt-3">
    <label for="exampleFormControlFile1">Amount <span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="amount" name="amount" value="<?php echo (isset($de_details)&&isset($de_details['amount']))?$de_details['amount']:''; ?>">
</div>