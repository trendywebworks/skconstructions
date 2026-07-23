<?php $col = 4; //echo '<pre>';print_r($emi_details);?>
<?php if($editRow=='') { $col = 6;?>
<div class="row">
<?php } ?>
	<input type="hidden" name="payment_on" value="<?php echo (isset($emi_details)&&isset($emi_details['id']))?$emi_details['id']:''; ?>">

	<?php
	if($option==3 || $option==8) 
	{
		$total = (isset($emi_details)&&isset($emi_details['total_amount']))?$emi_details['total_amount']:0;
	}
	else if($option==4) 
	{ 
		$total = (isset($emi_details)&&isset($emi_details['amount']))?$emi_details['amount']:0;
	}
	$paid = (isset($paid)&&isset($paid['paid']))?$paid['paid']:0;
	$pending = $total - $paid;
	if(!empty($editRow))
	{
		$pending = $pending + $editRow['de_details']['amount'];
	}
	?>
	<div class="col-<?php echo $col; ?> mb-4 mt-3">	
	    <label for="exampleFormControlFile1">Details</label>
	    <?php if($option==3 || $option==8) { ?>
		    <p>Loan Amount : <strong>₹<?php echo (isset($emi_details)&&isset($emi_details['loan_amount']))?$emi_details['loan_amount']:''; ?></strong></p>
		    <p>Interest : <strong><?php echo (isset($emi_details)&&isset($emi_details['interest']))?$emi_details['interest'].'%':''; ?></strong></p>
		    <p>Total amount : <strong>₹<?php echo (isset($emi_details)&&isset($emi_details['total_amount']))?$emi_details['total_amount']:''; ?></strong></p>
	    <?php } else if($option==4) { ?>
	    	<p>Vehicle No : <strong><?php echo (isset($emi_details)&&isset($emi_details['vehicle_no']))?$emi_details['vehicle_no']:''; ?></strong></p>
		    <p>Amount : <strong>₹<?php echo (isset($emi_details)&&isset($emi_details['amount']))?$emi_details['amount']:''; ?></strong></p>
	    <?php } ?>

		    <p>Pending : <strong>₹<?php echo $pending; ?></strong></p>
	</div>
	<div class="col-<?php echo $col; ?> mb-4 mt-3">
	    <label for="exampleFormControlFile1">Amount <span class="text-danger">*</span></label>
	    <input type="text" class="form-control" id="amount" name="amount" value="<?php echo (!empty($editRow))?$editRow['de_details']['amount']:$pending; ?>">
	</div>
<?php if($editRow=='') { ?>
</div>
<?php } ?>