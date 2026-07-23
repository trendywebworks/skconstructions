<?php
$userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
?>
<div class="row mb-3">
    <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-4">
        <div class="form widget-content-area br-8">
            <form action="<?php echo base_url('daily-entry-list'); ?>" method="post" id="listFilter">
                <div class="row mb-4">
                    <div class="col-md-3" id="status">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-select mb-3" id="status" name="status">
                                <option value="active" <?php echo isset($status) && $status=='active'?'selected':''; ?>>Approved</option>
                                <option value="inactive" <?php echo isset($status) && $status=='inactive'?'selected':''; ?>>Pending</option>
                                <option value="delete_pending" <?php echo isset($status) && $status=='delete_pending'?'selected':''; ?>>Delete Pending</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3" id="from">
                        <div class="form-group">
                            <label for="from">From date</label>
                            <input type="date" name="from" value="<?php echo isset($fromDate)?$fromDate:''; ?>" class="form-control dayDateFormat">
                        </div>
                    </div>
                    <div class="col-md-3" id="to">
                        <div class="form-group">
                            <label for="to">To Date</label>
                            <input type="date" name="to" value="<?php echo isset($toDate)?$toDate:''; ?>" class="form-control dayDateFormat">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="filter">&nbsp;</label>
                            <input class="btn btn-primary btn-sm _effect--ripple waves-effect waves-light" type="submit" name="filter" value="Filter">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>   

<div class="row">                
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">

        <?php if ($this->session->flashdata('success')) {?>
            <div class="col-sm-12 mt-3">
                <div class="alert  alert-success alert-dismissible fade show" role="alert">
                    <span class="badge badge-pill badge-success">Success</span> 
                    <?php echo $this->session->flashdata('success');?>
                    <button type="button" class="close btnn-close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        <?php }?>
        <?php if ($this->session->flashdata('error')) {?>
            <div class="col-sm-12 mt-3">
                <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                    <span class="badge badge-pill badge-danger">Error</span> 
                    <?php echo $this->session->flashdata('error'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        <?php }?>
        
        <div class="statbox widget box box-shadow">
            <form action="<?php echo base_url('daily-entry-list'); ?>" method="post" id="statusChange">
                <input type="hidden" name="hidstatus" value="<?php echo isset($status)?$status:'inactive'; ?>">
                <input type="hidden" name="hidfrom" value="<?php echo isset($fromDate)?$fromDate:date('Y-m-d'); ?>">
                <input type="hidden" name="hidto" value="<?php echo isset($toDate)?$toDate:date('Y-m-d'); ?>">
                <table id="html5-extension" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                        	<?php 
                        	if(isset($theads)) 
                        	{
                        		foreach($theads as $head)
                        		{
                        		?>
    		                        <th><?php echo toHeading($head); ?></th>
    		                    <?php
    		                    }
    		                }
    		                ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(isset($list)) 
                        {
                            foreach($list as $nm => $li)
                            {
                                $edit = $titles['edit'].'/'.$li['id'];
                            ?>
                                <tr>
                                    <td><input type="checkbox" name="selectRow[]" class="selectRow" value="<?php echo $li['id']; ?>"><?php echo $nm+1; ?></td>
                                    <td><span class="inv-date"> <?php echo commonDateFormat($li['entry_date']); ?> </span></td>
                                    <?php 
                                    foreach($li as $key => $value) 
                                    { 
                                        if(in_array($key, array('id', 'created_at', 'entry_date', 'table_name')))
                                        { continue; }
    
                                        if(in_array($key, array('id_proof')))
                                        {
                                            $value = '<a href="'.base_url('uploads/').$folder.'/'.$value.'" target="_blank" class="text-info">'.$value.'</a>';
                                        }
    
                                        $colvalue = $value;
                                        if(in_array($key, array('joining_date')))
                                        {
                                            $colvalue = date('d-m-Y', strtotime($value));
                                        }
    
                                        if($key === 'status')
                                        {
                                            if($value==='active'){
                                                $colvalue = '<span class="badge badge-success">Approved</span>';
                                            }
                                            else if($value==='inactive'){
                                                $colvalue = '<span class="badge badge-warning">Pending</span>';
                                            }
                                            else if($value==='delete_pending'){
                                                $colvalue = '<span class="badge badge-warning">Delete Pending</span>';
                                            }
                                        }
                                        ?>
                                        <td><?php echo $colvalue; ?></td>
                                    <?php } ?>
                                    <td>
                                        <?php if(isset($li['table_name']) && $li['table_name'] !==NULL) {} else {?>
                                        <a href="<?php echo base_url($edit); ?>" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Edit" data-bs-original-title="Edit" aria-label="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                                    <?php } ?>
                                        <a href="<?php echo base_url($view).'/'.$li['id']; ?>" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="View" data-bs-original-title="View" aria-label="View"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12.01 20c-5.065 0-9.586-4.211-12.01-8.424 2.418-4.103 6.943-7.576 12.01-7.576 5.135 0 9.635 3.453 11.999 7.564-2.241 4.43-6.726 8.436-11.999 8.436zm-10.842-8.416c.843 1.331 5.018 7.416 10.842 7.416 6.305 0 10.112-6.103 10.851-7.405-.772-1.198-4.606-6.595-10.851-6.595-6.116 0-10.025 5.355-10.842 6.584zm10.832-4.584c2.76 0 5 2.24 5 5s-2.24 5-5 5-5-2.24-5-5 2.24-5 5-5zm0 1c2.208 0 4 1.792 4 4s-1.792 4-4 4-4-1.792-4-4 1.792-4 4-4z"/></svg></a>
                                        <a href="<?php echo base_url($delete).'/'.$li['id']; ?>" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="View" data-bs-original-title="View" aria-label="View" onclick="return confirm('Are you sure you want to delete this?');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m3 0V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        </a>
                                    
                                    </td>
                                </tr>
                            <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <?php 
                            if(isset($tfooter))
                            {
                                echo '<th class="text-empty" colspan="'.$tfooter['colspan'].'">'.$tfooter['title'].'</th>';
                                foreach($tfooter['sum_cols'] as $sc)
                                {
                                    echo '<th class="sumcol" data-id="'.$sc.'"></th>';
                                }
                                for($lf =1; $lf <= $tfooter['empty']; $lf++)
                                {
                                    echo '<th></th>';
                                }
                            }
                            else if(isset($theads)) 
                            {
                                foreach($theads as $head)
                                {
                                ?>
                                    <th><?php echo toHeading($head); ?></th>
                                <?php
                                }
                            }
                            ?>
                        </tr>
                    </tfoot>
                </table>
                <?php if($userdata['role_id'] == 1 ) { ?>
                <div class="row">
                    <div class="col-sm-6 mt-3"></div>
                    <div class="col-sm-2 mt-3">
                        <input type="submit" class="btn btn-lg btn-success" name="approve" value="Approve">
                    </div>
                    <div class="col-sm-2 mt-3">
                        <input type="submit" class="btn btn-lg btn-warning" name="pending" value="Pending">
                    </div>
                    <div class="col-sm-2 mt-3">
                        <input type="submit" class="btn btn-lg btn-danger" name="delete" value="Delete">
                    </div>
                </div>
                <?php } ?>
            </form>
        </div>

    </div>
</div>


