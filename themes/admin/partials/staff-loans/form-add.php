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
            <div class="form-group mb-4" id="types" >
                        <label for="type">Employee Person</label>
                        <select class="form-select" >
                            <option value="staff1">Rakesh</option>
                            <option value="staff2">Sumit Sahu</option>
                            <option value="staff3">Roshan</option>
                        </select>
            </div>
            
            <div class="row">
                
                <div class="col-xs-12 col-sm-6">
                        <div class="form-group mb-4">
                        <label for="particular">Loan Amount</label>
                        <input type="number" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                <div class="form-group mb-4">
                    <label for="particular">Loan Tenure</label>
                    <select class="form-select">
                    <option value="staff1">1 Month</option>
                    <option value="staff2">3 Month</option>
                    <option value="staff3">6 Month</option>
                    </select>
                </div>
                </div>
            </div>
            
            
            <div class="form-group mb-4">
                <label for="date">Loan Last Date</label>
                <div id="datepicker3" 
                    class="input-group date" 
                    data-date-format="dd-mm-yyyy">
                    <input class="form-control" 
                    type="text" readonly />
                    <span class="input-group-addon">
                    </span>
                </div>
            </div>
            
            <div class="form-group mb-4">
                <label for="exampleFormControlTextarea1">Remarks</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <input type="submit" name="time" class="mt-4 mb-4 btn btn-primary">
        </form>

        </div>
    </div>
</div>