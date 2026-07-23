<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-4">
        <div class="form widget-content-area br-8">
            <form action="<?php echo base_url('site-expenses'); ?>" method="post" id="siteFilter">
                <div class="row mb-4">
                    <div class="col-md-3" id="allsites">
                        <div class="form-group">
                            <label for="fullName">Sites <span class="text-danger">*</span></label>
                            <select class="form-select mb-3" id="site" name="site">
                                <option value="">Select</option>
                                <?php
                                if(isset($sites) && count($sites) > 0)
                                {
                                    foreach($sites as $si)
                                    {
                                    ?>
                                    <option value="<?php echo $si['id']; ?>" <?php echo (isset($site) && $site!='' && $site==$si['id'])?'selected':''; ?>><?php echo $si['site_name']; ?></option>
                                    <?php
                                    }
                                }?>
                            </select>
                            <?php echo form_error('site','<p class="field-error">','</p>'); ?>
                        </div>
                    </div>
                    <div class="col-md-3" id="particu">
                        <div class="form-group" >
                            <label for="state">Search Term</label>
                            <input type="text" class="form-control" name="search_term" value="<?php echo (isset($search_term) && $search_term!='')?$search_term:''; ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label for="date">Start Date</label>
                            <div id="datepickerx" 
                                class="input-groupx datex" 
                                data-date-format="dd-mm-yyyy">
                                <input class="form-control" style="" 
                                    type="date" name="start_date" value="<?php echo (isset($start_date) && $start_date!='')?date('d-m-Y', strtotime($start_date)):''; ?>" />
                                <span class="input-group-addon">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label for="date">End Date</label>
                            <div id="datepicker2x" 
                                class="input-groupx datex" 
                                data-date-format="dd-mm-yyyy">
                                <input class="form-control" 
                                    type="date" name="end_date" value="<?php echo (isset($end_date) && $end_date!='')?date('d-m-Y', strtotime($end_date)):''; ?>" />
                                <span class="input-group-addon">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-1">
                    <div class="form-group text-start">
                        <button class="btn btn-primary _effect--ripple waves-effect waves-light" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="statbox widget box box-shadow">
            <?php if(isset($list) && count($list) > 0) { ?>  
                    <table id="html5-extension" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <?php 
                                $lk = 0;
                                if(isset($list[0]))
                                {
                                    foreach($list[0] as $liheadKey => $lihead) 
                                    { 
                                        if(in_array($liheadKey, array('id', 'created_at')))
                                        { continue; } ?>
                                        <th><?php echo toHeading($liheadKey); ?></th>
                                <?php $lk++; } } ?>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach($list as $lia => $li)
                            {
                                ?>
                                <tr>
                                    <td><?php echo $lia+1; ?></td>
                                    <?php 
                                    foreach($li as $key => $value) 
                                    { 
                                        if(in_array($key, array('id', 'created_at')))
                                        { continue; }
                                    ?>
                                        <td><?php echo $value; ?></td>
                                    <?php
                                    }
                                    ?>
                                    <td></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <?php 
                                if(isset($tfooter))
                                {
                                    echo '<th colspan="'.$tfooter['colspan'].'">'.$tfooter['title'].'</th>';
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
                <?php } else { ?>
                    <p>No results to show</p>
            <?php } ?>
        </div>
    </div>
