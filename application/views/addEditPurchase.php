<?php
$userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
?>

<div class="row">                
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="statbox widget box box-shadow">

            <form action="<?php echo base_url().$action; ?>" method="post" id="purchaseAddEditForm">
                <div class="row">
                    <div class="col-4 mb-4">
                        <label for="date">Date</label>
                        <div id="datepickerx" class="input-group datex" data-date-format="dd-mm-yyyy">
                            <input class="form-control" type="date" name="date" value="<?php echo (isset($details) && isset($details[0]['entry_date']))?date('d-m-Y', strtotime($details[0]['entry_date'])):date('d-m-Y'); ?>" />
                            <span class="input-group-addon"></span>
                            <?php echo form_error('date','<p class="field-error">','</p>'); ?>
                        </div>
                    </div>
                    <div class="col-4 mb-4">
                        <label for="exampleFormControlSelect1">Reference No</label>
                        <input type="text" class="form-control" name="reference_no" value="<?php echo (isset($details) && isset($details[0]['reference_no']))?$details[0]['reference_no']:$referenceNo; ?>" required readonly>
                        <?php echo form_error('reference_no','<p class="field-error">','</p>'); ?>
                    </div>
                    <div class="col-4 mb-4">
                        <label for="exampleFormControlSelect1">Supplier Name</label>
                        <select class="form-select" id="exampleFormControlSelect1" name="supplier_id" required>
                            <?php echo $suppliers; ?>
                        </select>
                        <?php echo form_error('supplier_id','<p class="field-error">','</p>'); ?>
                    </div>
                </div>
                <?php 
                if(isset($details)) 
                {
                    $detKey = 0;
                    foreach($details as  $det)
                    {
                        $detKey++;
                    ?>
                        <div class="row addMore" id="addMore<?php echo $detKey; ?>">
                            <div class="col-3 mb-4">
                                <input type="hidden" name="purchase_details_id[]" value="<?php echo ($det['id']!='')?$det['id']:''; ?>">
                                <label for="particular">Particular</label>
                                <input type="text" class="form-control" name="edit_particular[]" required value="<?php echo ($det['particular']!='')?$det['particular']:''; ?>">
                                <?php echo form_error('particular','<p class="field-error">','</p>'); ?>
                            </div>
                            <div class="col-xs-12 col-sm-2">
                                <div class="form-group mb-4">
                                    <label for="particular">Quantity</label>
                                    <input type="number" class="form-control" name="edit_quantity[]" id="quantity<?php echo $detKey; ?>" required onkeyup="doCalculation('<?php echo $detKey; ?>');" value="<?php echo ($det['quantity']!='')?$det['quantity']:''; ?>">
                                    <?php echo form_error('quantity','<p class="field-error">','</p>'); ?>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-2">
                                <div class="form-group mb-4">
                                    <label for="particular">Amount</label>
                                    <input type="text" class="form-control" name="edit_amount[]" id="amount<?php echo $detKey; ?>" required onkeyup="doCalculation('<?php echo $detKey; ?>');" value="<?php echo ($det['amount']!='')?$det['amount']:''; ?>">
                                    <input type="hidden" name="edit_subtotal[]" id="subtotal<?php echo $detKey; ?>" value="<?php echo ($det['subtotal']!='')?$det['subtotal']:''; ?>">
                                    <?php echo form_error('amount','<p class="field-error">','</p>'); ?>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-2">
                                <div class="form-group mb-2">
                                    <label for="particular">GST(%)</label>
                                    <input type="text" class="form-control" name="edit_gst[]"  id="gst<?php echo $detKey; ?>" required onkeyup="doCalculation('<?php echo $detKey; ?>');" value="<?php echo ($det['gst']!='')?$det['gst']:''; ?>">
                                    <input type="hidden" name="edit_gst_amount[]" id="gst_amount<?php echo $detKey; ?>" value="<?php echo ($det['gst_amount']!='')?$det['gst_amount']:''; ?>">
                                    <?php echo form_error('gst','<p class="field-error">','</p>'); ?>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-2">
                                <div class="form-group mb-2">
                                    <label for="particular">Total</label>
                                    <input type="text" class="form-control alltotal" name="edit_total[]" id="total<?php echo $detKey; ?>" required readonly value="<?php echo ($det['total']!='')?$det['total']:''; ?>">
                                    <?php echo form_error('gst','<p class="field-error">','</p>'); ?>
                                </div>
                            </div>
                            <div class="col-1">
                                <img src="<?php echo base_url('themes/images/trash.png'); ?>" width="20" class="text-danger" onclick="removeAddMore('<?php echo $detKey; ?>')">
                            </div>
                        </div>
                    <?php
                    }
                }
                else
                {?>
                    <div class="row addMore">
                        <div class="col-4 mb-4">
                            <label for="particular">Particular</label>
                            <input type="text" class="form-control" name="particular[]" required>
                            <?php echo form_error('particular','<p class="field-error">','</p>'); ?>
                        </div>
                        <div class="col-xs-12 col-sm-2">
                            <div class="form-group mb-4">
                                <label for="particular">Quantity</label>
                                <input type="number" class="form-control" name="quantity[]" id="quantity1" required onkeyup="doCalculation('1');">
                                <?php echo form_error('quantity','<p class="field-error">','</p>'); ?>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-2">
                            <div class="form-group mb-4">
                                <label for="particular">Amount</label>
                                <input type="text" class="form-control" name="amount[]" id="amount1" required onkeyup="doCalculation('1');">
                                <input type="hidden" name="subtotal[]" id="subtotal1">
                                <?php echo form_error('amount','<p class="field-error">','</p>'); ?>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-2">
                            <div class="form-group mb-2">
                                <label for="particular">GST(%)</label>
                                <input type="text" class="form-control" name="gst[]"  id="gst1" required onkeyup="doCalculation('1');">
                                <input type="hidden" name="gst_amount[]" id="gst_amount1">
                                <?php echo form_error('gst','<p class="field-error">','</p>'); ?>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-2">
                            <div class="form-group mb-2">
                                <label for="particular">Total</label>
                                <input type="text" class="form-control alltotal" name="total[]" id="total1" required readonly>
                                <?php echo form_error('gst','<p class="field-error">','</p>'); ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div id="addMoreLine"></div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <div class="form-group mb-4">
                            <label for="particular"></label>
                            <button type="button" id="purchaseAddmore" class="btn btn-xs btn-info pull-right" style="float: right;">Add more</button>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="particular">Total Amount</label>
                    <input class="form-control" id="disabledInput" type="text" value="<?php echo (isset($details) && isset($details[0]['total_amount']))?$details[0]['total_amount']:0; ?>" placeholder="" readonly name="total_amount" required>
                    <?php echo form_error('total_amount','<p class="field-error">','</p>'); ?>
                </div>
                <div class="form-group mb-4">
                    <label for="particular">Remarks</label>
                    <textarea class="form-control" id="disabledInput" type="text" placeholder="" name="remarks"><?php echo (isset($details) && isset($details[0]['remarks']))?$details[0]['remarks']:''; ?></textarea>
                    <?php echo form_error('remarks','<p class="field-error">','</p>'); ?>
                </div>

                <?php if($userdata['role_id'] == 1 ) { ?>
                    <div class="form-group mb-4 col-4" >
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select class="form-control" name="status">
                            <!-- <option value="" <?php echo (!isset($details))?'selected':'';?>>Select</option> -->
                            <option value="active" <?php echo (isset($details) && $details[0]['pstatus'] == 'active')?'selected':''; ?>>Active</option>
                            <option value="inactive" <?php echo (isset($details) && $details[0]['pstatus'] == 'inactive')?'selected':''; ?>>Inactive</option>
                        </select>
                        <?php echo form_error('status','<p class="field-error">','</p>'); ?>
                    </div>
                <?php } ?>
                <input type="submit" name="time" class="mt-4 mb-4 btn btn-primary">
            </form>

        </div>
    </div>
</div>
