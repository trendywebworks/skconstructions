<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-4">
        <div class="form widget-content-area br-8">
            <form action="<?php echo base_url('cashflow-reports'); ?>" method="post" id="reportFilter">
                <div class="row mb-4">
                    <div class="col-md-3" id="officeexpentypeopt">
                        <div class="form-group" >
                            <label for="state">Cashflow</label>
                            <select class="form-select" id="officeexenabletypeopt" name="office_expense_name_type_opt">
                                <option value="">Select</option>
                                <?php
                                if(isset($office_expense_type_options))
                                {
                                    foreach($office_expense_type_options as $oetno)
                                    { ?>
                                        <option value="<?php echo $oetno['title']; ?>" <?php echo (isset($office_expense_name_type_opt) && $office_expense_name_type_opt!='' && $office_expense_name_type_opt==$oetno['title'])?'selected':''; ?>><?php echo $oetno['title']; ?></option>
                                    <?php } } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3" id="officeexpen">
                        <div class="form-group" >
                            <label for="state">Office Expenses</label>
                            <select class="form-select" id="officeexenable" name="office_expense_name">
                                <option value="">Select</option>
                                <?php
                                if(isset($office_expense_name) && isset($office_expense_types))
                                {
                                    foreach($office_expense_types as $oet)
                                    { ?>
                                        <option value="<?php echo $oet['id']; ?>" <?php echo (isset($office_expense_name) && $office_expense_name!='' && $office_expense_name==$oet['id'])?'selected':''; ?>><?php echo $oet['expense_type']; ?></option>
                                    <?php } } ?>
                            </select>
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
            <div class="widget-content widget-content-area">
                <?php if(isset($list) && isset($list[0])) { ?> 
                    <table id="html5-extension" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <?php if (isset($list[0]) && array_key_exists('created_at', $list[0])) { ?>
                                <th>Date</th>
                                <?php 
                                }
                                $lk = 0;
                                if(isset($list[0]))
                                {
                                    foreach($list[0] as $liheadKey => $lihead) 
                                    { 
                                        if(in_array($liheadKey, array('id', 'created_at')))
                                        { continue; } ?>
                                        <th><?php echo toHeading($liheadKey); ?></th>
                                <?php $lk++; } } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach($list as $li)
                            {
                                ?>
                                <tr>
                                    <?php if (array_key_exists('created_at', $list[0])) { ?>
                                    <td>
                                        <span class="inv-date"><?php echo dayDateFormat($li['created_at']); ?></span>
                                    </td>
                                    <?php
                                    } 
                                    foreach($li as $key => $value) 
                                    { 
                                        if(in_array($key, array('id', 'created_at')))
                                        { continue; }
                                    ?>
                                        <td><?php echo $value; ?></td>
                                    <?php
                                    }
                                    ?>
                                </tr>
                            <?php } ?>
                        </tbody>

                        <?php if(isset($tfooter)) { ?>
                        <tfoot>
                            <tr>
                                <?php 
                                echo '<th colspan="'.$tfooter['colspan'].'">'.$tfooter['title'].'</th>';
                                foreach($tfooter['sum_cols'] as $sc)
                                {
                                    echo '<th class="sumcol" data-id="'.$sc.'"></th>';
                                }
                                for($lf =1; $lf <= $tfooter['empty']; $lf++)
                                {
                                    echo '<th></th>';
                                }
                                
                                ?>
                            </tr>
                        </tfoot>
                    <?php } ?>
                </table>
            <?php } else { echo 'No results to show.'; } ?>
        </div>
    </div>
</div>
<?php //} ?>
<!-- For report filter -->


</div>
