<div class="row">                
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="statbox widget box box-shadow">           
            <div class="row">
                <div class="col-4 mb-4">
                    <label for="date">Date</label>
                    <div id="datepickerx" class="input-group datex" data-date-format="dd-mm-yyyy">
                        <span class="input-group-addon"></span>
                        <?php echo (isset($list) && isset($list[0]['entry_date']))?dayDateFormat($list[0]['entry_date']):date('d-m-Y'); ?>
                    </div>
                </div>
                <div class="col-4 mb-4">
                    <label for="exampleFormControlSelect1">Reference No</label>
                    <br>
                    <?php echo (isset($list) && isset($list[0]['reference_no']))?$list[0]['reference_no']:''; ?>
                </div>
                <div class="col-4 mb-4">
                    <label for="exampleFormControlSelect1">Supplier Name</label>
                    <br>
                    <?php echo (isset($list) && isset($list[0]['supplier']))?$list[0]['supplier']:''; ?>
                </div>
            </div>
            <div class="row">
                <table class="table border-0" style="border: 0px!important;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Particular</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>GST(%)</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if(isset($list)) 
                    {
                        $detKey = 0;
                        foreach($list as  $det)
                        {
                            $detKey++;
                        ?>
                        <tr>
                            <td><?php echo $detKey; ?></td>
                            <td><?php echo ($det['particular']!='')?ucwords($det['particular']):''; ?></td>
                            <td><?php echo ($det['quantity']!='')?$det['quantity']:''; ?></td>
                            <td><?php echo ($det['amount']!='')?numFormat($det['amount']):''; ?></td>
                            <td><?php echo ($det['gst']!='')?$det['gst']:''; ?></td>
                            <td><?php echo ($det['total']!='')?numFormat($det['total']):''; ?></td>
                        </tr>
                        <?php
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5">Grand Total</th>
                            <th><?php echo (isset($list) && isset($list[0]['total_amount']))?numFormat($list[0]['total_amount']):0; ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="form-group mb-4">
                <label for="particular">Remarks</label>
                <br>
                <?php echo (isset($list) && isset($list[0]['remarks']))?$list[0]['remarks']:''; ?>
            </div>
            <div class="form-group mb-4">
                <label for="particular">Status</label>
                <br>
                <?php echo (isset($list) && isset($list[0]['pstatus']) && $list[0]['pstatus']==='active')?'<span class="badge badge-success">Active</span>':'<span class="badge badge-warning">Pending</span>'; ?>
            </div>
        </div>
    </div>
</div>
