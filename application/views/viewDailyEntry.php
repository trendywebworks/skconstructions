<style type="text/css">
    span.text-danger{
        display: none;
    }
    .form-control{
        border: 0px!important;
        padding: 0px!important;
        color: #888EA8;
    }
    .form-control[readonly]{
        background-color: #fff!important;
        color: #888EA8!important;
    }
</style>
<div class="row">                
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="row">
                <div class="col-4 mb-4">
                    <label for="date">Date</label>
                    <div id="datepickerx" class="input-group datex" data-date-format="dd-mm-yyyy">
                        <?php echo (isset($list) && isset($list['entry_date']))?date('d-m-Y', strtotime($list['entry_date'])):''; ?>
                    </div>
                </div>
                <div class="col-6 mb-4">
                    <label for="exampleFormControlSelect1">Site</label>
                    <br>
                    <?php echo (isset($list) && isset($list['site']))?ucfirst($list['site']):''; ?>
                </div>
                <div class="col-4 mb-4">
                    <label for="exampleFormControlSelect2">Expense Type</label>
                    <br>
                    <?php echo (isset($list) && isset($list['expense_type']))?ucfirst($list['expense_type']):''; ?>
                </div>
                <div class="col-4 mb-4">
                    <label for="exampleFormControlSelect2">Expense/Income Options</label>
                    <br>
                    <?php echo (isset($list) && isset($list['expense']))?ucfirst($list['expense']):''; ?>
                </div>
            </div>

            <div class="row">
                <?php echo (isset($divForm))?$divForm:''; ?>
            </div>

            <div class="row">
                <div class="col-4 mb-4">
                    <label for="exampleFormControlTextarea1">Status</label>
                    <br>
                    <?php echo (isset($list) && isset($list['status']) && $list['status']==='active')?'<span class="badge badge-success">Active</span>':'<span class="badge badge-warning">Pending</span>'; ?>
                </div>
                    
                <div class="col-8 mb-4">
                    <label for="exampleFormControlTextarea1">Remarks</label>
                    <br>
                    <?php echo (isset($list) && isset($list['remarks']))?$list['remarks']:''; ?>
                </div>   
            </div> 

        </div>
    </div>
</div>