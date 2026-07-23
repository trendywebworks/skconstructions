        <!--  BEGIN FOOTER  -->
        <?php require_once('copyright.php'); ?> 
        <!--  END CONTENT AREA  -->
    </div>
    <!--  END CONTENT AREA  -->

</div>
<!-- END MAIN CONTAINER -->

<!-- Jquery -->
<script src=
"https://code.jquery.com/jquery-3.6.1.min.js" 
        integrity=
"sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" 
        crossorigin="anonymous">
    </script>

<!-- GLOBAL MANDATORY SCRIPTS -->
<script src="<?php echo ADMIN_THEME; ?>src/plugins/src/global/vendors.min.js"></script>
<script src="<?php echo ADMIN_THEME; ?>src/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo ADMIN_THEME; ?>src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?php echo ADMIN_THEME; ?>src/plugins/src/mousetrap/mousetrap.min.js"></script>
<script src="<?php echo ADMIN_THEME; ?>src/plugins/src/waves/waves.min.js"></script>
<script src="<?php echo ADMIN_THEME; ?>src/layouts/js/app.js"></script>
<script src="<?php echo ADMIN_THEME; ?>src/assets/js/custom.js"></script>

<!-- DASHBOARD SCRIPTS -->
<script src="<?php echo ADMIN_THEME; ?>src/plugins/src/apex/apexcharts.min.js"></script>
<script src="<?php echo ADMIN_THEME; ?>src/assets/js/dashboard/dash_2.js"></script>

<!-- DATATABLES SCRIPTS -->
<script src="<?php echo ADMIN_THEME; ?>src/plugins/src/table/datatable/datatables.js"></script>
<script src="<?php echo ADMIN_THEME; ?>src/plugins/src/table/datatable/button-ext/dataTables.buttons.min.js"></script>
<script src="<?php echo ADMIN_THEME; ?>src/plugins/src/table/datatable/button-ext/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="<?php echo ADMIN_THEME; ?>src/plugins/src/table/datatable/button-ext/buttons.html5.min.js"></script>
<script src="<?php echo ADMIN_THEME; ?>src/plugins/src/table/datatable/button-ext/buttons.print.min.js"></script>
<script src="<?php echo ADMIN_THEME; ?>src/plugins/src/table/datatable/custom_miscellaneous.js"></script>
<!-- END DATATABLES SCRIPTS --> 

<!-- AUTOSUGGEST DROPDOWN SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- DATEPICKER SCRIPTS -->
<script src=
"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>

    <script>
        $(function () {
            var today = new Date();
            var todayValue = ('0' + today.getDate()).slice(-2) + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + today.getFullYear();
            var datepickerOptions = {
                autoclose: true,
                clearBtn: true,
                container: 'body',
                format: 'dd-mm-yyyy',
                orientation: 'bottom auto',
                todayBtn: 'linked',
                todayHighlight: true
            };

            var $dateFields = $('input[type="date"], .input-group.date input, .input-group.datex input, .input-groupx.datex input, .dayDateFormat')
                .not('[data-skip-datepicker="true"]');

            $dateFields.each(function () {
                var $field = $(this);

                if ($field.attr('type') === 'date') {
                    $field.attr('type', 'text');
                }

                if (/^\d{4}-\d{2}-\d{2}$/.test($field.val())) {
                    var parts = $field.val().split('-');
                    $field.val(parts[2] + '-' + parts[1] + '-' + parts[0]);
                }

                var formAction = ($field.closest('form').attr('action') || '').toLowerCase();
                if ($field.val() === '' && formAction.indexOf('-add') !== -1) {
                    $field.val(todayValue);
                }

                $field
                    .addClass('sk-datepicker-field')
                    .attr('autocomplete', 'off')
                    .attr('placeholder', 'dd-mm-yyyy')
                    .datepicker(datepickerOptions);
            });
        });
    </script>


</body>
</html>
<!-- , #interest, #total_installments -->
<script type="text/javascript">
$(document).on('blur', '#loan_amount, #interest, #total_installments, #quantity, #amount, #gst', function()
{
    // if($('#quantity').length || $('#amount').length || $('#gst').length)
    // {
    //     getQtyTot();
    // }
    // else
    // {
        var total = 0;
        var loan_amount = $('#loan_amount').val() || 0;
        var interest = $('#interest').val() || 0;
        var installments = $('#total_installments').val() || 0;
        var total_installments = 0;

        var onemonth = (interest/100) * loan_amount;
        if(installments != undefined || installments > 0)
        {
            total_installments = onemonth * installments;
        }
        total = parseFloat(loan_amount) + parseFloat(total_installments);
        // alert(loan_amount);alert(interest);alert(installments);alert(onemonth);alert(total_installments);alert(total);
        $('#total_amount').val(total);
    // }
});
</script>

<script type="text/javascript">
$(document).on('change', '#loan_tenure', function()
{
    var ten = parseInt($(this).val());
    var today = new Date();
    today.setMonth(today.getMonth() + ten);

    var formattedDate = new Date(today);
    var d = formattedDate.getDate();
    var m =  formattedDate.getMonth();
    m += 1;
    var y = formattedDate.getFullYear();

    $("#loan_last_date").val(d + "-" + m + "-" + y);
});
</script>

<script type="text/javascript">
$(document).on('change', '#vehicle_id', function()
{
    var href = "<?php echo base_url('Vehicleexpenses/getVehicleNo'); ?>";
    var vehicle_id = $(this).val();
    if(vehicle_id=='')
    {
        $("#vehicle_no").val('');
        return false;
    }
    $.ajax({
        type: 'POST', 
        dataType: 'json',
        url: href,
        data: {"vehicle_id": vehicle_id},
        success: function (data)
        {
            $("#vehicle_no").val(data);
        }
    });
});
</script>

<script type="text/javascript">
$(document).on('blur', ' #quantity, #amount, #gst', function()
{
    var total = 0;
    var quantity = $('#quantity').val() || 0;
    var amount = $('#amount').val() || 0;
    var gst = $('#gst').val() || 0;
    var gst_amount = 0;

    var amt = quantity * amount;
    if(gst != undefined || gst > 0)
    {
        gst_amount = (gst/100) * parseFloat(amt);
    }
    total = parseFloat(amt) + parseFloat(gst_amount);
    $('#total_amount').val(total);
});
</script>

<script type="text/javascript">
    $(document).on('click', '#deleteaccountBtn', function()
    {
        $('#deleteaccount').modal('show');
    });
</script>

<!-- <script type="text/javascript">
    $(document).on('change', '#expense_id', function()
    {
        alert($(this).val());
    });
</script> -->

<script type="text/javascript">
    var ami =  0;
    $(document).on('click', '#purchaseAddmore', function()
    {
        var addMoreCount = $('.addMore').length;
        ami =  addMoreCount + 1;
        $('#addMoreLine').before('<div class="row addMore" id="addMore'+ami+'"><div class="col-3 mb-4"><label for="particular">Particular</label><input type="text" class="form-control" name="particular[]" required><?php echo form_error('particular','<p class="field-error">','</p>'); ?></div><div class="col-xs-12 col-sm-2"><div class="form-group mb-4"><label for="particular">Quantity</label> <input type="number" class="form-control" name="quantity[]" id="quantity'+ami+'" required onkeyup="doCalculation('+ami+');"><?php echo form_error('quantity','<p class="field-error">','</p>'); ?></div></div><div class="col-xs-12 col-sm-2">    <div class="form-group mb-4"><label for="particular">Amount</label> <input type="text" class="form-control" name="amount[]" id="amount'+ami+'" required onkeyup="doCalculation('+ami+');"><input type="hidden" name="subtotal[]" id="subtotal'+ami+'"><?php echo form_error('amount','<p class="field-error">','</p>'); ?></div></div><div class="col-xs-12 col-sm-2"><div class="form-group mb-2"><label for="particular">GST(%)</label><input type="text" class="form-control" name="gst[]"  id="gst'+ami+'" required onkeyup="doCalculation('+ami+');"><input type="hidden" name="gst_amount[]" id="gst_amount'+ami+'"><?php echo form_error('gst','<p class="field-error">','</p>'); ?></div></div><div class="col-xs-12 col-sm-2"><div class="form-group mb-2"><label for="particular">Total</label><input type="text" class="form-control alltotal" name="total[]" id="total'+ami+'" required readonly><?php echo form_error('gst','<p class="field-error">','</p>'); ?>    </div></div><div class="col-1"><img src="<?php echo base_url('themes/images/trash.png'); ?>" width="20" class="text-danger" onclick="removeAddMore('+ami+')"></div></div>');

           
    });
    function removeAddMore(iid)
    {
        $('#addMore'+iid).remove();
    }
</script>

<script type="text/javascript">
    function doCalculation(sno)
    {
        var total = 0; var subtotal = 0; var gst_amount = 0;
        var quantity = parseFloat($('#quantity'+sno).val());
        var amount = parseInt($('#amount'+sno).val()) || 0;
        var gst = parseFloat($('#gst'+sno).val()) || 0;

        subtotal = quantity * amount;
        gst_amount = (gst/100)*subtotal;
        total = subtotal + gst_amount;
        $('#subtotal'+sno).val(Math.round(subtotal));
        $('#gst_amount'+sno).val(Math.round(gst_amount));
        $('#total'+sno).val(Math.round(total));

        var sum = 0;//$('#disabledInput').val();
        $('.alltotal').each(function(){
            sum += parseFloat(this.value);
        });
        $('#disabledInput').val(Math.round(sum));
    }
</script>

<script type="text/javascript">
    $(document).on('change', '#expense_type', function()
    {
        var href = "<?php echo base_url('Dailyentry/getExpenseDrop'); ?>";
        var expense_type = $(this).val();
        $.ajax({
            type: 'POST', 
            dataType: 'json',
            url: href,
            data: {"expense_type": expense_type},
            success: function (data)
            {
                $("#option").html(data);
                initAutosuggestDropdowns('#option');
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).on('change', '#option', function()
    {
        if ($('#reference_no').length) {
            var refValue = $('#reference_no').val();
        }
        if ($('#amount').length) {
            var amount = $('#amount').val();
        }

        if($('#expense_type').val()==''){
            alert('Please select Expense Type first');
            $('#option').val('').trigger('change.select2');
            return;
        }
    // $('#option').on('select2:select select2:close', function (e) {
        var href = "<?php echo base_url('Dailyentry/getOptionFields'); ?>";
        var option = $(this).val();
        var etype = $('#expense_type').val();
        $.ajax({
            type: 'POST', 
            dataType: 'json',
            url: href,
            data: {"option": option, etype:etype},
            success: function (data)
            {
                $("#divForm").html(data);
                $('#reference_no').val(refValue);
                $('#amount').val(amount);
                initAutosuggestDropdowns('#divForm');
            }
        });
    });
</script>

<script type="text/javascript">
    function getMLData(val)
    {
        var href = "<?php echo base_url('Dailyentry/getData'); ?>";
        var opt = $('#option').val();
        $.ajax({
            type: 'POST', 
            dataType: 'json',
            url: href,
            data: {"val": val, opt:opt},
            success: function (data)
            {
                // if($('#appendBefore').length == 0)
                // {
                //     $('#appendAfter').after('<div class="col-8" id="appendBefore"></div>');
                // }
                // $('.editclass').remove()
                $("#appendBefore").empty().html(data);
            }
        });
    }
</script>

<script type="text/javascript">
$(document).on('change', '#start_km,#end_km', function()
{
    var start_km = $('#start_km').val() || 0;
    var end_km = $('#end_km').val() || 0;
    var total_km = parseInt(end_km) - parseInt(start_km);
    $("#total_km").val(total_km);
});
</script>

<script type="text/javascript">
$(document).on('blur change', '#amount,#diesel_amount,#income', function()
{
    if(!$('#diesel_amount').length || !$('#income').length || !$('#balance').length)
    {
        return;
    }

    var amount = parseFloat($('#amount').val()) || 0;
    var dieselAmount = parseFloat($('#diesel_amount').val()) || 0;
    var income = parseFloat($('#income').val()) || 0;
    var balance = income - (amount + dieselAmount);
    $('#balance').val(Math.round(balance));
});
</script>

<script type="text/javascript">
function reporttype(answer){
    
    if(answer.value=="ccaccount"){
        document.getElementById('partynena').disabled = false;
        document.getElementById('partyname').classList.remove('d-none');

        document.getElementById('vehicleno').classList.add('d-none');
        document.getElementById('reportfor').classList.add('d-none');
        document.getElementById('sitename').classList.add('d-none');
        document.getElementById('lpartyname').classList.add('d-none');
        document.getElementById('partnersname').classList.add('d-none');
        document.getElementById('officeexpen').classList.add('d-none');
        document.getElementById('officeexpentypeopt').classList.add('d-none');
        document.getElementById('suppliern').classList.add('d-none');
        document.getElementById('productname').classList.add('d-none');
        document.getElementById('vehiclneno').classList.add('d-none');

    }
    else if(answer.value=="marketl"){
        document.getElementById('loanpena').disabled = false;
        document.getElementById('lpartyname').classList.remove('d-none');
        
        document.getElementById('reportfor').classList.add('d-none');
        document.getElementById('suppliern').classList.add('d-none');
        document.getElementById('vehicleno').classList.add('d-none');
        document.getElementById('sitename').classList.add('d-none');
        document.getElementById('partnersname').classList.add('d-none');
        document.getElementById('officeexpen').classList.add('d-none');
        document.getElementById('officeexpentypeopt').classList.add('d-none');
        document.getElementById('partyname').classList.add('d-none');
        document.getElementById('vehiclneno').classList.add('d-none');

    }
    else if(answer.value=="purchase"){
        document.getElementById('supplierena').disabled = false;
        document.getElementById('suppliern').classList.remove('d-none');
        
        document.getElementById('productname').classList.add('d-none');
        document.getElementById('officeexpen').classList.add('d-none');
        document.getElementById('officeexpentypeopt').classList.add('d-none');
        document.getElementById('vehicleno').classList.add('d-none');
        document.getElementById('staffn').classList.add('d-none');
        document.getElementById('sitename').classList.add('d-none');
        document.getElementById('partnersname').classList.add('d-none');
        document.getElementById('lpartyname').classList.add('d-none');
        document.getElementById('partyname').classList.add('d-none');
        document.getElementById('vehiclneno').classList.add('d-none');
    }
    else if(answer.value=="gstbill"){
        document.getElementById('supplierena').disabled = false;
        document.getElementById('suppliern').classList.remove('d-none');

        document.getElementById('vehicleno').classList.add('d-none');
        document.getElementById('staffn').classList.add('d-none');
        document.getElementById('reportfor').classList.add('d-none');
        document.getElementById('sitename').classList.add('d-none');
        document.getElementById('lpartyname').classList.add('d-none');
        document.getElementById('partnersname').classList.add('d-none');
        document.getElementById('partyname').classList.add('d-none');
        document.getElementById('officeexpen').classList.add('d-none');
        document.getElementById('officeexpentypeopt').classList.add('d-none');
        document.getElementById('productname').classList.add('d-none');
        document.getElementById('vehiclneno').classList.add('d-none');
    }
    else if(answer.value=="officeex"){
        document.getElementById('officeexenable').disabled = false;
        document.getElementById('officeexpen').classList.remove('d-none');
        document.getElementById('officeexpentypeopt').classList.remove('d-none');
        document.getElementById('staffn').classList.add('d-none');
        document.getElementById('reportfor').classList.add('d-none');
        document.getElementById('suppliern').classList.add('d-none');
        document.getElementById('productname').classList.add('d-none');
        document.getElementById('vehicleno').classList.add('d-none');
        document.getElementById('sitename').classList.add('d-none');
        document.getElementById('partnersname').classList.add('d-none');
        document.getElementById('suppliern').classList.add('d-none');
        document.getElementById('partyname').classList.add('d-none');
        document.getElementById('lpartyname').classList.add('d-none');
        document.getElementById('vehiclneno').classList.add('d-none');

    }

    else if(answer.value=="products"){
        document.getElementById('prodnenable').disabled = false;
        document.getElementById('productname').classList.remove('d-none');

        document.getElementById('reportfor').classList.add('d-none');
        document.getElementById('suppliern').classList.add('d-none');
        document.getElementById('vehicleno').classList.add('d-none');
        document.getElementById('sitename').classList.add('d-none');
        document.getElementById('partnersname').classList.add('d-none');
        document.getElementById('suppliern').classList.add('d-none');
        document.getElementById('lpartyname').classList.add('d-none');
        document.getElementById('partnersname').classList.add('d-none');
        document.getElementById('partyname').classList.add('d-none');
        document.getElementById('officeexpen').classList.add('d-none');
        document.getElementById('officeexpentypeopt').classList.add('d-none');
        document.getElementById('vehiclneno').classList.add('d-none');

    }
    else if(answer.value=="staffl"){
        document.getElementById('staffn').classList.remove('d-none');

        document.getElementById('staffena').disabled = false;
        
        document.getElementById('reportfor').classList.add('d-none');
        document.getElementById('productname').classList.add('d-none');
        document.getElementById('officeexpen').classList.add('d-none');
        document.getElementById('officeexpentypeopt').classList.add('d-none');
        document.getElementById('vehicleno').classList.add('d-none');
        document.getElementById('sitename').classList.add('d-none');
        document.getElementById('partnersname').classList.add('d-none');
        document.getElementById('suppliern').classList.add('d-none');
        document.getElementById('lpartyname').classList.add('d-none');
        document.getElementById('vehiclneno').classList.add('d-none');
        document.getElementById('partyname').classList.add('d-none');
    }
    else if(answer.value=="partn" || answer.value=="paypartn"){

        document.getElementById('partnersname').classList.remove('d-none');
        document.getElementById('partnernena').disabled = false;

        document.getElementById('productname').classList.add('d-none');
        document.getElementById('suppliern').classList.add('d-none');
        document.getElementById('officeexpen').classList.add('d-none');
        document.getElementById('officeexpentypeopt').classList.add('d-none');
        document.getElementById('staffn').classList.add('d-none');
        document.getElementById('reportfor').classList.add('d-none');
        document.getElementById('vehicleno').classList.add('d-none');
        document.getElementById('sitename').classList.add('d-none');
        document.getElementById('lpartyname').classList.add('d-none');
        document.getElementById('partyname').classList.add('d-none');
        document.getElementById('vehiclneno').classList.add('d-none');
    }
    else if(answer.value=="vehicls"){
        document.getElementById('vehiclena').disabled = false;
        document.getElementById('vehiclnena').disabled = false;
        document.getElementById('vehicleno').classList.remove('d-none');
        document.getElementById('vehiclneno').classList.remove('d-none');

        document.getElementById('productname').classList.add('d-none');
        document.getElementById('suppliern').classList.add('d-none');
        document.getElementById('partnersname').classList.add('d-none');
        document.getElementById('officeexpen').classList.add('d-none');
        document.getElementById('officeexpentypeopt').classList.add('d-none');
        document.getElementById('staffn').classList.add('d-none');
        document.getElementById('reportfor').classList.add('d-none');
        document.getElementById('sitename').classList.add('d-none');
        document.getElementById('lpartyname').classList.add('d-none');
        document.getElementById('partyname').classList.add('d-none');
    }

    else{

        document.getElementById('productname').classList.add('d-none');
        document.getElementById('suppliern').classList.add('d-none');
        document.getElementById('partnersname').classList.add('d-none');
        document.getElementById('officeexpen').classList.add('d-none');
        document.getElementById('officeexpentypeopt').classList.add('d-none');
        document.getElementById('staffn').classList.add('d-none');
        document.getElementById('reportfor').classList.add('d-none');
        document.getElementById('sitename').classList.add('d-none');
        document.getElementById('lpartyname').classList.add('d-none');
        document.getElementById('partyname').classList.add('d-none');
        document.getElementById('vehicleno').classList.add('d-none');

    }
    initAutosuggestDropdowns(document);
}

function reportforf(answer){
    if(answer.value=="site"){
        document.getElementById('sitename').classList.remove('d-none');
        document.getElementById('suppliern').classList.add('d-none');
        document.getElementById('vehicleno').classList.add('d-none');
        document.getElementById('staffn').classList.add('d-none');
        document.getElementById('officeexpen').classList.add('d-none');
        document.getElementById('productname').classList.add('d-none');

    }
    if(answer.value=="vehicles"){
        document.getElementById('vehicleno').classList.remove('d-none');
        document.getElementById('suppliern').classList.add('d-none');
        document.getElementById('staffn').classList.add('d-none');
        document.getElementById('officeexpen').classList.add('d-none');
        document.getElementById('productname').classList.add('d-none');

    }
    if(answer.value=="officestaff"){
        document.getElementById('officeexpen').classList.remove('d-none');
        document.getElementById('staffn').classList.remove('d-none');
        document.getElementById('suppliern').classList.add('d-none');
        document.getElementById('vehicleno').classList.add('d-none');
        document.getElementById('sitename').classList.add('d-none');
        document.getElementById('partnersname').classList.add('d-none');
        document.getElementById('productname').classList.add('d-none');
        document.getElementById('officeexenable').disabled = false;
        document.getElementById('staffena').disabled = false;

    }
    if(answer.value=="loanparty"){
        document.getElementById('loanpena').disabled = false;
        
        document.getElementById('sitename').classList.add('d-none');
        document.getElementById('suppliern').classList.add('d-none');
        document.getElementById('vehicleno').classList.add('d-none');
        document.getElementById('lpartyname').classList.remove('d-none');
        document.getElementById('productname').classList.add('d-none');

    }
    if(answer.value=="supplier"){
        document.getElementById('supplierena').disabled = false;

        document.getElementById('sitename').classList.add('d-none');
        document.getElementById('suppliern').classList.remove('d-none');
        document.getElementById('productname').classList.add('d-none');

        document.getElementById('vehicleno').classList.add('d-none');
        document.getElementById('lpartyname').classList.add('d-none');
        document.getElementById('staffn').classList.add('d-none');
        document.getElementById('officeexpen').classList.add('d-none');
    }

    if(answer.value=="employee"){
        document.getElementById('staffena').disabled = false;

        document.getElementById('sitename').classList.add('d-none');
        document.getElementById('suppliern').classList.add('d-none');
        document.getElementById('productname').classList.add('d-none');
        
        document.getElementById('vehicleno').classList.add('d-none');
        document.getElementById('lpartyname').classList.add('d-none');
        document.getElementById('officeexpen').classList.add('d-none');
        document.getElementById('staffn').classList.remove('d-none');
    }

    initAutosuggestDropdowns(document);
}
</script>

<script>
function toggleCheckboxes() {
    var checkboxes = document.querySelectorAll('.permission_checkboxes');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = !checkbox.checked;
    });
}
</script>

<script>
$(document).ready(function() {
    var table = $('#html5-extension').DataTable();

    // Handle click on "Select all" control
    $('#select-all').on('click', function() {
        var rows = table.rows({ 'search': 'applied' }).nodes();
        $('input.selectRow', rows).prop('checked', this.checked);
    });

    // Handle click on individual checkbox to update "select all" checkbox state
    $('#html5-extension tbody').on('change', 'input.selectRow', function() {
        if (!this.checked) {
            $('#select-all').prop('checked', false);
        } else {
            // If all checkboxes are checked
            if ($('#html5-extension tbody input.selectRow:checked').length === $('#html5-extension tbody input.selectRow').length) {
                $('#select-all').prop('checked', true);
            }
        }
    });
});
</script>

<script type="text/javascript">
$(document).on('change', '#officeexenabletypeopt', function()
{
    var href = "<?php echo base_url('Expensetype/getExpenseByType'); ?>";
    var expense_type = $(this).val();
    
    $.ajax({
        type: 'POST', 
        dataType: 'json',
        url: href,
        data: {"expense_type": expense_type},
        success: function (data)
        {
            $("#officeexenable").empty();
            $("#officeexenable").html(data);
        }
    });
});
</script>

<script>
function initAutosuggestDropdowns(scope) {
    if (typeof $.fn.select2 === 'undefined') {
        return;
    }

    var $scope = scope ? $(scope) : $(document);
    var $selects = $scope.is('select') ? $scope : $scope.find('select');

    $selects.each(function () {
        var $select = $(this);
        var selectId = $select.attr('id') || '';
        var selectName = $select.attr('name') || '';
        var optionCount = $select.find('option').length;
        var shouldAutosuggest = optionCount >= 8 || $select.is('[data-autosuggest="true"]') || selectId === 'option';
        var skipAutosuggest = $select.is('[data-skip-autosuggest="true"]') || $.inArray(selectName, ['status', 'expense_type', 'report_type']) !== -1;

        if (!shouldAutosuggest || skipAutosuggest) {
            return;
        }

        if ($select.hasClass('select2-hidden-accessible')) {
            $select.select2('destroy');
        }

        $select.select2({
            tags: selectId === 'option',
            placeholder: $select.find('option:first').text() || 'Select',
            tokenSeparators: selectId === 'option' ? [','] : [],
            allowClear: !$select.prop('required'),
            width: '100%'
        });
    });
}

$(function () {
    initAutosuggestDropdowns(document);
});
</script>
