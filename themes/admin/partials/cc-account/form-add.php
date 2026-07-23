<div class="row">                
    <div class="col-xl-5 col-lg-5 col-sm-5 layout-spacing">
        <div class="statbox widget box box-shadow">

            <form>
                <div class="form-group mb-4">
                    <label for="date">Date</label>
                    <div id="datepicker" 
                            class="input-group date" 
                            data-date-format="dd-mm-yyyy">
                        <input class="form-control" 
                                type="text" readonly />
                        <span class="input-group-addon">
                        </span>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="exampleFormControlSelect1">Bank Name</label>
                    <select class="form-select" id="exampleFormControlSelect1">
                        <option>SBI Bank</option>
                        <option>Axis Bank</option>
                        <option>Bank of Baroda</option>
                        <option>HDFC Bank</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group mb-4">
                             <label for="exampleFormControlSelect2">Loan Amount</label>
                            <input type="number" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group mb-4">
                            <label>Interest Per/Month</label>
                            <input type="number" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="particular">Total Amount</label>
                    <input class="form-control" id="disabledInput" type="text" placeholder="" disabled>
                </div>
                
                <div class="form-group mb-4 mt-3">
                    <label for="exampleFormControlTextarea1">Remarks</label>
                    <textarea class="form-control" rows="3"></textarea>
                </div>
                <input type="submit" name="time" class="mt-4 mb-4 btn btn-primary">
            </form>

        </div>
    </div>
</div>