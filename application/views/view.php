<div class="row">                
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="statbox widget box box-shadow">
        	<div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                    <div class="info">
                        <h4 class=""></h4>
                        <div class="row">
                            <div class="col-lg-11 mx-auto">
                                <div class="row">
			                    	<div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
			                        	<div class="form">
				                            <div class="row">
				                            	<?php 
						                    	if(isset($theads)) 
						                    	{
						                    		if(in_array('image', $theads))
						                    		{
						                    			$imageKey = array_search('image', $theads);
						                    		?>
								                        <div class="col-md-6 mb-3">
						                                    <div class="form-group">
						                                    	<label for="fullName"><?php echo toHeading($theads[$imageKey]); ?></label>
						                                        <br>
						                                    	<?php if(isset($list[$imageKey])){ ?>
						                                        <img src="<?php echo base_url('uploads/profile_pic/').$list[$imageKey]; ?>" width="200">
						                                    	<?php } else { ?>
						                                    	<?php echo 'No Image uploaded'; ?>
						                                    	<?php } ?>
						                                    </div>
						                                </div>
								                    <?php
								                    	unset($theads[$imageKey]);
						                    		}
						                    		foreach($theads as $key => $head)
						                    		{
						                    			$text = '';
						                    			if(isset($list[$key]))
						                    			{
						                    				if($key=='email_address' || $key=='email')
							                    			{
							                    				$text = $list[$key];
							                    			}
							                    			else if($key=='id_proof')
							                    			{
							                    				$text = '<a href="'.base_url('uploads/').$folder.'/'.$list[$key].'" target="_blank">'.$list[$key].'</a>';
							                    			}
							                    			else if($key=='joining_date' || $key=='entry_date' || $key=='created_at')
							                    			{
							                    				$text = dayDateFormat($list[$key]);
							                    			}
							                    			else
							                    			{
							                    				$text = ucfirst($list[$key]);
							                    			}
						                    			}
						                    			
						                    		?>
								                        <div class="col-md-6 mb-3">
						                                    <div class="form-group">
						                                        <label for="fullName"><?php echo toHeading($head); ?></label>
						                                        <br>
						                                        <span><?php echo $text; ?></span>
						                                    </div>
						                                </div>
								                    <?php
								                    }
								                }
								                ?>			                                    
			                            	</div>
							                <div class="col-4 mb-4">
							                    <label for="exampleFormControlTextarea1">Status</label>
							                    <br>
							                    <?php 
							                    if(isset($list) && isset($list['status']))
							                    {
							                    	echo (isset($list) && isset($list['status']) && $list['status']==='active')?'<span class="badge badge-success">Active</span>':'<span class="badge badge-warning">Pending</span>';
							                    } ?>
							                </div>
			                            </div>
			                        </div>
			                    </div>
			                </div>
			            </div>
			        </div>
				</div>
			</div>
        </div>
    </div>
</div>