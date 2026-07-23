<?php
$userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
?>
<div class="row mb-3">
    <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-4">
        <div class="form widget-content-area br-8">
            <form action="<?php echo base_url('daily-entry-list'); ?>" method="post" id="listFilter">
                <div class="row g-3 align-items-end mb-4 sk-list-filter-row">
                    <div class="col-md-3" id="filter-status">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-select mb-3" id="status" name="status">
                                <option value="all" <?php echo isset($status) && $status=='all'?'selected':''; ?>>All</option>
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
                    <div class="col-md-auto">
                        <div class="form-group">
                            <input class="btn btn-primary _effect--ripple waves-effect waves-light" type="submit" name="filter" value="Filter">
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
                <input type="hidden" name="hidstatus" value="<?php echo isset($status)?$status:'all'; ?>">
                <input type="hidden" name="hidfrom" value="<?php echo isset($fromDate)?$fromDate:date('d-m-Y'); ?>">
                <input type="hidden" name="hidto" value="<?php echo isset($toDate)?$toDate:date('d-m-Y'); ?>">
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
                                    <td class="text-center"><input type="checkbox" name="selectRow[]" class="selectRow" value="<?php echo $li['id']; ?>"></td>
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
                                        <div class="sk-row-actions" role="group" aria-label="Row actions">
                                        <?php if(isset($li['table_name']) && $li['table_name'] !==NULL) {} else {?>
                                        <a href="<?php echo base_url($edit); ?>" class="sk-action-btn sk-action-edit bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Edit" data-bs-original-title="Edit" aria-label="Edit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.85 2.85 0 0 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                                    <?php } ?>
                                        <a href="<?php echo base_url($view).'/'.$li['id']; ?>" class="sk-action-btn sk-action-view bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="View" data-bs-original-title="View" aria-label="View"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>
                                        <?php if($userdata['role_id'] == 1 ) { ?>
                                            <a href="<?php echo base_url($delete).'/'.$li['id']; ?>" class="sk-action-btn sk-action-delete bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Delete" data-bs-original-title="Delete" aria-label="Delete" onclick="return confirm('Are you sure you want to delete this?');"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path><path d="M10 11v6"></path><path d="M14 11v6"></path><path d="M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2"></path></svg></a>
                                        <?php } ?>
                                        </div>
                                    
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
                    <div class="col-12 mt-3">
                        <div class="btn-group sk-bulk-actions" role="group" aria-label="Bulk status actions">
                            <input type="submit" class="btn btn-success" name="approve" value="Approve">
                            <input type="submit" class="btn btn-warning" name="pending" value="Pending">
                            <input type="submit" class="btn btn-danger" name="delete" value="Delete">
                        </div>
                    </div>
                </div>
                <?php } ?>
            </form>
        </div>

    </div>
</div>
